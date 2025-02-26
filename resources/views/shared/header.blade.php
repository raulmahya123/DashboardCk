<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ URL::asset('/css/header.css') }}">
</head>

<body>

    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center position-relative">
            <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center text-decoration-none">
                <img src="{{ URL::asset('/img/logo-ck.png') }}" alt="">
                <span class="d-none d-lg-block px-2">Dashboard</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn" id="menuToggle"></i>
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown  pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown" style="background-color: #dfe8f6;">
                        <img src="{{ URL::asset('/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle"
                            width="35">
                        <span class="d-none d-md-block dropdown-toggle ps-2">
                            {{ Str::of(Session::get('userid'))->limit(10) }}
                        </span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        @if (session()->has('user_details') && is_array(session('user_details')))
                            @foreach (session('user_details') as $index => $group)
                                @if ($index === 3 && is_array($group))
                                    @foreach ($group as $data)
                                        @if (is_array($data) && isset($data['CompleteUserName']))
                                            <li class="dropdown-header text-center">
                                                <h6 class="fw-bold mb-0">{{ $data['CompleteUserName'] }}</h6>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @else
                            <li class="dropdown-header text-center text-danger">No CompleteUserName found.</li>
                        @endif

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form id="logout-form"  action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn w-100 text-start d-flex align-items-center text-white py-2 px-4 logout-btn bg-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <script src="{{ URL::asset('/js/header.js') }}"></script>

</body>

</html>
