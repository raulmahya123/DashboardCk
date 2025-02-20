<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h2>Selamat Datang di Dashboard</h2>

    {{-- @if(session('user'))
        <p>User ID: {{ session('user')->UserID }}</p>
    @endif --}}

    <a href="{{ route('logout') }}">Logout</a>
</body>
</html>
