<?php

namespace App\Livewire;

use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ListStudents extends Component
{
    use WithPagination;

    public string $search = '';

    public function render()
    {
        $query = Student::query();

        $query = $this->applySearch($query);

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

    public function deleteStudent($stidentId)
    {
        Student::find($stidentId)->delete();
    }
}
