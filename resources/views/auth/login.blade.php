<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Pangkalan LPG</title>
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
        class="min-h-screen flex items-center justify-center px-4 bg-gradient-to-br from-green-400 via-green-500 to-green-600">
        <div class="w-full max-w-sm">
            <!-- Card -->
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="bg-white px-6 pt-8 pb-6 text-center">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full mb-3 shadow-lg">
                        <i class="fas fa-gas-pump text-white text-2xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Pangkalan LPG</h2>
                    <p class="text-gray-500 text-xs mt-1">Masuk ke akun Anda</p>
                </div>

                <!-- Form -->
                <div class="px-6 pb-8">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-xs font-semibold mb-2">Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i class="fas fa-envelope text-gray-400 text-sm"></i>
                                </span>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                                    placeholder="email@example.com">
                            </div>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-xs font-semibold mb-2">Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i class="fas fa-lock text-gray-400 text-sm"></i>
                                </span>
                                <input type="password" name="password" required
                                    class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                                    placeholder="••••••••">
                            </div>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember"
                                    class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                <span class="ml-2 text-xs text-gray-600">Ingat saya</span>
                            </label>
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-2.5 rounded-lg hover:from-green-600 hover:to-green-700 transition shadow-md text-sm font-semibold">
                            Masuk
                        </button>
                    </form>

                    <div class="mt-5 text-center">
                        <p class="text-gray-600 text-xs">
                            Belum punya akun?
                            <a href="{{ route('register') }}"
                                class="text-green-600 hover:text-green-700 font-semibold">Daftar</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
