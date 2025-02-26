document.addEventListener('DOMContentLoaded', function () {
    if (sessionStorage.getItem('jsAlert')) {
        Swal.fire({
            title: "Success!",
            text: sessionStorage.getItem('jsAlert'),
            icon: "success"
        });
        sessionStorage.removeItem('jsAlert');
    }
});
