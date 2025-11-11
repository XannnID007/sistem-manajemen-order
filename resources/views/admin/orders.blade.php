@extends('layouts.app')

@section('title', 'Kelola Pesanan')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Kelola Pesanan</h1>
        <p class="text-gray-600 text-sm mt-1">Kelola semua pesanan pelanggan</p>
    </div>

    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-5">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="No. pesanan atau nama pelanggan"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Status</label>
                    <select name="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Diproses
                        </option>
                        <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Dikirim</option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan
                        </option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm font-medium w-full md:w-auto">
                        <i class="fas fa-search mr-2"></i> Filter
                    </button>
                </div>
            </form>
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $order->order_number }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                <div>{{ $order->user->name }}</div>
                                <div class="text-gray-500 text-xs">{{ $order->user->phone }}</div>
                            </td>
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
                                <button onclick="showDetail({{ $order->id }})"
                                    class="text-blue-600 hover:text-blue-700 text-xs mr-2">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if ($order->status !== 'confirmed' && $order->status !== 'cancelled')
                                    <button
                                        onclick="showStatusModal({{ $order->id }}, '{{ $order->order_number }}', '{{ $order->status }}')"
                                        class="text-green-600 hover:text-green-700 text-xs">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                        <tr id="detail-{{ $order->id }}" class="hidden bg-gray-50">
                            <td colspan="7" class="px-4 py-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-600 mb-1 font-medium">Alamat Pengiriman:</p>
                                        <p class="text-gray-900">{{ $order->delivery_address }}</p>
                                    </div>
                                    @if ($order->notes)
                                        <div>
                                            <p class="text-gray-600 mb-1 font-medium">Catatan:</p>
                                            <p class="text-gray-900">{{ $order->notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500 text-sm">
                                Tidak ada pesanan ditemukan
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

    <!-- Status Modal -->
    <div id="statusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Ubah Status Pesanan</h3>
            <p class="text-sm text-gray-600 mb-4">Pesanan: <span id="modalOrderNumber" class="font-medium"></span></p>

            <form id="statusForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Status Baru</label>
                    <select name="status" id="statusSelect"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">
                        <option value="pending">Menunggu</option>
                        <option value="processing">Diproses</option>
                        <option value="delivered">Dikirim</option>
                        <option value="cancelled">Dibatalkan</option>
                    </select>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm font-medium flex-1">
                        Simpan
                    </button>
                    <button type="button" onclick="closeStatusModal()"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-sm font-medium flex-1">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showDetail(orderId) {
            document.getElementById('detail-' + orderId).classList.toggle('hidden');
        }

        function showStatusModal(orderId, orderNumber, currentStatus) {
            document.getElementById('statusModal').classList.remove('hidden');
            document.getElementById('modalOrderNumber').textContent = orderNumber;
            document.getElementById('statusSelect').value = currentStatus;

            const form = document.getElementById('statusForm');
            form.onsubmit = function(e) {
                e.preventDefault();
                const newStatus = document.getElementById('statusSelect').value;

                Swal.fire({
                    title: 'Konfirmasi Perubahan',
                    html: `Ubah status pesanan <strong>${orderNumber}</strong>?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Ubah',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.action = `/admin/order/${orderId}/status`;
                        const realForm = document.createElement('form');
                        realForm.method = 'POST';
                        realForm.action = form.action;

                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;

                        const statusInput = document.createElement('input');
                        statusInput.type = 'hidden';
                        statusInput.name = 'status';
                        statusInput.value = newStatus;

                        realForm.appendChild(csrfToken);
                        realForm.appendChild(statusInput);
                        document.body.appendChild(realForm);
                        realForm.submit();
                    }
                });
            };
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
        }
    </script>
@endsection
