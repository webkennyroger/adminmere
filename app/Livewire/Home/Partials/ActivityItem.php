<?php

namespace App\Livewire\Home\Partials;

use Livewire\Component;
use App\Models\Activity;
use App\Models\Comment;

class ActivityItem extends Component
{
    public Activity $activity;
    
    public $newComment = ''; // Single string, not array since it's one component per activity
    public $replyingToCommentId = null; 
    public $confirmingCommentDeletion = null;
    public $showComments = false;
    public $showMentions = false;
    public $filteredUsers = []; // For mentions
    
    // Edit/Delete Post
    public $editingPost = false;
    public $editTitle = '';
    public $editContent = '';
    public $confirmingPostDeletion = false;

    public function mount(Activity $activity)
    {
        $this->activity = $activity;
        $this->editTitle = $activity->title ?? '';
        $this->editContent = $activity->description ?? '';
    }
    
    public function startEditingPost()
    {
        if ($this->activity->user_id !== auth()->id()) {
            return; // Only owner can edit
        }
        $this->editingPost = true;
    }
    
    public function cancelEditingPost()
    {
        $this->editingPost = false;
        $this->editTitle = $this->activity->title ?? '';
        $this->editContent = $this->activity->description ?? '';
    }
    
    public function updatePost()
    {
        if ($this->activity->user_id !== auth()->id()) {
            return; // Only owner can edit
        }
        
        $this->validate([
            'editTitle' => 'nullable|string|max:100',
            'editContent' => 'required|min:3',
        ]);
        
        $this->activity->update([
            'title' => $this->editTitle ?: 'Publicação',
            'description' => $this->editContent,
        ]);
        
        $this->editingPost = false;
        $this->activity->refresh();
        session()->flash('message', 'Post atualizado com sucesso!');
    }
    
    public function confirmDeletePost()
    {
        if ($this->activity->user_id !== auth()->id()) {
            return; // Only owner can delete
        }
        $this->confirmingPostDeletion = true;
    }
    
    public function cancelDeletePost()
    {
        $this->confirmingPostDeletion = false;
    }
    
    public function deletePost()
    {
        if ($this->activity->user_id !== auth()->id()) {
            return; // Only owner can delete
        }
        
        $this->activity->delete();
        $this->dispatch('post-deleted');
        session()->flash('message', 'Post deletado com sucesso!');
    }

    public function confirmDelete($commentId)
    {
        $this->confirmingCommentDeletion = $commentId;
    }

    public function cancelDelete()
    {
        $this->confirmingCommentDeletion = null;
    }

    public function formatComment($body)
    {
        $escapedBody = e($body);
        return preg_replace_callback('/@([\w\s\p{L}]+)/u', function($matches) {
            $name = trim($matches[1]);
            $user = \App\Models\User::where('name', $name)->first();
            if ($user) {
                 return '<a href="'.route('profile.view', $user->id).'" class="text-brand-600 font-bold hover:underline cursor-pointer">@' . $name . '</a>';
            }
            return '@' . $name;
        }, $escapedBody);
    }

    public function toggleLike()
    {
        $user = auth()->user();
        
        $existingLike = $this->activity->likes()->where('user_id', $user->id)->first();
        if ($existingLike) {
            $existingLike->delete();
        } else {
            $this->activity->likes()->create(['user_id' => $user->id]);
        }
        
        $this->activity->refresh(); // Reload mainly for likes count if needed, but reactivity handles it mostly
    }

    public function toggleCommentLike($commentId)
    {
        $user = auth()->user();
        $comment = Comment::find($commentId);
        
        if ($comment) {
            $existingLike = $comment->likes()->where('user_id', $user->id)->first();
            if ($existingLike) {
                $existingLike->delete();
            } else {
                $comment->likes()->create(['user_id' => $user->id]);
            }
        }
        $this->activity->refresh(); 
    }

    public function deleteComment()
    {
        if (!$this->confirmingCommentDeletion) {
            return;
        }

        $commentId = $this->confirmingCommentDeletion;
        $user = auth()->user();
        $comment = Comment::find($commentId);

        if ($comment) {
            $isCommentOwner = $comment->user_id === $user->id;
            $isActivityOwner = $this->activity->user_id === $user->id; // Logic simplified since we have context

            if ($isCommentOwner || $isActivityOwner) {
                $comment->delete();
            }
        }

        $this->confirmingCommentDeletion = null;
        $this->activity->refresh();
    }

    public function postComment()
    {
        $this->validate([
            'newComment' => 'required|string|max:1000',
        ]);

        $this->activity->comments()->create([
            'user_id' => auth()->user()->id,
            'body' => $this->newComment,
            'parent_id' => $this->replyingToCommentId
        ]);
        
        $this->newComment = '';
        $this->replyingToCommentId = null;
        $this->showComments = true;
        $this->activity->refresh();
    }
    
    // Mentions logic (simplified)
    public function updatedNewComment($value)
    {
        if (str_contains($value, '@')) {
            // Simple logic: if last word starts with @
             $parts = explode(' ', $value);
             $lastPart = end($parts);
             if (str_starts_with($lastPart, '@')) {
                 $search = substr($lastPart, 1);
                 if (strlen($search) > 0) {
                     $this->showMentions = true;
                     $this->filteredUsers = \App\Models\User::where('name', 'like', "%{$search}%")
                        ->take(5)
                        ->get()
                        ->map(function($user) {
                            return [
                                'id' => $user->id,
                                'name' => $user->name,
                                'image_url' => $user->image_url,
                            ];
                        })
                        ->toArray();
                 } else {
                     $this->showMentions = false;
                 }
             } else {
                 $this->showMentions = false;
             }
        } else {
            $this->showMentions = false;
        }
    }

    public function selectUser($user)
    {
        $parts = explode(' ', $this->newComment);
        array_pop($parts); // Remove partial mention
        $parts[] = '@' . $user['name'] . ' ';
        $this->newComment = implode(' ', $parts);
        $this->showMentions = false;
    }

    public function render()
    {
        return view('livewire.home.partials.activity-item');
    }
}
