<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System</title>

    <!-- Tambahkan FontAwesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .bg-login {
            background: url('{{ asset('assets/login/login.png') }}') no-repeat center center;
            background-size: contain;
            /* Menampilkan seluruh gambar tanpa terpotong */
            background-attachment: fixed;
            /* Agar tidak ikut scroll (opsional) */
        }
    </style>
</head>

<body class="bg-login flex items-center justify-end min-h-screen p-10">

    <div class="bg-white py-10 px-8 rounded-tr-[32px] rounded-bl-[32px] shadow-lg w-[400px] min-h-[700px] relative">
        <!-- Logo -->
        <div
            class="absolute -top-14 left-1/2 transform -translate-x-1/2 bg-[#E8EEF5] rounded-xl shadow-md p-5 w-32 text-center">
            <img src="{{ asset('assets/login/logo-ck.png') }}" alt="Logo" class="h-14 mx-auto">
        </div>


        <!-- Title -->
        <div class="text-center mt-20">
            <h2 class="text-3xl font-bold text-[#183A77]">Dashboard PT.Cipta Kridatama</h2>
            <p class="text-gray-600">Login akun kamu!</p>
        </div>

        <!-- Form -->
        <form id="loginForm" class="mt-10">
            @csrf

            <!-- Username -->
            <div class="mb-6">
                <label for="userId" class="block text-gray-700 font-medium">Username</label>
                <div class="relative">
                    <span
                        class="absolute inset-y-0 left-0 flex items-center px-3 text-gray-500 border-r border-gray-300">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input id="userId" type="text" name="userId" required
                        class="block w-full pl-12 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>


            </div>

            <!-- Password -->
            <div class="mb-8">
                <label for="password" class="block text-gray-700 font-medium">Password</label>
                <div class="relative mt-1">
                    <span
                        class="absolute inset-y-0 left-0 flex items-center px-3 text-gray-500 border-r border-gray-300">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input id="password" type="password" name="password" required
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Login Button -->
            <div class="mt-6">
                <button type="submit"
                    class="w-full bg-[#C7D6EE] hover:bg-sky-700 text-black hover:text-[#ffffff] font-bold py-4 rounded-lg flex items-center justify-center gap-2 ">
                    <i class="fas fa-sign-in-alt text-2xl"></i> Login
                </button>
            </div>
        </form>

        <!-- Footer -->
        <div class="text-center text-sm text-gray-500 mt-10">
            &copy; 2025 PT. Cipta Kridatama <br> All rights reserved.
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#loginForm").submit(function(event) {
                event.preventDefault(); // Mencegah reload halaman

                $.ajax({
                    url: "{{ route('login.process') }}",
                    type: "POST",
                    data: {
                        userId: $("#userId").val(),
                        password: $("#password").val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Login Berhasil!",
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = response.redirect;
                        });
                    },
                    error: function(xhr) {
                        let errorMessage = xhr.responseJSON?.message || "Login Gagal!";
                        Swal.fire({
                            icon: "error",
                            title: "Login Gagal",
                            text: errorMessage,
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>
