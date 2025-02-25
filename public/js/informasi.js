$(".dowload_information_tender").on("click", function () {
    var filesid = $(this).attr("data-fileid");
    console.log(filesid);
    get_information(filesid);
});
// $("#download_file_information").on("click", function () {

//     get_information();
// });

function downloadFile(filecontenttype, filename, base64) {
    var a = document.createElement("a");
    a.href = "data:" + filecontenttype + ";base64," + base64;
    a.download = filename;
    a.textContent = filename;
    a.click();
}

function get_information(filesid) {
    var invited_id = $("#invited_id").val();
    var docsid = $("#docsid").val();
    var userid = $("#username").val();
    var actionUrl =
        "/tender/get_data_download?_token=" +
        $("[name='csrf-token']")[0].content +
        "&type=15&value1=" +
        docsid +
        "&value2=RFQCEV&value3=1&value4=" +
        filesid +
        "&value5=4&value6=5&value7=6&value8=7&startdate=2024-09-30&enddate=2024-09-30";
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
        },
        success: function (response) {
            // console.log(response["data"].length);
            // $(".load-information").hide();
            // $("#download_file_information").show();
            const data = response["data"];
            for (let i = 0; i < data.length; ++i) {
                const base64 = data[i].DataBase64;
                const filecontenttype = data[i].FileContentType;
                const filename = data[i].FileName;
                $("#file_information").val(base64);
                $("#FCT_info").val(filecontenttype);
                $("#FN_info").val(filename);

                downloadFile(filecontenttype, filename, base64);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            swal.fire("Error saving!", "Please try again", "error");
        },
        complete: function () {
            //Hide the loader over here
            $(".loading-state").hide();
        },
    });
}
// function get_information() {
//     var invited_id = $("#invited_id").val();
//     var userid = $("#username").val();
//     var actionUrl =
//         "/tender/get_data_download?_token=" +
//         $("[name='csrf-token']")[0].content +
//         "&type=8&value1=" +
//         invited_id +
//         "&value2=1&value3=" +
//         userid +
//         "&value4=3&value5=4&value6=5&value7=6&value8=7&startdate=2024-09-30&enddate=2024-09-30";
//     $(".loading-state").show();
//     $.ajax({
//         url: actionUrl,
//         method: "GET",
//         dataType: "json",
//         headers: {
//             Accept: "application/json",
//         },
//         beforeSend: function (xhr, type) {
//             if (!type.crossDomain) {
//                 xhr.setRequestHeader(
//                     "X-CSRF-Token",
//                     $('meta[name="csrf-token"]').attr("content")
//                 );
//             }
//         },
//         success: function (response) {
//             // console.log(response["data"].length);
//             // $(".load-information").hide();
//             // $("#download_file_information").show();
//             const data = response["data"];
//             for (let i = 0; i < data.length; ++i) {
//                 const base64 = data[i].DataBase64;
//                 const filecontenttype = data[i].FileContentType;
//                 const filename = data[i].FileName;
//                 $("#file_information").val(base64);
//                 $("#FCT_info").val(filecontenttype);
//                 $("#FN_info").val(filename);

//                 downloadFile(filecontenttype, filename, base64);
//             }
//         },
//         error: function (xhr, ajaxOptions, thrownError) {
//             swal.fire("Error saving!", "Please try again", "error");
//         },
//         complete: function () {
//             //Hide the loader over here
//             $(".loading-state").hide();
//         },
//     });
// }
