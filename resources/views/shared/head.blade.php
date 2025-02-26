<meta charset=UTF-8>
<meta content="width=device-width, initial-scale=1.0" name="viewport">

<title>Dashboard - PT Cipta Kridatama @yield('title')</title>
<meta content="" name="description">
<meta content="" name="keywords">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->

<!-- Favicons -->
<link href="{{ URL::asset('img/favicon.png') }}" rel="icon">
<link href="{{ URL::asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon">

<!-- Google Fonts -->
<link href="https://fonts.gstatic.com" rel="preconnect">
<link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

<!-- Vendor CSS Files -->
<!-- <script src="{{ URL::asset('vendor/tinymce/tinymce.min.js') }}"></script> -->

<link href="{{ URL::asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ URL::asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
<link href="{{ URL::asset('vendor/quill/quill.bubble.css') }}" rel="stylesheet">
<link href="{{ URL::asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet">
<link href="{{ URL::asset('vendor/simple-datatables/style.css') }}" rel="stylesheet">
<!-- Template Main CSS File -->
<link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">
<!-- <link href="{{ URL::asset('css/dark-mode.css') }}" rel="stylesheet"> -->

<script rel="javascript" src="{{ URL::asset('js/jquery-3.5.1.min.js') }}"></script>

<!-- sweetalert2 -->
<link href="{{ URL::asset('vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
<script rel="javascript" src="{{ URL::asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>

<script rel="text/javascript" src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script rel="text/javascript" src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script rel="text/javascript" src="{{ URL::asset('js/datatable/dataTables.responsive.js') }}"></script>
<script rel="text/javascript" src="{{ URL::asset('js/datatable/dataTables.rowReorder.js') }}"></script>
<script rel="text/javascript" src="{{ URL::asset('js/datatable/responsive.dataTables.js') }}"></script>
<script rel="text/javascript" src="{{ URL::asset('js/datatable/rowReorder.dataTables.js') }}"></script>
