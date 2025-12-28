@extends('layouts.app')

@section('title', 'Detail Pelanggan')
@section('page-title', 'Data Pelanggan')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Detail Pelanggan</h1>
            <p class="text-sm text-gray-500 mt-1">Informasi lengkap pelanggan: <span
                    class="font-semibold text-emerald-600">{{ $user->name }}</span></p>
        </div>
        <a href="{{ route('admin.users.index') }}"
            class="text-sm font-medium text-gray-500 hover:text-emerald-600 flex items-center transition-colors bg-white px-4 py-2 rounded-xl border border-gray-200 shadow-sm hover:shadow-md">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="h-1.5 w-full bg-gradient-to-r from-emerald-500 to-teal-400"></div>

            <div class="p-8">
                <!-- Profile Header -->
                <div class="flex items-center mb-8 pb-6 border-b border-gray-100">
                    <div
                        class="flex-shrink-0 w-20 h-20 rounded-full bg-gradient-to-tr from-blue-400 to-blue-600 flex items-center justify-center text-white text-3xl font-bold shadow-lg shadow-blue-500/30">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="ml-6">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-500 mt-1">Terdaftar sejak {{ $user->created_at->format('d F Y') }}</p>
                        <span
                            class="inline-flex items-center mt-2 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                            <i class="fas fa-check-circle mr-1.5"></i> Pelanggan Aktif
                        </span>
                    </div>
                </div>

                <!-- Informasi Akun -->
                <div class="mb-8">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-5 flex items-center">
                        <span
                            class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center mr-3">
                            <i class="fas fa-user-circle"></i>
                        </span>
                        Informasi Akun
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama
                                Lengkap</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Alamat
                                Email</label>
                            <p class="text-sm font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-envelope text-gray-400 mr-2"></i>{{ $user->email }}
                            </p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">NIK
                                (KTP)</label>
                            <p class="text-sm font-mono font-semibold text-gray-900">{{ $user->nik }}</p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">No.
                                Telepon</label>
                            <p class="text-sm font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-phone text-gray-400 mr-2"></i>{{ $user->phone }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-dashed border-gray-200 my-6"></div>

                <!-- Kontak & Alamat -->
                <div class="mb-8">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-5 flex items-center">
                        <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center mr-3">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                        Alamat Lengkap
                    </h3>

                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <p class="text-sm text-gray-900 leading-relaxed">{{ $user->address }}</p>
                    </div>
                </div>

                <div class="border-t border-dashed border-gray-200 my-6"></div>

                <!-- Statistik Pesanan -->
                <div class="mb-8">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-5 flex items-center">
                        <span class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center mr-3">
                            <i class="fas fa-chart-bar"></i>
                        </span>
                        Statistik Aktivitas
                    </h3>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
                            <div class="flex items-center justify-between mb-2">
                                <i class="fas fa-shopping-bag text-blue-600 text-xl"></i>
                                <span class="text-xs font-bold text-blue-600 uppercase">Total</span>
                            </div>
                            <p class="text-2xl font-bold text-blue-700">{{ $user->orders()->count() }}</p>
                            <p class="text-xs text-blue-600 mt-1">Pesanan</p>
                        </div>

                        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 border border-yellow-200">
                            <div class="flex items-center justify-between mb-2">
                                <i class="fas fa-clock text-yellow-600 text-xl"></i>
                                <span class="text-xs font-bold text-yellow-600 uppercase">Pending</span>
                            </div>
                            <p class="text-2xl font-bold text-yellow-700">
                                {{ $user->orders()->where('status', 'pending')->count() }}</p>
                            <p class="text-xs text-yellow-600 mt-1">Pesanan</p>
                        </div>

                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200">
                            <div class="flex items-center justify-between mb-2">
                                <i class="fas fa-truck text-purple-600 text-xl"></i>
                                <span class="text-xs font-bold text-purple-600 uppercase">Dikirim</span>
                            </div>
                            <p class="text-2xl font-bold text-purple-700">
                                {{ $user->orders()->where('status', 'delivered')->count() }}</p>
                            <p class="text-xs text-purple-600 mt-1">Pesanan</p>
                        </div>

                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
                            <div class="flex items-center justify-between mb-2">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                <span class="text-xs font-bold text-green-600 uppercase">Selesai</span>
                            </div>
                            <p class="text-2xl font-bold text-green-700">
                                {{ $user->orders()->where('status', 'confirmed')->count() }}</p>
                            <p class="text-xs text-green-600 mt-1">Pesanan</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col-reverse md:flex-row items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.users.index') }}"
                        class="w-full md:w-auto text-center px-6 py-3 rounded-xl border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 hover:border-gray-300 transition-all text-sm">
                        Kembali ke Daftar
                    </a>
                    <button onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                        class="w-full md:w-auto bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-xl shadow-lg shadow-red-500/30 transition-all transform active:scale-95 text-sm flex items-center justify-center gap-2">
                        <i class="fas fa-trash"></i> Hapus Pelanggan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(userId, userName) {
            Swal.fire({
                title: 'Hapus Pelanggan?',
                text: `Anda akan menghapus data pelanggan "${userName}". Tindakan ini tidak dapat dibatalkan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                background: '#fff',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-5 py-2.5',
                    cancelButton: 'rounded-xl px-5 py-2.5'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/users/${userId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Terhapus!',
                                    text: data.message,
                                    confirmButtonColor: '#10b981',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = '{{ route('admin.users.index') }}';
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: data.message,
                                    confirmButtonColor: '#ef4444'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error Sistem',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                confirmButtonColor: '#ef4444'
                            });
                        });
                }
            });
        }
    </script>
@endsection
