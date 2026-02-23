<?php

namespace App\Livewire\Traits;

use App\Models\Comment;
use App\Models\User;

trait HasInteractions
{
    public $newComment = '';

    public $replyingToCommentId = null;

    public $confirmingCommentDeletion = null;

    public $showComments = false;

    public $showMentions = false;

    public $filteredUsers = [];

    // abstract protected function getInteractableModel(); // O model atual (Post, Activity, etc)

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

        return preg_replace_callback('/@([\w\s\p{L}]+)/u', function ($matches) {
            $name = trim($matches[1]);
            $user = User::where('name', $name)->first();
            if ($user) {
                return '<a href="'.profile_url($user).'" class="text-brand-600 font-bold hover:underline cursor-pointer">@'.$name.'</a>';
            }

            return '@'.$name;
        }, $escapedBody);
    }

    public function toggleLike()
    {
        $user = auth()->user();
        $model = $this->getInteractableModel();

        $existingLikeQuery = $model->allLikes()->where('user_id', $user->id);

        if ($existingLikeQuery->exists()) {
            $existingLikeQuery->delete();
        } else {
            $model->allLikes()->create(['user_id' => $user->id]);
        }

        $model->refresh();
    }

    public function toggleSave()
    {
        $user = auth()->user();
        $model = $this->getInteractableModel();

        $existingSave = \App\Models\SavedItem::where('user_id', $user->id)
            ->where('saved_item_id', $model->id)
            ->where('saved_item_type', get_class($model))
            ->first();

        if ($existingSave) {
            $existingSave->delete();
        } else {
            \App\Models\SavedItem::create([
                'user_id' => $user->id,
                'saved_item_id' => $model->id,
                'saved_item_type' => get_class($model),
            ]);
        }

        $model->refresh();
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
        $this->getInteractableModel()->refresh();
    }

    public function deleteComment()
    {
        if (! $this->confirmingCommentDeletion) {
            return;
        }

        $commentId = $this->confirmingCommentDeletion;
        $user = auth()->user();
        $comment = Comment::find($commentId);
        $model = $this->getInteractableModel();

        if ($comment) {
            $isCommentOwner = $comment->user_id == $user->id;
            $isPostOwner = $model->user_id == $user->id;

            if ($isCommentOwner || $isPostOwner || auth()->user()->isAdmin()) {
                $comment->delete();
            }
        }

        $this->confirmingCommentDeletion = null;
        $model->refresh();
    }

    public function postComment()
    {
        $this->validate([
            'newComment' => 'required|string|max:1000',
        ]);

        $model = $this->getInteractableModel();

        $model->comments()->create([
            'user_id' => auth()->user()->id,
            'body' => $this->newComment,
            'parent_id' => $this->replyingToCommentId,
        ]);

        $this->newComment = '';
        $this->replyingToCommentId = null;
        $this->showComments = true;
        $model->refresh();
    }

    public function updatedNewComment($value)
    {
        if (str_contains($value, '@')) {
            $parts = explode(' ', $value);
            $lastPart = end($parts);
            if (str_starts_with($lastPart, '@')) {
                $search = substr($lastPart, 1);
                if (strlen($search) > 0) {
                    $this->showMentions = true;
                    $this->filteredUsers = User::where('name', 'like', "%{$search}%")
                        ->take(5)
                        ->get()
                        ->map(function ($user) {
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
        array_pop($parts);
        $parts[] = '@'.$user['name'].' ';
        $this->newComment = implode(' ', $parts);
        $this->showMentions = false;
    }
}
