<?php 
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    @include('shared.head')
</head>

<body>
    <!-- <div id="modalBackground"></div> -->
    <!-- ======= Header ======= -->
    @include('shared.header')
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    @include('shared.sidebar')
    <!-- End Sidebar-->

    <main id="main" class="main">

        <style>
        .breadcrumb-custom {
            border: 1px solid #fff;
            padding: 12px;
            border-radius: 3px;
            background-color: #fff;
        }

        /* HTML: <div class="loader"></div> */
        </style>
        <nav class="row d-flex justify-content-end" style="--bs-breadcrumb-divider: '•';">
            <ol class="breadcrumb breadcrumb-custom">
                @for($i = 2; $i <= count(Request::segments()); $i++) @if(Request::segment($i)=='upload' ) <li
                    class="breadcrumb-item">
                    <a href="{{ URL::to( implode( '/', array_slice(Request::segments(), 0 ,$i, true)))}}">
                        {{ strtoupper(Request::segment($i)) }}
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Document Information Tender</a></li>
                    @elseif(Request::segment($i)=='history')
                    <a href="{{ URL::to( implode( '/', array_slice(Request::segments(), 0 ,$i, true)))}}">
                        {{ strtoupper(Request::segment($i)) }}
                    </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">History Information Tender</a></li>

                    @endif
                    @endfor
                    @if(Request::segments()[0] == 'index' )
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to( implode( '/', array_slice(Request::segments(), 0 ,$i, true)))}}">
                            Information Tender
                        </a>
                    </li>
                    @endif
            </ol>
        </nav>
        <!-- End Page Title -->

        <!-- Content  -->
        <div class="loading-state" style="display: none">
            <div class="loading">
            </div>
        </div>
        @yield('content')
        <!-- End Content  -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    @include('shared.footer')
    <!-- End Footer -->
    @include('shared.js')
    @if(session()->has('jsAlert'))
    <script>
    // $('#modalBackground').modal('hide');
    Swal.fire({
        title: "Success!",
        text: "{{Session::get('jsAlert')}}",
        icon: "success"
    });
    </script>
    @endif
</body>

</html>