<style>
.unstyled-button {
    border: none;
    padding: 0;
    background: none;
}
</style>
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
            <img src="{{ URL::asset('/img/logo-ck.png') }}" alt="">
            <span class="d-none d-lg-block px-2"> Tender</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">


            <li class="nav-item dropdown" style="display:none;">

                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown"
                        style="background-color: #dfe8f6;">
                        <img src="{{ URL::asset('/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle" width="35">
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

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="form_logout">
                                @csrf
                                <button type="submit" class="btn w-100 text-start d-flex align-items-center text-black py-2 px-4 logout-btn">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>

                <style>
                .logout-btn {
                    background: none;
                    border: none;
                    font-size: 16px;
                    transition: background-color 0.3s, color 0.3s;
                    width: 100%;
                    text-align: left;
                }

                .logout-btn:hover {
                    background-color: #133E87;
                    color: white;
                    border-radius: 5px;
                }
                </style>

                <script>
                $(document).ready(function() {
                    $("#form_logout").submit(function(e) {
                        e.preventDefault();
                        var form = $(this);
                        var actionUrl = form.attr('action');

                        Swal.fire({
                            title: 'Are You Sure?',
                            text: 'Do you want to logout from your account?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, Logout',
                            cancelButtonText: 'Cancel',
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: actionUrl,
                                    method: "POST",
                                    data: new FormData(form[0]),
                                    dataType: "json",
                                    processData: false,
                                    contentType: false,
                                    headers: {
                                        "Accept": "application/json",
                                        "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
                                    },
                                    beforeSend: function() {
                                        Swal.fire({
                                            title: 'Logging out...',
                                            html: 'Please wait a moment',
                                            allowOutsideClick: false,
                                            didOpen: () => {
                                                Swal.showLoading();
                                            }
                                        });
                                    },
                                    success: function() {
                                        window.location.href = '/auth';
                                    },
                                    error: function() {
                                        Swal.fire("Error!", "Failed to logout. Please try again.", "error");
                                    }
                                });
                            }
                        });
                    });
                });
                </script>

        </ul>
    </nav><!-- End Icons Navigation -->

</header>

<script>
$("#form_logout").submit(function(e) {

    e.preventDefault();
    var form = $(this);
    var actionUrl = form.attr('action');

    Swal.fire({
        title: 'Are You Sure!',
        text: 'Do you want to logout account',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Okey',
        cancelButtonText: 'No, cancel!'
    }).then((result) => {
        if (result.isConfirmed) {
            $(".loading-state").show();
            $.ajax({
                url: actionUrl,
                method: "POST",
                // data: form.serialize(),
                data: new FormData(this),
                dataType: "json",
                contentType: "multipart/form-data",
                processData: false,
                contentType: false,
                headers: {
                    "Accept": "application/json"
                },
                beforeSend: function(xhr, type) {
                    if (!type.crossDomain) {
                        xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]')
                            .attr('content'));
                    }
                },
                success: function() {
                    // console.log(response);
                    // swal.fire("Done!", "It was succesfully saved!", "success").then(
                    //     function() {
                    // location.reload();
                    window.location.href = '/auth';
                    // });
                },
                // error: function(xhr, ajaxOptions, thrownError) {
                //     // swal.fire("Error saving!", xhr.responseJSON.message, "error");
                //     // console.log(xhr.responseJSON.message)
                //     // console.log(ajaxOptions)
                //     // console.log(thrownError)
                // },
                complete: function() {
                    //Hide the loader over here
                    $('.loading-state').hide();
                }
            });
            // } else {
            // swal.fire("Warning!", "You Don't logout!", "warning");
        }
    });
    // alert('tes');
});
</script>
