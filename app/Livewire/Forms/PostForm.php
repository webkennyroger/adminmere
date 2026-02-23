<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class PostForm extends Form
{
    public $title = '';
    public $content = '';
    public $photos = [];
    public $videos = [];
    public $feedType = 'personal';
    public $location = '';
    public $privacy = 'public';

    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:100',
            'content' => 'required|min:3',
            'photos.*' => 'nullable|image|max:20480',
            'photos' => 'nullable|array|max:5',
            'videos.*' => 'nullable|mimes:mp4,mov,ogg,qt|max:102400',
            'videos' => 'nullable|array|max:1',
        ];
    }
}
