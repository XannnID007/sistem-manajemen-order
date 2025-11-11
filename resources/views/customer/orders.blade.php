@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Pesanan</h1>
        <p class="text-gray-600 text-sm mt-1">Lihat semua pesanan Anda</p>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-5 border-b border-gray-200">
            <a href="{{ route('customer.order.create') }}"
                class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm font-medium">
                <i class="fas fa-plus mr-2"></i> Pesanan Baru
            </a>
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $order->order_number }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $order->quantity }} tabung</td>
                            <td class="px-4 py-3 text-sm text-gray-900 font-medium">Rp
                                {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs font-medium rounded {{ $order->getStatusBadgeClass() }}">
                                    {{ $order->getStatusLabel() }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if ($order->status === 'delivered')
                                    <button onclick="confirmReceive({{ $order->id }}, '{{ $order->order_number }}')"
                                        class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700 transition">
                                        <i class="fas fa-check mr-1"></i> Konfirmasi
                                    </button>
                                @elseif($order->status === 'confirmed')
                                    <span class="text-green-600 text-xs">
                                        <i class="fas fa-check-circle mr-1"></i> Selesai
                                    </span>
                                @else
                                    <button onclick="showDetail({{ $order->id }})"
                                        class="text-blue-600 hover:text-blue-700 text-xs">
                                        <i class="fas fa-eye mr-1"></i> Detail
                                    </button>
                                @endif
                            </td>
                        </tr>
                        <tr id="detail-{{ $order->id }}" class="hidden bg-gray-50">
                            <td colspan="6" class="px-4 py-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-600 mb-1">Alamat Pengiriman:</p>
                                        <p class="text-gray-900">{{ $order->delivery_address }}</p>
                                    </div>
                                    @if ($order->notes)
                                        <div>
                                            <p class="text-gray-600 mb-1">Catatan:</p>
                                            <p class="text-gray-900">{{ $order->notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500 text-sm">
                                Belum ada pesanan. <a href="{{ route('customer.order.create') }}"
                                    class="text-green-600 hover:text-green-700">Buat pesanan pertama Anda</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($orders->hasPages())
            <div class="p-5 border-t border-gray-200">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

    <script>
        function showDetail(orderId) {
            const detail = document.getElementById('detail-' + orderId);
            detail.classList.toggle('hidden');
        }

        function confirmReceive(orderId, orderNumber) {
            Swal.fire({
                title: 'Konfirmasi Penerimaan',
                html: `Apakah Anda sudah menerima pesanan<br><strong>${orderNumber}</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Sudah Diterima',
                cancelButtonText: 'Batal'
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
