<?php

namespace App\Livewire\Home\Partials;

use App\Models\Post;
use Livewire\Component;

class PostItem extends Component
{
    use \App\Livewire\Traits\HasInteractions;

    public Post $post;

    // Edit/Delete Post
    public $editingPost = false;

    public $confirmingPostDeletion = false;

    // Edit/Delete Poll
    public $editingPoll = false;

    public $confirmingPollDeletion = false;

    public $editTitle = '';

    public $editContent = '';

    public function getInteractableModel()
    {
        return $this->post;
    }

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->editTitle = $post->title ?? '';
        $this->editContent = $post->content ?? '';
    }

    public function startEditingPost()
    {
        $user = auth()->user();
        if ($this->post->user_id != $user->id && ! $user->isAdmin()) {
            session()->flash('error', 'Sem permissão para editar.');

            return;
        }
        $this->editTitle = $this->post->title ?? '';
        $this->editContent = $this->post->content ?? '';

        if ($this->post->type === 'poll') {
            $this->editingPoll = true;
        } else {
            $this->editingPost = true;
        }
    }

    public function cancelEditingPost()
    {
        $this->editingPost = false;
        $this->editingPoll = false;
        $this->editTitle = $this->post->title ?? '';
        $this->editContent = $this->post->content ?? '';
    }

    public function updatePost()
    {
        $user = auth()->user();
        if ($this->post->user_id != $user->id && ! $user->isAdmin()) {
            session()->flash('error', 'Sem permissão para editar.');

            return;
        }

        $this->validate([
            'editTitle' => 'nullable|string|max:100',
            'editContent' => 'nullable|string',
        ]);

        $this->post->update([
            'title' => $this->editTitle ?: null,
            'content' => $this->editContent,
        ]);

        $this->editingPost = false;
        $this->editingPoll = false;
        $this->post->refresh();
        $message = $this->post->type === 'poll' ? 'Enquete atualizada!' : 'Post atualizado!';
        session()->flash('message', $message);
    }

    public function confirmDeletePost()
    {
        $user = auth()->user();
        if ($this->post->user_id != $user->id && ! $user->isAdmin()) {
            session()->flash('error', 'Sem permissão para excluir.');

            return;
        }

        if ($this->post->type === 'poll') {
            $this->confirmingPollDeletion = true;
        } else {
            $this->confirmingPostDeletion = true;
        }
    }

    public function cancelDeletePost()
    {
        $this->confirmingPostDeletion = false;
        $this->confirmingPollDeletion = false;
    }

    public function deletePost()
    {
        $user = auth()->user();
        if ($this->post->user_id != $user->id && ! $user->isAdmin()) {
            session()->flash('error', 'Sem permissão para excluir.');

            return;
        }

        $this->post->delete();
        $this->confirmingPostDeletion = false;
        $this->confirmingPollDeletion = false;
        $this->dispatch('post-deleted');
        $message = $this->post->type === 'poll' ? 'Enquete excluída!' : 'Post excluído!';
        session()->flash('message', $message);
    }

    public function vote($optionId)
    {
        if (! $this->post->is_poll) {
            return;
        }

        $user = auth()->user();
        $isMultiple = (bool) (is_array($this->post->meta) && ($this->post->meta['isMultiple'] ?? false));

        // Single choice check
        if (! $isMultiple && $this->post->hasVoted($user)) {
            return;
        }

        // Check if already voted for THIS specific option
        if ($this->post->pollVotes()->where('user_id', $user->id)->where('poll_option_id', $optionId)->exists()) {
            return;
        }

        $option = \App\Models\PollOption::find($optionId);
        if (! $option || $option->post_id !== $this->post->id) {
            return;
        }

        \App\Models\PollVote::create([
            'user_id' => $user->id,
            'post_id' => $this->post->id,
            'poll_option_id' => $option->id,
        ]);

        $option->increment('votes_count');

        $this->post->refresh();
    }

    public function render()
    {
        return view('livewire.home.partials.post-item');
    }
}
