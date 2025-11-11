@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
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
                    <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $pendingOrders }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs uppercase">Diproses</p>
                    <p class="text-2xl font-bold text-blue-600 mt-1">{{ $processingOrders }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-sync text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs uppercase">Dikirim</p>
                    <p class="text-2xl font-bold text-purple-600 mt-1">{{ $deliveredOrders }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-truck text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-xs uppercase">Total Pelanggan</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalCustomers }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentOrders as $order)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $order->order_number }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $order->user->name }}</td>
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
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500 text-sm">
                                Belum ada pesanan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($recentOrders->count() > 0)
            <div class="p-5 border-t border-gray-200">
                <a href="{{ route('admin.orders') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                    Lihat Semua Pesanan <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        @endif
    </div>
@endsection
