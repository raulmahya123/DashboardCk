<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-heading text-white">Pages</li>
        @foreach ($menus as $menu)
            @php
                $hasURL = !empty($menu->FormURLAddress);
                $hasPowerBILink = !empty($menu->PowerBILink);
            @endphp
            @if ($hasPowerBILink)
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" @click="selectedMenu = '{{ $menu->PowerBILink }}'">
                    <i class="bi bi-bar-chart"></i><span>DASHBOARD BI</span>
                </a>
            </li>
            @elseif ($hasURL)
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ $menu->FormURLAddress }}">
                    <i class="bi bi-link"></i><span>{{ $menu->FormDescription }}</span>
                </a>
            </li>
            @elseif ($menu->ParentRoleLineID === null)
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#menu-{{ $menu->RoleLineID }}" data-bs-toggle="collapse" href="#">
                    @if (!empty($menu->IconFileName))
                        <img src="{{ asset($menu->IconFileName) }}" class="w-6 h-6 mr-2">
                    @endif
                    <span>{{ $menu->FormDescription }}</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="menu-{{ $menu->RoleLineID }}" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    @foreach ($menus as $submenu)
                        @if ($submenu->ParentRoleLineID === $menu->RoleLineID)
                        <li>
                            <a href="{{ $submenu->FormURLAddress ?? '#' }}">
                                @if (!empty($submenu->IconFileName))
                                    <img src="{{ asset('icons/' . $submenu->IconFileName) }}" class="w-5 h-5 mr-2">
                                @endif
                                <span>{{ $submenu->FormDescription }}</span>
                            </a>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </li>
            @endif
        @endforeach
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components2-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>History</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components2-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            </ul>
        </li>
    </ul>
</aside>
