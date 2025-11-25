@extends('layouts.app')

@section('title', 'Riwayat Pemesanan')
@section('page-title', 'Laporan & Riwayat')

@section('content')
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Laporan Transaksi</h1>
            <p class="text-sm text-gray-500 mt-1">Rekapitulasi data pemesanan dan pendapatan pangkalan.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8 relative overflow-hidden group">
        <div
            class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-emerald-50 rounded-full blur-3xl opacity-60 pointer-events-none group-hover:scale-110 transition-transform duration-700">
        </div>

        <div class="relative z-10">
            <h2 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-wider flex items-center">
                <i class="fas fa-filter mr-2 text-emerald-500"></i> Filter Data
            </h2>

            <form method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-3">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5 ml-1">Dari Tanggal</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <i class="far fa-calendar-alt"></i>
                        </div>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-gray-400">
                    </div>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5 ml-1">Sampai Tanggal</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <i class="far fa-calendar-check"></i>
                        </div>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-gray-400">
                    </div>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5 ml-1">Status Pesanan</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <i class="fas fa-tags"></i>
                        </div>
                        <select name="status"
                            class="w-full pl-10 pr-8 py-2.5 bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all appearance-none cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu
                            </option>
                            <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Diproses
                            </option>
                            <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Dikirim
                            </option>
                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan
                            </option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-3 flex items-end gap-2">
                    <button type="submit"
                        class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-4 rounded-xl shadow-sm transition-all transform active:scale-95 text-sm flex items-center justify-center gap-2"
                        title="Terapkan Filter">
                        <i class="fas fa-search"></i> <span class="hidden md:inline">Cari</span>
                    </button>

                    <button type="button" onclick="printReport()"
                        class="bg-white border border-blue-200 text-blue-600 hover:bg-blue-50 font-medium py-2.5 px-4 rounded-xl shadow-sm transition-all text-sm"
                        title="Cetak Laporan">
                        <i class="fas fa-print text-lg"></i>
                    </button>

                    <button type="button" onclick="exportExcel()"
                        class="bg-white border border-green-200 text-green-600 hover:bg-green-50 font-medium py-2.5 px-4 rounded-xl shadow-sm transition-all text-sm"
                        title="Export Excel">
                        <i class="fas fa-file-excel text-lg"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        <div
            class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl p-6 text-white shadow-lg shadow-emerald-500/20 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-emerald-100 text-sm font-medium mb-1">Total Pendapatan</p>
                    <h3 class="text-3xl font-bold tracking-tight">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <i class="fas fa-wallet text-2xl text-white"></i>
                </div>
            </div>
            <div
                class="absolute -bottom-6 -left-6 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all duration-500">
            </div>
        </div>

        <div
            class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="relative z-10 flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Total Tabung Terjual</p>
                    <h3 class="text-3xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors">
                        {{ $totalQuantity }} <span class="text-sm text-gray-400 font-normal">Unit</span></h3>
                </div>
                <div
                    class="p-3 bg-blue-50 rounded-xl text-blue-600 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-cubes text-2xl"></i>
                </div>
            </div>
            <div
                class="absolute bottom-0 left-0 h-1 w-full bg-blue-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-left">
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">No. Pesanan</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider text-center">
                            Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                        <tr class="group hover:bg-emerald-50/30 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono text-xs font-medium text-gray-600 bg-gray-100 px-2 py-1 rounded-md">
                                    {{ $order->order_number }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-xs mr-3">
                                        {{ substr($order->user->name, 0, 1) }}
                                    </div>
                                    <div class="text-sm font-medium text-gray-700">{{ $order->user->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600">{{ $order->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $order->quantity }} <span class="text-xs text-gray-400">Tabung</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-800 text-sm">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $order->getStatusBadgeClass() }} shadow-sm">
                                    {{ $order->getStatusLabel() }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-folder-open text-3xl text-gray-300"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Tidak ada riwayat pesanan ditemukan.</p>
                                    <p class="text-xs text-gray-400 mt-1">Coba atur filter tanggal atau status yang
                                        berbeda.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($orders->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
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
