<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tender-App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script> <!-- Lucide Icons -->
</head>

<!-- Background Dashboard -->
<body class="h-screen flex flex-col bg-cover bg-center" style="background-image: url('{{ asset('assets/login/bg.png') }}');">

    <!-- NAVBAR UTAMA -->
    <div x-data="{ navbarOpen: false }" class="w-full bg-blue-100 shadow-md px-6 py-3 flex items-center justify-between fixed top-0 left-0 right-0 z-50">
        <!-- Left Section -->
        <div class="flex items-center space-x-4">
            <!-- Toggle Navbar Button -->
            <button @click="navbarOpen = !navbarOpen" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                <i data-lucide="menu"></i>
            </button>

            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <img src="{{ asset('assets/login/Logodashboard.png') }}" alt="Logo" class="h-16">
            </div>
        </div>

        <!-- Right Section (Profile) -->
        <div class="flex items-center space-x-4">
            <p class="text-gray-700 font-medium">
                Login Result: {{ session('user')->LoginResult ?? 'N/A' }}
            </p>
            <i data-lucide="user-circle" class="w-6 h-6 text-gray-700"></i>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">
                Logout
            </button>
        </form>
        <!-- NAVBAR MENU DROPDOWN -->
        <div
            x-show="navbarOpen"
            x-cloak
            @click.away="navbarOpen = false"
            @keydown.escape.window="navbarOpen = false"
            x-transition.duration.300ms
            class="absolute top-16 left-4 bg-white shadow-lg rounded-lg w-64 p-4"
        >
            <nav class="space-y-2">
                @foreach ($menus as $menu)
                    @if ($menu->ParentRoleLineID === null)
                        <div x-data="{ open: false }">
                            <!-- Menu Utama -->
                            <button @click="open = !open" class="w-full text-left font-semibold uppercase text-gray-700 flex justify-between items-center py-2 px-4 hover:bg-gray-200 rounded">
                                <div class="flex items-center">
                                    @if (!empty($menu->IconFileName))
                                        <img src="{{ asset($menu->IconFileName) }}" class="w-6 h-6 mr-2">
                                    @endif
                                    {{ $menu->FormDescription }}
                                </div>
                                <i class="w-4 h-4" x-bind:class="open ? 'rotate-90' : ''">⮞</i>
                            </button>

                            <!-- Submenu -->
                            <div x-show="open" x-collapse class="ml-4 space-y-1">
                                @foreach ($menus as $submenu)
                                    @if ($submenu->ParentRoleLineID === $menu->RoleLineID)
                                        <a href="{{ $submenu->FormURLAddress ?? '#' }}"
                                           class="block py-2 px-4 rounded-lg transition duration-300 ease-in-out hover:bg-gray-300 flex items-center">
                                            @if (!empty($submenu->IconFileName))
                                                <img src="{{ asset('icons/' . $submenu->IconFileName) }}" class="w-5 h-5 mr-2">
                                            @endif
                                            {{ $submenu->FormDescription }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </nav>
        </div>
    </div>


    <!-- Load Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>

</body>
</html>
