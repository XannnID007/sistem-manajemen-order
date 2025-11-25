@extends('layouts.app')

@section('title', 'Pengaturan Sistem')
@section('page-title', 'Pengaturan')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Pengaturan Sistem</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola informasi pangkalan dan keamanan akun Anda.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative group">
            <div class="h-1.5 w-full bg-gradient-to-r from-emerald-500 to-teal-400"></div>

            <div class="p-6 md:p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 mr-4">
                        <i class="fas fa-store text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Profil Pangkalan</h2>
                        <p class="text-xs text-gray-500">Informasi umum toko/pangkalan.</p>
                    </div>
                </div>

                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama
                            Pangkalan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                <i class="fas fa-building"></i>
                            </div>
                            <input type="text" name="pangkalan_name"
                                value="{{ old('pangkalan_name', $setting->pangkalan_name) }}" required
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-gray-400">
                        </div>
                        @error('pangkalan_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Alamat
                            Lengkap</label>
                        <div class="relative">
                            <div class="absolute top-3.5 left-3 pointer-events-none text-gray-400">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <textarea name="pangkalan_address" rows="3" required
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-gray-400 resize-none">{{ old('pangkalan_address', $setting->pangkalan_address) }}</textarea>
                        </div>
                        @error('pangkalan_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">No.
                                Telepon</label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <input type="text" name="pangkalan_phone"
                                    value="{{ old('pangkalan_phone', $setting->pangkalan_phone) }}" required
                                    class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-gray-400">
                            </div>
                            @error('pangkalan_phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Harga /
                                Tabung</label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                    <span class="text-xs font-bold">Rp</span>
                                </div>
                                <input type="number" name="price_per_unit"
                                    value="{{ old('price_per_unit', $setting->price_per_unit) }}" step="100"
                                    min="0" required
                                    class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all placeholder-gray-400">
                            </div>
                            @error('price_per_unit')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Logo
                            Pangkalan</label>
                        <div class="flex items-center gap-4">
                            @if ($setting->logo)
                                <div class="flex-shrink-0 w-16 h-16 rounded-xl border border-gray-200 p-1 bg-white">
                                    <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo"
                                        class="w-full h-full object-contain rounded-lg">
                                </div>
                            @endif
                            <div class="w-full relative">
                                <input type="file" name="logo" accept="image/*" id="logoInput"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all cursor-pointer border border-gray-200 rounded-xl bg-gray-50">
                                <p class="text-[10px] text-gray-400 mt-1.5 ml-1">Format: JPG/PNG. Maks: 2MB.</p>
                            </div>
                        </div>
                        @error('logo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-xl shadow-lg shadow-emerald-500/30 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative group">
            <div class="h-1.5 w-full bg-gradient-to-r from-blue-500 to-indigo-400"></div>

            <div class="p-6 md:p-8">
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 mr-4">
                        <i class="fas fa-user-cog text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Akun & Keamanan</h2>
                        <p class="text-xs text-gray-500">Update profil dan password login.</p>
                    </div>
                </div>

                <form action="{{ route('admin.profile.update') }}" method="POST"
                    onsubmit="return confirmProfileUpdate(event)">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama
                            Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                <i class="fas fa-user"></i>
                            </div>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder-gray-400">
                        </div>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email</label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder-gray-400">
                            </div>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">No.
                                Telepon</label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                                    class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder-gray-400">
                            </div>
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Alamat
                            Pribadi</label>
                        <div class="relative">
                            <div class="absolute top-3.5 left-3 pointer-events-none text-gray-400">
                                <i class="fas fa-home"></i>
                            </div>
                            <textarea name="address" rows="2" required
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all placeholder-gray-400 resize-none">{{ old('address', $user->address) }}</textarea>
                        </div>
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t border-dashed border-gray-200 my-6 relative">
                        <span
                            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white px-3 text-xs font-medium text-gray-400 uppercase tracking-widest">Keamanan</span>
                    </div>

                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Password
                                Saat Ini</label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <input type="password" name="current_password" placeholder="********"
                                    class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                            </div>
                            @error('current_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Password
                                    Baru</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                        <i class="fas fa-key"></i>
                                    </div>
                                    <input type="password" name="new_password" placeholder="Minimal 6 karakter"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                </div>
                                @error('new_password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Ulangi
                                    Password</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                        <i class="fas fa-check-double"></i>
                                    </div>
                                    <input type="password" name="new_password_confirmation" placeholder="Konfirmasi"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl shadow-lg shadow-blue-500/30 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                        <i class="fas fa-user-check"></i> Update Profil
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmProfileUpdate(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Update',
                text: 'Apakah Anda yakin ingin memperbarui data profil?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb', // Blue for profile
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Update',
                cancelButtonText: 'Batal',
                background: '#fff',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-6 py-2.5',
                    cancelButton: 'rounded-xl px-6 py-2.5'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
            });

            return false;
        }
    </script>
@endsection
