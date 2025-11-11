@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Pelanggan</h1>
        <p class="text-gray-600 text-sm mt-1">Selamat datang, {{ auth()->user()->name }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs uppercase">Total Pesanan</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalOrders }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs uppercase">Menunggu</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $pendingOrders }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs uppercase">Selesai</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $completedOrders }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-5 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Aksi Cepat</h2>
        </div>
        <div class="p-5">
            <a href="{{ route('customer.order.create') }}"
                class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition text-sm font-medium">
                <i class="fas fa-plus mr-2"></i> Buat Pesanan Baru
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-5 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Pesanan Terbaru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Pesanan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentOrders as $order)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $order->order_number }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $order->quantity }} tabung</td>
                            <td class="px-4 py-3 text-sm text-gray-900 font-medium">Rp
                                {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs font-medium rounded {{ $order->getStatusBadgeClass() }}">
                                    {{ $order->getStatusLabel() }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500 text-sm">
                                Belum ada pesanan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($recentOrders->count() > 0)
            <div class="p-5 border-t border-gray-200">
                <a href="{{ route('customer.orders') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                    Lihat Semua Pesanan <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        @endif
    </div>
@endsection
