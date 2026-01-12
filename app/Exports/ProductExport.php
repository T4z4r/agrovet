<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class ProductExport implements FromCollection, WithHeadings, WithTitle, WithEvents, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Product::all();
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

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Agrovet Products';
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:H1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            },
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 10,
            'C' => 15,
            'D' => 10,
            'E' => 15,
            'F' => 15,
            'G' => 20,
            'H' => 15,
        ];
    }
}
