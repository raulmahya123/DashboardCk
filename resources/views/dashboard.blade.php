<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex h-screen">

    <!-- Sidebar -->
    <div class="w-64 bg-gray-900 text-white p-6 space-y-6">
        <h2 class="text-xl font-bold">Dashboard</h2>
        <nav>
            <a href="#" class="block py-2 px-4 rounded-lg hover:bg-gray-700">🏠 Home</a>
            <a href="#" class="block py-2 px-4 rounded-lg hover:bg-gray-700">📊 Analytics</a>
            <a href="#" class="block py-2 px-4 rounded-lg hover:bg-gray-700">⚙️ Settings</a>
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
    <div class="flex-1 p-6">
        <h1 class="text-2xl font-bold">Selamat Datang di Dashboard</h1>
        <p class="mt-4">Login Result: {{ session('login_result') }}</p>
        <p>Message: {{ session('login_message') }}</p>
    </div>

</body>
</html>
