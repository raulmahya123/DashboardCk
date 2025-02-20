<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .bg-login {
            background: url('{{ asset('assets/login/login.png') }}') no-repeat center center/cover;
        }
    </style>
</head>
<body class="bg-login flex items-center justify-end min-h-screen p-10">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md relative">
        <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-white rounded-full shadow-lg p-2">
            <img src="{{ asset('assets/login/logo.png') }}" alt="Logo" class="h-16">
        </div>

        <div class="text-center mt-12">
            <h2 class="text-2xl font-bold text-gray-700">Tender System</h2>
            <p class="text-gray-500">Login ke Akun Anda</p>
        </div>

        <form id="loginForm" class="mt-6">
            @csrf

            <!-- User ID -->
            <div>
                <label for="userId" class="block text-gray-700 font-medium">User ID</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">&#128100;</span>
                    <input id="userId" type="text" name="userId" required class="block w-full pl-10 pr-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="block text-gray-700 font-medium">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">&#128274;</span>
                    <input id="password" type="password" name="password" required class="block w-full pl-10 pr-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Login Button -->
            <div class="mt-6">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg flex items-center justify-center">
                    &#128274; Login
                </button>
            </div>
        </form>

        <div class="text-center text-sm text-gray-500 mt-6">
            &copy; 2025 PT. Cipta Kridatama <br> All rights reserved.
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#loginForm").submit(function (event) {
                event.preventDefault(); // Mencegah reload halaman

                $.ajax({
                    url: "{{ route('login.process') }}",
                    type: "POST",
                    data: {
                        userId: $("#userId").val(),
                        password: $("#password").val(),
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
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
                    error: function (xhr) {
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
