<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', \App\Models\Setting::get()->pangkalan_name)</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Base Setup */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Sidebar Styling */
        .sidebar-container {
            background: #064e3b;
            background: linear-gradient(180deg, #064e3b 0%, #065f46 100%);
            color: white;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.1);
            transition: width 0.3s ease, transform 0.3s ease;
            /* Smooth transition for width & slide */
            white-space: nowrap;
            /* Mencegah teks turun baris saat mengecil */
        }

        /* Sidebar Links */
        .sidebar-link {
            position: relative;
            transition: all 0.3s ease;
            margin-bottom: 5px;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 500;
            display: flex;
            align-items: center;
            overflow: hidden;
            /* Sembunyikan teks yang meluap */
        }

        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-weight: 600;
        }

        /* Indicator Garis */
        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 20px;
            width: 4px;
            background-color: #34d399;
            border-radius: 0 4px 4px 0;
        }

        /* Navbar Glass Effect */
        .glass-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            position: sticky;
            top: 0;
            z-index: 40;
            transition: all 0.3s ease;
        }

        /* Dropdown Animation */
        .dropdown-menu {
            transform-origin: top right;
            transition: all 0.2s ease-out;
            transform: scale(0.95);
            opacity: 0;
            display: none;
        }

        .dropdown-menu.show {
            display: block;
            transform: scale(1);
            opacity: 1;
        }

        /* Utility class untuk hide text saat sidebar kecil */
        .sidebar-mini .sidebar-text {
            opacity: 0;
            pointer-events: none;
            display: none;
        }

        /* Pusatkan icon saat mini */
        .sidebar-mini .sidebar-link {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
        }

        .sidebar-mini .logo-text {
            display: none;
        }

        .sidebar-mini .menu-label {
            display: none;
        }
    </style>
</head>

