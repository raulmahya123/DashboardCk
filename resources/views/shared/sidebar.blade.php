<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <!-- End Dashboard Nav -->
        <li class="nav-heading text-white">Pages</li>
        <li class="nav-item dropdown">
        </li>
        <li class="nav-item dropdown">
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components2-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>History</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components2-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                {{-- @foreach ($data['result_sidebar2'] as $row)
                <li>
                    <a href="{{ url('tender/history/'. Crypt::encrypt($row->InvitedID .'&type=history')  ) }}">
                        <i class="bi bi-circle"></i><span class="text-white">{{ $row->TenderTitle }}</span>
                    </a>
                </li>
                @endforeach --}}
            </ul>
        </li><!-- End Components Nav -->

    </ul>

</aside>
