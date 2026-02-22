<?php

namespace App\Livewire\Home\Partials;

use App\Models\Post;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;

class ActivityFeed extends Component
{
    #[Reactive]
    public $feed = 'personal';

    use WithFileUploads;

    // Propriedades do Novo Post
    public $title = '';
    public $content = '';
    public $photos = [];  // Multiple photos
    public $videos = []; // Video upload
    public $feedType = 'personal';
    public $location = '';

    // Propriedades do Evento
    public $eventTitle = '';
    public $eventDescription = '';
    public $eventDate = '';
    public $eventTime = '';
    public $eventDuration = '';
    public $eventLocation = '';
    public $eventGuestEmail = '';
    public $eventAttachment = null;

    // Poll Properties
    public $isPoll = false;
    public $isMultiple = false;
    public $pollOptions = ['', '']; // Start with 2 empty options
    public $pollDuration = 7; // Days

    public $viewingUserProfile = null;
    public $showPostForm = true;
    public $page = 1;
    public $perPage = 10;
    public $hasMore = true;

    public function viewUserProfile($name)
    {
        $name = trim($name);
        $this->viewingUserProfile = \App\Models\User::where('name', $name)->first();
    }

    public function closeProfileModal()
    {
        $this->viewingUserProfile = null;
    }

    public function loadMore()
    {
        if (! $this->hasMore) {
            return;
        }
        $this->page++;
    }

    // --- Poll Methods ---

    public function togglePoll()
    {
        $this->isPoll = !$this->isPoll;
        if ($this->isPoll && count($this->pollOptions) < 2) {
            $this->pollOptions = ['', ''];
        }
    }

    // Chamado ao publicar enquete via modal
    public function activatePoll()
    {
        $this->isPoll = true;
    }

    public function addPollOption()
    {
        if (count($this->pollOptions) < 5) {
            $this->pollOptions[] = '';
        }
    }


    public function removePollOption($index)
    {
        if (count($this->pollOptions) > 2) {
            unset($this->pollOptions[$index]);
            $this->pollOptions = array_values($this->pollOptions);
        }
    }