<body class="antialiased overflow-hidden">
    @php
        $setting = \App\Models\Setting::get();
    @endphp

    <div class="flex h-screen">

        <aside id="sidebar"
            class="sidebar-container fixed inset-y-0 left-0 z-50 w-72 transform -translate-x-full lg:translate-x-0 flex flex-col">

            <div
                class="h-20 flex items-center justify-center border-b border-white/10 transition-all duration-300 px-2">
                <div class="flex items-center space-x-3 overflow-hidden">
                    <div
                        class="flex-shrink-0 w-10 h-10 rounded-full bg-white/10 flex items-center justify-center p-1 backdrop-blur-sm">
                        @if ($setting->logo)
                            <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo"
                                class="w-full h-full object-contain rounded-full">
                        @else
                            <i class="fas fa-gas-pump text-xl text-emerald-400"></i>
                        @endif
                    </div>

                    <div class="logo-text transition-opacity duration-300">
                        <h2 class="text-white font-bold text-lg leading-tight tracking-wide">PANGKALAN</h2>
                        <p class="text-emerald-300 text-xs font-light tracking-wider uppercase truncate max-w-[120px]">
                            {{ $setting->pangkalan_name }}
                        </p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-3 py-6 overflow-y-auto space-y-1 overflow-x-hidden">
                <p
                    class="menu-label px-4 text-xs font-semibold text-emerald-400/80 uppercase tracking-wider mb-2 mt-2 truncate">
                    Menu Utama</p>

                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                            class="sidebar-link h-11 px-4 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                            title="Dashboard">
                            <i class="fas fa-chart-pie w-6 text-center text-lg"></i>
                            <span class="sidebar-text ml-3">Dashboard</span>
                        </a>

                        <a href="{{ route('admin.orders') }}"
                            class="sidebar-link h-11 px-4 {{ request()->routeIs('admin.orders') ? 'active' : '' }}"
                            title="Kelola Pesanan">
                            <i class="fas fa-shopping-bag w-6 text-center text-lg"></i>
                            <span class="sidebar-text ml-3">Kelola Pesanan</span>
                        </a>

                        <a href="{{ route('admin.users.index') }}"
                            class="sidebar-link h-11 px-4 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                            title="Data Pengguna">
                            <i class="fas fa-users w-6 text-center text-lg"></i>
                            <span class="sidebar-text ml-3">Data Pengguna</span>
                        </a>

                        <p
                            class="menu-label px-4 text-xs font-semibold text-emerald-400/80 uppercase tracking-wider mb-2 mt-6 truncate">
                            Laporan</p>

                        <a href="{{ route('admin.history') }}"
                            class="sidebar-link h-11 px-4 {{ request()->routeIs('admin.history') ? 'active' : '' }}"
                            title="Riwayat Transaksi">
                            <i class="fas fa-file-invoice w-6 text-center text-lg"></i>
                            <span class="sidebar-text ml-3">Riwayat</span>
                        </a>

                        <a href="{{ route('admin.settings') }}"
                            class="sidebar-link h-11 px-4 {{ request()->routeIs('admin.settings') ? 'active' : '' }}"
                            title="Pengaturan">
                            <i class="fas fa-sliders-h w-6 text-center text-lg"></i>
                            <span class="sidebar-text ml-3">Pengaturan</span>
                        </a>
                    @else
                        <a href="{{ route('customer.dashboard') }}"
                            class="sidebar-link h-11 px-4 {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}"
                            title="Dashboard">
                            <i class="fas fa-home w-6 text-center text-lg"></i>
                            <span class="sidebar-text ml-3">Dashboard</span>
                        </a>

                        <a href="{{ route('customer.order.create') }}"
                            class="sidebar-link h-11 px-4 {{ request()->routeIs('customer.order.create') ? 'active' : '' }}"
                            title="Buat Pesanan">
                            <i class="fas fa-plus-circle w-6 text-center text-lg"></i>
                            <span class="sidebar-text ml-3">Buat Pesanan</span>
                        </a>

                        <a href="{{ route('customer.orders') }}"
                            class="sidebar-link h-11 px-4 {{ request()->routeIs('customer.orders') ? 'active' : '' }}"
                            title="Riwayat Pesanan">
                            <i class="fas fa-history w-6 text-center text-lg"></i>
                            <span class="sidebar-text ml-3">Riwayat</span>
                        </a>
                    @endif
                @endauth
            </nav>

        </aside>

        <div id="main-content"
            class="flex-1 flex flex-col h-screen overflow-hidden lg:pl-72 transition-all duration-300 ease-in-out relative w-full">

            <header
                class="glass-header h-20 flex items-center justify-between px-6 lg:px-10 shadow-sm transition-all duration-300">

                <div class="flex items-center gap-5">
                    <button onclick="toggleSidebar()"
                        class="group p-2.5 rounded-xl bg-white border border-gray-100 shadow-sm hover:shadow-lg hover:shadow-emerald-500/10 hover:border-emerald-100 text-gray-500 hover:text-emerald-600 transition-all duration-300 focus:outline-none active:scale-95">
                        <i
                            class="fas fa-bars-staggered text-lg transform transition-transform duration-300 group-hover:rotate-180"></i>
                    </button>

                    <div>
                        <h1 class="text-xl font-bold text-gray-800 tracking-tight">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-xs text-gray-500 font-medium hidden sm:block">Sistem Informasi Pangkalan LPG 3Kg
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-6">

                    <div class="dropdown relative">
                        <button onclick="toggleDropdown(event)"
                            class="flex items-center space-x-3 focus:outline-none group">
                            <div class="text-right hidden md:block">
                                <p
                                    class="text-sm font-bold text-gray-700 group-hover:text-emerald-600 transition-colors">
                                    {{ auth()->user()->name }}</p>
                                <p class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">
                                    {{ auth()->user()->isAdmin() ? 'Administrator' : 'Pelanggan' }}
                                </p>
                            </div>
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-tr from-emerald-500 to-green-400 flex items-center justify-center text-white font-bold shadow-lg shadow-emerald-500/30 ring-2 ring-white ring-offset-2 ring-offset-gray-50 group-hover:scale-105 transition-transform">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <i
                                class="fas fa-chevron-down text-xs text-gray-400 group-hover:text-emerald-600 transition-colors"></i>
                        </button>

                        <div id="dropdownMenu"
                            class="dropdown-menu absolute right-0 mt-5 w-60 bg-white/90 backdrop-blur-md rounded-2xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.1)] border border-white/50 z-50 overflow-hidden transform origin-top-right">
                            <div class="bg-gray-50/50 px-5 py-4 border-b border-gray-100">
                                <p class="text-sm font-bold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="p-2 space-y-1">
                                <a href="#"
                                    class="flex items-center px-4 py-2.5 text-sm text-gray-600 hover:bg-emerald-50 hover:text-emerald-600 rounded-xl transition-all group">
                                    <span
                                        class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-emerald-100 flex items-center justify-center mr-3 transition-colors">
                                        <i class="fas fa-user-circle text-gray-500 group-hover:text-emerald-600"></i>
                                    </span>
                                    Profil Saya
                                </a>
                                <div class="h-px bg-gray-100 my-1 mx-2"></div>
                                <button onclick="confirmLogout()"
                                    class="w-full flex items-center px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 rounded-xl transition-all group">
                                    <span
                                        class="w-8 h-8 rounded-lg bg-red-50 group-hover:bg-red-100 flex items-center justify-center mr-3 transition-colors">
                                        <i class="fas fa-sign-out-alt text-red-400 group-hover:text-red-500"></i>
                                    </span>
                                    Keluar
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 lg:p-8 relative">
                @if (session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: '{{ session('success') }}',
                            confirmButtonColor: '#10b981',
                            timer: 2000,
                            timerProgressBar: true
                        });
                    </script>
                @endif

                @if (session('error'))
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: '{{ session('error') }}',
                            confirmButtonColor: '#ef4444',
                        });
                    </script>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <div id="overlay" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-40 hidden lg:hidden"
        onclick="toggleSidebar()"></div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>

    <script>
        // --- LOGIC SIDEBAR BARU ---

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const overlay = document.getElementById('overlay');
            const isMobile = window.innerWidth < 1024;

            if (isMobile) {
                // Logic Mobile: Slide In/Out
                if (sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                }
            } else {
                // Logic Desktop: Mini Sidebar (Icon Only)
                sidebar.classList.toggle('w-72'); // Default width
                sidebar.classList.toggle('w-20'); // Mini width
                sidebar.classList.toggle('sidebar-mini'); // Trigger CSS hide text

                // Adjust Main Content Padding
                if (mainContent.classList.contains('lg:pl-72')) {
                    mainContent.classList.remove('lg:pl-72');
                    mainContent.classList.add('lg:pl-20');
                } else {
                    mainContent.classList.remove('lg:pl-20');
                    mainContent.classList.add('lg:pl-72');
                }
            }
        }

        // Dropdown Toggle
        function toggleDropdown(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('show');
        }

        // Close Dropdown on Outside Click
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdownMenu');
            if (dropdown && dropdown.classList.contains('show')) {
                if (!event.target.closest('.dropdown')) {
                    dropdown.classList.remove('show');
                }
            }
        });

        // Logout Confirmation
        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar?',
                icon: 'warning',
                iconColor: '#ef4444',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                background: '#fff',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-6 py-2.5',
                    cancelButton: 'rounded-xl px-6 py-2.5'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
</body>

</html>
