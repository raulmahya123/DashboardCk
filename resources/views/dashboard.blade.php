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
            height: 100vh;
            /* Full height dari viewport */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .main {
            padding-top: 20px;
            /* Sesuaikan angka sesuai kebutuhan */
        }

        .iframe-container {
            margin-top: 50px;
            /* Sesuaikan jika perlu lebih turun */
        }

        @media (max-width: 768px) {

            /* Untuk HP atau tablet kecil */
            .iframe-container {
                height: 80vh;
                /* Kurangi tinggi agar tidak terlalu ke atas */
                margin-top: 80px;
                /* Tambahkan margin agar lebih turun */
            }

            .main {
                padding-top: 50px;
                /* Tambahkan padding agar lebih turun */
            }
        }

        @media (min-width: 769px) and (max-width: 1440px) {

            /* Untuk MacBook Air */
            .iframe-container {
                height: 85vh;
                /* Kurangi tinggi agar tidak terlalu ke atas */
                margin-top: 90px;
                /* Sesuaikan agar lebih turun */
            }

            .main {
                padding-top: 50px;
                /* Sesuaikan agar lebih turun */
            }
        }

        @media (min-width: 1441px) {

            /* Untuk laptop besar atau layar lebih lebar */
            .iframe-container {
                height: 90vh;
                /* Pastikan iframe besar */
                margin-top: 60px;
                /* Sesuaikan posisi turun */
            }

            .main {
                padding-top: 30px;
            }
        }

        @media (max-width: 1559px) {
            /* Untuk MacBook 1559 x 975 */
            .iframe-container {
                height: 110vh;
                /* Sesuaikan tinggi */
                margin-top: 150px;
                /* Tambahkan margin agar lebih turun */
            }

            .main {
                padding-top: 160px;
                /* Tambahkan padding agar lebih turun */
            }
        }
    </style>
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

    @if (session()->has('jsAlert'))
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
