var gPrmFi = '';
var global_edit_table = '';

function format() {
    return '<table border="1" >' +
        '<tr style="background-color:#DCDCDC;color:black;">' +
        '<th style="width:50px;padding-left:10px;font-weight:bold" >Tran Type</th>' +
        '<th style="width:50px;padding-left:10px;font-weight:bold" >Tran Type Name</th>' +
        '<th style="width:300px;padding-left:10px;font-weight:bold" >Issuer Fee</th>' +
        '<th style="width:800px;padding-left:10px;font-weight:bold" >Acquire Fee</th>' +
        '<th style="width:800px;padding-left:10px;font-weight:bold" >Switch Fee</th>' +
        '</tr>' +
        v_global_1 +
        '</table>';
}

$(function () {
    var table_fee = $('#dt_list_package').DataTable({
        iDisplayLength: 100,
        paging: true,
        info: true,
        searching: true,
        columnDefs: [
            { targets: 'no-sort', orderable: false }
        ]
    });

    $('#dt_list_package tbody').on('click', 'td.details-control', function () {

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

            var v_package_code = $(this).attr("title");
            //   var v_prefix = $(this).attr('data-prefix');     

            var data_post = $.param({ ajaxPackageCode: v_package_code });
            var v_url = baseURL + "postilion/ajaxcontroller/get_fee_package/";
            $.ajax({
                url: v_url,
                type: "POST",
                data: data_post,
                async: false,
                dataType: "JSON",
                success: function (result) {
                    $.each(result, function (i, item) {
                        switch (item.tran_type) {
                            case "01":
                                v_tran_type_name = "Withdrawal";
                                break;
                            case "31":
                                v_tran_type_name = "Balance Inquiry";
                                break;
                            default:
                                v_tran_type_name = "Fund Transfer";
                        }
                        v_global_1 += '<tr><td>' + item.tran_type + '</td><td>' + v_tran_type_name + '</td><td>' + item.iss_fee + '</td><td>' + item.acq_fee + '</td><td>' + item.swt_fee + '</td></tr>';
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
});


$('#btn_add_fee').click(function () {
    tran_type_code = $('#v_tran_type').val();
    tran_type = $('#v_tran_type').find(":selected").text();
    issuer_fee = $("#v_iss_fee").val();
    acq_fee = $("#v_acq_fee").val();
    swt_fee = $("#v_swt_fee").val();

    $('#table_fee').append('<tr><td>' + tran_type_code + '</td><td>' + tran_type + '</td><td>' + issuer_fee + '</td><td>' + acq_fee + '</td><td>' + swt_fee + '</td><td><button type="button" class="btn btn-danger btn_remove_fee" style="margin-top: 10px;" >Remove</button></td></tr>');

});

$("#table_fee").on("click", ".btn_remove_fee", function () {
    $(this).closest("tr").remove();
});

$("#edit_table_fee").on("click", ".btn_remove_fee_edit", function () {
    $(this).closest("tr").remove();
});

$('#btn_add_fee_test').click(function () {

    // var table = document.getElementById("table_fee");
    var textval = [];
    $('#table_fee tr').each(function () {
        $(this).find('td').each(function () {
            // textval.push(($(this).text()=="Remove" ? $(this).text() + "|" : $(this).text() ));
            // alert($(this).text());
            //do your stuff, you can use $(this) to get current cell
        })
    })

    // alert(textval[0]);
    // var myJsonString = JSON.stringify(textval);
    $("#txt_fee_selected").val(textval);



});

// $('#dt_list_package').DataTable({
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



function modal_delete_list_package(value_this, prm1, prm2) {
    gPrmFi = prm1;
    gPrm2 = prm2;
    value_this = "Are You Sure Delete This Package :";
    $('#signupalert').css('display', 'none');
    $('#modal_delete_package').modal('show');
    $('#confirm_delete').text(value_this + " (" + prm1 + " - " + prm2 + ")"); // Set Title to Bootstrap modal title
}

function modal_add_list_package() {
    value_this = "Are You Sure Want To Add This Package ?";
    // $('#signupalert').css('display', 'none');
    $('#modal_add_package').modal('show');
    $('#confirm_add').text(value_this); // Set Title to Bootstrap modal title
}

$('#submit_add_package').click(function () {
    var textval = [];
    $('#table_fee tr').each(function () {
        $(this).find('td').each(function () {
            textval.push($(this).text());
            // alert($(this).text());
            //do your stuff, you can use $(this) to get current cell
        })
    })

    // alert(textval[0]);
    // var myJsonString = JSON.stringify(textval);
    // $("#txt_fee_selected").val(myJsonString);
    $("#txt_fee_selected").val(textval);
    $('#form_add_package').submit();
});

$('#submit_change_package_fee').click(function () {

    if($('#update_list_package_modal').html()=='Add Package')
    {
        var tran_type_name = $('#v_tran_type_edit').find(":selected").text();
        tran_type_code = $('#v_tran_type_edit').val();
        tran_type = $('#v_tran_type').find(":selected").text();
        issuer_fee = $("#v_iss_fee_edit").val();
        acq_fee = $("#v_acq_fee_edit").val();
        swt_fee = $("#v_swt_fee_edit").val();
    
        $('#edit_table_fee').append('<tr><td>' + tran_type_code + '</td><td>' + tran_type_name + '</td><td>' + issuer_fee + '</td><td>' + acq_fee + '</td><td>' + swt_fee + '</td><td><button type="button" class="btn btn-danger btn_remove_fee" style="margin-top: 10px;" >Remove</button></button><button type="button" class="btn btn-primary btn_change_fee" style="margin-top: 10px;" >Change</button></td></tr>');
    
    }else{
        index_row = $("#v_index_row").val();
        // alert(index_row);
        // $("#edit_table_fee tr:eq("+index_row+")").remove();
        var tran_type_name = $('#v_tran_type_edit').find(":selected").text();
        $("#edit_table_fee tr:eq(" + index_row + ")").find("td").eq(1).html($("#v_tran_type_edit").val());
        $("#edit_table_fee tr:eq(" + index_row + ")").find("td").eq(1).html(tran_type_name);
        $("#edit_table_fee tr:eq(" + index_row + ")").find("td").eq(2).html($("#v_iss_fee_edit").val());
        $("#edit_table_fee tr:eq(" + index_row + ")").find("td").eq(3).html($("#v_acq_fee_edit").val());
        $("#edit_table_fee tr:eq(" + index_row + ")").find("td").eq(4).html($("#v_swt_fee_edit").val());
    }
    

    



    $('#modal_change_fee_package').modal('hide');
    // $('#edit_table_fee').append('<tr><td>' + $("#v_tran_type_edit").val() + '</td><td>' + tran_type_name + '</td><td>' + $("#v_iss_fee_edit").val() + '</td><td>' + $("#v_acq_fee_edit").val() + '</td><td>' + $("#v_swt_fee_edit").val() + '</td><td><button type="button" class="btn btn-danger btn_remove_fee_edit" style="margin-top: 10px;" >Remove</button><button type="button" class="btn btn-primary btn_change_fee" style="margin-top: 10px;" >Change</button></td></tr>');

});

function delete_package() {
    $('#modal_add_package').modal('hide');
    waitingDialog.show('deleting package...', {
        // headerText: '',
        dialogSize: 'sm',
        progressType: 'success'
    });
    // alert(gPrm1 + " - " + gPrm2);
    var url = baseURL + "postilion/ajaxcontroller/ajax_delete_list_package";
    // alert(url);
    // var url = "<?php echo site_url('postilion/ajax_delete_terminal_parameterize')?>";
    var data_post = $.param({ ajaxPackageCode: gPrmFi });
    $.ajax({
        url: url,
        type: "POST",
        data: data_post,
        success: function (data) {
            if (data == "Success") {

                location.reload();
            }
            else {
                $('#signupalertdeleteprm').css('display', 'block');
            }
        }
    });
}

$(".edit-list-package").click(function () {
    var textval = [];
    $(this).closest('tr').find('td').each(function () {
        textval.push($(this).text()); // this will be the text of each <td>
        //alert(textval);
    });
    $("#m_package_code").val(textval[1]);
    $("#m_limit").val(textval[2]);
    $("#m_price").val(textval[3]);
    $("#m_minimum_limit").val(textval[4]);

    $("#edit_table_fee  > tbody").empty();

    var v_package_code = textval[1];
    //   var v_prefix = $(this).attr('data-prefix');     

    var data_post = $.param({ ajaxPackageCode: v_package_code });
    var v_url = baseURL + "postilion/ajaxcontroller/get_fee_package/";
    $.ajax({
        url: v_url,
        type: "POST",
        data: data_post,
        async: false,
        dataType: "JSON",
        success: function (result) {
            $.each(result, function (i, item) {
                switch (item.tran_type) {
                    case "01":
                        v_tran_type_name = "Withdrawal";
                        break;
                    case "31":
                        v_tran_type_name = "Balance Inquiry";
                        break;
                    default:
                        v_tran_type_name = "Fund Transfer";
                }
                // global_edit_table += '<tr><td>' + item.tran_type + '</td><td>' + v_tran_type_name + '</td><td>' + item.iss_fee + '</td><td>' + item.acq_fee + '</td><td>' + item.swt_fee + '</td><td><button type="button" class="btn btn-danger btn_remove_fee" style="margin-top: 10px;" >Remove</button><button type="button" class="btn btn-primary btn_change_fee" style="margin-top: 10px;" >Change</button></td></tr>';
                $('#edit_table_fee').append('<tr><td>' + item.tran_type + '</td><td>' + v_tran_type_name + '</td><td>' + item.iss_fee + '</td><td>' + item.acq_fee + '</td><td>' + item.swt_fee + '</td><td><button type="button" class="btn btn-danger btn_remove_fee_edit" style="margin-top: 10px;" >Remove</button><button type="button" class="btn btn-primary btn_change_fee" style="margin-top: 10px;" >Change</button></td></tr>');
                // v_global_1 += '<tr><td>' + item.tran_type + '</td><td>' + v_tran_type_name + '</td><td>' + item.iss_fee + '</td><td>' + item.acq_fee + '</td><td>' + item.swt_fee + '</td></tr>';
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });

    // $('#edit_table_fee').append('<tr><td>' + "01" + '</td><td>' + "tran_type" + '</td><td>' + "issuer_fee" + '</td><td>' + "acq_fee" + '</td><td>' + "swt_fee" + '</td><td><button type="button" class="btn btn-danger btn_remove_fee" style="margin-top: 10px;" >Remove</button><button type="button" class="btn btn-primary btn_change_fee" style="margin-top: 10px;" >Change</button></td></tr>');

    // $('#edit_table_fee').append(global_edit_table);
    $('#v_title_accounts').html('Edit List Package');
    $('#modal_edit_list_package').modal('show');
});

$("#btn_add_list_fee").click(function () {
    
    $('#update_list_package_modal').html('Add Package');
    $('#modal_change_fee_package').modal('show');
});

$("#edit_table_fee").on("click", ".btn_change_fee", function () {

    // $(this).closest('tr').find('td');
    // alert($(this).text());

    var row_index = $(this).closest("tr").index();
    $("#v_index_row").val(row_index + 1);
    // alert(row_index)

    var tran_type = $(this).closest('tr').children('td:eq(0)').text();

    // Get the second td
    var iss_fee = $(this).closest('tr').children('td:eq(2)').text();
    var acq_fee = $(this).closest('tr').children('td:eq(3)').text();
    var swt_fee = $(this).closest('tr').children('td:eq(4)').text();

    // alert('periodStart:  ' + periodStart + '\nperiodEnd:  ' + periodEnd)


    // var textval = [];
    // $('#edit_table_fee tr').each(function () {
    //     $(this).closest('tr').find('td').each(function () {
    //         textval.push($(this).text());
    //         alert($(this).text());
    //         //do your stuff, you can use $(this) to get current cell
    //     })
    // })

    // // var $row = $('#edit_table_fee').closest('tr');
    // // var $columns = $row.find('td');

    // // // $columns.addClass('row-highlight');
    // // var values = "";
    // // alert(values);
    // // $.each($columns, function(i, item) {
    // //     values = values + 'td' + (i + 1) + ':' + item.innerHTML + '<br/>';
    // //     alert(values);
    // // });
    // // console.log(values);

    // alert(textval[0]);
    // var myJsonString = JSON.stringify(textval);
    // $("#txt_fee_selected").val(myJsonString);
    $("#v_tran_type_edit").val(tran_type).change();
    // $("#v_tran_type_edit").val(textval[0]);
    $("#v_iss_fee_edit").val(iss_fee);
    $("#v_acq_fee_edit").val(acq_fee);
    $("#v_swt_fee_edit").val(swt_fee);

    $('#update_list_package_modal').html('Change Package');
    $('#modal_change_fee_package').modal('show');
});

// $(".btn_change_fee").click(function () {
//     $('#v_title_accounts').html('Edit List Package 1234');
//     // $('#modal_change_fee_package').modal('show');
// });

function update_list_package() {
    value_this = "Are You Sure Update This Change Package ?";
    $('#modal_update_package').modal('show');
    $('#confirm_update').text(value_this);
}

function update_package() {
    var textval = [];
    $('#edit_table_fee tr').each(function () {
        $(this).find('td').each(function () {
            textval.push($(this).text());
            // alert($(this).text());
            //do your stuff, you can use $(this) to get current cell
        })
    })

    // alert(textval[0]);
    // var myJsonString = JSON.stringify(textval);
    // $("#txt_fee_selected").val(myJsonString);
    $('input[name="txt_update_list_fee"]').val(textval);
    
    $('#form_edit_package').submit();
}

function save_list_package() {

    var foo = $('#m_fi_code').html();
    // splashArrayFix.push(foo);
    //alert(foo);
    //alert(splashArray);
    sMenu = foo;
    var url;
    var $form = $('form_edit_package');
    var data = {
        'foo': 'bar'
    };


    url = baseURL + "postilion/ajaxcontroller/update_list_package";

    sId = $("#m_package_code").val();
    sPackageCode = $("#m_package_code").val();
    sLimit = $("#m_limit").val();
    sPrice = $("#m_price").val();
    sFee = $("#m_fee").val();


    // alert(sTerminalId + sMinSaldo + sDateFrom + sDateTo);
    // return;
    data = $form.serialize() + '&' + $.param({
        ajaxId: 2,
        ajaxPackage: sPackageCode,
        ajaxLimit: sLimit,
        ajaxPrice: sPrice,
        ajaxFee: sFee
    });
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        dataType: "JSON",
        success: function (data) {
            $('#modal_edit_list_package').modal('hide');
            location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //how to catch error ajax post
            //alert(jqXHR.responseText);
            alert('Error adding / update data account');
        }
    });
}