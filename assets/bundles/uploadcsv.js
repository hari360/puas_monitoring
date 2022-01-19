// const date = new Date();
// const dateString = date.toLocaleString("en-us");
// const dateString = date.format("yyyyMMdd_HHmmss.fff");

// var v_id_upload_csv = "";
// format = function date2str(x, y) {
//     var z = {
//         M: x.getMonth() + 1,
//         d: x.getDate(),
//         h: x.getHours(),
//         m: x.getMinutes(),
//         s: x.getSeconds(),
//         S: x.getMilliseconds()
//     };
//     y = y.replace(/(M+|d+|h+|m+|s+|S)/g, function(v) {
//         return ((v.length > 1 ? "0" : "") + z[v.slice(-1)]).slice(-2)
//     });

//     return y.replace(/(y+)/g, function(v) {
//         return x.getFullYear().toString().slice(-v.length)
//     });
// }

function progress(e) {  
    if(e.lengthComputable){
        var max = e.total;
        var current = e.loaded;
        var percentage = (current*100)/max;

        $(".progress-bar").css('width',percentage+'%').attr('aria-valuenow',percentage);
        $("#v_progress").html(percentage.toFixed(0)+'%');
    }
}

$(document).ready(function(){

    // var date = new Date();
    // var dateString = date.toLocaleString("en-us");

    // var d = new Date();
    // var n = d.getMilliseconds();
    // //alert(dateString.getTime());

    // $('#v_id_upload').val(format(new Date(dateString), 'yyyyMMddhhmmss') + n);
    $('#v_id_upload').val("-");
    // v_id_upload_csv = "-";

    var url;
    url = baseURL + "reportiso/ajax_get_data_upload";
    // alert(url);

    // $.ajax({
    //     url : v_url,
    //     type: "GET",
    //     async: false,
    //     dataType: "JSON",
    //     success: function(result)
    //     {            
    //         $.each(result, function (i, item) {  
    //           v_global_1 += '<tr><td>'+item.event_id+'</td><td>'+item.date_time+'</td><td ' + (item.description_event == 'The ATM changed mode from In Service to Off-Line. ' ? 'style="color:red;font-weight:bold"' : (item.description_event == 'The ATM changed mode from Closed to In Service. ' ? 'style="color:green;font-weight:bold"' : '')) + '>'+item.description_event+'</td></tr>' ;
    //         });
    //     },
    //     error: function (jqXHR, textStatus, errorThrown)
    //     {
    //         alert('Error get data from ajax');
    //     }
    // });      

    // $.ajax({
    //     type : 'GET',
    //     url  : url,
    //     dataType: 'json',
    //     cache: false,
    //     success :  function(result)
    //         {
    //             //pass data to datatable
    //             console.log(result); // just to see I'm getting the correct data.
    //             // alert(result);
    //             $('#example').DataTable({
    //                 "processing": true,
    //                 "serverSide": true,
    //                 "searching": false, //this is disabled because I have a custom search.
    //                 "aaData": [result], //here we get the array data from the ajax call.
    //                 "aoColumns": [
    //                   { "sTitle": "id" },
    //                   { "sTitle": "short_name" },
    //                   { "sTitle": "kelola" }
    //                 ] //this isn't necessary unless you want modify the header
    //                   //names without changing it in your html code. 
    //                   //I find it useful tho' to setup the headers this way.
    //             });
    //         }
    //     });

    

    var table_reload = $('#item-list').DataTable({
        iDisplayLength:50,
        // processing: true,
        // serverSide: true,
        searching: true,
        ajax: {
            url : url,//"http://localhost:81/atmi_monitoring/terminalcardbase/ajax_get_data_flm_slm_temp",
            data: {
                extra_search : function() {return $('#v_id_upload').val()}
            },
            type : 'GET'
        },
    });


    // $('#example').DataTable( {
    //     "processing": true,
    //     "serverSide": true,
    //     "ajax": {
    //         "url": "http://localhost:81/atmi_monitoring/terminalcardbase/ajax_get_data_flm_slm_temp",
    //         "type": "POST"
    //     },
    //     "columns": [
    //         { "data": "id" },
    //         { "data": "kelola" },
    //         { "data": "short_name" },
    //         // { "data": "office" },
    //         // { "data": "start_date" },
    //         // { "data": "salary" }
    //     ]
    // } );


    // $('#example').DataTable( {
    //     "processing": true,
    //     "serverSide": true,
    //     "ajax": "http://localhost:81/atmi_monitoring/terminalcardbase/ajax_get_data_flm_slm_temp"
    // } );

    // $('#tbl_status_upload').DataTable( {
    //     "processing": true,
    //     "serverSide": true,
    //     "ajax": url
    // });

    // var table_cardbase = $('#tbl_status_upload').DataTable({
    //      iDisplayLength:100,
    //      paging: true, 
    //      info: true, 
    //      searching: false,
    //     // scrollY:        "350px",
    //   });


    $( "#alert_upload" ).hide();

    // $('#btn_clear').click(function(){
    //     alert('test');
    //     $('#succes_notif').empty();
    // });

    $('#btn_show_table').click(function(){
        $("#fileInput").val(null);
        // v_id_upload_csv = $('#v_id_upload').val();
        // alert(url + "/" + $('#v_id_upload').val());
        table_reload.ajax.reload();
        // alert('es');
    });
    
    
    $("#formupload").on('submit',function(e){
        date_upload = new Date();
        dateString_upload = date_upload.toLocaleString("en-us");

        d_upload = new Date();
        n_upload = d_upload.getMilliseconds();

        $('#v_id_upload').val(format(new Date(dateString_upload), 'yyyyMMddhhmmss') + n_upload);
        // alert('test');
        $('#btn_upload_csv').prop('disabled',true);
        var formdata = new FormData(this);
        var v_url = baseURL + "reportiso/upload_files/" +  $('#v_id_upload').val();
        // alert(v_url);
        $('#succes_notif').empty();
        $('#failed_notif').empty();

        $.ajax({
            type        : "POST",
            url         : v_url,
            data        : formdata,
            xhr         : function(){
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress',progress,false);
                }
                return myXhr;
            },
            cache       : false,
            contentType : false,
            processData : false,
            success     : function (data) {  
                $('#btn_upload_csv').prop('disabled',false);
                var obj = JSON.parse(data);
                for(var i = 0; i < obj.success_get.length; i++){
                    // $('#succes_notif').parents('li').remove();
                    // alert(obj.success_get[0]);
                    $('#succes_notif').append("<li>" + obj.success_get[i]+"</li>");
                }
                for(var i = 0; i < obj.failed_get.length; i++){
                    // alert(obj.failed_get[0]);
                    // $('#failed_notif').parents('li').remove();
                    $('#failed_notif').append("<li>" + obj.failed_get[i]+"</li>");
                }
                $("#btn_show_table").trigger("click");
                // $("#formupload")[0].reset();
                
            }
        })
        // table_reload.ajax.reload();
        
        e.preventDefault();
        $( "#alert_upload" ).show();
        

        
    });
});