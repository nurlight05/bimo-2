<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public $supplier;

    public function __construct(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }

    public function model(array $row)
    {
        $product = Product::where('sku', $row['sku'])->first();

        if ($product) {
            $product->name = $row['name'];
            $product->brand = $row['brand'];
            $product->kaspi_price = $row['kaspi_price'];
            $product->pre_order = $row['pre_order'];
            $product->supplier_id = $this->supplier->id;
            $product->active = $row['active'];
            $product->save();
            return null;
        } else {
            return new Product([
                'sku' => $row['sku'],
                'name' => $row['name'],
                'brand' => $row['brand'],
                'kaspi_price' => $row['kaspi_price'],
                'pre_order' => $row['pre_order'],
                'supplier_id' => $this->supplier->id,
                'active' => $row['active'],
            ]);
        }
    }
}
