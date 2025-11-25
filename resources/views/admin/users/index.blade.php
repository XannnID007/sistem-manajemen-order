@extends('layouts.app')

@section('title', 'Kelola Pelanggan')
@section('page-title', 'Data Pelanggan')

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8 relative overflow-hidden">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 relative z-10">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Daftar Pelanggan</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola data dan informasi pelanggan pangkalan.</p>
            </div>

            <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                <form method="GET" class="relative flex-1 md:w-80">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama, NIK, atau telepon..."
                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all text-sm placeholder-gray-400">
                </form>

                <a href="{{ route('admin.users.create') }}"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-5 rounded-xl shadow-lg shadow-emerald-500/30 transition-all transform active:scale-95 text-sm flex items-center justify-center gap-2 whitespace-nowrap">
                    <i class="fas fa-user-plus"></i> Tambah Baru
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 text-left">
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider w-16">No</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama Pelanggan
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Kontak</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Identitas (NIK)
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider text-center">
                            Aktivitas</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider text-center">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $index => $user)
                        <tr class="group hover:bg-emerald-50/30 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-md">
                                    {{ $users->firstItem() + $index }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-tr from-blue-400 to-blue-600 flex items-center justify-center text-white text-sm font-bold shadow-md shadow-blue-500/20">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-400">Terdaftar:
                                            {{ $user->created_at->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center text-xs text-gray-600">
                                        <i class="fas fa-envelope w-4 text-gray-400"></i> {{ $user->email }}
                                    </div>
                                    <div class="flex items-center text-xs text-gray-600">
                                        <i class="fas fa-phone w-4 text-gray-400"></i> {{ $user->phone }}
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="text-sm font-mono text-gray-700 bg-gray-50 px-2 py-1 rounded border border-gray-100">
                                    {{ $user->nik }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                    <i class="fas fa-shopping-bag mr-1.5"></i> {{ $user->orders()->count() }} Pesanan
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 hover:text-amber-700 transition-all flex items-center justify-center"
                                        title="Edit Data">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>

                                    <button onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                        class="w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 transition-all flex items-center justify-center"
                                        title="Hapus Pelanggan">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div
                                        class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                                        <i class="fas fa-users-slash text-3xl"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Data pelanggan tidak ditemukan.</p>
                                    <p class="text-xs text-gray-400 mt-1">Coba kata kunci lain atau tambahkan pelanggan
                                        baru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                {{ $users->links() }}
            </div>
        @endif
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
                                    window.location.reload();
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
