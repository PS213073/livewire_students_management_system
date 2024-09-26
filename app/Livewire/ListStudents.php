<?php

namespace App\Livewire;

use App\Exports\StudentsExport;
use App\Models\Student;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListStudents extends Component
{
    use WithPagination;

    public string $search = '';

    public string $sortColumn = 'created_at', $sortDirection = 'desc';

    public array $selectedStudentIds = [];

    public function render()
    {
        $query = Student::query();

        $query = $this->applySearch($query);

        $query = $this->applySort($query);

        return view('livewire.list-students',
            ['students' => $query->paginate(10)]
        );
    }

    public function applySearch(Builder $query): Builder
    {
        return $query->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%');
//            ->orWhereHas('class', function ($query) {             // for implimenting class search
//                $query->where('name', 'like', '%' . $this->search . '%');
//            });
    }

    protected function applySort(): Builder
    {
        return Student::query()
            ->orderBy($this->sortColumn, $this->sortDirection);
    }

    public function sortBy(string $column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function queryString(): array
    {
        return [
            'sortColumn',
            'sortDirection',
        ];
    }

    public function deleteStudents(): void
    {
        $students = Student::find($this->selectedStudentIds);
        foreach ($students as $student) {
            $this->deleteStudent($student);
        }

        Notification::make()
            ->title('Selected records deleted successfully!')
            ->success()
            ->send();
    }

    public function deleteStudent(Student $student): void
    {
        // Authorization check


        $student->delete();
    }

    public function export()
    {
        return (new StudentsExport($this->selectedStudentIds))->download(now() . 'students.xlsx');
    }
}
