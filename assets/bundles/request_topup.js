var gPrmFi = '';

function format() {
    return '<table border="1" width="100%" >' +
        '<tr style="background-color:#DCDCDC;color:black;">' +
        '<th style="width:50px;padding-left:10px;font-weight:bold" >File Name</th>' +
        '<th style="width:50px;padding-left:10px;font-weight:bold" >Size File</th>' +
        '<th style="width:50px;padding-left:10px;font-weight:bold" >Date Uploaded</th>' +
        '</tr>' +
        v_global_1 +
        '</table>';
}

$(function () {
    $('#queueing_topup').hide();
    $('#attached_topup_file').hide();

    var table_rcs_approved = $('#dt_app_rcs_package').DataTable({
        iDisplayLength: 100,
        paging: true,
        info: true,
        searching: true,
        columnDefs: [
            { targets: 'no-sort', orderable: false }
        ]
    });

    $('#dt_app_rcs_package tbody').on('click', 'td.details-control', function () {

        var tr = $(this).closest('tr');
        var row = table_rcs_approved.row(tr);
        v_global_1 = '';
        v_global_2 = '';

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {

            var v_request_no = $(this).attr("title");

            var data_post = $.param({ ajaxRequestNo: v_request_no });
            var v_url = baseURL + "postilion/ajaxcontroller/get_attachment_topup/";
            $.ajax({
                url: v_url,
                type: "POST",
                data: data_post,
                async: false,
                dataType: "JSON",
                success: function (result) {
                    $.each(result, function (i, item) {
                        $image_show = '<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 m-b-30"> <a href="' + baseURL + 'topup/' + item.file_name + '" target="_blank" > <img class="img-fluid img-thumbnail" src="' + baseURL + '/topup/' + item.file_name + '" alt=""> </a> </div>';
                        v_global_1 += '<tr><td>' + $image_show + '<br>' + item.file_name + '</td><td>' + item.size_file + '</td><td>' + item.date_uploaded + '</td></tr>';
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });

    var table_fee = $('#dt_app_package').DataTable({
        iDisplayLength: 100,
        paging: true,
        info: true,
        searching: true,
        columnDefs: [
            { targets: 'no-sort', orderable: false }
        ]
    });

    $('#dt_app_package tbody').on('click', 'td.details-control', function () {

        var tr = $(this).closest('tr');
        var row = table_fee.row(tr);
        var html = '';
        var arr_offline = [];
        var arr_inservice = [];
        var datetime_offline = '';
        var datetime_inservice = '';
        var value_duration = '';
        v_global_1 = '';
        v_global_2 = '';

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {

            var v_request_no = $(this).attr("title");
            //   var v_prefix = $(this).attr('data-prefix');     

            var data_post = $.param({ ajaxRequestNo: v_request_no });
            var v_url = baseURL + "postilion/ajaxcontroller/get_attachment_topup/";
            $.ajax({
                url: v_url,
                type: "POST",
                data: data_post,
                async: false,
                dataType: "JSON",
                success: function (result) {
                    $.each(result, function (i, item) {
                        $image_show = '<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 m-b-30"> <a href="' + baseURL + 'topup/' + item.file_name + '" target="_blank" > <img class="img-fluid img-thumbnail" src="' + baseURL + '/topup/' + item.file_name + '" alt=""> </a> </div>';
                        v_global_1 += '<tr><td>' + $image_show + '<br>' + item.file_name + '</td><td>' + item.size_file + '</td><td>' + item.date_uploaded + '</td></tr>';
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });

})
function approved_() {

    var url = baseURL + "accounts/profile/update_password";
    var $form = $('form_parameterize');

    sOldPassword = $("#txt_old_password").val();
    sNewPassword = $("#txt_new_password").val();
    sConfPassword = $("#txt_new_conf_password").val();

    var data = $form.serialize() + '&'
        + $.param({
            ajaxOldPassword: sOldPassword,
            ajaxNewPassword: sNewPassword,
            ajaxConfPassword: sConfPassword
        });

    $.ajax({
        url: url,
        type: "POST",
        data: data,
        dataType: "JSON",
        success: function (data) {
            // alert(data['status_field_old']);
            if (data['status_field_old'] != "") {
                $('#name-error-old-pass').css('display', 'block');
                $('#name-error-old-pass').html(data['status_field_old']);
            } else {
                $('#name-error-old-pass').css('display', 'none');
            }

            if (data['status_field_new'] != "") {
                $('#name-error-new-pass').css('display', 'block');
                $('#name-error-new-pass').html(data['status_field_new']);
            } else {
                $('#name-error-new-pass').css('display', 'none');
            }

            if (data['status_field_conf'] != "") {
                $('#name-error-conf-pass').css('display', 'block');
                $('#name-error-conf-pass').html(data['status_field_conf']);
            } else {
                $('#name-error-conf-pass').css('display', 'none');
            }

            // alert(data['status_field']);
            if (data['status_field'] == "success") {
                $('#modal_form_change_password').modal('hide');
                showSuccessMessageX();
                // location.reload();
            }
            // else{
            //     $('#modal_form_change_password').modal('hide');
            //     location.reload();
            // }

        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error adding / update data');
        }
    });
}

$('#dt_req_package').DataTable({
    // iDisplayLength: 5,
    paging: true,
    info: true,
    searching: true,
    ordering: true,
    columnDefs: [
        { width: '1%', targets: 0 }
    ],
    // scrollY:        "350px",
});

// $('#dt_app_package').DataTable({
//     // iDisplayLength: 5,
//     paging: true,
//     info: true,
//     searching: true,
//     ordering: true,
//     columnDefs: [
//         { width: '1%', targets: 0 }
//     ],
//     // scrollY:        "350px",
// });

// $('#dt_app_rcs_package').DataTable({
//     // iDisplayLength: 5,
//     paging: true,
//     info: true,
//     searching: true,
//     ordering: true,
//     columnDefs: [
//         { width: '1%', targets: 0 }
//     ],
//     // scrollY:        "350px",
// });

$('#dt_rej_package').DataTable({
    // iDisplayLength: 5,
    paging: true,
    info: true,
    searching: true,
    ordering: true,
    columnDefs: [
        { width: '1%', targets: 0 }
    ],
    // scrollY:        "350px",
});

$('#dt_rej_rcs_package').DataTable({
    // iDisplayLength: 5,
    paging: true,
    info: true,
    searching: true,
    ordering: true,
    columnDefs: [
        { width: '1%', targets: 0 }
    ],
    // scrollY:        "350px",
});

$('#dt_completed_package').DataTable({
    // iDisplayLength: 5,
    paging: true,
    info: true,
    searching: true,
    ordering: true,
    columnDefs: [
        { width: '1%', targets: 0 }
    ],
    // scrollY:        "350px",
});

function reject_req_topup(value_this, prm1, prm2) {
    gPrmFi = prm1;
    gPrm2 = prm2;
    value_this = "Are You Sure Want To Reject This Invoice : ";
    // $('#signupalert').css('display', 'none');

    $("#reject_req_no").val(prm1);
    $("#v_reject_user_fin").val(prm2);

    $('#modal_reject_invoice').modal('show');
    $('#confirm_reject_invoice').text(value_this + prm1); // Set Title to Bootstrap modal title
}

function approve_req_topup(value_this, prm1, prm2, prmCheck, firstApproved, user_req, date_req, package) {
    // var title=$(this).attr("value");
    //alert(value_this);

    if (prmCheck != "1") {
        value_this = "Please check request no ";
        $('#confirm_approve_check').text(value_this + firstApproved + " first");
        $('#modal_approve_check').modal('show');
        return;
    }


    $('#attached_topup_file').show();
    if (value_this == "RCS Approve") {
        $('#attached_topup_file').hide();
    }
    // else{
    //     $('#attached_topup_file').hide();
    // }
    gPrmFi = prm1;
    gPrm2 = prm2;
    value_this = "Are You Sure Want To Approve This Invoice : ";
    // $('#signupalert').css('display', 'none');
    $("#v_req_no").val(prm1);
    $("#v_user_fin").val(prm2);
    $("#v_user_req").val(user_req);
    $("#v_date_req").val(date_req);
    $("#v_package_user").val(package);
    //attached_topup_file
    $('#modal_approve_invoice').modal('show');
    $('#confirm_approve_invoice').text(value_this + prm1); // Set Title to Bootstrap modal title
}


function modal_req_package() {
    value_this = "Are You Sure Want To Request This Package ?";
    // $('#signupalert').css('display', 'none');
    $('#modal_req_package').modal('show');
    $('#confirm_req').text(value_this); // Set Title to Bootstrap modal title
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$('#submit_req_package').click(function () {
    $('#form_req_package').submit();
});

$('#sPackageCode').on('change', function () {
    //alert(this.value);
    var url = baseURL + "postilion/ajaxcontroller/get_data_package";
    var $form = $('form_parameterize');

    var data = $form.serialize() + '&'
        + $.param({
            ajaxId: this.value,
            // ajaxNewPassword: sNewPassword,
            // ajaxConfPassword: sConfPassword
        });

    $.ajax({
        url: url,
        type: "POST",
        data: data,
        dataType: "JSON",
        success: function (data) {
            //alert(data[0]['fi_number']);  
            $('#sPrice').html(numberWithCommas(data[0]['price']));
            $('#sLimit').html(numberWithCommas(data[0]['limit']));
            $('#sFee').html(numberWithCommas(data[0]['minimum_limit']));

            // $('input[name="txt_bank_code"]').val(data[0]['cbc']);
            // $('input[name="txt_fi_code"]').val(data[0]['fi_number']);
            // $('input[name="txt_entity"]').val(data[0]['business_entity_name']);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data');
        }
    });
});

function approved_topup() {
    // alert($("#v_user_fin").val());
    if ($("#v_user_fin").val().length > 0) {
        update_from_rcs();
    } else {
        // update_from_finance();
        update_from_finance();
    }

}

function update_from_finance() {
    var files = $('#files')[0].files;
    var error = '';
    var form_data = new FormData();
    for (var count = 0; count < files.length; count++) {
        var name = files[count].name;
        var extension = name.split('.').pop().toLowerCase();
        if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
            error += "Invalid " + count + " Image File"
        }
        else {
            form_data.append("files[]", files[count]);
        }
    }

    // var other_data = $('form_approve').serializeArray();
    // $.each(other_data, function (key, input) {
    //     form_data.append(input.name, input.value);
    // });

    form_data.append('sReqNo', $("#v_req_no").val());
    form_data.append('sPaymentDate', $("#payment_date_topup").val());

    // console.log(form_data);
    // return;

    if (error == '') {
        var url;
        url = baseURL + "postilion/ajaxcontroller/finance_upload_image";
        // alert(url);
        $.ajax({
            url: url, //base_url() return http://localhost/tutorial/codeigniter/
            method: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            // beforeSend: function () {
            //     $('#uploaded_images').html("<label class='text-success'>Uploading...</label>");
            // },
            // success: function (data) {
            //     $('#uploaded_images').html(data);
            //     $('#files').val('');
            // }
            success: function (data) {
                $('#modal_approve_invoice').modal('hide');
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data account');
            }
        })
    }
    else {
        alert(error);
    }
}

function update_from_finance_old() {

    var form_data = new FormData();
    var ins = document.getElementById('fileInputimage').files.length;
    for (var x = 0; x < ins; x++) {
        form_data.append("files[]", document.getElementById('image_file').files[x]);
    }
    // alert("fina");

    var url;
    // var $form = $('form_approve');
    url = baseURL + "postilion/ajaxcontroller/upload_image_files";
    // sReqNo = $("#v_req_no").val();
    // sFiles = $('#fileInputimage').prop('files')[0];
    // sPaymentDate = $("#payment_date_topup").val();
    // data = $form.serialize() + '&' + $.param({
    //     ajaxReqNo: sReqNo,
    //     // ajaxFiles : sFiles, 
    //     ajaxPaymentDate: sPaymentDate
    // });
    // datax:form_data,  
    alert(form_data);
    $.ajax({
        url: url,
        type: "POST",
        data: form_data,
        dataType: "JSON",
        success: function (data) {
            $('#modal_approve_invoice').modal('hide');
            location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error adding / update data account');
        }
    });
}

function update_from_rcs() {
    // alert("rcs");
    var form_data = new FormData();

    form_data.append('ajaxReqNo', $("#v_req_no").val());
    form_data.append('ajaxUserRequest', $("#v_user_req").val());
    form_data.append('ajaxDateReq', $("#v_date_req").val());
    form_data.append('ajaxPackage', $("#v_package_user").val());


    var url;
    // var $form = $('form_approve');
    url = baseURL + "postilion/ajaxcontroller/updated_by_rcs";
    // sReqNo = $("#v_req_no").val();
    // sUserReq = $("#v_user_req").val();
    // sDateReq = $("#v_date_req").val();
    // sPackage = $("#v_package_user").val();

    // sQueu  = $("#queu_topup").val();
    // data = $form.serialize() + '&' + $.param({
    //     ajaxReqNo: sReqNo,
    //     ajaxUserRequest: sUserReq,
    //     ajaxDateReq: sDateReq,
    //     ajaxPackage: sPackage,
    //     // ajaxQueu  : sQueu
    // });
    $.ajax({
        url: url,
        method: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (result) {
            // var obj = JSON.parse(data);
            // alert(obj.success_get[0]);
            // $.each(result, function (i, item) {
            //     alert (item.package_code);
            // });


            $('#modal_approve_invoice').modal('hide');
            location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error updating from rcs');
        }
    });
}


function rejected_topup() {
    // alert($("#v_user_fin").val());
    if ($("#v_reject_user_fin").val().length > 0) {
        rejected_from_rcs();
    } else {
        rejected_from_finance();
    }

}

function rejected_from_finance() {
    // alert("fin");
    var url;
    var $form = $('form_reject');
    url = baseURL + "postilion/ajaxcontroller/updated_reject_by_finance";
    sReqNo = $("#reject_req_no").val();
    data = $form.serialize() + '&' + $.param({
        ajaxReqNo: sReqNo,
    });
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        dataType: "JSON",
        success: function (data) {
            $('#modal_approve_invoice').modal('hide');
            location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error adding / update data account');
        }
    });
}

function rejected_from_rcs() {
    // alert("rcs");
    var url;
    var $form = $('form_reject');
    url = baseURL + "postilion/ajaxcontroller/updated_reject_by_rcs";
    sReqNo = $("#reject_req_no").val();
    data = $form.serialize() + '&' + $.param({
        ajaxReqNo: sReqNo,
    });
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        dataType: "JSON",
        success: function (data) {
            $('#modal_approve_invoice').modal('hide');
            location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error adding / update data account');
        }
    });
}