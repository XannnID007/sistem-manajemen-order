@extends('layouts.app')

@section('title', 'Tambah Pelanggan')
@section('page-title', 'Data Pelanggan')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Tambah Pelanggan Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Lengkapi formulir di bawah untuk mendaftarkan pelanggan baru ke sistem.</p>
        </div>
        <a href="{{ route('admin.users.index') }}"
            class="text-sm font-medium text-gray-500 hover:text-emerald-600 flex items-center transition-colors bg-white px-4 py-2 rounded-xl border border-gray-200 shadow-sm hover:shadow-md">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-emerald-500 to-teal-400"></div>

            <div class="p-8">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="mb-8">
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-5 flex items-center">
                            <span
                                class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mr-3">
                                <i class="fas fa-user-circle"></i>
                            </span>
                            Informasi Akun
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama
                                    Lengkap</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                        placeholder="Masukkan nama lengkap..."
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-gray-400">
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Alamat
                                    Email</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                        placeholder="contoh@email.com"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-gray-400">
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">NIK
                                    (KTP)</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16" required
                                        placeholder="16 digit NIK"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-gray-400">
                                </div>
                                @error('nik')
                                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-dashed border-gray-200 my-6"></div>

                    <div class="mb-8">
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-5 flex items-center">
                            <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mr-3">
                                <i class="fas fa-address-book"></i>
                            </span>
                            Kontak & Alamat
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">No.
                                    Telepon / WhatsApp</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <input type="text" name="phone" value="{{ old('phone') }}" required
                                        placeholder="08xxxxxxxxxx"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-gray-400">
                                </div>
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Alamat
                                    Lengkap</label>
                                <div class="relative">
                                    <div class="absolute top-3.5 left-3 pointer-events-none text-gray-400">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <textarea name="address" rows="3" required placeholder="Jalan, RT/RW, Kelurahan, Kecamatan..."
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-gray-400 resize-none">{{ old('address') }}</textarea>
                                </div>
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-dashed border-gray-200 my-6"></div>

                    <div class="mb-8">
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-5 flex items-center">
                            <span
                                class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center mr-3">
                                <i class="fas fa-lock"></i>
                            </span>
                            Keamanan Akun
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Password</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                        <i class="fas fa-key"></i>
                                    </div>
                                    <input type="password" name="password" required placeholder="Minimal 6 karakter"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-gray-400">
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Konfirmasi
                                    Password</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <input type="password" name="password_confirmation" required
                                        placeholder="Ulangi password"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-gray-400">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse md:flex-row items-center justify-end gap-3 pt-4">
                        <a href="{{ route('admin.users.index') }}"
                            class="w-full md:w-auto text-center px-6 py-3 rounded-xl border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 hover:border-gray-300 transition-all text-sm">
                            Batal
                        </a>
                        <button type="submit"
                            class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-8 rounded-xl shadow-lg shadow-emerald-500/30 transition-all transform active:scale-95 text-sm flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
