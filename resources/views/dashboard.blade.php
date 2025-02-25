<?php
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    @include('shared.head')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        .breadcrumb-custom {
            border: 1px solid #fff;
            padding: 12px;
            border-radius: 3px;
            background-color: #fff;
        }
        /* Pastikan iframe mengambil full height */
        .iframe-container {
            width: 100%;
            height: 100vh; /* Full height dari viewport */
            display: flex;
            justify-content: center;
            align-items: center;
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>

<body x-data="{ selectedMenu: '' }">
    <!-- Header -->
    @include('shared.header')

    <!-- Sidebar -->
    @include('shared.sidebar')

    <main id="main" class="main">
        <!-- Dashboard Content -->
        <main class="p-0 m-0 w-full h-screen flex flex-col items-center justify-center"
            :class="open ? 'ml-64' : 'ml-0'">

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

    @if(session()->has('jsAlert'))
        <script>
            Swal.fire({
                title: "Success!",
                text: "{{ Session::get('jsAlert') }}",
                icon: "success"
            });
        </script>
    @endif
</body>

</html>
