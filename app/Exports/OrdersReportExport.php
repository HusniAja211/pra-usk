<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class OrdersReportExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    public function collection()
{
    return DB::table('orders')
        ->join('books', 'books.id', '=', 'orders.book_id')
        ->select(
            'orders.id as order_id',
            'books.title as judul',
            DB::raw("CONCAT('Rp ', FORMAT(books.modal, 0, 'id_ID')) as modal"),
            DB::raw("CONCAT('Rp ', FORMAT(books.price, 0, 'id_ID')) as harga_jual"),
            DB::raw("CONCAT('Rp ', FORMAT(books.profit, 0, 'id_ID')) as keuntungan_satuan"),
            DB::raw("CONCAT('Rp ', FORMAT(books.profit * orders.qty, 0, 'id_ID')) as total_keuntungan"),
            'orders.qty',
            'orders.created_at as tanggal_order'
        )
        ->get();
}

    public function headings(): array
    {
        return [
            'ID Order',
            'Judul',
            'Modal',
            'Harga Jual',
            'Keuntungan (Satuan)',
            'Total Keuntungan',
            'Quantity',
            'Tanggal Order'
        ];
    }

    // Styling header
    public function styles(Worksheet $sheet)
    {
        // Header (baris 1)
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'], // teks putih
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4CAF50'], // hijau
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);
    }

    // Set lebar kolom
    public function columnWidths(): array
    {
        return [
            'A' => 10,  // ID Order
            'B' => 25,  // Judul
            'C' => 15,  // Modal
            'D' => 15,  // Harga Jual
            'E' => 20,  // Keuntungan (Satuan)
            'F' => 20,  // Total Keuntungan
            'G' => 10,  // Quantity
            'H' => 25,  // Tanggal Order
        ];
    }
}