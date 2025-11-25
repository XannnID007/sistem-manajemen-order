@extends('layouts.app')

@section('title', 'Riwayat Pesanan')
@section('page-title', 'Pesanan Saya')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Riwayat Transaksi</h1>
            <p class="text-sm text-gray-500 mt-1">Pantau status dan riwayat pembelian gas LPG Anda.</p>
        </div>
        <a href="{{ route('customer.order.create') }}"
            class="bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white font-semibold py-2.5 px-5 rounded-xl shadow-lg shadow-emerald-500/30 transition-all transform active:scale-95 text-sm flex items-center justify-center gap-2">
            <i class="fas fa-plus-circle"></i> Buat Pesanan Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/30 flex items-center justify-between">
            <div class="flex items-center gap-2 text-sm text-gray-600 font-medium">
                <i class="fas fa-list text-emerald-500"></i> Daftar Pesanan
            </div>
            <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-1 rounded-lg font-bold">{{ $orders->count() }}
                Transaksi</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-left">
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">No. Pesanan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Status
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                        <tr class="group hover:bg-emerald-50/30 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="font-mono text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md border border-emerald-100">
                                    {{ $order->order_number }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span
                                        class="text-sm font-medium text-gray-700">{{ $order->created_at->format('d M Y') }}</span>
                                    <span class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }} WIB</span>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $order->quantity }} <span class="text-xs text-gray-400 font-normal">Tabung</span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-gray-800">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $order->getStatusBadgeClass() }} shadow-sm">
                                    {{ $order->getStatusLabel() }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex justify-center items-center gap-2">
                                    @if ($order->status === 'delivered')
                                        <button onclick="confirmReceive({{ $order->id }}, '{{ $order->order_number }}')"
                                            class="bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-emerald-700 transition-all shadow-sm hover:shadow-md flex items-center gap-1">
                                            <i class="fas fa-check-circle"></i> Terima
                                        </button>
                                    @elseif($order->status === 'confirmed')
                                        <span
                                            class="text-emerald-600 text-xs font-bold flex items-center gap-1 bg-emerald-50 px-2 py-1 rounded-lg">
                                            <i class="fas fa-check-double"></i> Selesai
                                        </span>
                                    @endif

                                    <button onclick="showDetail({{ $order->id }})"
                                        class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 transition-all flex items-center justify-center"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr id="detail-{{ $order->id }}"
                            class="hidden bg-gray-50/60 border-b border-gray-100 animate-fade-in">
                            <td colspan="6" class="px-6 py-4">
                                <div class="flex flex-col md:flex-row gap-6">
                                    <div class="flex-1 bg-white p-3 rounded-xl border border-gray-200 shadow-sm">
                                        <h4
                                            class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 flex items-center">
                                            <i class="fas fa-map-marker-alt mr-2 text-red-400"></i> Alamat Pengiriman
                                        </h4>
                                        <p class="text-sm text-gray-700 leading-relaxed">
                                            {{ $order->delivery_address }}
                                        </p>
                                    </div>

                                    @if ($order->notes)
                                        <div class="flex-1 bg-white p-3 rounded-xl border border-gray-200 shadow-sm">
                                            <h4
                                                class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 flex items-center">
                                                <i class="fas fa-sticky-note mr-2 text-amber-400"></i> Catatan
                                            </h4>
                                            <p class="text-sm text-gray-700 italic leading-relaxed">
                                                "{{ $order->notes }}"
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div
                                        class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                                        <i class="fas fa-box-open text-3xl"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Belum ada pesanan.</p>
                                    <a href="{{ route('customer.order.create') }}"
                                        class="mt-2 text-sm font-medium text-emerald-600 hover:text-emerald-700 hover:underline">
                                        Mulai buat pesanan pertama Anda &rarr;
                                    </a>
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
        function showDetail(orderId) {
            const detail = document.getElementById('detail-' + orderId);
            // Simple toggle logic
            if (detail.classList.contains('hidden')) {
                detail.classList.remove('hidden');
            } else {
                detail.classList.add('hidden');
            }
        }

        function confirmReceive(orderId, orderNumber) {
            Swal.fire({
                title: 'Pesanan Diterima?',
                html: `Konfirmasi bahwa pesanan <strong>${orderNumber}</strong> telah sampai di lokasi Anda?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981', // Emerald-500
                cancelButtonColor: '#9ca3af', // Gray-400
                confirmButtonText: 'Ya, Terima',
                cancelButtonText: 'Batal',
                background: '#fff',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-5 py-2.5',
                    cancelButton: 'rounded-xl px-5 py-2.5'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/customer/order/${orderId}/confirm`;

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;

                    form.appendChild(csrfToken);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection
