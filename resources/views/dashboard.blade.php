<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="h-screen flex flex-col bg-cover bg-center"
    style="background-image: url('{{ asset('assets/login/bg.png') }}');">
    <div class="flex h-screen" x-data="{ open: false }">
        <!-- Sidebar -->
        <aside class="bg-[#DFE8F6] text-black w-64 h-screen py-7 px-2 space-y-6 overflow-y-auto md:block hover:text-blue-500"
            :class="{'hidden': !open && window.innerWidth < 768}">
            {{-- <h1 class="text-2xl font-semibold text-center text-[#133E87]">TENDER</h1> --}}
            <div class="flex justify-center">
                <img src="{{ asset('assets/login/logo-ck.png') }}" alt="logo" class="text-2xl font-semibold text-center text-[#133E87]">
            </div>


            <nav>
                @foreach ($menus as $menu)
                    @php
                        $hasURL = !empty($menu->FormURLAddress);
                        $hasPowerBILink = !empty($menu->PowerBILink);
                    @endphp

                    @if ($hasPowerBILink)
                    <div class="flex items-center text-[#133E87] font-semibold py-2 px-4 bg-white border border-gray-300 rounded shadow-md hover:bg-gray-100 hover:text-blue-500 cursor-pointer">
                        <i data-lucide="bar-chart-2" class="mr-2"></i> DASHBOARD BI
                    </div>
                    @elseif ($hasURL)
                        <a href="{{ $menu->FormURLAddress }}" class="flex items-center text-black font-semibold py-2 px-4 border border-white rounded hover:bg-white hover:text-blue-500 hover:shadow-lg transition duration-300">
                            <i data-lucide="link" class="mr-2"></i> {{ $menu->FormDescription }}
                        </a>
                    @elseif ($menu->ParentRoleLineID === null)
                        <div x-data="{ open: false }">
                            <button @click="open = !open" class="flex justify-between items-center w-full text-left text-black font-semibold py-2 px-4 bg-white border border-gray-300 hover:bg-gray-100 hover:text-blue-500 rounded shadow-md">
                                <div class="flex items-center">
                                    @if (!empty($menu->IconFileName))
                                        <img src="{{ asset($menu->IconFileName) }}" class="w-6 h-6 mr-2">
                                    @endif
                                    {{ $menu->FormDescription }}
                                </div>
                                <i :class="open ? 'rotate-180' : ''" data-lucide="chevron-down"></i>
                            </button>
                            <div x-show="open" x-cloak class="ml-4 max-h-[300px] overflow-y-auto rounded-lg hover:text-blue-500">
                                @foreach ($menus as $submenu)
                                    @if ($submenu->ParentRoleLineID === $menu->RoleLineID)
                                        <a href="{{ $submenu->FormURLAddress ?? '#' }}" class="flex  items-center py-2 px-4 rounded-lg hover:bg-[#FFFFFF]">
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
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            <header class="bg-white shadow flex justify-between items-center p-4">
                <div class="flex items-center gap-4">
                    <!-- Tombol Menu (Mobile) -->
                    <button @click="open = !open" class="text-gray-700 focus:outline-none md:hidden">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>

                    <!-- Logo -->
                </div>

                <!-- Dropdown Profile -->
                <div x-data="{ openDropdown: false }" class="relative">
                    <button @click="openDropdown = !openDropdown" class="flex items-center space-x-2 focus:outline-none">
                        <i data-lucide="user" class="w-6 h-6 text-black"></i>
                    </button>
                    <div x-show="openDropdown" @click.away="openDropdown = false" class="absolute right-0 mt-2 w-48 bg-[#DFE8F6] rounded-md shadow-lg border p-2">
                        @if (session()->has('user_details') && is_array(session('user_details')))
                            @foreach (session('user_details') as $index => $group)
                                @if ($index === 3 && is_array($group))
                                    @foreach ($group as $data)
                                        @if (is_array($data) && isset($data['CompleteUserName']))
                                            <div class="p-2 text-black font-semibold">
                                                {{ $data['CompleteUserName'] }}
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @else
                            <div class="p-2 text-red-500">
                                No CompleteUserName found.
                            </div>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button type="submit" class="flex items-center w-full text-left text-black py-2 px-4 hover:bg-[#133E87] hover:text-white rounded">
                                <i data-lucide="log-out" class="w-6 h-6 mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="p-6 flex justify-center items-start h-screen w-full">
                @foreach ($menus as $menu)
                    @if (!empty($menu->PowerBILink))
                        <div class="bg-white shadow-lg rounded-lg w-full h-[88vh] flex flex-col">
                            <div class="p-4 border-b">
                                <h3 class="text-lg font-semibold flex items-center">
                                    <i data-lucide="bar-chart-2" class="mr-2"></i> Dashboard BI
                                </h3>
                            </div>
                            <iframe src="{{ $menu->PowerBILink }}" class="w-full h-[70vh] flex-grow rounded-lg" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @endif
                @endforeach
            </main>


        </div>
    </div>




    <script>
        $(document).ready(function() {
            lucide.createIcons();
            $('#dropdownButton').click(function() {
                $('#dropdownMenu').toggle();
            });
            $('form[action="{{ route('logout') }}"]').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are You Sure?',
                    text: 'Do you want to logout from your account?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Logout',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
       <!-- Load Alpine.js -->
       <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js" defer></script>
       <!-- Load Alpine.js -->
       <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js" defer></script>


</body>
</html>
