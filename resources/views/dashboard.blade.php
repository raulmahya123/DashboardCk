<?php
// Grupkan menu berdasarkan ParentRoleLineID
$groupedMenus = [];
foreach ($menus as $menu) {
    $parentID = $menu->ParentRoleLineID ?? $menu->RoleLineID; // Jika null, pakai RoleLineID
    $groupedMenus[$parentID][] = $menu;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script> <!-- Lucide Icons -->
</head>
<body class="bg-gray-100 flex h-screen">

    <!-- Sidebar -->
<!-- Sidebar -->
<div class="w-64 bg-gray-900 text-white p-6 space-y-6 fixed h-screen overflow-y-auto">
    <h2 class="text-xl font-bold">Dashboard</h2>
    <nav class="space-y-2">
        @foreach ($menus as $menu)
            @if ($menu->ParentRoleLineID === null)
                <div x-data="{ open: false }">
                    <!-- Menu Utama -->
                    <button @click="open = !open" class="w-full text-left font-semibold uppercase text-gray-400 flex justify-between items-center py-2 px-4 hover:bg-gray-700 rounded">
                        <div class="flex items-center">
                            @if (!empty($menu->IconFileName))
                            <img src="{{ asset($menu->IconFileName) }}" class="w-10 h-10 mr-2">


                        @endif

                            {{ $menu->FormDescription }}
                        </div>
                    </button>

                    <!-- Submenu -->
                    <div x-show="open" class="ml-4 space-y-1">
                        @foreach ($menus as $submenu)
                            @if ($submenu->ParentRoleLineID === $menu->RoleLineID)
                                <a href="{{ $submenu->FormURLAddress ?? '#' }}"
                                   class="block py-2 px-4 rounded-lg transition duration-300 ease-in-out hover:bg-gray-700 flex items-center">
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

    <!-- Logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">
            Logout
        </button>
    </form>
</div>



    <!-- Main Content -->
    <div class="flex-1 p-6 ml-64">
        <h1 class="text-2xl font-bold">Selamat Datang di Dashboard</h1>
        <p class="mt-4">Login Result: {{ session('user')->LoginResult ?? 'N/A' }}</p>
        <p>Message: {{ session('user')->LoginResultMessage ?? 'N/A' }}</p>
    </div>

    <!-- Load Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>
<!-- Tambahkan Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.5/dist/cdn.min.js"></script>


</body>
</html>
