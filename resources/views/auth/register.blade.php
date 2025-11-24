<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - {{ $setting->pangkalan_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100">
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                showConfirmButton: true
            });
        </script>
    @endif

    <div
        class="min-h-screen flex items-center justify-center px-4 py-8 bg-gradient-to-br from-green-400 via-green-500 to-green-600">
        <div class="w-full max-w-2xl">
            <!-- Card -->
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="bg-white px-6 pt-6 pb-5 text-center border-b">
                    @if ($setting->logo)
                        <div class="mb-2 flex justify-center">
                            <img src="{{ asset('storage/' . $setting->logo) }}" alt="{{ $setting->pangkalan_name }}"
                                class="h-14 w-14 object-contain">
                        </div>
                    @else
                        <div
                            class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-full mb-2 shadow-lg">
                            <i class="fas fa-user-plus text-white text-xl"></i>
                        </div>
                    @endif
                    <h2 class="text-xl font-bold text-gray-800">{{ $setting->pangkalan_name }}</h2>
                    <p class="text-gray-500 text-xs mt-1">Daftar Akun Baru</p>
                </div>

                <!-- Form -->
                <div class="px-6 py-6">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf

                        <!-- 2 Column Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nama Lengkap -->
                            <div>
                                <label class="block text-gray-700 text-xs font-semibold mb-2">Nama Lengkap</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fas fa-user text-gray-400 text-sm"></i>
                                    </span>
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                                        placeholder="Nama lengkap">
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-gray-700 text-xs font-semibold mb-2">Email</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fas fa-envelope text-gray-400 text-sm"></i>
                                    </span>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                                        placeholder="email@example.com">
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NIK -->
                            <div>
                                <label class="block text-gray-700 text-xs font-semibold mb-2">NIK (16 digit)</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fas fa-id-card text-gray-400 text-sm"></i>
                                    </span>
                                    <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16"
                                        required
                                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                                        placeholder="16 digit NIK">
                                </div>
                                @error('nik')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- No. Telepon -->
                            <div>
                                <label class="block text-gray-700 text-xs font-semibold mb-2">No. Telepon</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fas fa-phone text-gray-400 text-sm"></i>
                                    </span>
                                    <input type="text" name="phone" value="{{ old('phone') }}" required
                                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                                        placeholder="08xxxxxxxxxx">
                                </div>
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-gray-700 text-xs font-semibold mb-2">Password</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fas fa-lock text-gray-400 text-sm"></i>
                                    </span>
                                    <input type="password" name="password" required
                                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                                        placeholder="Min. 6 karakter">
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Konfirmasi Password -->
                            <div>
                                <label class="block text-gray-700 text-xs font-semibold mb-2">Konfirmasi
                                    Password</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fas fa-lock text-gray-400 text-sm"></i>
                                    </span>
                                    <input type="password" name="password_confirmation" required
                                        class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                                        placeholder="Ulangi password">
                                </div>
                            </div>
                        </div>

                        <!-- Alamat - Full Width -->
                        <div class="mt-4">
                            <label class="block text-gray-700 text-xs font-semibold mb-2">Alamat Lengkap</label>
                            <div class="relative">
                                <span class="absolute top-3 left-3">
                                    <i class="fas fa-map-marker-alt text-gray-400 text-sm"></i>
                                </span>
                                <textarea name="address" rows="2" required
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                                    placeholder="Alamat lengkap">{{ old('address') }}</textarea>
                            </div>
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-5">
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-2.5 rounded-lg hover:from-green-600 hover:to-green-700 transition shadow-md text-sm font-semibold">
                                Daftar Sekarang
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 text-center">
                        <p class="text-gray-600 text-xs">
                            Sudah punya akun?
                            <a href="{{ route('login') }}"
                                class="text-green-600 hover:text-green-700 font-semibold">Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
