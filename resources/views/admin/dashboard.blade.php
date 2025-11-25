@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Overview')

@section('content')
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Ringkasan Statistik</h2>
            <p class="text-sm text-gray-500 mt-1">Pantau aktivitas pangkalan LPG secara real-time.</p>
        </div>
        <div class="flex items-center bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100">
            <i class="far fa-calendar-alt text-emerald-500 mr-2"></i>
            <span
                class="text-sm font-medium text-gray-600">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div
            class="group bg-white rounded-2xl p-5 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-blue-500/20 hover:-translate-y-1 transition-all duration-300 border border-gray-100 relative overflow-hidden">
            <div class="flex justify-between items-start z-10 relative">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Total Pesanan</p>
                    <h3 class="text-3xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors">
                        {{ $totalOrders }}</h3>
                </div>
                <div
                    class="w-12 h-12 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center text-xl group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
            <div
                class="absolute bottom-0 left-0 h-1 w-full bg-gradient-to-r from-blue-400 to-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left">
            </div>
        </div>

        <div
            class="group bg-white rounded-2xl p-5 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-amber-500/20 hover:-translate-y-1 transition-all duration-300 border border-gray-100 relative overflow-hidden">
            <div class="flex justify-between items-start z-10 relative">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Menunggu</p>
                    <h3 class="text-3xl font-bold text-gray-800 group-hover:text-amber-500 transition-colors">
                        {{ $pendingOrders }}</h3>
                </div>
                <div
                    class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center text-xl group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <div
                class="absolute bottom-0 left-0 h-1 w-full bg-gradient-to-r from-amber-400 to-amber-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left">
            </div>
        </div>

        <div
            class="group bg-white rounded-2xl p-5 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-cyan-500/20 hover:-translate-y-1 transition-all duration-300 border border-gray-100 relative overflow-hidden">
            <div class="flex justify-between items-start z-10 relative">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Diproses</p>
                    <h3 class="text-3xl font-bold text-gray-800 group-hover:text-cyan-600 transition-colors">
                        {{ $processingOrders }}</h3>
                </div>
                <div
                    class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-sync-alt"></i>
                </div>
            </div>
            <div
                class="absolute bottom-0 left-0 h-1 w-full bg-gradient-to-r from-cyan-400 to-cyan-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left">
            </div>
        </div>

        <div
            class="group bg-white rounded-2xl p-5 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-emerald-500/20 hover:-translate-y-1 transition-all duration-300 border border-gray-100 relative overflow-hidden">
            <div class="flex justify-between items-start z-10 relative">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1">Selesai/Dikirim</p>
                    <h3 class="text-3xl font-bold text-gray-800 group-hover:text-emerald-600 transition-colors">
                        {{ $deliveredOrders }}</h3>
                </div>
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div
                class="absolute bottom-0 left-0 h-1 w-full bg-gradient-to-r from-emerald-400 to-emerald-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        <div
            class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center justify-between relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-sm font-medium text-gray-500 mb-1">Total Pelanggan Terdaftar</p>
                <h3 class="text-3xl font-bold text-gray-800">{{ $totalCustomers }} <span
                        class="text-sm font-normal text-gray-400">Orang</span></h3>
            </div>
            <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-500 text-2xl">
                <i class="fas fa-users"></i>
            </div>
            <div
                class="absolute -bottom-4 -left-4 w-24 h-24 bg-indigo-50 rounded-full mix-blend-multiply filter blur-xl opacity-70">
            </div>
        </div>

        <div
            class="bg-gradient-to-br from-emerald-600 to-green-500 rounded-2xl p-6 shadow-lg shadow-emerald-500/20 text-white flex items-center justify-between relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-sm font-medium text-emerald-100 mb-1">Total Pendapatan</p>
                <h3 class="text-3xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
            <div
                class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-2xl border border-white/30">
                <i class="fas fa-wallet"></i>
            </div>

            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white opacity-10 blur-2xl"></div>
            <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-32 h-32 rounded-full bg-black opacity-10 blur-2xl"></div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Pesanan Terbaru</h2>
                <p class="text-xs text-gray-500 mt-1">5 transaksi terakhir yang masuk.</p>
            </div>
            <a href="{{ route('admin.orders') }}"
                class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 px-3 py-1.5 rounded-lg transition-colors border border-emerald-200">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 text-left">
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">No. Pesanan</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded text-xs">
                                    {{ $order->order_number }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-xs mr-3">
                                        {{ substr($order->user->name, 0, 1) }}
                                    </div>
                                    <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">
                                    {{ $order->created_at->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $order->created_at->format('H:i') }} WIB
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $order->quantity }} <span class="text-xs text-gray-400">Tabung</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-800">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $order->getStatusBadgeClass() }}">
                                    {{ $order->getStatusLabel() }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <div
                                        class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3 text-gray-400">
                                        <i class="fas fa-clipboard-list text-2xl"></i>
                                    </div>
                                    <p class="text-sm">Belum ada pesanan terbaru saat ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
