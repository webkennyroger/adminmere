<?php

namespace App\Livewire\Activities;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Activity;
use Livewire\Attributes\Layout;

class ActivityList extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';

    #[Layout('layouts.app')] 
    public function render()
    {
        $activities = Activity::with('user', 'comments', 'likes')
            ->where(function($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                  ->orWhere('description', 'like', '%'.$this->search.'%');
            })
            ->latest('start_time')
            ->paginate(10);

        return view('livewire.activities.activity-list', [
            'activities' => $activities,
        ]);
    }
}
