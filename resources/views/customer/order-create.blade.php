@extends('layouts.app')

@section('title', 'Buat Pesanan')
@section('page-title', 'Pesanan Baru')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Buat Pesanan Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Lengkapi formulir di bawah untuk memesan Gas LPG 3kg.</p>
        </div>
        <a href="{{ route('customer.dashboard') }}"
            class="text-sm font-medium text-gray-500 hover:text-emerald-600 flex items-center transition-colors bg-white px-4 py-2 rounded-xl border border-gray-200 shadow-sm hover:shadow-md">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
    </div>

    <form action="{{ route('customer.order.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-100 flex items-center">
                        <div
                            class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center mr-3">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h2 class="font-bold text-gray-800 text-sm uppercase tracking-wide">Detail Pesanan</h2>
                    </div>

                    <div class="p-6 md:p-8">
                        <div class="mb-8">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Jumlah
                                Tabung</label>
                            <div class="flex items-center gap-4">
                                <div class="relative w-full max-w-[200px]">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-emerald-600">
                                        <i class="fas fa-gas-pump text-lg"></i>
                                    </div>
                                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}"
                                        min="1" max="10" required oninput="calculateTotal()"
                                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-lg font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all text-center shadow-sm">
                                </div>
                                <span class="text-gray-500 font-medium">Tabung</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-2 ml-1 flex items-center">
                                <i class="fas fa-info-circle mr-1"></i> Maksimal 10 tabung per transaksi.
                            </p>
                            @error('quantity')
                                <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Catatan
                                Tambahan (Opsional)</label>
                            <div class="relative">
                                <div class="absolute top-3.5 left-3 pointer-events-none text-gray-400">
                                    <i class="fas fa-sticky-note"></i>
                                </div>
                                <textarea name="notes" rows="2" placeholder="Contoh: Tolong antar sebelum jam 12 siang..."
                                    class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-gray-400 resize-none">{{ old('notes') }}</textarea>
                            </div>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-100 flex items-center">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h2 class="font-bold text-gray-800 text-sm uppercase tracking-wide">Lokasi Pengiriman</h2>
                    </div>

                    <div class="p-6 md:p-8">
                        <div class="mb-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Alamat
                                Lengkap</label>
                            <div class="relative">
                                <textarea name="delivery_address" rows="3" required
                                    class="w-full p-4 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder-gray-400 resize-none leading-relaxed shadow-inner">{{ old('delivery_address', auth()->user()->address) }}</textarea>
                            </div>
                            <p class="text-xs text-gray-400 mt-2 flex items-center">
                                <i class="fas fa-check-circle mr-1 text-green-500"></i> Alamat ini diambil dari profil Anda.
                                Ubah jika ingin mengirim ke lokasi lain.
                            </p>
                            @error('delivery_address')
                                <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-100 p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                        Ringkasan Biaya
                    </h3>

                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-sm items-center">
                            <span class="text-gray-500">Harga Satuan</span>
                            <span class="font-medium text-gray-800 bg-gray-100 px-2 py-1 rounded text-xs">
                                Rp {{ number_format($setting->price_per_unit, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex justify-between text-sm items-center">
                            <span class="text-gray-500">Jumlah Pesanan</span>
                            <span class="font-medium text-gray-800" id="quantity-display">1 Tabung</span>
                        </div>

                        <div class="border-t border-dashed border-gray-200 my-4"></div>

                        <div class="flex justify-between items-end">
                            <span class="text-gray-800 font-bold">Total Bayar</span>
                            <span class="text-2xl font-bold text-emerald-600 tracking-tight" id="total-price">
                                Rp {{ number_format($setting->price_per_unit, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6 flex gap-3">
                        <i class="fas fa-info-circle text-blue-500 mt-0.5 shrink-0"></i>
                        <p class="text-xs text-blue-700 leading-relaxed">
                            Pesanan akan segera diproses oleh admin setelah dikirim. Pastikan alamat Anda sudah benar.
                        </p>
                    </div>

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-emerald-500 to-green-500 hover:from-emerald-600 hover:to-green-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-emerald-500/30 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Kirim Pesanan
                    </button>
                </div>
            </div>

        </div>
    </form>

    <script>
        const pricePerUnit = {{ $setting->price_per_unit }};

        function calculateTotal() {
            // Get value, default to 0 if empty, limit min to 1 visual logic
            let quantityInput = document.getElementById('quantity');
            let quantity = parseInt(quantityInput.value) || 0;

            // Validasi visual sederhana (backend tetap validasi utama)
            if (quantity < 1) quantity = 0;

            const total = quantity * pricePerUnit;

            // Update Display
            document.getElementById('quantity-display').textContent = quantity + ' Tabung';
            document.getElementById('total-price').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }
    </script>
@endsection
