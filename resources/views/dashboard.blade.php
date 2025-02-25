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

<body class="h-screen flex flex-col bg-cover bg-center"
    style="background-image: url('{{ asset('assets/login/bg.png') }}');">

    <!-- NAVBAR UTAMA -->
    <div
        class="w-full bg-blue-100 shadow-md px-6 py-3 flex items-center justify-between fixed top-0 left-0 right-0 z-50">
        <!-- Left Section -->
        <div class="flex items-center space-x-4">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <img src="{{ asset('assets/login/Logodashboard.png') }}" alt="Logo" class="h-10">
            </div>
        </div>

        <!-- Right Section (Profile) -->
        <div class="flex items-center space-x-4">
            <i data-lucide="user-circle" class="w-6 h-6 text-gray-700"></i>
            <p class="text-gray-700 font-medium px-4 py-2 border-b">
                @if (session()->has('user_details') && is_array(session('user_details')))
                    @foreach (session('user_details') as $index => $group)
                        @if ($index === 3 && is_array($group))
                            @foreach ($group as $data)
                                @if (is_array($data) && isset($data['CompleteUserName']))
                                    {{ $data['CompleteUserName'] }}
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @else
                    <span class="text-red-500">No CompleteUserName found.</span>
                @endif
            </p>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left font-semibold uppercase text-gray-700 flex justify-between items-center py-2 px-4 hover:bg-red-500 hover:text-white rounded">
                    <div class="flex items-center">
                        <i data-lucide="log-out" class="w-6 h-6 mr-2"></i>
                        Logout
                    </div>
                </button>
            </form>


            {{-- buatkan button logout --}}

        </div>
    </div>

    <div class="fixed top-16 left-0 w-64 h-full bg-white shadow-lg p-4 overflow-y-auto z-40">
        <nav class="space-y-2">
            @foreach ($menus as $menu)
                @php
                    $hasURL = !empty($menu->FormURLAddress); // Cek apakah memiliki URL
                    $hasPowerBILink = !empty($menu->PowerBILink); // Cek apakah memiliki Power BI Link
                @endphp

                @if ($hasPowerBILink)
                    <!-- Navbar Utama: Menu Power BI jika tersedia -->
                    <div class="block font-semibold uppercase text-blue-600 py-2 px-4 hover:bg-gray-200 rounded flex items-center">
                        <i data-lucide="bar-chart-2" class="mr-2"></i> {{ $menu->FormDescription }} (Power BI)
                    </div>
                @elseif ($hasURL)
                    <!-- Navbar Utama: Menu dengan FormURLAddress -->
                    <a href="{{ $menu->FormURLAddress }}"
                        class="block font-semibold uppercase text-gray-700 py-2 px-4 hover:bg-gray-200 rounded flex items-center">
                        <i data-lucide="link" class="mr-2"></i> {{ $menu->FormDescription }}
                    </a>
                @elseif ($menu->ParentRoleLineID === null)
                    <!-- Navbar Utama: Jika tidak punya FormURLAddress -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full text-left font-semibold uppercase text-gray-700 flex justify-between items-center py-2 px-4 hover:bg-gray-200 rounded">
                            <div class="flex items-center">
                                @if (!empty($menu->IconFileName))
                                    <img src="{{ asset($menu->IconFileName) }}" class="w-6 h-6 mr-2">
                                @endif
                                {{ $menu->FormDescription }}
                            </div>
                            <i :class="open ? 'rotate-180' : ''" data-lucide="chevron-down"></i>
                        </button>

                        <!-- Submenu -->
                        <div x-show="open" class="ml-4 space-y-1" x-cloak>
                            @foreach ($menus as $submenu)
                                @if ($submenu->ParentRoleLineID === $menu->RoleLineID)
                                    <div x-data="{ openSub: false }">
                                        <button @click="openSub = !openSub"
                                            class="w-full text-left flex items-center py-2 px-4 rounded-lg transition duration-300 ease-in-out hover:bg-gray-300">
                                            @if (!empty($submenu->IconFileName))
                                                <img src="{{ asset('icons/' . $submenu->IconFileName) }}" class="w-5 h-5 mr-2">
                                            @endif
                                            {{ $submenu->FormDescription }}
                                            <i :class="openSub ? 'rotate-180' : ''" data-lucide="chevron-down"></i>
                                        </button>

                                        <!-- Sub-submenu -->
                                        <div x-show="openSub" class="ml-4 space-y-1" x-cloak>
                                            @foreach ($menus as $subsubmenu)
                                                @if ($subsubmenu->ParentRoleLineID === $submenu->RoleLineID)
                                                    <a href="{{ $subsubmenu->FormURLAddress ?? '#' }}"
                                                        class="block py-2 px-4 rounded-lg transition duration-300 ease-in-out hover:bg-gray-300 flex items-center">
                                                        @if (!empty($subsubmenu->IconFileName))
                                                            <img src="{{ asset('icons/' . $subsubmenu->IconFileName) }}" class="w-5 h-5 mr-2">
                                                        @endif
                                                        {{ $subsubmenu->FormDescription }}
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </nav>
    </div>




        <div class="w-full h-screen flex items-center justify-center">
            @foreach ($menus as $menu)
                @if (!empty($menu->PowerBILink))
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden max-w-4xl w-full h-[80vh] mx-auto">
                        <div class="p-4 border-b">
                            <h3 class="text-lg font-semibold text-gray-700 flex items-center">
                                <i data-lucide="bar-chart-2" class="mr-2"></i>
                                (DASHBOARD BI)
                            </h3>
                        </div>
                        <div class="w-full h-full">
                            <iframe src="{{ $menu->PowerBILink }}" class="w-full h-[70vh] rounded-lg" frameborder="0" allowFullScreen></iframe>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>





    <!-- Load Lucide Icons -->
    <script>
        lucide.createIcons();
    </script>

</body>

</html>

