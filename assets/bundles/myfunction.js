var gPrm1 = '';
var gPrm2 = '';  

function delete_terminal_parameterize(value_this,prm1,prm2)
{
    gPrm1 = prm1;
    gPrm2 = prm2;
    value_this = "Are You Sure Delete This Terminal ID :"; 
    $('#signupalert').css('display','none');
    $('#modal_delete').modal('show'); 
    $('#confirm_delete').text(value_this + " (" + prm1 + " - " + prm2 + ")"); // Set Title to Bootstrap modal title
}

function delete_terminal_id_parameterize()
{
  // alert(gPrm1 + " - " + gPrm2);
  var url = baseURL + "postilion/ajaxcontroller/ajax_delete_terminal_parameterize";
  // alert(url);
  // var url = "<?php echo site_url('postilion/ajax_delete_terminal_parameterize')?>";
  var data_post = $.param({ ajaxUserID:gPrm1, ajaxTerminalID:gPrm2});
    $.ajax({
                    url : url,
                    type: "POST",
                    data: {'ajaxTerminalID':gPrm1},
                    success: function(data)
                    {
                        if (data == "Success")
                        {
                          $('#modal_delete').modal('hide'); 
                          location.reload();
                        }
                        else
                        {
                          $('#signupalertdeleteprm').css('display','block');
                        }
                    }
              });
}

function myFunction() {
  var x = document.getElementById("v_pass");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

function add_person(value_this,prm1,prm2){
    pValueThis = value_this;
    pTerminalID = prm1;
    $("#sVendor").empty();
    if(value_this=='SLM'){
      $('#sVendor').append('<option value=\'\'>Select Vendor</option>');
      $('#sVendor').append('<option value="1. NCR">1. NCR</option>');
      $('#sVendor').append('<option value="2. Telkomsel">2. Telkomsel</option>');
    }else{
      $('#sVendor').append('<option value=\'\'>Select Vendor</option>');
      $('#sVendor').append('<option value="1. CMS">1. CMS</option>');
      $('#sVendor').append('<option value="2. Gedung">2. Gedung</option>');
    }

    // $("#sVendor").prop('selectedIndex', 0);
    $('#sVendor').val("").change();
    $('#sProblem').val("").change();
    // alert(prm2);
    if((prm2=='Modify' || prm2=='Submit') && (value_this=='FLM' || value_this=='SLM')){
      // alert(pTerminalID);
      $( "#v_progress" ).show();
      get_data_flm_slm(pTerminalID.split("|",1),value_this);
    }else{
      $( "#v_progress" ).hide();
    }

    save_method = 'add';
    pTerminalID = prm1;
    pStatusFlm = prm2;
    $('#form')[0].reset(); 
    
    $('#modal_form').modal('show');
    $('.modal-title').text(value_this + " (Terminal ID : " + pTerminalID.split("|",1) + ")"); 
}

function get_data_flm_slm(terminal_id,v_table){
  var url = baseURL + "terminalcardbase/ajax_get_data_flm_slm";
  var datapost = {
      term_id: terminal_id,
      table: v_table,
  };
	
  $.getJSON( url, datapost )
      .done(function( data ) {
        $.each(data, function(index, element) {	
          //  alert(element.atmi_problem);	
            $('[name="txtdescription"]').val(element.description);
            $('[name="txtdatetime"]').val(element.date_time_problem);
            // $('[name="cmbProblem"]').val(element.atmi_problem);
            $('#sProblem').val(element.atmi_problem).change();
            $('[id="sVendor"]').val(element.vendor).change();
            $( "#v_progress" ).hide();
          });
      })
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        alert( "Request Failed 4321: " + err );
  });
}

function get_data_parameterize(terminal_id,prm1,prm2){

  $('#v_title_parameterize').html('Edit Parameterize Terminal');
  $('#modal_add_parameterize').modal('show');

  // var term = $("#sTerminalId option:selected").val();
  // var v_term_id = term.split("-",0);

  // alert(v_term_id);

  var url = baseURL + "postilion/ajaxcontroller/get_parameterize";
  var datapost = {
      term_id: prm1
  };

  $.getJSON( url, datapost )
      .done(function( data ) {
        $.each(data, function(index, element) {	
          //  alert(element.atmi_problem);	
            $('#sTerminalId').val(element.terminal_id + "-" + element.terminal_name).change();
            $("#min_saldo").val(element.percentage);
            $("#date_from_parameterize").val(element.from_date);
            $("#to_from_parameterize").val(element.to_date);
            // $( "#v_progress" ).hide();
          });
      })
      .fail(function( jqxhr, textStatus, error ) {
        var err = textStatus + ", " + error;
        alert( "Request Failed 5678: " + err );
  });
}

