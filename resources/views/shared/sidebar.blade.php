<style>
    .custom-divider {
    border: 4px solid rgb(6, 91, 131); /* Ubah ketebalan garis */
    margin: 10px 0; /* Jarak atas dan bawah */
    width: 100%; /* Pastikan lebar penuh */
}
.sidebar-nav .nav-link {
    font-size: 20px; /* Perbesar font */
    font-weight: bold; /* Tambahkan ketebalan */
}

.sidebar-nav .nav-heading {
    font-size: 20px; /* Perbesar teks pada heading */
    font-weight: bold;
}

</style>
<aside id="sidebar" class="sidebar mt-5">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>MENU</span>
            </a>
        </li>

        <li class="nav-heading">
            <hr class="custom-divider">
        </li>


        @foreach ($menus as $menu)
            @if ($menu->ParentRoleLineID === null)
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#menu-{{ $menu->RoleLineID }}" data-bs-toggle="collapse" href="#">
                        <span class="fw-bold">{{ $menu->FormDescription }}</span>
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="menu-{{ $menu->RoleLineID }}" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                        @foreach ($menus as $submenu)
                            @if ($submenu->ParentRoleLineID === $menu->RoleLineID)
                                <li class="nav-item">
                                    <a class="nav-link collapsed d-flex justify-content-between align-items-center"
                                        data-bs-target="#submenu-{{ $submenu->RoleLineID }}"
                                        data-bs-toggle="collapse"
                                        href="#">
                                        <span class="fw-bold">{{ $submenu->FormDescription }}</span>
                                        <i class="bi bi-chevron-down"></i>
                                    </a>
                                    <ul id="submenu-{{ $submenu->RoleLineID }}" class="nav-content collapse">
                                        @foreach ($menus as $subsubmenu)
                                            @if ($subsubmenu->ParentRoleLineID === $submenu->RoleLineID && !empty($subsubmenu->PowerBILink))
                                                <li class="nav-item">
                                                    <a href="#" class="d-flex align-items-center"
                                                        @click="selectedMenu = '{{ $subsubmenu->PowerBILink }}'">
                                                        <i class="bi bi-bar-chart me-2"></i>
                                                        <span>DASHBOARD BI</span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endif
        @endforeach
    </ul>
</aside>
