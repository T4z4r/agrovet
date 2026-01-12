<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class ProductImportTemplate implements FromCollection, WithHeadings, WithTitle, WithEvents, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect([
            [
                'name' => 'Item Name',
                'unit' => 'kg',
                'category' => 'Category',
                'stock' => 100,
                'cost_price' => 5000,
                'selling_price' => 6000,
                'minimum_quantity' => 10,
                'barcode' => '123456789012'
            ],
            
        ]);
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
        return 'Product Import Template';
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
                        'color' => ['argb' => 'FFFFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF741222'],
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