function save(){

    var myVariable;
    $.ajax({
        'async': false,
        'type': "POST",
        'global': false,
        'dataType': 'html',
        'url': baseURL + "terminalcardbase/get_datetime_server",
        'data': { 'request': "", 'target': 'arrange_url', 'method': 'method_target' },
        'success': function (data) {
            myVariable = data;
        }
    });

    var pDateInsert = myVariable;
    var url;
    var $form = $('form');
    var data = {
      'foo' : 'bar'
    };

    if(pStatusFlm == 'Submit') 
    {
        url = baseURL + "terminalcardbase/ajax_add";
    }
    else
    {
        url = baseURL + "terminalcardbase/ajax_update";
    }
    
    sUsrLogin = $("#usrLogin").html();
    sProblem = $("#sProblem option:selected").val();
    sVendor = $("#sVendor option:selected").val();
    data = $form.serialize() + '&' + $.param({ ajaxTerminalID:pTerminalID, ajaxProblem:sProblem, 
                                                ajaxVendor:sVendor, ajaxUser:sUsrLogin, 
                                                ajaxStatusFLM_SLM:pStatusFlm,ajaxDateInsert:pDateInsert, ajaxTable:pValueThis});
    $.ajax({
        url : url,
        type: "POST",
        data: data,
        dataType: "JSON",
        success: function(data)
        {
            $('#modal_form').modal('hide');
            location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');               
        }
    });
}


function save_parameterize(){

  
  var url;
  var $form = $('form_parameterize');
  var data = {
    'foo' : 'bar'
  };

  var str = $('#v_title_parameterize').html();
  // alert(str.substring(0,3));
  // return;

  if(str.substring(0,3) == 'Add') 
  {
      url = baseURL + "postilion/ajaxcontroller/add_parameterize";
  }
  else
  {
      url = baseURL + "postilion/ajaxcontroller/update_parameterize";
  }
  
  
  sTerminalId = $("#sTerminalId option:selected").val();
  sMinSaldo   = $("#min_saldo").val();
  sDateFrom   = $("#date_from_parameterize").val();
  sDateTo     = $("#to_from_parameterize").val();

  // alert(sTerminalId + sMinSaldo + sDateFrom + sDateTo);
  // return;
  data = $form.serialize() + '&' + $.param({ ajaxTerminalID:sTerminalId, ajaxMinSaldo:sMinSaldo, 
                                              ajaxDateFrom:sDateFrom, ajaxDateTo:sDateTo 
                                              });
  $.ajax({
      url : url,
      type: "POST",
      data: data,
      dataType: "JSON",
      success: function(data)
      {
          $('#modal_add_parameterize').modal('hide');
          location.reload();
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error adding / update data');               
      }
  });
}

var v_global_1 = '';
var v_global_2 = '';

function format() {
  return '<table border="1" >' +
              '<tr style="background-color:#DCDCDC;color:black;">' +
                  '<th style="width:50px;padding-left:10px;font-weight:bold" >Event ID</th>' +
                  '<th style="width:300px;padding-left:10px;font-weight:bold" >Data Time</th>' +
                  '<th style="width:800px;padding-left:10px;font-weight:bold" >Description</th>' +
              '</tr>' +               
              v_global_1 +
          '</table>';       
}

