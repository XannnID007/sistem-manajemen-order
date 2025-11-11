<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class OrdersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
     protected $dateFrom;
     protected $dateTo;
     protected $status;

     public function __construct($dateFrom = null, $dateTo = null, $status = null)
     {
          $this->dateFrom = $dateFrom;
          $this->dateTo = $dateTo;
          $this->status = $status;
     }

     public function collection()
     {
          $query = Order::with('user')->latest();

          if ($this->dateFrom) {
               $query->whereDate('created_at', '>=', $this->dateFrom);
          }

          if ($this->dateTo) {
               $query->whereDate('created_at', '<=', $this->dateTo);
          }

          if ($this->status) {
               $query->where('status', $this->status);
          }

          return $query->get();
     }

     public function headings(): array
     {
          return [
               'No',
               'No. Pesanan',
               'Nama Pelanggan',
               'NIK',
               'No. Telepon',
               'Alamat Pengiriman',
               'Tanggal Pesanan',
               'Jumlah Tabung',
               'Harga per Tabung',
               'Total Harga',
               'Status',
               'Tanggal Konfirmasi',
               'Catatan',
          ];
     }

     public function map($order): array
     {
          static $no = 0;
          $no++;

          return [
               $no,
               $order->order_number,
               $order->user->name,
               $order->user->nik,
               $order->user->phone,
               $order->delivery_address,
               $order->created_at->format('d/m/Y H:i'),
               $order->quantity,
               number_format($order->total_price / $order->quantity, 0, ',', '.'),
               number_format($order->total_price, 0, ',', '.'),
               $order->getStatusLabel(),
               $order->confirmed_at ? $order->confirmed_at->format('d/m/Y H:i') : '-',
               $order->notes ?? '-',
          ];
     }

     public function styles(Worksheet $sheet)
     {
          // Style untuk header
          $sheet->getStyle('A1:M1')->applyFromArray([
               'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
               ],
               'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '16A34A'], // Green-600
               ],
               'borders' => [
                    'allBorders' => [
                         'borderStyle' => Border::BORDER_THIN,
                    ],
               ],
               'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
               ],
          ]);

          // Border untuk semua cell yang ada data
          $highestRow = $sheet->getHighestRow();
          $sheet->getStyle('A1:M' . $highestRow)->applyFromArray([
               'borders' => [
                    'allBorders' => [
                         'borderStyle' => Border::BORDER_THIN,
                         'color' => ['rgb' => 'CCCCCC'],
                    ],
               ],
          ]);

          // Alignment untuk kolom angka
          $sheet->getStyle('H2:J' . $highestRow)->getAlignment()
               ->setHorizontal(Alignment::HORIZONTAL_RIGHT);

          // Alignment untuk No
          $sheet->getStyle('A2:A' . $highestRow)->getAlignment()
               ->setHorizontal(Alignment::HORIZONTAL_CENTER);

          return [];
     }

     public function title(): string
     {
          return 'Laporan Pemesanan';
     }
}
