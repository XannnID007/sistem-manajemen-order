@extends('layouts.app')

@section('title', 'Buat Pesanan')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Buat Pesanan Baru</h1>
        <p class="text-gray-600 text-sm mt-1">Isi form untuk memesan LPG 3kg</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ route('customer.order.store') }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Jumlah Tabung</label>
                        <input type="number" name="quantity" value="{{ old('quantity', 1) }}" min="1" max="10"
                            required id="quantity" oninput="calculateTotal()"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">
                        <p class="text-gray-500 text-xs mt-1">Maksimal 10 tabung per pesanan</p>
                        @error('quantity')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Alamat Pengiriman</label>
                        <textarea name="delivery_address" rows="4" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">{{ old('delivery_address', auth()->user()->address) }}</textarea>
                        @error('delivery_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Catatan (Opsional)</label>
                        <textarea name="notes" rows="3" placeholder="Contoh: Antar sebelum jam 12 siang"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition text-sm font-medium">
                            <i class="fas fa-check mr-2"></i> Buat Pesanan
                        </button>
                        <a href="{{ route('customer.dashboard') }}"
                            class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition text-sm font-medium">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h3>

                <div class="space-y-3 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Harga per tabung</span>
                        <span class="font-medium text-gray-900">Rp
                            {{ number_format($setting->price_per_unit, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Jumlah</span>
                        <span class="font-medium text-gray-900" id="quantity-display">1 tabung</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3 flex justify-between">
                        <span class="text-gray-900 font-semibold">Total</span>
                        <span class="text-green-600 font-bold text-lg" id="total-price">Rp
                            {{ number_format($setting->price_per_unit, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <p class="text-blue-800 text-xs">
                        <i class="fas fa-info-circle mr-1"></i>
                        Pesanan akan diproses setelah Anda mengirim pesanan. Konfirmasi penerimaan setelah barang sampai.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const pricePerUnit = {{ $setting->price_per_unit }};

        function calculateTotal() {
            const quantity = parseInt(document.getElementById('quantity').value) || 1;
            const total = quantity * pricePerUnit;

            document.getElementById('quantity-display').textContent = quantity + ' tabung';
            document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
    </script>
@endsection
