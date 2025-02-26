<?php
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    @include('shared.head')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body x-data="{ selectedMenu: '' }">
    <!-- Header -->
    @include('shared.header')

    <div class="d-flex">
        <!-- Sidebar -->
        @include('shared.sidebar')
    </div>

    <main id="main" class="main">
        <!-- Dashboard Content -->
        <main class="p-0 m-0 w-full h-screen flex flex-col items-center justify-center" :class="open ? 'ml-64' : 'ml-0'">

            <!-- Debugging Output -->

            <template x-if="selectedMenu">
                <div class="iframe-container">
                    <iframe :src="selectedMenu" allowfullscreen></iframe>
                </div>
            </template>
        </main>

        @yield('content')
    </main>

    <!-- Footer -->
    @include('shared.footer')

    @include('shared.js')

    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>

</html>
