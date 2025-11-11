<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pemesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 5px 0;
            font-size: 11px;
        }

        .info {
            margin-bottom: 20px;
        }

        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f5f5f5;
        }

        .summary div {
            flex: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #16a34a;
            color: white;
            font-size: 11px;
        }

        td {
            font-size: 11px;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        @media print {
            body {
                margin: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ $setting->pangkalan_name }}</h1>
        <p>{{ $setting->pangkalan_address }}</p>
        <p>Telp: {{ $setting->pangkalan_phone }}</p>
    </div>

    <h2 style="text-align: center; margin-bottom: 20px;">LAPORAN PEMESANAN</h2>

    <div class="info">
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d/m/Y H:i') }}</p>
        @if (request('date_from') || request('date_to'))
            <p>
                <strong>Periode:</strong>
                {{ request('date_from') ? \Carbon\Carbon::parse(request('date_from'))->format('d/m/Y') : '-' }}
                s/d
                {{ request('date_to') ? \Carbon\Carbon::parse(request('date_to'))->format('d/m/Y') : '-' }}
            </p>
        @endif
        @if (request('status'))
            <p><strong>Status:</strong> {{ ucfirst(request('status')) }}</p>
        @endif
    </div>

    <div class="summary">
        <div>
            <strong>Total Pesanan:</strong> {{ $orders->count() }}
        </div>
        <div>
            <strong>Total Tabung:</strong> {{ $totalQuantity }}
        </div>
        <div>
            <strong>Total Pendapatan:</strong> Rp {{ number_format($totalRevenue, 0, ',', '.') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">No. Pesanan</th>
                <th width="20%">Pelanggan</th>
                <th width="15%">Tanggal</th>
                <th width="10%">Jumlah</th>
                <th width="15%">Total</th>
                <th width="20%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $order->quantity }} tabung</td>
                    <td class="text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td>{{ $order->getStatusLabel() }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>{{ $setting->pangkalan_name }}</p>
        <br><br><br>
        <p>_____________________</p>
        <p>Pimpinan</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()"
            style="background-color: #16a34a; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 14px;">
            <i class="fas fa-print"></i> Cetak Laporan
        </button>
        <button onclick="window.close()"
            style="background-color: #6b7280; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 14px; margin-left: 10px;">
            Tutup
        </button>
    </div>

    <script>
        // Auto print when page loads
        // window.onload = function() { window.print(); }
    </script>
</body>

</html>
