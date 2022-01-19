var gPrmFi = '';

$('#dt_register_interchange').DataTable({
    // iDisplayLength: 5,
    paging: true,
    info: true,
    searching: true,
    ordering: false,
    columnDefs: [
        { width: '1%', targets: 0 }
      ],
    // scrollY:        "350px",
});


function modal_delete_list_interchange(value_this, prm1, prm2) {
    gPrmFi = prm1;
    gPrm2 = prm2;
    value_this = "Are You Sure Delete This Package :";
    $('#signupalert').css('display', 'none');
    $('#modal_delete_interchange').modal('show');
    $('#confirm_delete').text(value_this + " (" + prm1 + " - " + prm2 + ")"); // Set Title to Bootstrap modal title
}

function modal_add_new_interchange() {
    value_this = "Are You Sure Want To Add This Interchange ?";
    // $('#signupalert').css('display', 'none');
    $('#modal_add_interchange').modal('show');
    $('#confirm_add').text(value_this); // Set Title to Bootstrap modal title
}

$('#submit_add_interchange').click( function() {
    $('#form_add_interchange').submit();
});

function delete_interchange() {
    $('#modal_delete_interchange').modal('hide');
    waitingDialog.show('deleting package...', {
        // headerText: '',
        dialogSize: 'sm',
        progressType: 'success'
    });
    // alert(gPrm1 + " - " + gPrm2);
    var url = baseURL + "postilion/ajaxcontroller/ajax_delete_list_interchange";
    // alert(url);
    // var url = "<?php echo site_url('postilion/ajax_delete_terminal_parameterize')?>";
    var data_post = $.param({ ajaxFiNumber: gPrmFi });
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

$(".edit-interchange-bank").click(function () {
    var textval = [];
    $(this).closest('tr').find('td').each(function () {
        textval.push($(this).text()); // this will be the text of each <td>
        // alert(textval);
    });
    $("#m_fi_number").html(textval[0]);
    $("#m_interchange").html(textval[1]);
    $("#m_bank_code").html(textval[4]);

    $("#m_source_node").val(textval[2]);
    $("#m_sink_node").val(textval[3]);
    $("#m_total_group").val(textval[5]);
    $("#m_bussiness_entity").val(textval[6]);


    $('#v_title_interchange').html('Edit List Package');
    $('#modal_edit_list_interchange').modal('show');
});

function update_interchange_bank() {

    var foo = $('#m_fi_number').html();
    // splashArrayFix.push(foo);
    // alert(foo);
    //alert(splashArray);
    sMenu = foo;
    var url;
    var $form = $('form_edit_interchange');
    var data = {
        'foo': 'bar'
    };

    url = baseURL + "postilion/ajaxcontroller/update_list_interchange";

    sFI             = $("#m_fi_number").html();
    sSourceNode     = $("#m_source_node").val();
    sSinkNode       = $("#m_sink_node").val();
    sTotalGroup     = $("#m_total_group").val();
    sEntity         = $("#m_bussiness_entity").val();


    // alert(sTerminalId + sMinSaldo + sDateFrom + sDateTo);
    // return;
    data = $form.serialize() + '&' + $.param({
        ajaxFi         : sFI, 
        ajaxSource     : sSourceNode, 
        ajaxSink       : sSinkNode,
        ajaxTotal      : sTotalGroup, 
        ajaxEntity     : sEntity
    });
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        dataType: "JSON",
        success: function (data) {
            $('#modal_edit_list_interchange').modal('hide');
                location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //how to catch error ajax post
            //alert(jqXHR.responseText);
            alert('Error adding / update data account');
        }
    });
}