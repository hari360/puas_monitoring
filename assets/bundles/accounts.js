function show_modal_change_password() {
    $('#modal_form_change_password').modal('show');
}

function save_change_password() {

    var url = baseURL + "accounts/profile/update_password";
    var $form = $('form_parameterize');

    sOldPassword   = $("#txt_old_password").val();
    sNewPassword   = $("#txt_new_password").val();
    sConfPassword   = $("#txt_new_conf_password").val();

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
            if(data['status_field_old']!=""){
                $('#name-error-old-pass').css('display','block');
                $('#name-error-old-pass').html(data['status_field_old']);
            }else{
                $('#name-error-old-pass').css('display','none');
            }

            if(data['status_field_new']!=""){
                $('#name-error-new-pass').css('display','block');
                $('#name-error-new-pass').html(data['status_field_new']);
            }else{
                $('#name-error-new-pass').css('display','none');
            }

            if(data['status_field_conf']!=""){
                $('#name-error-conf-pass').css('display','block');
                $('#name-error-conf-pass').html(data['status_field_conf']);
            }else{
                $('#name-error-conf-pass').css('display','none');
            }

            // alert(data['status_field']);
            if(data['status_field']=="success"){
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


$('#btn_change_img').click(function(){
    showConfirmMessage();
});


$(document).ready(function(){

    

    $("#modal_form_change_password").on('hide.bs.modal', function(){
        // alert("Hello World!123");
        $('#name-error-conf-new-pass').css('display','none');
        $('#txt_old_password').val("");
        $('#txt_new_password').val("");
        $('#txt_new_conf_password').val("");
    });

});