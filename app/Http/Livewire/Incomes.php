<?php

namespace App\Http\Livewire;

use App\Models\Warehouse;
use Livewire\Component;

class Incomes extends Component
{
    public $incomes;
    public $perPage;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    public function mount()
    {
        $this->perPage = 10;
    }

    public function render()
    {
        $this->incomes = Warehouse::orderBy($this->sortBy, $this->sortDirection)->get();

        return view('livewire.incomes', [
            'incomes' => $this->incomes,
        ]);
    }

    public function sortBy($field)
    {
        if ($this->sortDirection == 'asc') {
            $this->sortDirection = 'desc';
        } else {
            $this->sortDirection = 'asc';
        }

        return $this->sortBy = $field;
    }
}
