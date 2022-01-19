var str = $(location).attr('href');
var last = str.split('/').pop();
$(function() {
  $('#loader_process').hide();
  // alert($(location).attr('href'));
  
  //alert(last);
  //if(last=="manageaccounts"){
    if(last!="setup"){

      var url = baseURL + "postilion/ajaxcontroller/get_data_register";
      var datapost = {
          user_id: last
      };

      $.getJSON( url, datapost )
          .done(function( data ) {
            $.each(data, function(index, element) {	
              //alert(element.full_name);
                $("#txt_full_name").val(element.full_name);
                $("#txt_user_id").val(element.user_name);
                $("#txt_gender").val(element.gender);
                $("#txt_email").val(element.email);
                $('#cActive').val(element.status_active).change();
                $('#cLock').val(element.status_lock).change();
                $('#cRole').val(element.user_right).change();
              });
          })
          .fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ", " + error;
            alert( "Request Failed 127: " + err );
      });

      $('#v_title_accounts').html('Edit Accounts');
      $('#modal_edit_accounts').modal('show');
    }

    
    // $('.optgroup option[value=Dashboard]').attr('selected','selected');
  //}
});

var table_card_retain = $('#dt_manage_accounts').DataTable({
  iDisplayLength: 100,
  paging: true,
  info: true,
  searching: true,
  columnDefs: [
    { width: 100, targets: 9 }
  ],
  // fixedColumns: true,
  // scrollY:        "350px",
});

$("#test_btn").click(function () {
  
  // $("#optgroup option[value='Dashboard']").remove();
  // $('#optgroup').append('<optgroup label="Menu2"><option value="1">One</option></optgroup>');
  // $('#optgroup').multiSelect({ selectableOptgroup: true });
  // $('#optgroup').multiSelect('select_all');
  // $('#optgroup').multiSelect('deselect_all');
  // $('#optgroup').multiSelect('deselect', (['Dashboard', 'Generate Report ISO']));
  // $('#optgroup').multiSelect('select', (['Dashboard', 'Generate Report ISO']));
  // alert('test11');
  // $("#optgroup").val("Dashboard").change();
});

$("#btnSaveTerminalAccess").click(function () {
  // alert('test');
  
  // var splashArray = new Array();
  var splashArray = [];
  $(".ms-selection li.ms-selected span").each(function () {                  
    //  var imageURI = $(this).html(); 
    //  splashArray.push($(this).html());
    //  alert(imageURI);
    var str = $(this).html();
    var res = str.split("-");
     splashArray.push(res[0]);
  });

  //  alert(splashArray);

 $('#modal_edit_access_terminal').modal('hide');
  waitingDialog.show('update terminal access...', {
    // headerText: '',
    dialogSize: 'sm',
    progressType: 'success'
  });
  // alert(gPrm1 + " - " + gPrm2);
  var url = baseURL + "postilion/ajaxcontroller/ajax_update_terminal_access";
  // alert(url);
  // var url = "<?php echo site_url('postilion/ajax_delete_terminal_parameterize')?>";
  var data_post = $.param({ ajaxTerminalID: splashArray });
  $.ajax({
    url: url,
    type: "POST",
    data: data_post,
    success: function (datax) {
      if (datax == "Success") {
        location.reload();
      }
      else {
        alert('test1234');
        $('#signupalertdeleteprm').css('display', 'block');
      }
    }
  });

});

$(".edit-accounts").click(function () {
  var textval = [];
  $(this).closest('tr').find('td').each(function () {
    textval.push($(this).text()); // this will be the text of each <td>
    // alert(textval);
  });
  // alert(textval[4]);
  $("#txt_full_name").val(textval[1]);
  $("#txt_user_id").val(textval[0]);

  $("#txt_gender").val(textval[2]);
  $("#txt_email").val(textval[3]);

  $('#cActive').val((textval[4] == "Non Active" ? "0" : "1")).change();

  $('#cLock').val(textval[7]).change();
  let v_role_user = "";
  if(textval[8] == "Administrator") v_role_user = "1"
  if(textval[8] == "Supervisor") v_role_user = "2"
  if(textval[8] == "User") v_role_user = "3"

  $('#cRole').val(v_role_user).change();

  var url = baseURL + "postilion/ajaxcontroller/get_data_menu";
      var datapost = {
          user_id: textval[0]
      };

      $.getJSON( url, datapost )
          .done(function( data ) {
            //$.each(data, function(index, element) {	
              get_access_menu_user(data);
              
              //alert(element.full_name);
                // $("#txt_full_name").val(element.full_name);
                // $("#txt_user_id").val(element.user_name);
                // $("#txt_gender").val(element.gender);
                // $("#txt_email").val(element.email);
                // $('#cActive').val(element.status).change();
                // $('#cLock').val(element.status_lock).change();
              //});
          })
          .fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ", " + error;
            alert( "Request Failed 1234: " + err );
      });


  $('#v_title_accounts').html('Edit Accounts');
  $('#modal_edit_accounts').modal('show');
  $('#loader_process').show();
});

function get_access_menu_user(json){
  const fruits = [];
  // fruits.push("6");
    $.each(json, function(index, element) {	
      // alert(element.user_name);
      if(element.user_name!=null){
        fruits.push((element.no).toString());	
        // alert(element.page_controller);
      }
    });

  // $('#optgroup').multiSelect('select', (['Dashboard', 'Generate Report ISO']));
  // alert(fruits);
  
  // console.log(fruits);
  $('#optgroup').multiSelect('select', fruits);
  // $('#optgroup').multiSelect('select', (['1', '2']));
  $('#loader_process').hide();
}

