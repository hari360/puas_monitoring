$(function () {
    $('#loader_process').hide();
    // var table_tran_type = $('#dt_top_5_crm_7_days').DataTable({
    //     // iDisplayLength:100,
    //     paging: true,
    //     info: true,
    //     searching: true,
    // });

    $("#dt_sum_query_trx").on('xhr.dt', function(e, settings, json, xhr){
        // alert(json.total_trx);
            $("#total_trx").html(json.total_trx);
            $("#total_trx_approved").html(json.total_approved);
            $("#total_trx_reject_technical").html(json.total_reject_technical);
            $("#total_trx_reject_customer").html(json.total_reject_customer);
        // TODO: Insert your code
    });

    var url;
    url = baseURL + "postilion/ajaxcontroller/get_query_trx";
    // alert(url);

    var table_tran_type = $('#dt_query_trx').DataTable({
        iDisplayLength:10,
        processing: true,
        // serverSide: true,
        searching: true,
        ajax: {
            url : url,
            data: {
                from_date : function() {return $('#from_date').val()},
                to_date : function() {return $('#to_date').val()},
                batch_nr : function() {return $('#select_batch_cutoff').val()},
                tran_type : function() {return $('#select_tran_type').val()},
                // issuer : function() {return $('#select_issuer').val()},
                // benef : function() {return $('#select_benef').val()},
                sink_node_name : function() {return $('#select_sink_node_name').val()},
                pan : function() {return $('#txt_pan').val()},
                rrn : function() {return $('#txt_rrn').val()},
                prefix_term : function() {return $('#select_pref_term').val()},
                terminal_id : function() {return $('#txt_terminal_id').val()},
                response_code : function() {return $('#select_resp_code').val()},
                show_records : function() {return $('#txt_show_records').val()},
                
                
            },
            type : 'GET'
        },
        language: {
            // "processing": "Loading. Please wait..."
            "processing": '<div class="loader"><div class="m-t-30"><img class="zmdi-hc-spin" src="'+baseURL+'assets/images/loader.svg" width="48" height="48" alt="Aero"></div><p>Processing...</p></div>'
            
        }
        //,"order": [[ 6, 'desc' ]]
    });


    var url_sum;
    url_sum = baseURL + "postilion/ajaxcontroller/get_sum_query_trx";
    // alert(url);

    var table_tran_type_sum = $('#dt_sum_query_trx').DataTable({
        iDisplayLength:100,
        processing: true,
        // serverSide: true,
        searching: true,
        ajax: {
            url : url_sum,
            //dataType: 'json',
            data: {
                from_date : function() {return $('#from_date').val()},
                to_date : function() {return $('#to_date').val()},
                batch_nr : function() {return $('#select_batch_cutoff').val()},
                tran_type : function() {return $('#select_tran_type').val()},
                // issuer : function() {return $('#select_issuer').val()},
                // benef : function() {return $('#select_benef').val()},
                sink_node_name : function() {return $('#select_sink_node_name').val()},
                pan : function() {return $('#txt_pan').val()},
                rrn : function() {return $('#txt_rrn').val()},
                prefix_term : function() {return $('#select_pref_term').val()},
                terminal_id : function() {return $('#txt_terminal_id').val()},
                response_code : function() {return $('#select_resp_code').val()},
                show_records : function() {return $('#txt_show_records').val()},
            },
            type : 'GET',
            // success: function(response){

            //     var g = response;
            //     alert(g);

            // }
        },
        // "initComplete":function( settings, json){
        //     //console.log(json);
        //     //alert(json.data);
        //     // call your function here
            
        //     //alert(json.data[0]);
        //     // alert(json.total_reject_customer);
        //     $("#total_trx").html(json.total_trx);
        //     $("#total_trx_approved").html(json.total_approved);
        //     $("#total_trx_reject_technical").html(json.total_reject_technical);
        //     $("#total_trx_reject_customer").html(json.total_reject_customer);
        // },

        // drawCallback: function(setting) {

        //     //alert(settings.total_approved);
        //     //alert(setting.json.draw);
        //     console.log(setting.json);
        //     // console.log(jqXHR.jqXHR.responseJSON.total_approved);
        //     // console.log(settings.jqXHR);
        //     // var responseText = jQuery.parseJSON(jqXHR.responseText);
        //     // console.log(responseText.total_approved);
        //     //do whatever  
        //  },
        
        language: {
            // "processing": "Loading. Please wait..."
            "processing": '<div class="loader"><div class="m-t-30"><img class="zmdi-hc-spin" src="'+baseURL+'assets/images/loader.svg" width="48" height="48" alt="Aero"></div><p>Processing...</p></div>'
            
        }
        //,"order": [[ 6, 'desc' ]]
    });

    $('#btn_search').click(function () {
        // alert($(this).val());
        $("#lbl_date_from").html(($('#from_date').val()=="" ? "-" : $('#from_date').val()));
        $("#lbl_date_to").html(($('#to_date').val()=="" ? "-" : $('#to_date').val()));
        $("#lbl_batch").html(($('#select_batch_cutoff').val()=="" ? "-" : $('#select_batch_cutoff').val()));
        $("#lbl_tran_type").html(($('#select_tran_type').val()=="" ? "-" : $('#select_tran_type option:selected').text()));
        // $("#lbl_issuer").html(($('#select_issuer').val()=="" ? "-" : $('#select_issuer').val()));
        // $("#lbl_benef").html(($('#select_benef').val()=="" ? "-" : $('#select_benef').val()));
        $("#lbl_sink_node").html(($('#select_sink_node_name').val()=="" ? "-" : $('#select_sink_node_name').val()));
        $("#lbl_pan").html(($('#txt_pan').val()=="" ? "-" : $('#txt_pan').val()));
        $("#lbl_rrn").html(($('#txt_rrn').val()=="" ? "-" : $('#txt_rrn').val()));
        $("#lbl_pref_term").html(($('#select_pref_term').val()=="" ? "-" : $('#select_pref_term').val()));
        $("#lbl_spec_term").html(($('#txt_terminal_id').val()=="" ? "-" : $('#txt_terminal_id').val()));
        $("#lbl_resp_code").html(($('#select_resp_code').val()=="" ? "-" : $('#select_resp_code option:selected').text()));
        $("#lbl_show_records").html(($('#txt_show_records').val()=="" ? "-" : $('#txt_show_records').val()));

        table_tran_type.ajax.reload();
        table_tran_type_sum.ajax.reload();
    });

    $('#btn_export_excel_query_trx').click(function () {
        var url;
        url = baseURL + "reporting/querytrx/get_result_excel/";

        $('#loader_process').show();
        $.ajax({
            type:'POST',
            url:url,
            data: {
                from_date : function() {return $('#from_date').val()},
                to_date : function() {return $('#to_date').val()},
                batch_nr : function() {return $('#select_batch_cutoff').val()},
                tran_type : function() {return $('#select_tran_type').val()},
                sink_node_name : function() {return $('#select_sink_node_name').val()},
                pan : function() {return $('#txt_pan').val()},
                rrn : function() {return $('#txt_rrn').val()},
                prefix_term : function() {return $('#select_pref_term').val()},
                terminal_id : function() {return $('#txt_terminal_id').val()},
                response_code : function() {return $('#select_resp_code').val()},
                show_records : function() {return $('#txt_show_records').val()},
            },
            dataType:'json'
        }).done(function(data){
            var $a = $("<a>");
            $a.attr("href",data.file);
            $("body").append($a);
            $a.attr("download","result_query_transactions.xlsx");
            $a[0].click();
            $a.remove();
            $('#loader_process').hide();
        });
    });

    // $('#dt_top_5_crm_7_days').DataTable( {
    //     "scrollY":        "200px",
    //     "scrollCollapse": true,
    //     "paging":         false,
    //     "fixedHeader": true
    // } );

});