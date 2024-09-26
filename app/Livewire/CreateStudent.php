<?php

namespace App\Livewire;

use App\Livewire\Forms\CreateStudentForm;
use App\Models\Classes;
use Filament\Notifications\Notification;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateStudent extends Component
{
    public CreateStudentForm $form;

    #[Validate('required')]
    public $class_id;

    public function addStudent()
    {
        $this->validate();

        $this->form->storeStudent($this->class_id);

        Notification::make()
            ->title('Student added successfully')
            ->success()
            ->send();
//        return $this->redirect(route('students.index'), navigate:true);
        return redirect(route('students.index'));

    }

    public function updatedClassId($classId)
    {
        $this->form->setSections($classId);
    }

    public function render()
    {
        return view('livewire.create-student', [
            'classes' => Classes::all()
        ]);
    }
}
