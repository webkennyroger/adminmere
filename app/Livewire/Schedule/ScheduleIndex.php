<?php

namespace App\Livewire\Schedule;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Schedule;

class ScheduleIndex extends Component
{
    public function getEvents()
    {
        $events = Schedule::where('user_id', auth()->id())
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->event_date->format('Y-m-d'),
                    'end' => $event->event_date->format('Y-m-d'),
                    'extendedProps' => [
                        'calendar' => $event->color ?? 'Primary',
                    ]
                ];
            })
            ->values()
            ->toArray();

        return $events;
    }

    public function createEvent($title, $startDate, $endDate, $eventLevel)
    {
        Schedule::create([
            'user_id' => auth()->id(),
            'title' => $title,
            'event_date' => $startDate,
            'event_time' => '00:00',
            'color' => $eventLevel,
        ]);

        return ['success' => true];
    }

    public function updateEvent($eventId, $title, $startDate, $endDate, $eventLevel)
    {
        $event = Schedule::where('user_id', auth()->id())->findOrFail($eventId);
        
        $event->update([
            'title' => $title,
            'event_date' => $startDate,
            'color' => $eventLevel,
        ]);

        return ['success' => true];
    }

    public function deleteEvent($eventId)
    {
        $event = Schedule::where('user_id', auth()->id())->findOrFail($eventId);
        $event->delete();

        return ['success' => true];
    }

    public function render()
    {
        return view('livewire.schedule.schedule-index');
    }
}
