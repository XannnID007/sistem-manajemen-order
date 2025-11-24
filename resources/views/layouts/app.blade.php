<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', \App\Models\Setting::get()->pangkalan_name)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-size: 0.9rem;
        }

        .sidebar-link {
            transition: all 0.3s;
        }

        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-link.active {
            background-color: rgba(255, 255, 255, 0.15);
            border-left: 4px solid white;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 0.5rem;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            z-index: 50;
        }

        .dropdown-menu.show {
            display: block;
        }
    </style>
</head>

<body class="bg-gray-100">
    @php
        $setting = \App\Models\Setting::get();
    @endphp

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-30 w-64 bg-gradient-to-b from-green-600 to-green-700 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 bg-green-800 bg-opacity-50 px-4">
                    @if ($setting->logo)
                        <img src="{{ asset('storage/' . $setting->logo) }}" alt="{{ $setting->pangkalan_name }}"
                            class="h-12 w-12 object-contain mr-2 rounded-full">
                    @else
                        <i class="fas fa-gas-pump text-2xl mr-2"></i>
                    @endif
                    <span class="text-lg font-bold truncate">{{ $setting->pangkalan_name }}</span>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-3 py-4 overflow-y-auto">
                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                class="sidebar-link flex items-center px-3 py-2.5 rounded-lg mb-1 text-sm {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-home w-5"></i>
                                <span class="ml-3">Dashboard</span>
                            </a>
                            <a href="{{ route('admin.orders') }}"
                                class="sidebar-link flex items-center px-3 py-2.5 rounded-lg mb-1 text-sm {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                                <i class="fas fa-shopping-cart w-5"></i>
                                <span class="ml-3">Kelola Pesanan</span>
                            </a>
                            <a href="{{ route('admin.users.index') }}"
                                class="sidebar-link flex items-center px-3 py-2.5 rounded-lg mb-1 text-sm {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                <i class="fas fa-users w-5"></i>
                                <span class="ml-3">Kelola User</span>
                            </a>
                            <a href="{{ route('admin.history') }}"
                                class="sidebar-link flex items-center px-3 py-2.5 rounded-lg mb-1 text-sm {{ request()->routeIs('admin.history') ? 'active' : '' }}">
                                <i class="fas fa-history w-5"></i>
                                <span class="ml-3">Riwayat & Laporan</span>
                            </a>
                            <a href="{{ route('admin.settings') }}"
                                class="sidebar-link flex items-center px-3 py-2.5 rounded-lg mb-1 text-sm {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                                <i class="fas fa-cog w-5"></i>
                                <span class="ml-3">Pengaturan</span>
                            </a>
                        @else
                            <a href="{{ route('customer.dashboard') }}"
                                class="sidebar-link flex items-center px-3 py-2.5 rounded-lg mb-1 text-sm {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                                <i class="fas fa-home w-5"></i>
                                <span class="ml-3">Dashboard</span>
                            </a>
                            <a href="{{ route('customer.order.create') }}"
                                class="sidebar-link flex items-center px-3 py-2.5 rounded-lg mb-1 text-sm {{ request()->routeIs('customer.order.create') ? 'active' : '' }}">
                                <i class="fas fa-plus-circle w-5"></i>
                                <span class="ml-3">Buat Pesanan</span>
                            </a>
                            <a href="{{ route('customer.orders') }}"
                                class="sidebar-link flex items-center px-3 py-2.5 rounded-lg mb-1 text-sm {{ request()->routeIs('customer.orders') ? 'active' : '' }}">
                                <i class="fas fa-list w-5"></i>
                                <span class="ml-3">Riwayat Pesanan</span>
                            </a>
                        @endif
                    @endauth
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-64">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-4 lg:px-6">
                <div class="flex items-center space-x-4">
                    <button onclick="toggleSidebar()" class="lg:hidden text-gray-600">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <!-- Profile Dropdown -->
                        <div class="dropdown">
                            <button onclick="toggleDropdown(event)"
                                class="flex items-center space-x-2 hover:bg-gray-100 rounded-lg px-3 py-2 transition-colors">
                                <div
                                    class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ auth()->user()->isAdmin() ? 'Administrator' : 'Pelanggan' }}
                                    </p>
                                </div>
                                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="dropdownMenu" class="dropdown-menu">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                                <button onclick="confirmLogout()"
                                    class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 flex items-center space-x-2 transition-colors">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Keluar</span>
                                </button>
                            </div>
                        </div>
                    @endauth
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-4 lg:p-6">
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

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden lg:hidden" onclick="toggleSidebar()">
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function toggleDropdown(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdownMenu');
            if (dropdown && dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        });

        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
</body>

</html>
