<?php

namespace App\Http\Livewire;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class Suppliers extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $suppliers = [];
    public $isEditable;
    public $newRow;
    public $name;
    public $bonus;
    public $info;
    public $nds;
    public $rrc;
    public $active;
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $search = '';
    public $perPage = 10;

    protected $rules = [
        'suppliers.*.name' => ['required'],
        'suppliers.*.info' => ['required'],
        'suppliers.*.bonus' => ['required', 'between:0.00,100.00'],
    ];

    // protected $messages = [
    //     'email.required' => 'The Email Address cannot be empty.',
    //     'email.email' => 'The Email Address format is not valid.',
    // ];

    protected $validationAttributes = [
        'suppliers.*.name' => 'name',
        'suppliers.*.info' => 'info',
        'suppliers.*.bonus' => 'bonus',
    ];

    public function mount()
    {
        $this->suppliers = Supplier::all()->toArray();
        $this->newRow = false;
        $this->nds = false;
        $this->rrc = false;
        $this->active = true;
    }

    public function render()
    {
        $paginated = Supplier::query()
            ->search($this->search)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        $this->suppliers = collect($paginated->items())->toArray();

        return view('livewire.suppliers', [
            'suppliers' => $this->suppliers,
            'paginated' => $paginated,
        ]);
    }

    public function setPerPage($count)
    {
        $this->perPage = $count;
    }

    public function paginationView()
    {
        return 'vendor.livewire.pagination';
    }

    public function updatingSearch()
    {
        $this->resetPage();
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

    public function addNewRow()
    {
        if (!$this->newRow) {
            $this->newRow = true;
        }
    }

    public function removeNewRow()
    {
        $this->newRow = false;
        $this->name = null;
        $this->bonus = null;
        $this->info = null;
        $this->nds = false;
        $this->rrc = false;
        $this->active = true;
        $this->resetValidation();
    }

    public function editSupplier($index)
    {
        $this->isEditable = $index;
    }

    public function saveSupplier($index)
    {
        $this->validate();

        $supplier = $this->suppliers[$index] ?? NULL;
        if (!is_null($supplier)) {
            $editedSupplier = Supplier::find($supplier['id']);
            if ($editedSupplier) {
                $editedSupplier->update($supplier);
            }
        }
        $this->isEditable = null;
    }

    public function storeSupplier()
    {
        $data = $this->validate([
            'name' => 'required',
            'info' => 'required',
            'bonus' => 'required|between:0.00,100.00',
            'nds' => '',
            'rrc' => '',
            'active' => '',
        ]);

        Supplier::create($data);
        $this->removeNewRow(); 
    }

    public function deleteSupplier($index)
    {
        
    }
}