    public function savePost()
    {
        Log::info('=== SAVE POST STARTED ===');
        Log::info('Photos count: ' . count($this->photos ?? []));
        Log::info('Content: ' . $this->content);
        Log::info('Feed type: ' . $this->feedType);

        $rules = [
            'title' => 'nullable|string|max:100',
            'content' => 'required|min:3',
            'photos.*' => 'nullable|image|max:20480', // 20MB per photo
            'photos' => 'nullable|array|max:5', // Max 5 photos
            'videos.*' => 'nullable|mimes:mp4,mov,ogg,qt|max:102400', // 100MB per video
            'videos' => 'nullable|array|max:1', // Max 1 video
        ];

        if ($this->isPoll) {
            $rules['pollOptions.*'] = 'required|string|max:255';
            $rules['pollOptions'] = 'array|min:2';
        }

        $this->validate($rules);
        Log::info('Validation passed');

        $media = [];

        if ($this->photos && count($this->photos) > 0) {
            Log::info('Processing ' . count($this->photos) . ' photos');
            foreach ($this->photos as $index => $photo) {
                try {
                    $path = $photo->store('posts/' . auth()->id(), 'public');
                    $fullUrl = url('storage/' . $path);
                    $media[] = $fullUrl;
                    Log::info("Photo {$index} stored: {$path} -> {$fullUrl}");
                } catch (\Exception $e) {
                    Log::error("Failed to store photo {$index}: " . $e->getMessage());
                }
            }
        }

        if ($this->videos && count($this->videos) > 0) {
            Log::info('Processing ' . count($this->videos) . ' videos');
            foreach ($this->videos as $index => $video) {
                try {
                    $path = $video->store('posts/' . auth()->id() . '/videos', 'public');
                    $fullUrl = url('storage/' . $path);
                    $media[] = $fullUrl;
                    Log::info("Video {$index} stored: {$path} -> {$fullUrl}");
                } catch (\Exception $e) {
                    Log::error("Failed to store video {$index}: " . $e->getMessage());
                }
            }
        }

        Log::info('Media array: ' . json_encode($media));

        try {
            $postData = [
                'user_id' => auth()->id(),
                'title' => $this->title ?: null,
                'content' => $this->content,
                'media' => $media,
                'feed_type' => $this->feedType,
                'location' => $this->location ?: (auth()->user()->profile->city ?? null),
                'privacy' => 'public',
                'type' => $this->isPoll ? 'poll' : 'post',
                'poll_expires_at' => $this->isPoll ? now()->addDays((int)$this->pollDuration) : null,
                'meta' => $this->isPoll ? ['isMultiple' => (bool)$this->isMultiple] : null,
            ];

            Log::info('Creating post with data: ' . json_encode($postData));
            $post = Post::create($postData);
            Log::info('Post created successfully with ID: ' . $post->id);

            if ($this->isPoll) {
                foreach ($this->pollOptions as $optionText) {
                    if (trim($optionText)) {
                        $post->pollOptions()->create(['option_text' => trim($optionText)]);
                    }
                }
            }

            $this->reset(['title', 'content', 'photos', 'videos', 'location', 'isPoll', 'pollOptions', 'isMultiple']);
            $this->pollOptions = ['', ''];
            session()->flash('message', 'Publicado com sucesso! 🎉');
            Log::info('=== SAVE POST COMPLETED ===');
            $this->js('window.location.reload()');
        } catch (\Exception $e) {
            Log::error('Failed to create post: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            session()->flash('error', 'Erro ao publicar: ' . $e->getMessage());
        }
    }

    public function saveEvent()
    {
        $this->validate([
            'eventTitle'       => 'required|string|max:200',
            'eventDescription' => 'nullable|string|max:2000',
            'eventDate'        => 'required|date',
            'eventTime'        => 'nullable|string',
            'eventLocation'    => 'nullable|string|max:200',
            'eventAttachment'  => 'nullable|file|max:51200', // 50MB max
        ]);

        $attachmentUrl = null;
        if ($this->eventAttachment) {
            $path = $this->eventAttachment->store('events/attachments', 'public');
            $attachmentUrl = url('storage/' . $path);
        }

        // Salva como post do tipo 'event'
        Post::create([
            'user_id'    => auth()->id(),
            'title'      => $this->eventTitle,
            'content'    => $this->eventDescription ?? '',
            'type'       => 'event',
            'feed_type'  => $this->feedType,
            'privacy'    => 'public',
            'meta'       => [
                'date'           => $this->eventDate,
                'time'           => $this->eventTime,
                'duration'       => $this->eventDuration,
                'location'       => $this->eventLocation,
                'attachment_url' => $attachmentUrl,
            ],
        ]);

        $this->reset(['eventTitle', 'eventDescription', 'eventDate', 'eventTime', 'eventDuration', 'eventLocation', 'eventGuestEmail', 'eventAttachment']);
        session()->flash('message', 'Evento criado com sucesso! 🎉');
        $this->js('window.location.reload()');
    }

    #[On('post-deleted')]
    #[On('activity-deleted')]
    public function refreshFeed(): void
    {
        // This will trigger a re-render of the component
    }

    public function render()
    {
        $user = auth()->user();

        // Users for Mentions
        $mentionableUsers = \App\Models\User::select('id', 'name', 'avatar')->take(50)->get();

        // Fetch Posts
        $postsQuery = Post::with(['user', 'comments.user', 'comments.likes', 'comments.replies.user', 'comments.replies.likes', 'likes', 'pollOptions', 'pollVotes']);

        // Fetch Activities
        $activitiesQuery = \App\Models\Activity::with(['user', 'comments.user', 'comments.likes', 'comments.replies.user', 'comments.replies.likes', 'likes']);

        if ($this->feed === 'timeline' || $this->feed === 'network') {
            // Show public posts and activities from everyone (Discovery mode)
            $postsQuery->where('privacy', 'public');
            $activitiesQuery->where('privacy', 'public');
        } elseif ($this->feed === 'personal') {
            $postsQuery->where('user_id', $user->id);
            $activitiesQuery->where('user_id', $user->id);
        } elseif ($this->feed === 'community') {
            // Community feed shows public posts from everyone
            $postsQuery->where('feed_type', 'community')->orWhere('privacy', 'public');
            // Activities are usually public
            $activitiesQuery->where('privacy', 'public');
        }

        // Get posts and activities
        $posts = $postsQuery->latest('created_at')->limit(50)->get();
        $activities = $activitiesQuery->latest('start_time')->limit(50)->get();

        // Merge and sort by date
        $items = collect([])
            ->merge($posts->map(fn($post) => [
                'type' => 'post',
                'item' => $post,
                'date' => $post->created_at ? $post->created_at->toDateTimeString() : now()->toDateTimeString()
            ]))
            ->merge($activities->map(fn($activity) => [
                'type' => 'activity',
                'item' => $activity,
                'date' => $activity->start_time ? $activity->start_time->toDateTimeString() : now()->toDateTimeString()
            ]))
            ->sortByDesc('date')
            ->take($this->perPage * $this->page)
            ->values();

        $totalCount = $posts->count() + $activities->count();
        $this->hasMore = ($this->perPage * $this->page) < $totalCount;

        return view('livewire.home.partials.activity-feed', [
            'items' => $items,
            'mentionableUsers' => $mentionableUsers,
        ]);
    }
}
