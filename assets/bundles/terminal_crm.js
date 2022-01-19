$(document).ready(function(){

    $('#dt_terminal_transactions_crm,#dt_crm_history_flm_slm,#dt_terminal_offline_crm,#dt_terminal_closed_crm,#dt_terminal_inservice_crm,#dt_terminal_faulty_crm').DataTable({
        iDisplayLength:5,
        paging: true, 
        info: true, 
        searching: true,
        ordering: false
    });

    var url;
    url = baseURL + "postilion/ajaxcontroller/batch_viewer_crm";
    // alert(url);
    var table_batch_viewer_crm = $('#datatable_batch_viewer_crm').DataTable({
        iDisplayLength:50,
        processing: true,
        // serverSide: true,
        searching: true,
        ajax: {
            url : url,
            data: {
                terminal_name : function() {return $('#terminal_batch').val()},
                datebatch : function() {return $('#date_batch').val()}
            },
            type : 'GET'
        },
        language: {
            // "processing": "Loading. Please wait..."
            "processing": '<div class="loader"><div class="m-t-30"><img class="zmdi-hc-spin" src="'+baseURL+'assets/images/loader.svg" width="48" height="48" alt="Aero"></div><p>Processing...</p></div>'
            
        },
    });

    $( "#btn_submit_batch_viewer" ).click(function() {
        table_batch_viewer_crm.ajax.reload();
    });

});