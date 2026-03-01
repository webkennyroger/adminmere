<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class PollForm extends Form
{
    public $title = '';

    public $content = '';

    public $options = ['', ''];

    public $isMultiple = false;

    public $duration = 7;

    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:100',
            'content' => 'required|string|min:3',
            'options' => 'required|array|min:2|max:5',
            'options.*' => 'required|string|max:255',
        ];
    }
}
