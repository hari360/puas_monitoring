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

    var url;
    url = baseURL + "reportiso/ajax_get_data_upload";
    
    var table_reload = $('#item-list').DataTable({
        iDisplayLength:50,
        searching: true,
        ajax: {
            url : url,
            data: {
                extra_search : function() {return $('#v_id_upload').val()}
            },
            type : 'GET'
        },
    });


    
    $( "#alert_upload" ).hide();

    $('#btn_show_table').click(function(){
        $("#fileInput").val(null);
        table_reload.ajax.reload();
    });
    
    
    $("#formuploadparameterize").on('submit',function(e){
        date_upload = new Date();
        dateString_upload = date_upload.toLocaleString("en-us");

        d_upload = new Date();
        n_upload = d_upload.getMilliseconds();

        $('#btn_upload_excel').prop('disabled',true);
        var formdata = new FormData(this);
        var v_url = baseURL + "atm/parameterize/upload_excel";

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
                $('#btn_upload_excel').prop('disabled',false);
                location.reload();
                var obj = JSON.parse(data);
                for(var i = 0; i < obj.success_get.length; i++){
                }
                for(var i = 0; i < obj.failed_get.length; i++){
                }       
            }
        })
        // table_reload.ajax.reload();
        
        e.preventDefault();
        // $( "#alert_upload" ).show();
        
    });
});