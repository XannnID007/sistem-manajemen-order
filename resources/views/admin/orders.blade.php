@extends('layouts.app')

@section('title', 'Kelola Pesanan')
@section('page-title', 'Manajemen Pesanan')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8 relative overflow-hidden">

        <div
            class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-emerald-50 rounded-full blur-3xl opacity-50 pointer-events-none">
        </div>

        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 relative z-10">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Filter Pesanan</h2>
                <p class="text-sm text-gray-500">Cari dan saring data pesanan pelanggan.</p>
            </div>
        </div>

        <form method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 relative z-10">
            <div class="md:col-span-5">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pencarian</label>
                <div class="relative group">
                    <span
                        class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 group-focus-within:text-emerald-500 transition-colors">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="No. Pesanan / Nama Pelanggan..."
                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 text-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-gray-400 text-sm">
                </div>
            </div>

            <div class="md:col-span-4">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Status
                    Pesanan</label>
                <div class="relative group">
                    <span
                        class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 group-focus-within:text-emerald-500 transition-colors">
                        <i class="fas fa-filter"></i>
                    </span>
                    <select name="status"
                        class="w-full pl-10 pr-8 py-2.5 bg-gray-50 border border-gray-200 text-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all text-sm appearance-none cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Diproses
                        </option>
                        <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Dikirim</option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan
                        </option>
                    </select>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </span>
                </div>
            </div>

            <div class="md:col-span-3 flex items-end">
                <button type="submit"
                    class="w-full bg-gradient-to-r from-emerald-500 to-green-500 hover:from-emerald-600 hover:to-green-600 text-white font-semibold py-2.5 px-4 rounded-xl shadow-lg shadow-emerald-500/30 transition-all transform hover:-translate-y-0.5 active:scale-95 text-sm flex items-center justify-center gap-2">
                    <i class="fas fa-sort-amount-down"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">No.
                            Pesanan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            Pelanggan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Detail
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Total
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                        <tr class="group hover:bg-emerald-50/30 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap align-top">
                                <span
                                    class="font-mono font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md text-xs">
                                    {{ $order->order_number }}
                                </span>
                                <div class="text-[10px] text-gray-400 mt-1">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </div>
                            </td>

                            <td class="px-6 py-4 align-top">
                                <div class="flex items-start">
                                    <div
                                        class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 text-xs font-bold mr-3 mt-1">
                                        {{ substr($order->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-800">{{ $order->user->name }}</div>
                                        <div class="text-xs text-gray-500 flex items-center mt-0.5">
                                            <i class="fas fa-phone-alt text-[10px] mr-1.5 opacity-70"></i>
                                            {{ $order->user->phone }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 align-top">
                                <div class="text-sm text-gray-700 font-medium">
                                    {{ $order->quantity }} <span class="text-xs text-gray-500 font-normal">Tabung</span>
                                </div>
                            </td>

                            <td class="px-6 py-4 align-top">
                                <div class="text-sm font-bold text-gray-800">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </div>
                            </td>

                            <td class="px-6 py-4 align-top">
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

                            <td class="px-6 py-4 align-top text-center">
                                <div class="flex justify-center space-x-2">
                                    <button onclick="showDetail({{ $order->id }})"
                                        class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 transition-all flex items-center justify-center tooltip"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye text-xs"></i>
                                    </button>

                                    @if ($order->status !== 'confirmed' && $order->status !== 'cancelled')
                                        <button
                                            onclick="showStatusModal({{ $order->id }}, '{{ $order->order_number }}', '{{ $order->status }}')"
                                            class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 hover:text-amber-700 transition-all flex items-center justify-center tooltip"
                                            title="Ubah Status">
                                            <i class="fas fa-pen text-xs"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tr id="detail-{{ $order->id }}"
                            class="hidden bg-gray-50/50 border-b border-gray-100 animate-fade-in">
                            <td colspan="6" class="px-6 py-4">
                                <div
                                    class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm flex flex-col md:flex-row gap-6 relative overflow-hidden">
                                    <div class="absolute left-0 top-0 w-1 h-full bg-blue-400"></div>

                                    <div class="flex-1">
                                        <h4
                                            class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 flex items-center">
                                            <i class="fas fa-map-marker-alt mr-2 text-red-400"></i> Alamat Pengiriman
                                        </h4>
                                        <p
                                            class="text-sm text-gray-700 leading-relaxed bg-gray-50 p-3 rounded-lg border border-gray-100">
                                            {{ $order->delivery_address }}
                                        </p>
                                    </div>

                                    @if ($order->notes)
                                        <div class="flex-1">
                                            <h4
                                                class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 flex items-center">
                                                <i class="fas fa-sticky-note mr-2 text-amber-400"></i> Catatan Pelanggan
                                            </h4>
                                            <p
                                                class="text-sm text-gray-700 leading-relaxed bg-gray-50 p-3 rounded-lg border border-gray-100 italic">
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
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-inbox text-3xl text-gray-300"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Tidak ada data pesanan yang ditemukan.</p>
                                    <p class="text-xs text-gray-400 mt-1">Coba ubah filter pencarian Anda.</p>
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

    <div id="statusModal" class="hidden fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">

                <div class="bg-gray-50 px-4 py-3 sm:px-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Perbarui Status Pesanan
                    </h3>
                    <button onclick="closeStatusModal()" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center mb-6 bg-blue-50 p-3 rounded-xl border border-blue-100">
                        <div class="flex-shrink-0 bg-blue-100 rounded-lg p-2 mr-3">
                            <i class="fas fa-receipt text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-blue-600 font-medium">Nomor Pesanan</p>
                            <p class="text-sm font-bold text-gray-800" id="modalOrderNumber">ORD-XXXX</p>
                        </div>
                    </div>

                    <form id="statusForm" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Status Baru</label>
                            <div class="relative">
                                <select name="status" id="statusSelect"
                                    class="block w-full rounded-xl border-gray-200 bg-gray-50 py-3 pl-3 pr-10 text-sm focus:border-emerald-500 focus:ring-emerald-500 shadow-sm cursor-pointer">
                                    <option value="pending">⏳ Menunggu Konfirmasi</option>
                                    <option value="processing">⚙️ Sedang Diproses</option>
                                    <option value="delivered">🚚 Sedang Dikirim</option>
                                    <option value="cancelled">❌ Dibatalkan</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col sm:flex-row-reverse gap-3">
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-xl bg-emerald-600 px-3 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 sm:w-auto transition-colors">
                                Simpan Perubahan
                            </button>
                            <button type="button" onclick="closeStatusModal()"
                                class="inline-flex w-full justify-center rounded-xl bg-white px-3 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:w-auto transition-colors">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDetail(orderId) {
            const row = document.getElementById('detail-' + orderId);
            if (row.classList.contains('hidden')) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        }

        function showStatusModal(orderId, orderNumber, currentStatus) {
            const modal = document.getElementById('statusModal');
            document.getElementById('modalOrderNumber').textContent = orderNumber;
            document.getElementById('statusSelect').value = currentStatus;

            modal.classList.remove('hidden');

            const form = document.getElementById('statusForm');
            form.onsubmit = function(e) {
                e.preventDefault();
                const newStatus = document.getElementById('statusSelect').value;

                // Close modal first
                closeStatusModal();

                Swal.fire({
                    title: 'Konfirmasi',
                    text: `Ubah status pesanan ${orderNumber}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#9ca3af',
                    confirmButtonText: 'Ya, Ubah',
                    cancelButtonText: 'Batal',
                    background: '#fff',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl',
                        cancelButton: 'rounded-xl'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.action = `/admin/order/${orderId}/status`;

                        // Create hidden form to submit properly
                        const realForm = document.createElement('form');
                        realForm.method = 'POST';
                        realForm.action = form.action;

                        const csrf = document.createElement('input');
                        csrf.type = 'hidden';
                        csrf.name = '_token';
                        csrf.value = document.querySelector('meta[name="csrf-token"]').content;

                        const statusInput = document.createElement('input');
                        statusInput.type = 'hidden';
                        statusInput.name = 'status';
                        statusInput.value = newStatus;

                        realForm.appendChild(csrf);
                        realForm.appendChild(statusInput);
                        document.body.appendChild(realForm);
                        realForm.submit();
                    } else {
                        // Re-open modal if cancelled (optional)
                        modal.classList.remove('hidden');
                    }
                });
            };
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
        }

        // Close modal on clicking backdrop
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('statusModal');
            // Check if backdrop was clicked (backdrop is the parent flex container in this tailwind structure)
            if (e.target.classList.contains('backdrop-blur-sm')) {
                closeStatusModal();
            }
        });
    </script>
@endsection
