var gPrmFi = '';

function save_account_bank() {

    var foo = $('#m_fi_code').html();
    // splashArrayFix.push(foo);
    //alert(foo);
    //alert(splashArray);
    sMenu = foo;
    var url;
    var $form = $('form_accounts');
    var data = {
        'foo': 'bar'
    };


    url = baseURL + "postilion/ajaxcontroller/update_account_bank";

    sFicode     = $("#m_fi_code").html();
    sMailpic    = $("#m_mail_pic").val();
    sMailFin    = $("#m_mail_finance").val();
    sMacct      = $("#m_account_id").val();
    sMname      = $("#m_account_name").val();

    // alert(sTerminalId + sMinSaldo + sDateFrom + sDateTo);
    // return;
    data = $form.serialize() + '&' + $.param({
        ajaxFi      : sFicode, 
        ajaxMailPic : sMailpic,
        ajaxMailFin : sMailFin, 
        ajaxAcct    : sMacct,
        ajaxName    : sMname
    });
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        dataType: "JSON",
        success: function (data) {
            $('#modal_edit_account_bank').modal('hide');
                location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //how to catch error ajax post
            //alert(jqXHR.responseText);
            alert('Error adding / update data account');
        }
    });
}


function get_bank_sponsor(json) {
    const bank = [];
    // fruits.push("6");
    $.each(json, function (index, element) {
        // alert(element.user_name);
        if (element.user_name != null) {
            bank.push((element.no).toString());
            // alert(element.page_controller);
        }
    });

    // $('#optgroup').multiSelect('select', (['Dashboard', 'Generate Report ISO']));
    // alert(fruits);

    // console.log(fruits);
    // $('#optgroup').multiSelect('select', bank);
    // $('#optgroup').multiSelect('select', (['1', '2']));
    $('#loader_process').hide();
}

$(".edit-accounts-bank").click(function () {
    var textval = [];
    $(this).closest('tr').find('td').each(function () {
        textval.push($(this).text()); // this will be the text of each <td>
        //alert(textval);
    });
    $("#m_bank_code").html(textval[0]);
    $("#m_fi_code").html(textval[1]);
    $("#m_entity").html(textval[3]);

    $("#m_mail_pic").val(textval[4]);
    $("#m_mail_finance").val(textval[5]);
    $("#m_account_id").val(textval[7]);
    $("#m_account_name").val(textval[8]);


    $('#v_title_accounts').html('Edit Bank Sponsor');
    $('#modal_edit_account_bank').modal('show');
});


function delete_account_bank() {
    $('#modal_delete_register').modal('hide');
    waitingDialog.show('deleting account...', {
        // headerText: '',
        dialogSize: 'sm',
        progressType: 'success'
    });
    // alert(gPrm1 + " - " + gPrm2);
    var url = baseURL + "postilion/ajaxcontroller/ajax_delete_bank_sponsor";
    // alert(url);
    // var url = "<?php echo site_url('postilion/ajax_delete_terminal_parameterize')?>";
    var data_post = $.param({ ajaxFi: gPrmFi });
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

function modal_delete_register(value_this, prm1, prm2) {
    gPrmFi = prm1;
    gPrm2 = prm2;
    value_this = "Are You Sure Delete This Record :";
    $('#signupalert').css('display', 'none');
    $('#modal_delete_register').modal('show');
    $('#confirm_delete').text(value_this + " (" + prm1 + " - " + prm2 + ")"); // Set Title to Bootstrap modal title
}

$('#dt_register_bank_sponsor').DataTable({
    iDisplayLength: 5,
    paging: true,
    info: true,
    searching: true,
    ordering: false
    // scrollY:        "350px",
});

$('#terminal_batch').on('change', function () {
    //alert(this.value);
    var url = baseURL + "postilion/ajaxcontroller/get_data_interchange";
    var $form = $('form_parameterize');

    sOldPassword = $("#txt_old_password").val();
    sNewPassword = $("#txt_new_password").val();
    sConfPassword = $("#txt_new_conf_password").val();

    var data = $form.serialize() + '&'
        + $.param({
            ajaxInterchange: this.value,
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
            $('#bank_code').html(data[0]['cbc']);
            $('#fi_code').html(data[0]['fi_number']);
            $('#entity').html(data[0]['business_entity_name']);

            $('input[name="txt_bank_code"]').val(data[0]['cbc']);
            $('input[name="txt_fi_code"]').val(data[0]['fi_number']);
            $('input[name="txt_entity"]').val(data[0]['business_entity_name']);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data');
        }
    });
});

// var url = baseURL + "postilion/ajaxcontroller/get_interchange_iso";
// var datapost = {
//     user_id: textval[1]
// };

// $.getJSON(url, datapost)
//     .done(function (data) {
//         get_access_terminal_user(data);
//     })
//     .fail(function (jqxhr, textStatus, error) {
//         var err = textStatus + ", " + error;
//         alert("Request Failed : " + err);
//     });