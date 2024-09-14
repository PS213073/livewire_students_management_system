<?php

namespace App\Livewire;

use App\Models\Classes;
use Livewire\Component;

class CreateStudent extends Component
{
    public function render()
    {
        return view('livewire.create-student', [
            'classes' => Classes::all()
        ]);
    }
}
