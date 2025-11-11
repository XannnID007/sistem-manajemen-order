<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Emergency Logout - Pangkalan LPG</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Session Problem</h1>
                <p class="text-gray-600 text-sm">Terjadi masalah dengan session Anda</p>
            </div>

            <div class="space-y-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 transition text-sm font-semibold">
                        Force Logout
                    </button>
                </form>

                <a href="{{ route('login') }}"
                    class="block w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition text-sm font-semibold text-center">
                    Go to Login
                </a>

                <button onclick="clearAndReload()"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition text-sm font-semibold">
                    Clear Cache & Reload
                </button>
            </div>

            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-600 mb-2"><strong>Langkah-langkah:</strong></p>
                <ol class="text-xs text-gray-600 space-y-1 list-decimal list-inside">
                    <li>Klik "Force Logout"</li>
                    <li>Atau klik "Clear Cache & Reload"</li>
                    <li>Kemudian login kembali</li>
                </ol>
            </div>
        </div>
    </div>

    <script>
        function clearAndReload() {
            // Clear all storage
            localStorage.clear();
            sessionStorage.clear();

            // Clear cookies
            document.cookie.split(";").forEach(function(c) {
                document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() +
                    ";path=/");
            });

            // Reload
            window.location.href = '{{ route('login') }}';
        }
    </script>
</body>

</html>
