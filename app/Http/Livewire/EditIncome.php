<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Warehouse;
use Livewire\Component;

class EditIncome extends Component
{
    public $products;
    public $search = '';
    public $incomeProducts = [];
    public $productQuantities = [];
    public $productPrices = [];
    public $income;

    protected $validationAttributes = [
        'productQuantities.*' => 'Количество',
        'productPrices.*' => 'Цена',
    ];

    public function mount()
    {
        $this->products = Product::all();
        if ($this->income->products()->exists()) {
            $products = $this->income->products;
            foreach ($products as $product) {
                array_push($this->incomeProducts, $product->toArray());
                array_push($this->productQuantities, $product->pivot->quantity);
                array_push($this->productPrices, $product->pivot->price);
            }
        }
    }

    public function render()
    {
        $this->products = Product::query()->searchName($this->search)->get();

        return view('livewire.edit-income', [
            'products' => $this->products,
            'incomeProducts' => $this->incomeProducts,
            'productQuantities' => $this->productQuantities,
            'productPrices' => $this->productPrices,
        ]);
    }

    public function addIncomeProduct(Product $product)
    {
        if ($product) {
            array_push($this->incomeProducts, $product->toArray());
            array_push($this->productQuantities, array());
            array_push($this->productPrices, array());
        }
    }

    public function deleteProduct($index)
    {
        unset($this->incomeProducts[$index]);
        unset($this->productQuantities[$index]);
        unset($this->productPrices[$index]);
    }

    public function updateIncome()
    {
        $this->validate([
            'productQuantities.*' => 'required|numeric|min:1',
            'productPrices.*' => 'required|numeric|min:1',
        ]);

        $productsArray = array();
        foreach ($this->incomeProducts as $index => $product) {
            $productsArray[$product['id']] = ['quantity' => $this->productQuantities[$index], 'price' => $this->productPrices[$index]];
        }

        $this->income->products()->sync($productsArray);

        return redirect()->to('/warehouse');
    }
}
