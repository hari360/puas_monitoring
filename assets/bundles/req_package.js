var gPrmFi = '';

$('#dt_list_package').DataTable({
    // iDisplayLength: 5,
    paging: true,
    info: true,
    searching: true,
    ordering: false,
    columnDefs: [
        { width: '1%', targets: 0 }
      ],
    // scrollY:        "350px",
});


function modal_req_package() {
    value_this = "Are You Sure Want To Request This Package ?";
    // $('#signupalert').css('display', 'none');
    $('#modal_req_package').modal('show');
    $('#confirm_req').text(value_this); // Set Title to Bootstrap modal title
}