function get_data_accounts(terminal_id, prm1, prm2) {

  $(this).closest('tr').find('td').each(function () {
    var textval = $(this).text(); // this will be the text of each <td>
    alert(textval);
  });

  $('#v_title_accounts').html('Edit Accounts');
  $('#modal_edit_accounts').modal('show');

  // var term = $("#sTerminalId option:selected").val();
  // var v_term_id = term.split("-",0);

  // alert(v_term_id);

  // var url = baseURL + "postilion/ajaxcontroller/get_parameterize";
  // var datapost = {
  //     term_id: prm1
  // };

  // $.getJSON( url, datapost )
  //     .done(function( data ) {
  //       $.each(data, function(index, element) {	
  //         //  alert(element.atmi_problem);	
  //           $('#sTerminalId').val(element.terminal_id + "-" + element.terminal_name).change();
  //           $("#min_saldo").val(element.percentage);
  //           $("#date_from_parameterize").val(element.from_date);
  //           $("#to_from_parameterize").val(element.to_date);
  //           // $( "#v_progress" ).hide();
  //         });
  //     })
  //     .fail(function( jqxhr, textStatus, error ) {
  //       var err = textStatus + ", " + error;
  //       alert( "Request Failed: " + err );
  // });
}

$(".edit-terminal-access").click(function () {
  var textval = [];
  $(this).closest('tr').find('td').each(function () {
    textval.push($(this).text()); // this will be the text of each <td>
    // alert(textval);
  });
  // alert(textval[4]);
  $("#txt_user_id").val(textval[0]);


  $('#v_title_terminal_access').html('Edit Terminal Access');
  $('#modal_edit_access_terminal').modal('show');
});


function delete_terminal_access(value_this, prm1, prm2) {
  gPrm1 = prm1;
  gPrm2 = prm2;
  value_this = "Are You Sure Delete This Terminal Access  :";
  $('#signupalert').css('display', 'none');
  $('#modal_delete_terminal_access').modal('show');
  $('#confirm_delete_terminal_access').text(value_this + " (" + prm1 + " - " + prm2 + ")"); // Set Title to Bootstrap modal title
}

function delete_manage_accounts(value_this, prm1, prm2) {
  gPrm1 = prm1;
  gPrm2 = prm2;
  value_this = "Are You Sure Delete This Account :";
  $('#signupalert').css('display', 'none');
  $('#modal_delete_account').modal('show');
  $('#confirm_delete').text(value_this + " (" + prm1 + " - " + prm2 + ")"); // Set Title to Bootstrap modal title
}

function delete_account_id() {
  $('#modal_delete_account').modal('hide');
  waitingDialog.show('deleting account...', {
    // headerText: '',
    dialogSize: 'sm',
    progressType: 'success'
  });
  // alert(gPrm1 + " - " + gPrm2);
  var url = baseURL + "postilion/ajaxcontroller/ajax_delete_accounts";
  // alert(url);
  // var url = "<?php echo site_url('postilion/ajax_delete_terminal_parameterize')?>";
  var data_post = $.param({ ajaxUserID: gPrm1 });
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


function delete_access_terminal_id() {
  $('#modal_delete_terminal_access').modal('hide');
  waitingDialog.show('deleting terminal access...', {
    // headerText: '',
    dialogSize: 'sm',
    progressType: 'success'
  });
  // alert(gPrm1 + " - " + gPrm2);
  var url = baseURL + "postilion/ajaxcontroller/ajax_delete_access_terminal";
  // alert(url);
  // var url = "<?php echo site_url('postilion/ajax_delete_terminal_parameterize')?>";
  var data_post = $.param({ ajaxUserID: gPrm1, ajaxTerminalID: gPrm2 });
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
function save_account() {

  let splashArray = [];
  let splashArrayFix = [];
  $(".ms-selection li.ms-selected span").each(function () {                  
    //  var imageURI = $(this).html(); 
    //  splashArray.push($(this).html());
    //  alert(imageURI);
    var str = $(this).html();
    var res = str.split("-");
     splashArray.push(res[0]);
  });

  var foo = $('#optgroup').val(); 
  // splashArrayFix.push(foo);
  //alert(foo);
  //alert(splashArray);
  sMenu = foo;
  var url;
  var $form = $('form_accounts');
  var data = {
    'foo': 'bar'
  };


  url = baseURL + "postilion/ajaxcontroller/update_account";

  sUserId = $("#txt_user_id").val();
  sActive = $("#cActive option:selected").val();
  sLock   = $("#cLock option:selected").val();
  sRole   = $("#cRole option:selected").val();

  // alert(sTerminalId + sMinSaldo + sDateFrom + sDateTo);
  // return;
  data = $form.serialize() + '&' + $.param({
    ajaxActive: sActive, ajaxLock: sLock,
    ajaxRole: sRole, ajaxUserId: sUserId,
    ajaxListmenu: sMenu
  });
  $.ajax({
    url: url,
    type: "POST",
    data: data,
    dataType: "JSON",
    success: function (data) {
      $('#modal_edit_accounts').modal('hide');
      if(last!="setup"){
        $(location).attr('href', baseURL + "accounts/manageaccounts/setup");
      }else{
        location.reload();
      }
      
    },
    error: function (jqXHR, textStatus, errorThrown) {
      //how to catch error ajax post
      //alert(jqXHR.responseText);
      alert('Error adding / update data account');
    }
  });
}

