<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow
{
    protected $user;
    protected $errors = [];

    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            // Skip empty rows
            if (empty($row['name'])) {
                continue;
            }

            try {
                $data = [
                    'name' => $row['name'],
                    'unit' => $row['unit'] ?? 'pcs',
                    'category' => $row['category'] ?? 'General',
                    'stock' => (int) ($row['stock'] ?? 0),
                    'cost_price' => (int) ($row['cost_price'] ?? 0),
                    'selling_price' => (int) ($row['selling_price'] ?? 0),
                    'minimum_quantity' => (int) ($row['minimum_quantity'] ?? 0),
                    'barcode' => $row['barcode'] ?? null,
                ];

                // Set shop_id and branch_id based on user
                if ($this->user->role !== 'owner' && $this->user->branch_id) {
                    $data['branch_id'] = $this->user->branch_id;
                    $data['shop_id'] = $this->user->shop_id;
                }

                $product = Product::create($data);

                // Create stock transaction if initial stock > 0
                if ($data['stock'] > 0) {
                    StockTransaction::create([
                        'branch_id' => $product->branch_id,
                        'product_id' => $product->id,
                        'type' => 'stock_in',
                        'quantity' => $data['stock'],
                        'supplier_id' => null,
                        'recorded_by' => Auth::id(),
                        'date' => now()->toDateString(),
                        'remarks' => 'Initial stock on bulk import'
                    ]);
                }
            } catch (\Exception $e) {
                $this->errors[] = 'Row ' . ($collection->search($row) + 2) . ': ' . $e->getMessage();
            }
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
