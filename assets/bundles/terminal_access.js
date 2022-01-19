var v_global_1 = '';
var v_global_2 = '';
var gPrm1 = '';
var gPrm2 = ''; 

$('#cAddUserTerm').on('change', function() {
  //alert(this.value);
  $("#txt_user_id").val(this.value);
});

$('#btn_add_terminal_access').click(function(){
  // $('#cAddUserTerm').css('display','block');
  $('#loader_process_edit').hide();
  $('#cmbSelect2').show();
  $('#txt_user_id').hide();
  $("#txt_full_name").val("");
  $('#optgroup').multiSelect('deselect_all');
  $('#v_title_accounts').html('Add User Access Terminal');
  $('#modal_edit_term_access').modal('show');
});


function get_access_terminal_user(json){
  const fruits = [];
  // fruits.push("6");
    $.each(json, function(index, element) {	
      // alert(element.user_name);
      // if(element.terminal_id!=null){
        fruits.push((element.terminal_id).toString());	
        // alert(element.page_controller);
      // }
    });

  // $('#optgroup').multiSelect('select', (['Dashboard', 'Generate Report ISO']));
  
  
  
  // console.log(fruits);
  $('#optgroup').multiSelect('select', fruits);
  // $('#optgroup').multiSelect('select', (['1', '2']));
  $('#loader_process_edit').hide();
  // alert(fruits);
  
}


function format() {
  return '<table border="1" >' +
              '<tr style="background-color:#DCDCDC;color:black;">' +
                  '<th style="width:50px;padding-left:10px;font-weight:bold" >Terminal ID</th>' +
                  '<th style="width:300px;padding-left:10px;font-weight:bold" >Terminal Name</th>' +
                  '<th style="width:800px;padding-left:10px;font-weight:bold" >Location</th>' +
              '</tr>' +               
              v_global_1 +
          '</table>';       
}

function delete_terminal_access(value_this,prm1,prm2)
{
    gPrm1 = prm1;
    gPrm2 = prm2;
    value_this = "Are You Sure To Delete This :"; 
    $('#modal_delete_term_access').modal('show'); 
    $('#confirm_delete').text(value_this + " (" + prm1 + " - " + prm2 + ")"); // Set Title to Bootstrap modal title
}

function delete_terminal_id_access()
{
  var url = baseURL + "postilion/ajaxcontroller/ajax_delete_access_terminal";
  var data_post = $.param({ ajaxUserID:gPrm1, ajaxTerminalID:gPrm2});
    $.ajax({
                    url : url,
                    type: "POST",
                    data: data_post,
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

$(".edit-terminal-access").click(function () {
  $('#optgroup').multiSelect('deselect_all');
  $('#loader_process_edit').show();
  var textval = [];
  $(this).closest('tr').find('td').each(function () {
    textval.push($(this).text()); // this will be the text of each <td>
    // alert(textval);
  });

  $('#txt_user_id').show();
  $('#cmbSelect2').hide();
  // $('#cAddUserTerm').css('display','none');
  $("#txt_user_id").val(textval[1]);
  $("#txt_full_name").val(textval[2]);
  // $("#txt_prefix_atm").val(textval[3]);


  var url = baseURL + "postilion/ajaxcontroller/get_data_user_terminal";
      var datapost = {
          user_id: textval[1]
      };

      $.getJSON( url, datapost )
          .done(function( data ) {
            get_access_terminal_user(data);
          })
          .fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ", " + error;
            alert( "Request Failed : " + err );
      });


  $('#v_title_accounts').html('Edit User Access Terminal');
  $('#modal_edit_term_access').modal('show');
  // $('#loader_process').hide();
});


function update_terminal_user() {

  let splashArray = [];
  $(".ms-selection li.ms-selected span").each(function () {                  

    var str = $(this).html();
    var res = str.split("-");
    splashArray.push(res[0]);
  });

  var foo = $('#optgroup').val(); 

  sTerm = foo;
  var url;
  var $form = $('form_terminal_access');
  var data = {
    'foo': 'bar'
  };

  url = baseURL + "accounts/terminalaccess/update_terminal_access";

  sUserId = $("#txt_user_id").val();

  data = $form.serialize() + '&' + $.param({
    ajaxUserId: sUserId,ajaxListterm: sTerm
  });
  $.ajax({
    url: url,
    type: "POST",
    data: data,
    dataType: "JSON",
    success: function (data) {
      $('#modal_edit_term_access').modal('hide');
        location.reload();      
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert('Error adding / update data account');
    }
  });
}

$(function() {
    var table_terminal_access = $('#dt_terminal_access').DataTable({
        iDisplayLength:100,
        paging: true, 
        info: true, 
        searching: true,
    });
  
    $('#dt_terminal_access tbody').on('click', 'td.details-control', function () {
      
      var tr = $(this).closest('tr');
      var row = table_terminal_access.row( tr );
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
                   
          var v_user_id = $(this).attr("title");  
          var v_prefix = $(this).attr('data-prefix');     
          
          var data_post = $.param({ ajaxUserID:v_user_id, ajaxTerminalID:v_prefix});                 
          var v_url = baseURL + "postilion/ajaxcontroller/get_terminal_access/"; 
          $.ajax({
              url : v_url,
              type: "POST",
              data: data_post,
              async: false,
              dataType: "JSON",
              success: function(result)
              {            
                  $.each(result, function (i, item) {  
                    v_global_1 += '<tr><td>'+item.terminal_id+'</td><td>'+item.terminal_name+'</td><td>'+item.terminal_city+'</td></tr>' ;
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
});