<?php

namespace App\Http\Livewire;

use App\Imports\ProductsImport;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Excel;

class Products extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $products = [];
    public $suppliers;
    public $isEditable;
    public $newRow;
    public $sku;
    public $name;
    public $brand;
    public $kaspi_price;
    public $pre_order;
    public $supplier;
    public $img;
    public $imgFile;
    public $storedImg;
    public $imageChange;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $search = '';
    public $perPage = 10;
    public $active;
    public $isImport;

    public $importSupplier;
    public $importFile;

    // protected $rules = [
    //     'products.*.sku' => ['required', 'unique:products,sku'],
    //     'products.*.name' => ['required'],
    //     'products.*.brand' => ['required'],
    //     'products.*.kaspi_price' => ['required', 'numeric', 'min:0'],
    //     'products.*.supplier' => ['required', 'numeric', 'exists:suppliers,id'],
    //     'imgFile' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:100000'],
    // ];

    // protected $messages = [
    //     'email.required' => 'The Email Address cannot be empty.',
    //     'email.email' => 'The Email Address format is not valid.',
    // ];

    protected $validationAttributes = [
        'products.*.sku' => 'Артикул',
        'products.*.name' => 'Название',
        'products.*.brand' => 'Бренд',
        'products.*.kaspi_price' => 'Цена Kaspi',
        'products.*.pre_order' => 'Пред. заказ',
        'products.*.supplier' => 'Поставщик',
        'imgFile' => 'Картинка',
    ];

    public function mount()
    {
        $this->products = Product::all()->toArray();
        $this->newRow = false;
        $this->active = true;
        $this->isImport = false;
        $this->importFile = null;
    }

    public function render()
    {
        $paginated = Product::query()
            ->search($this->search)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->with('supplier')
            ->paginate($this->perPage);

        $this->products = collect($paginated->items())->toArray();

        $this->suppliers = Supplier::all();

        return view('livewire.products', [
            'products' => $this->products,
            'paginated' => $paginated,
            'suppliers' => $this->suppliers,
        ]);
    }

    public function setPerPage($count)
    {
        $this->perPage = $count;
        $this->resetPage();
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
        $this->isEditable = null;
    }

    public function removeNewRow()
    {
        $this->newRow = false;
        $this->sku = null;
        $this->name = null;
        $this->brand = null;
        $this->kaspi_price = null;
        $this->pre_order = null;
        $this->imgFile = null;
        $this->storedImg = null;
        $this->active = true;
        $this->supplier = null;
        $this->resetValidation();
    }

    public function editProduct($index)
    {
        $this->isEditable = $index;
    }

    public function uneditProduct($index)
    {
        $this->isEditable = null;
        $this->imageChange = null;
        $this->imgFile = null;
        $this->storedImg = null;
    }

    public function saveProduct($index)
    {
        $this->validate([
            'products.' . $index . '.sku' => 'required|unique:products,sku,' . $this->products[$index]['id'],
            'products.' . $index . '.name' => 'required',
            'products.' . $index . '.brand' => 'required',
            'products.' . $index . '.kaspi_price' => 'required|numeric|min:0',
            'products.' . $index . '.pre_order' => 'required|numeric|min:0',
            'products.' . $index . '.supplier_id' => 'required|numeric|exists:suppliers,id',
            'imgFile' => 'nullable|mimes:jpeg,jpg,png,gif|max:100000',
        ]);

        $product = $this->products[$index] ?? NULL;
        if (!is_null($product)) {
            $editedProduct = Product::find($product['id']);
            if ($editedProduct) {
                $editedProduct->sku = $this->products[$index]['sku'];
                $editedProduct->name = $this->products[$index]['name'];
                $editedProduct->brand = $this->products[$index]['brand'];
                $editedProduct->kaspi_price = $this->products[$index]['kaspi_price'];
                $editedProduct->pre_order = $this->products[$index]['pre_order'];
                $editedProduct->supplier_id = $this->products[$index]['supplier_id'];
                $editedProduct->active = $this->products[$index]['active'];

                if ($this->imageChange !== null) {
                    if (Storage::disk('public')->exists($editedProduct->img)) {
                        Storage::disk('public')->delete($editedProduct->img);
                    }
                    if ($this->imgFile) {
                        $path = $this->imgFile->store("assets/images/products", ['disk' => 'public']);
                        $this->storedImg = '/' . $path;
                        $editedProduct->img = $this->storedImg;
                    } else {
                        $editedProduct->img = null;
                    }
                }

                $editedProduct->save();
            }
        }

        $this->isEditable = null;
        $this->imageChange = null;
        $this->imgFile = null;
        $this->storedImg = null;
    }

    public function storeProduct()
    {
        $this->validate([
            'sku' => 'required|unique:products,sku',
            'name' => 'required',
            'brand' => 'required',
            'kaspi_price' => 'required|numeric|min:0',
            'pre_order' => 'required|numeric|min:0',
            'imgFile' => 'nullable|mimes:jpeg,jpg,png,gif|max:100000',
            'supplier' => 'required|numeric|exists:suppliers,id',
        ]);

        $product = new Product;
        $product->sku = $this->sku;
        $product->name = $this->name;
        $product->brand = $this->brand;
        $product->kaspi_price = $this->kaspi_price;
        $product->pre_order = $this->pre_order;
        $product->supplier_id = $this->supplier;
        $product->active = $this->active;

        if ($this->imgFile) {
            $path = $this->imgFile->store("assets/images/products", ['disk' => 'public']);
            $this->storedImg = '/' . $path;
            $product->img = $this->storedImg;
        }

        $product->save();

        $this->removeNewRow();
    }

    public function deleteProduct($index)
    {
        $product = $this->products[$index] ?? NULL;
        if (!is_null($product)) {
            $deletedProduct = Product::find($product['id']);
            if ($deletedProduct) {
                if (Storage::disk('public')->exists($deletedProduct->img)) {
                    Storage::disk('public')->delete($deletedProduct->img);
                }
                $deletedProduct->delete();
            }
        }
    }

    public function importProducts()
    {
        $this->validate([
            'importSupplier' => 'required|numeric|exists:suppliers,id',
            'importFile' => 'required|file',
        ]);

        $supplier = Supplier::find($this->importSupplier);

        Excel::import(new ProductsImport($supplier), $this->importFile);
    }
}