$(document).ready(function(){

  
  // $( '.uang' ).mask('0.000.000.000', {reverse: true});
  $("#change_img").change(function(e) {

    for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
        
        var file = e.originalEvent.srcElement.files[i];
        
        var img = document.getElementById("modify_img");
        var reader = new FileReader();
        reader.onloadend = function() {
             img.src = reader.result;
        }
        reader.readAsDataURL(file);
        // $("#change_img").after(img);
    }
});



  // $('.id_100 option[value=val2]').attr('selected','selected');
  // $("#sProblemTest").val("1");

  // $('#sProblemTest').val("4. SOFTWARE").change();

  // $('#idUkuran').val(11).change();

  // $( "#dup_datetimepick" ).keyup(function() {

  //   $(".datetimepicker").val($( "#dup_datetimepick" ).val());
  //   // alert( "Handler for .change() called." );
  // });

  // $( ".datetimepicker" ).change(function() {

  //   $("#dup_datetimepick").val($( ".datetimepicker" ).val());
  //   // alert( "Handler for .change() called." );
  // });

  $('#btn_show_table').click(function(){
    $("#fileInput").val(null);
    // v_id_upload_csv = $('#v_id_upload').val();
    // alert(url + "/" + $('#v_id_upload').val());
    table_reload.ajax.reload();
    // alert('es');
});

  // $('#btn_delete_parameterize').click(function(){
  //   $('#modal_delete').modal('show');
  // });

  $('#btn_add_parameterize').click(function(){
    $('#v_title_parameterize').html('Add Parameterize Terminal');
    $('#modal_add_parameterize').modal('show');
  });

  $("body").toggleClass("ls-toggle-menu");

  var table_cardbase = $('#dt_terminal_cardbase').DataTable({
    iDisplayLength:100,
    paging: true, 
    info: true, 
    searching: true,
    // scrollY:        "350px",
  });

  var table_cardbase = $('#dt_batch_viewer').DataTable({
    iDisplayLength:100,
    paging: true, 
    info: true, 
    searching: true,
    // scrollY:        "350px",
  });

  $('#dt_parameterize_saldo').DataTable({
    iDisplayLength:5,
    paging: true, 
    info: true, 
    searching: true,
    // scrollY:        "350px",
  });

  $('#dt_history_flm_slm').DataTable({
    iDisplayLength:5,
    paging: true, 
    info: true, 
    searching: true,
    ordering: false
    // scrollY:        "350px",
  });

  var table_card_retain = $('#dt_card_retain_cardbase').DataTable({
    iDisplayLength:100,
    paging: true, 
    info: true, 
    searching: true,
    columnDefs: [
      { width: '20%', targets: 0 }
    ],
    fixedColumns: true,
    // scrollY:        "350px",
  });

  var table_summarized_generate = $('#dt_summarized_iso').DataTable({
    iDisplayLength:5,
    paging: true, 
    info: true, 
    searching: true,
    columnDefs: [
      { width: '2%', targets: 0 }
    ],
    fixedColumns: true,
    // scrollY:        "350px",
  });

  var table_summarized_settlement = $('#dt_settlement_iso').DataTable({
    iDisplayLength:4,
    paging: true, 
    info: true, 
    searching: true,
    columnDefs: [
      { width: '2%', targets: 0 }
    ],
    fixedColumns: true,
    // scrollY:        "350px",
  });

var table_card_retain = $('.dt_terminal_access').DataTable({
    iDisplayLength:100,
    paging: true, 
    info: true, 
    searching: true,
    columnDefs: [
      { width: '20%', targets: 0 }
    ],
    fixedColumns: true,
    // scrollY:        "350px",
  });
  
  var table_count_trx_atm = $('#dt_count_trx_cardbase').DataTable({
    iDisplayLength:20,
    paging: true, 
    info: true, 
    searching: true,
    columnDefs: [
      { width: '20%', targets: 0 }
    ],
    fixedColumns: true,
    // scrollY:        "350px",
  });

  var table_offline = $('#dt_offline').DataTable({
    iDisplayLength:100,
    paging: true, 
    info: true, 
    searching: true,
    columnDefs: [
      { width: '20%', targets: 0 }
    ],
    fixedColumns: true,
  });

  var table_closed = $('#dt_closed').DataTable({
    iDisplayLength:100,
    paging: true, 
    info: true, 
    searching: true,
    columnDefs: [
      { width: '20%', targets: 0 }
    ],
    fixedColumns: true,
  });

  var table_inservice = $('#dt_inservice').DataTable({
    iDisplayLength:100,
    paging: true, 
    info: true, 
    searching: true,
    columnDefs: [
      { width: '20%', targets: 0 }
    ],
    fixedColumns: true,
  });

  var table_inservice = $('#dt_faulty').DataTable({
    iDisplayLength:100,
    paging: true, 
    info: true, 
    searching: true,
    columnDefs: [
      { width: '20%', targets: 0 }
    ],
    fixedColumns: true,
  });

  var table_inservice = $('#dt_idle_term').DataTable({
    iDisplayLength:100,
    paging: true, 
    info: true, 
    searching: true,
    columnDefs: [
      { width: '20%', targets: 0 }
    ],
    fixedColumns: true,
  });

  var table_inservice = $('#dt_saldo_min').DataTable({
    iDisplayLength:100,
    paging: true, 
    info: true, 
    searching: true,
    columnDefs: [
      { width: '20%', targets: 0 }
    ],
    fixedColumns: true,
  });

  var table_cardbase = $('#dt_terminal_crm').DataTable({
    iDisplayLength:100,
    paging: true, 
    info: true, 
    searching: true,
    // scrollY:        "350px",
    // scrollX:        true,
  });

  var table = $('#dt_terminal_log').DataTable({
      iDisplayLength:100,
      paging: true, 
      info: true, 
      searching: true,
      // scrollY:        "350px",
  });

  $('#dt_terminal_log tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = table.row( tr );
    var html = '';
    var arr_offline = [];
    var arr_inservice = [];
    var datetime_offline = '';
    var datetime_inservice = '';
    var value_duration = '';
    v_global_1 = '';
    v_global_2 = '';

    if ( row.child.isShown() ) {
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
                 
        var v_terminal_id = $(this).attr("title");                      
        var v_url = baseURL + "log/ajax_get_history_offline/" + v_terminal_id; 
        $.ajax({
            url : v_url,
            type: "GET",
            async: false,
            dataType: "JSON",
            success: function(result)
            {            
                $.each(result, function (i, item) {  
                  v_global_1 += '<tr><td>'+item.event_id+'</td><td>'+item.date_time+'</td><td ' + (item.description_event == 'The ATM changed mode from In Service to Off-Line. ' ? 'style="color:red;font-weight:bold"' : (item.description_event == 'The ATM changed mode from Closed to In Service. ' ? 'style="color:green;font-weight:bold"' : '')) + '>'+item.description_event+'</td></tr>' ;
                });
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });      
        row.child( format(row.data()) ).show();
        tr.addClass('shown');
    }
  });

  $('#dt_bottom_5_crm_7_days').DataTable({
    iDisplayLength:5,
    paging: true, 
    info: true, 
    searching: true,
    ordering: false
    // scrollY:        "350px",
  });


  $('#dt_top_5_crm_7_days').DataTable({
    iDisplayLength:5,
    paging: true, 
    info: true, 
    searching: true,
    ordering: false
    // scrollY:        "350px",
  });

  var table_crm = $('#dt_terminal_log_crm').DataTable({
    iDisplayLength:100,
    paging: true, 
    info: true, 
    searching: true,
});

$('#dt_terminal_log_crm tbody').on('click', 'td.details-control', function () {
  var tr = $(this).closest('tr');
  var row = table_crm.row( tr );
  var html = '';
  var arr_offline = [];
  var arr_inservice = [];
  var datetime_offline = '';
  var datetime_inservice = '';
  var value_duration = '';
  v_global_1 = '';
  v_global_2 = '';

  if ( row.child.isShown() ) {
      row.child.hide();
      tr.removeClass('shown');
  }
  else {
               
      var v_terminal_id = $(this).attr("title");                      
      var v_url = baseURL + "log/ajax_get_history_offline_crm/" + v_terminal_id; 
      $.ajax({
          url : v_url,
          type: "GET",
          async: false,
          dataType: "JSON",
          success: function(result)
          {            
              $.each(result, function (i, item) {  
                v_global_1 += '<tr><td>'+item.event_id+'</td><td>'+item.date_time+'</td><td ' + (item.description_event == 'The ATM changed mode from In Service to Off-Line. ' ? 'style="color:red;font-weight:bold"' : (item.description_event == 'The ATM changed mode from Closed to In Service. ' ? 'style="color:green;font-weight:bold"' : '')) + '>'+item.description_event+'</td></tr>' ;
              });
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error get data from ajax');
          }
      });      
      row.child( format(row.data()) ).show();
      tr.addClass('shown');
  }
});

// $("#modal_form_change_password").on('hide.bs.modal', function(){
//   alert("Hello World!");
// });

});