$('#btn_show_table').click(function () {
    // alert('test');
    $("#fileInput").val(null);

});

$('.panel-collapse').on('show.bs.collapse', function () {
    $(this).siblings('.panel-heading').addClass('active');
});

$('.panel-collapse').on('hide.bs.collapse', function () {
    $(this).siblings('.panel-heading').removeClass('active');
});

$("#formupload").on('submit', function (e) {
    date_upload = new Date();
    dateString_upload = date_upload.toLocaleString("en-us");

    d_upload = new Date();
    n_upload = d_upload.getMilliseconds();

    $('#v_id_upload').val(format(new Date(dateString_upload), 'yyyyMMddhhmmss') + n_upload);

    $('#btn_upload_csv').prop('disabled', true);
    var formdata = new FormData(this);
    var v_url = baseURL + "reporting/uploadrawdata/upload_xlsx_files/";

    $('#succes_notif').empty();
    $('#failed_notif').empty();

    $.ajax({
        type: "POST",
        url: v_url,
        data: formdata,
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', progress, false);
            }
            return myXhr;
        },
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $('#btn_upload_csv').prop('disabled', false);
            var obj = JSON.parse(data);
            for (var i = 0; i < obj.success_get.length; i++) {
                $('#succes_notif').append("<li>" + obj.success_get[i] + "</li>");
            }
            for (var i = 0; i < obj.failed_get.length; i++) {
                $('#failed_notif').append("<li>" + obj.failed_get[i] + "</li>");
            }
            // $("#btn_show_table").trigger("click");
            $("#fileInput").val(null);
            $('#dt_history_upload').DataTable().ajax.reload();
            $('#dt_history_ppob').DataTable().ajax.reload();
            $('#dt_history_setor_tarik').DataTable().ajax.reload();
            $('#dt_history_transfer').DataTable().ajax.reload();
        }
    })

    e.preventDefault();
    $("#alert_upload").show();

});

function progress(e) {
    if (e.lengthComputable) {
        var max = e.total;
        var current = e.loaded;
        var percentage = (current * 100) / max;

        $(".progress-bar").css('width', percentage + '%').attr('aria-valuenow', percentage);
        $("#v_progress").html(percentage.toFixed(0) + '%');
    }
}

$(document).ready(function () {

    $('#v_id_upload').val("-");
    $("#alert_upload").hide();

    var url;
    url = baseURL + "reporting/uploadrawdata/get_data_transaksi_deposit";

    $('#dt_history_upload').DataTable({
        iDisplayLength: 50,
        processing: true,
        searching: true,
        "order": [[1, "desc"]],
        ajax: {
            url: url,
            type: 'GET'
        },
        language: {
            "processing": '<div class="loader"><div class="m-t-30"><img class="zmdi-hc-spin" src="' + baseURL + 'assets/images/loader.svg" width="48" height="48" alt="Aero"></div><p>Processing...</p></div>'

        },
    });

    var url_ppob;
    url_ppob = baseURL + "reporting/uploadrawdata/get_data_transaksi_ppob";

    $('#dt_history_ppob').DataTable({
        iDisplayLength: 50,
        processing: true,
        searching: true,
        "order": [[1, "desc"]],
        ajax: {
            url: url_ppob,
            type: 'GET'
        },
        language: {
            "processing": '<div class="loader"><div class="m-t-30"><img class="zmdi-hc-spin" src="' + baseURL + 'assets/images/loader.svg" width="48" height="48" alt="Aero"></div><p>Processing...</p></div>'

        },
    });

    var url_setor_tarik;
    url_setor_tarik = baseURL + "reporting/uploadrawdata/get_data_transaksi_setor_tarik";

    $('#dt_history_setor_tarik').DataTable({
        iDisplayLength: 50,
        processing: true,
        searching: true,
        "order": [[1, "desc"]],
        ajax: {
            url: url_setor_tarik,
            type: 'GET'
        },
        language: {
            "processing": '<div class="loader"><div class="m-t-30"><img class="zmdi-hc-spin" src="' + baseURL + 'assets/images/loader.svg" width="48" height="48" alt="Aero"></div><p>Processing...</p></div>'

        },
    });

    var url_transfer;
    url_transfer = baseURL + "reporting/uploadrawdata/get_data_transaksi_transfer";

    $('#dt_history_transfer').DataTable({
        iDisplayLength: 50,
        processing: true,
        searching: true,
        "order": [[1, "desc"]],
        ajax: {
            url: url_transfer,
            type: 'GET'
        },
        language: {
            "processing": '<div class="loader"><div class="m-t-30"><img class="zmdi-hc-spin" src="' + baseURL + 'assets/images/loader.svg" width="48" height="48" alt="Aero"></div><p>Processing...</p></div>'

        },
    });






});