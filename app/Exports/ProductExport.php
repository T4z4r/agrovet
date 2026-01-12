<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect([]);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'name',
            'unit',
            'category',
            'stock',
            'cost_price',
            'selling_price',
            'minimum_quantity',
            'barcode'
        ];
    }
}
