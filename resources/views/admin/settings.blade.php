@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Pengaturan</h1>
        <p class="text-gray-600 text-sm mt-1">Kelola pengaturan pangkalan dan profil Anda</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pengaturan Pangkalan -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-5 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Pengaturan Pangkalan</h2>
            </div>
            <div class="p-5">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Nama Pangkalan</label>
                        <input type="text" name="pangkalan_name"
                            value="{{ old('pangkalan_name', $setting->pangkalan_name) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">
                        @error('pangkalan_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Alamat</label>
                        <textarea name="pangkalan_address" rows="3" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">{{ old('pangkalan_address', $setting->pangkalan_address) }}</textarea>
                        @error('pangkalan_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">No. Telepon</label>
                        <input type="text" name="pangkalan_phone"
                            value="{{ old('pangkalan_phone', $setting->pangkalan_phone) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">
                        @error('pangkalan_phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Harga per Tabung (Rp)</label>
                        <input type="number" name="price_per_unit"
                            value="{{ old('price_per_unit', $setting->price_per_unit) }}" step="100" min="0"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">
                        @error('price_per_unit')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Logo Pangkalan</label>
                        @if ($setting->logo)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo"
                                    class="h-20 w-20 object-cover rounded">
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/*"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">
                        <p class="text-gray-500 text-xs mt-1">Format: JPG, PNG. Maksimal 2MB</p>
                        @error('logo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition text-sm font-medium">
                        <i class="fas fa-save mr-2"></i> Simpan Pengaturan
                    </button>
                </form>
            </div>
        </div>

        <!-- Profil Saya -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-5 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Profil Saya</h2>
            </div>
            <div class="p-5">
                <form action="{{ route('admin.profile.update') }}" method="POST"
                    onsubmit="return confirmProfileUpdate(event)">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">No. Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Alamat</label>
                        <textarea name="address" rows="3" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t border-gray-200 pt-4 mb-4">
                        <p class="text-gray-700 text-sm font-medium mb-3">Ganti Password (Opsional)</p>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-medium mb-2">Password Saat Ini</label>
                            <input type="password" name="current_password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">
                            @error('current_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-medium mb-2">Password Baru</label>
                            <input type="password" name="new_password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">
                            @error('new_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-medium mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition text-sm font-medium">
                        <i class="fas fa-save mr-2"></i> Simpan Profil
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmProfileUpdate(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Perubahan',
                text: 'Apakah Anda yakin ingin menyimpan perubahan profil?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
            });

            return false;
        }
    </script>
@endsection
