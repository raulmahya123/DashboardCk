var invited_id = $("input[name=invited_id]").val();
var userid = $("input[name=userid]").val();

function downloadFile(filecontenttype, filename, base64) {
    var a = document.createElement("a");
    a.href = "data:" + filecontenttype + ";base64," + base64;
    a.download = filename;
    a.click();
}

$("#download_file_pernyataan").on("click", function () {
    get_pernyataan();
});

function get_pernyataan() {
    var actionUrl =
        "/tender/get_data_download?_token=" +
        $("[name='csrf-token']")[0].content +
        "&type=9&value1=" +
        invited_id +
        "&value2=1&value3=" +
        userid +
        "&value4=3&value5=4&value6=5&value7=6&value8=7&startdate=2024-09-30&enddate=2024-09-30";
    $(".loading-state").show();
    $.ajax({
        url: actionUrl,
        method: "GET",
        dataType: "json",
        headers: {
            Accept: "application/json",
        },
        beforeSend: function (xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader(
                    "X-CSRF-Token",
                    $('meta[name="csrf-token"]').attr("content")
                );
            }
            $(".load-pernyataan").hide();
        },
        success: function (response) {
            // console.log(response["data"].length);

            // $("#download_file_pernyataan").show();
            const data = response["data"];
            for (let i = 0; i < data.length; ++i) {
                const base64 = data[i].DataBase64;
                const filecontenttype = data[i].FileContentType;
                const filename = data[i].FileName;
                $("#files_pernyataan").val(base64);
                $("#FCT_info").val(filecontenttype);
                $("#FN_info").val(filename);

                // $("#download_file_pernyataan").append(filename);
                // $("#download_file_pernyataan").on("click", function () {
                downloadFile(filecontenttype, filename, base64);
                // });
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            swal.fire("Error saving!", "Please Contact ICT", "error");
        },
        complete: function () {
            //Hide the loader over here
            $(".loading-state").hide();
        },
    });
}

$("#form_submit").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var actionUrl = form.attr("action");

    Swal.fire({
        title: "Are You Sure!",
        text: "Do you want to continue submit dokumen",
        text: "Document not editable after submit document",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Okey",
        cancelButtonText: "No, cancel!",
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
                    Accept: "application/json",
                },
                beforeSend: function (xhr, type) {
                    if (!type.crossDomain) {
                        xhr.setRequestHeader(
                            "X-CSRF-Token",
                            $('meta[name="csrf-token"]').attr("content")
                        );
                    }
                },
                success: function () {
                    // console.log(response);
                    swal.fire(
                        "Done!",
                        "It was succesfully saved!",
                        "success"
                    ).then(function () {
                        location.reload();
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    swal.fire("Error saving!", "Please Contact ICT", "error");
                },
                complete: function () {
                    //Hide the loader over here
                    $(".loading-state").hide();
                },
            });
        }
    });
});

$("#form_pernyataan").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var actionUrl = form.attr("action");

    Swal.fire({
        title: "Are You Sure!",
        text: "Do you want to continue",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Okey",
        cancelButtonText: "No, cancel!",
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
                    Accept: "application/json",
                },
                beforeSend: function (xhr, type) {
                    if (!type.crossDomain) {
                        xhr.setRequestHeader(
                            "X-CSRF-Token",
                            $('meta[name="csrf-token"]').attr("content")
                        );
                    }
                },
                success: function (response) {
                    // console.log(response);
                    swal.fire(
                        "Done!",
                        "It was succesfully saved!",
                        "success"
                    ).then(function () {
                        // location.reload();
                        window.location = "/tender/upload/" + response.id + "";
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    swal.fire("Error saving!", "Please Contact ICT", "error");
                },
                complete: function () {
                    //Hide the loader over here
                    $(".loading-state").hide();
                },
            });
        }
    });
    // alert('tes');
});

$("#form_penawaran").submit(function (e) {
    e.preventDefault();
    var form = $(this);
    var actionUrl = form.attr("action");

    Swal.fire({
        title: "Are You Sure!",
        text: "Do you want to continue submit penawatan",
        text: "Document not editable after submit penawaran",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Okey",
        cancelButtonText: "No, cancel!",
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
                    Accept: "application/json",
                },
                beforeSend: function (xhr, type) {
                    if (!type.crossDomain) {
                        xhr.setRequestHeader(
                            "X-CSRF-Token",
                            $('meta[name="csrf-token"]').attr("content")
                        );
                    }
                },
                success: function (response) {
                    console.log(response);
                    // var a = swal.fire("Done!", "It was succesfully saved!", "success");
                    // setInterval(function() {
                    //     if (a.closed) {
                    //         window.location.reload();
                    //     }
                    // }, 1500);
                    swal.fire(
                        "Done!",
                        "It was succesfully saved!",
                        "success"
                    ).then(function () {
                        // location.reload();
                        window.location = "/tender/upload/" + response.id + "";
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    swal.fire("Error saving!", "Please Contact ICT", "error");
                },
                complete: function () {
                    //Hide the loader over here
                    $(".loading-state").hide();
                },
            });
        }
    });
});
