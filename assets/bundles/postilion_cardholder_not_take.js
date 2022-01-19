$(document).ready(function(){

    var url;
    url = baseURL + "postilion/ajaxcontroller/cardholder_not_take";
    // alert(url);

    var table_batch_viewer = $('#datatable_cardholder_not_take').DataTable({
        iDisplayLength:50,
        processing: true,
        // serverSide: true,
        searching: true,
        ajax: {
            url : url,
            data: {
                datefrom : function() {return $('#txt_datefrom').val()},
                dateend : function() {return $('#txt_dateend').val()},
                terminal_name : function() {return $('#sTerminal').val()}
            },
            type : 'GET'
        },
        language: {
            "processing": '<div class="loader"><div class="m-t-30"><img class="zmdi-hc-spin" src="'+baseURL+'assets/images/loader.svg" width="48" height="48" alt="Aero"></div><p>Processing...</p></div>'
            
        },
    });

    $( "#btn_submit_cardholder" ).click(function() {
        table_batch_viewer.ajax.reload();
    });

        
        

});