@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Kelola User</h1>
        <p class="text-gray-600 text-sm mt-1">Kelola data pelanggan</p>
    </div>

    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-5">
            <div class="flex flex-col md:flex-row justify-between gap-4">
                <form method="GET" class="flex-1 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama, email, NIK, atau telepon..."
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm">
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm font-medium">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <a href="{{ route('admin.users.create') }}"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm font-medium whitespace-nowrap">
                    <i class="fas fa-plus mr-2"></i>Tambah Pelanggan
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIK</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Telepon</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Pesanan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $index => $user)
                        <tr>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $users->firstItem() + $index }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $user->email }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $user->nik }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $user->phone }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-medium">
                                    {{ $user->orders()->count() }} pesanan
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="text-blue-600 hover:text-blue-700 text-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                        class="text-red-600 hover:text-red-700 text-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500 text-sm">
                                Tidak ada data pelanggan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="p-5 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <script>
        function confirmDelete(userId, userName) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: `Apakah Anda yakin ingin menghapus pelanggan<br><strong>${userName}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
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
                                    title: 'Berhasil!',
                                    text: data.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: data.message
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat menghapus data.'
                            });
                        });
                }
            });
        }
    </script>
@endsection
