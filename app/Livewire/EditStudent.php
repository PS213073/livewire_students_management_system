<?php

namespace App\Livewire;

use App\Livewire\Forms\UpdateStudentForm;
use App\Models\Classes;
use App\Models\Student;
use Filament\Notifications\Notification;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditStudent extends Component
{
    public Student $student;

    public UpdateStudentForm $form;

    public $class_id;

    public $email;

    public function mount()
    {
        $this->form->setStudent($this->student);

        $this->fill($this->student->only([
            'class_id',
            'email'
        ]));
    }

    public function updateStudent()
    {
        $this->validate([
            'email' => 'required|email|unique:students,email,' . $this->student->id,
            'class_id' => 'required',
        ]);

        $this->form->updateStudent($this->class_id, $this->email);

        Notification::make()
            ->title('Student updated successfully')
            ->success()
            ->send();

         return redirect(route('students.index'));
    }

    public function updatedClassId($classId)
    {
        $this->form->setSections($classId);
    }

    public function render()
    {
        return view('livewire.edit-student', [
            'classes' => Classes::all(),
        ]);
    }
}
