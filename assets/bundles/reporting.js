$("form input:radio").change(function () {
    if ($(this).val() == "pdf") {
        // Disable your roomnumber element here
        //$('.roomNumber').attr('disabled', 'disabled');
        //alert('ter');
        //alert( "selectAll: " + $(this).val() );

        $("#category_det_app").removeAttr("checked");
        $("#category_det_app").attr("disabled","");

        $("#category_det_rej").removeAttr("checked");
        $("#category_det_rej").attr("disabled","");

        $("#category_sum").removeAttr("checked");
        $("#category_sum").attr("disabled","");

        $("#category_vault").removeAttr("checked");
        $("#category_vault").attr("disabled","");

        $("#category_atmi_ptpr").removeAttr("checked");
        $("#category_atmi_ptpr").attr("disabled","");
        
    } else if ($(this).val() == "xlsx") {
        // Re-enable here I guess
        //$('.roomNumber').removeAttr('disabled');
        //alert('ter2');
        //alert( "selectAll: " + $(this).val() );
        $("#category_det_app").removeAttr("disabled");
        $("#category_det_app").attr("checked","");

        $("#category_det_rej").removeAttr("disabled");
        $("#category_det_rej").attr("checked","");

        $("#category_sum").removeAttr("disabled");
        $("#category_sum").attr("checked","");

        $("#category_vault").removeAttr("disabled");
        $("#category_vault").attr("checked","");

        $("#category_atmi_ptpr").removeAttr("disabled");
        $("#category_atmi_ptpr").attr("checked","");
    }
});


$('#btn_submit_report_iso_test').click(function () {
    var splashArray = [];
    $(".ms-selection li.ms-selected span").each(function () {                  
      //  var imageURI = $(this).html(); 
      //  splashArray.push($(this).html());
      //  alert(imageURI);
      var str = $(this).html();
      var res = str.split("-");
       splashArray.push(res[0].trim());
    });
    // alert(splashArray);
    $("#txt_terminal").val(splashArray);
    $("#form_generate_report").submit();
});

$('#btn_submit_report_iso').click(function () {
    var url = "";
    let radioValue = $("input[name='output_file']:checked").val();
    // if(radioValue){
    //     alert("Your are a - " + radioValue);
    // }

    var cmbBsnDate = $('#cmb_bsn_date').find(":selected").text();
    // alert("Your are a - " + cmbBsnDate);

    switch (radioValue) {
        case "xlsx":
            url = baseURL + "reportiso/download_excel";
            //execute code block 1
            break;
        case "pdf":
            url = baseURL + "reportiso/pdf";
            //execute code block 2
            break;
        default:
            url = baseURL + "reportiso/csv";
        // code to be executed if n is different from case 1 and 2
    }

    waitingDialog.show('Generate report...', {
        // headerText: '',
        dialogSize: 'sm',
        progressType: 'success'
    });

    // alert(url);
    var datapost = {
        ajaxBsnDate: cmbBsnDate,
        //v_to_date: to_date,
    };
    

    $.getJSON(url, datapost)
        .done(function (data) {
            //$.each(data, function(index, element) {	
                //alert(element);
                // alert(JSON.stringify(element));
                //});
                // alert(data.op);
                // document.location.href =(output.url);
                window.location = data.op;
                waitingDialog.hide();
        })
        .fail(function (jqxhr, textStatus, error) {
            var err = textStatus + ", " + error;
            // waitingDialog.hide();
            alert("Request Failed 908: " + err);
        });

});

$(function () {


});