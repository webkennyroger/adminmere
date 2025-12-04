<?php

namespace App\Livewire\Schedule;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Schedule;
use Livewire\Attributes\On;

class EventModal extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $editMode = false;
    public $eventId = null;

    // Event properties
    public $title = '';
    public $description = '';
    public $event_date = '';
    public $event_time = '';
    public $color = '#3b82f6';
    public $photo;
    public $existingPhoto = null;

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'color' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ];
    }

    #[On('openCreateModal')]
    public function openCreateModal($date, $time = '09:00')
    {
        $this->resetForm();
        $this->event_date = $date;
        $this->event_time = $time;
        $this->editMode = false;
        $this->showModal = true;
    }

    #[On('openEditModal')]
    public function openEditModal($eventId)
    {
        $event = Schedule::findOrFail($eventId);
        
        $this->eventId = $event->id;
        $this->title = $event->title;
        $this->description = $event->description;
        $this->event_date = $event->event_date->format('Y-m-d');
        $this->event_time = $event->event_time;
        $this->color = $event->color;
        $this->existingPhoto = $event->photo;
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function saveEvent()
    {
        $this->validate();

        $data = [
            'user_id' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
            'event_date' => $this->event_date,
            'event_time' => $this->event_time,
            'color' => $this->color,
        ];

        if ($this->photo) {
            $data['photo'] = $this->photo->store('events', 'public');
        }

        if ($this->editMode) {
            $event = Schedule::findOrFail($this->eventId);
            $event->update($data);
            session()->flash('message', 'Evento atualizado com sucesso!');
        } else {
            Schedule::create($data);
            session()->flash('message', 'Evento criado com sucesso!');
        }

        $this->closeModal();
        $this->dispatch('eventSaved');
    }

    public function deleteEvent()
    {
        if ($this->eventId) {
            Schedule::findOrFail($this->eventId)->delete();
            session()->flash('message', 'Evento excluído com sucesso!');
            $this->closeModal();
            $this->dispatch('eventSaved');
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset([
            'eventId',
            'title',
            'description',
            'event_date',
            'event_time',
            'color',
            'photo',
            'existingPhoto',
            'editMode',
        ]);
        $this->color = '#3b82f6';
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.schedule.event-modal');
    }
}
