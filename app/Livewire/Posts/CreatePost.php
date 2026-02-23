<?php

namespace App\Livewire\Posts;

use App\Actions\Posts\CreatePost as CreatePostAction;
use App\Livewire\Forms\PostForm;
use App\Livewire\Forms\PollForm;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

class CreatePost extends Component
{
    use WithFileUploads;

    public PostForm $postForm;
    public PollForm $pollForm;
    
    public $isPoll = false;
    public $feedType = 'personal';

    public function togglePoll()
    {
        $this->isPoll = !$this->isPoll;
    }

    public function addPollOption()
    {
        if (count($this->pollForm->options) < 5) {
            $this->pollForm->options[] = '';
        }
    }

    public function removePollOption($index)
    {
        if (count($this->pollForm->options) > 2) {
            unset($this->pollForm->options[$index]);
            $this->pollForm->options = array_values($this->pollForm->options);
        }
    }

    public function save(CreatePostAction $createPostAction)
    {
        if ($this->isPoll) {
            $this->pollForm->validate();
        } else {
            $this->postForm->validate();
        }

        $media = [];

        // Single implementation of media handling
        if ($this->postForm->photos) {
            foreach ($this->postForm->photos as $photo) {
                $path = $photo->store('posts/' . auth()->id(), 'public');
                $media[] = url('storage/' . $path);
            }
        }

        if ($this->postForm->videos) {
            foreach ($this->postForm->videos as $video) {
                $path = $video->store('posts/' . auth()->id() . '/videos', 'public');
                $media[] = url('storage/' . $path);
            }
        }

        $post = $createPostAction->execute([
            'user_id' => auth()->id(),
            'title' => $this->isPoll ? $this->pollForm->title : $this->postForm->title,
            'content' => $this->isPoll ? $this->pollForm->content : $this->postForm->content,
            'media' => $media,
            'feed_type' => $this->feedType,
            'location' => $this->postForm->location ?: (auth()->user()->profile->city ?? null),
            'privacy' => 'public',
            'type' => $this->isPoll ? 'poll' : 'post',
            'poll_options' => $this->isPoll ? $this->pollForm->options : [],
            'poll_expires_at' => $this->isPoll ? now()->addDays((int)$this->pollForm->duration) : null,
            'meta' => $this->isPoll ? ['isMultiple' => (bool)$this->pollForm->isMultiple] : null,
        ]);

        $this->reset(['isPoll']);
        $this->postForm->reset();
        $this->pollForm->reset();

        session()->flash('message', 'Publicado com sucesso! 🎉');
        
        $this->dispatch('post-created');
        $this->dispatch('refresh-feed');
    }

    public function render()
    {
        return view('livewire.posts.create-post');
    }
}
