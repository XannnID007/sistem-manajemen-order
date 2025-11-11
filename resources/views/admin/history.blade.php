@extends('layouts.app')

@section('title', 'Riwayat Pemesanan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Riwayat Pemesanan</h1>
    <p class="text-gray-600 text-sm mt-1">Lihat dan cetak laporan pemesanan</p>
</div>

<div class="bg-white rounded-lg shadow mb-6">
    <div class="p-5">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Diproses</option>
                    <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Dikirim</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm font-medium flex-1">
                    <i class="fas fa-search mr-1"></i> Filter
                </button>
                <button type="button" onclick="printReport()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                    <i class="fas fa-print"></i>
                </button>
                <button type="button" onclick="exportExcel()" class="bg-green-700 text-white px-4 py-2 rounded-lg hover:bg-green-800 transition text-sm font-medium">
                    <i class="fas fa-file-excel"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs uppercase">Total Pendapatan</p>
                <p class="text-2xl font-bold text-green-600 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs uppercase">Total Tabung Terjual</p>
                <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalQuantity }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas fa-gas-pump text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Pesanan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                <tr>
                    <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $order->order_number }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $order->user->name }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $order->quantity }} tabung</td>
                    <td class="px-4 py-3 text-sm text-gray-900 font-medium">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs font-medium rounded {{ $order->getStatusBadgeClass() }}">
                            {{ $order->getStatusLabel() }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500 text-sm">
                        Tidak ada data ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
    <div class="p-5 border-t border-gray-200">
        {{ $orders->links() }}
    </div>
    @endif
</div>

<script>
    function printReport() {
        const params = new URLSearchParams(window.location.search);
        window.open('/admin/report/print?' + params.toString(), '_blank');
    }

    function exportExcel() {
        const params = new URLSearchParams(window.location.search);
        window.location.href = '/admin/report/excel?' + params.toString();
    }
</script>
@endsection