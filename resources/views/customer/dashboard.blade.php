@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')
@section('page-title', 'Beranda')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Halo, {{ explode(' ', auth()->user()->name)[0] }}! 👋
            </h1>
            <p class="text-sm text-gray-500 mt-1">Selamat datang kembali di dashboard pemesanan Anda.</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-xl px-4 py-2 shadow-sm flex items-center gap-3">
            <div class="bg-emerald-50 p-2 rounded-lg text-emerald-600">
                <i class="far fa-calendar-alt"></i>
            </div>
            <span class="text-sm font-medium text-gray-600">
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        <div
            class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-lg shadow-emerald-500/20 relative overflow-hidden group">
            <div class="relative z-10 h-full flex flex-col justify-between">
                <div>
                    <h2 class="text-lg font-bold mb-1">Butuh Gas LPG?</h2>
                    <p class="text-emerald-100 text-sm mb-6">Pesan sekarang dengan mudah dan cepat.</p>
                </div>
                <a href="{{ route('customer.order.create') }}"
                    class="inline-flex items-center justify-center w-full bg-white text-emerald-600 font-bold py-3 px-4 rounded-xl shadow-md hover:bg-emerald-50 transition-colors group-hover:scale-[1.02] transform duration-300">
                    <i class="fas fa-plus-circle mr-2"></i> Buat Pesanan Baru
                </a>
            </div>

            <div
                class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all duration-500">
            </div>
            <div class="absolute bottom-0 left-0 -ml-4 -mb-4 w-24 h-24 bg-black/10 rounded-full blur-xl"></div>
            <i
                class="fas fa-gas-pump absolute bottom-4 right-4 text-6xl text-white/10 transform rotate-12 group-hover:rotate-0 transition-transform duration-500"></i>
        </div>

        <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-4">

            <div
                class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <span class="text-xs font-bold bg-blue-50 text-blue-600 px-2 py-1 rounded-md">Total</span>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</h3>
                    <p class="text-xs text-gray-500 mt-1">Semua Pesanan</p>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500">
                        <i class="fas fa-clock"></i>
                    </div>
                    <span class="text-xs font-bold bg-amber-50 text-amber-600 px-2 py-1 rounded-md">Proses</span>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $pendingOrders }}</h3>
                    <p class="text-xs text-gray-500 mt-1">Menunggu Konfirmasi</p>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <span class="text-xs font-bold bg-emerald-50 text-emerald-600 px-2 py-1 rounded-md">Selesai</span>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $completedOrders }}</h3>
                    <p class="text-xs text-gray-500 mt-1">Pesanan Diterima</p>
                </div>
            </div>

        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Pesanan Terbaru</h2>
                <p class="text-xs text-gray-500 mt-1">Riwayat 5 transaksi terakhir Anda.</p>
            </div>
            <a href="{{ route('customer.orders') }}"
                class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 px-3 py-1.5 rounded-lg transition-colors border border-emerald-200">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-left">
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">No. Pesanan</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Harga</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider text-center">
                            Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentOrders as $order)
                        <tr class="group hover:bg-emerald-50/30 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="font-mono text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md border border-emerald-100">
                                    {{ $order->order_number }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600 font-medium">{{ $order->created_at->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }} WIB</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $order->quantity }} <span class="text-xs text-gray-400">Tabung</span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-gray-800">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $order->getStatusBadgeClass() }} shadow-sm">
                                    @if ($order->status == 'confirmed')
                                        <i class="fas fa-check-circle mr-1.5"></i>
                                    @elseif($order->status == 'pending')
                                        <i class="fas fa-clock mr-1.5"></i>
                                    @elseif($order->status == 'delivered')
                                        <i class="fas fa-truck mr-1.5"></i>
                                    @elseif($order->status == 'cancelled')
                                        <i class="fas fa-times-circle mr-1.5"></i>
                                    @else
                                        <i class="fas fa-sync-alt mr-1.5"></i>
                                    @endif
                                    {{ $order->getStatusLabel() }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div
                                        class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                                        <i class="fas fa-box-open text-3xl"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Belum ada pesanan.</p>
                                    <p class="text-xs text-gray-400 mt-1">Silakan buat pesanan baru untuk memulai.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
