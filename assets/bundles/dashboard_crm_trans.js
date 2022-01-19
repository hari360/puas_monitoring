var v_global_1 = '';
var v_global_2 = '';

function format() {
    // alert(v_global_1);
  return '<table border="1" width="100%" >' +
              '<tr style="background-color:#DCDCDC;color:black;">' +
                  '<th style="width:50px;padding-left:10px;font-weight:bold" >Tran Type</th>' +
                  '<th style="width:300px;padding-left:10px;font-weight:bold" >Count</th>' +
                //   '<th style="width:800px;padding-left:10px;font-weight:bold" >Description</th>' +
              '</tr>' +               
            v_global_1 +
          '</table>';       
}

function get_data_summary_trx_crm() {
    var url = baseURL + "chart/getsummary/ajax_get_summary_tran_type";
    $.getJSON(url)
        .done(function (data) {
            processMyJson(data);
        })
        .fail(function (jqxhr, textStatus, error) {
            //   var err = textStatus + ", " + error;
            alert("Request Failed 11: ");
        });
}

function processMyJson(json) {
    var chart = c3.generate({
        bindto: '#chart-trx-sum-crm', // id of chart wrapper
        size: {
            height: 340,
            width: 580
        },
        // grid: {
        //     x: {
        //         show: true
        //     },
        //     y: {
        //         show: true
        //     }
        // },
        data: {
            json: json,
            // json: [{
            //     bank: 'BTN',
            //     wdl: 200,
            //     inqury: 200,
            //     ibft: 400
            // }, {
            //     bank: 'Mandiri',
            //     wdl: 100,
            //     inqury: 700,
            //     ibft: 800
            // }, {
            //     bank: 'BCA',
            //     wdl: 200,
            //     inqury: 500,
            //     ibft: 900
            // }, {
            //     bank: 'BNI',
            //     wdl: 1200,
            //     inqury: 1200,
            //     ibft: 1400
            // }],
            keys: {
                x: 'bank',
                value: ['withdrawal', 'balance_inq','transfer']
            },
            type: 'bar'
        },
        bar: {
            width: {
                ratio: 0.5 // this makes bar width 50% of length between ticks
            }
            // or
            //width: 100 // this makes bar width 100px
        },
        tooltip: {
            format: {
                value: function (value) {
                    return d3.format(",.0f")(value)
                }
            }
        },
        axis: {
            x: {
                type: 'category',
                categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni']
            },
            y: {
                tick: {
                    format: d3.format(",.0f")
                    //                format: function (d) { return "$" + d; }
                }
            },
        },
        // bar: {
        //     width: 20
        // },
        legend: {
            show: true, //hide legend
        },
        padding: {
            bottom: 0,
            top: 0
        },
    });

    // var chart_line = c3.generate({
    //     bindto: '#chart-employment', // id of chart wrapper   
    //     data: {
    //         json: json,
    //         keys: {
    //             //                x: 'name', // it's possible to specify 'x' when category axis
    //             value: ['total_amount', 'total_acq_fee', 'ben_fee'],
    //         },
    //         labels: { format: d3.format(",.0f") },
    //         type: 'line',
    //         colors: {
    //             'total_amount': Aero.colors["pink"],
    //             'total_acq_fee': Aero.colors["cyan"],
    //             'ben_fee': Aero.colors["blue-dark"]
    //         },
    //         names: {
    //             'total_amount': 'Transfer',
    //             'total_acq_fee': 'Withdrawal',
    //             'ben_fee': 'Balance Inquiry'
    //         }
    //     },
    //     tooltip: {
    //         format: {
    //             value: function (value) {
    //                 return d3.format(",.0f")(value)
    //             }
    //         }
    //     },
    //     axis: {
    //         x: {
    //             type: 'category',
    //             categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni']
    //         },
    //         y: {
    //             tick: {
    //                 format: d3.format(",.0f")
    //                 //                format: function (d) { return "$" + d; }
    //             }
    //         },
    //     },
    //     bar: {
    //         width: 20
    //     },
    //     legend: {
    //         show: true, //hide legend
    //     },
    //     padding: {
    //         bottom: 0,
    //         top: 0
    //     },
    // });

    const fruits = [];
    $.each(json, function (index, element) {
        fruits.push(element.bsn_date);
    });

    // const fruits = ['20210628',
    //     '20210629',
    //     '20210630',
    //     '20210701',
    //     '20210702',
    //     '20210703',
    //     '20210704'];
    // fruits.push("Juli");

    // var chart_line_trx_trend = c3.generate({
    //     bindto: '#chart-trx-trend', // id of chart wrapper   
    //     data: {
    //         json: json,
    //         keys: {
    //             //                x: 'name', // it's possible to specify 'x' when category axis
    //             value: ['jml_trx'],
    //         },
    //         labels: { format: d3.format(",.0f") },
    //         type: 'line',
    //         colors: {
    //             'jml_trx': Aero.colors["blue-dark"],
    //         },
    //         names: {
    //             'jml_trx': 'Count Transactions',
    //         }
    //     },
    //     tooltip: {
    //         format: {
    //             value: function (value) {
    //                 return d3.format(",.0f")(value)
    //             }
    //         }
    //     },
    //     axis: {
    //         x: {
    //             type: 'category',
    //             categories: fruits//['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni']
    //         },
    //         y: {
    //             tick: {
    //                 format: d3.format(",.0f")
    //                 //                format: function (d) { return "$" + d; }
    //             }
    //         },
    //     },
    //     bar: {
    //         width: 20
    //     },
    //     legend: {
    //         show: true, //hide legend
    //     },
    //     padding: {
    //         bottom: 0,
    //         top: 0
    //     },
    // });
}

$('.div_package').click(function(){
    // alert($(this).css('background-color'));
    if($(this).css('background-color') == 'rgb(26, 195, 105)'){
        // alert($(this).find('h2').attr('data-value')+"|");
        $(this).css('background-color', '#FFFFFF');
        $("#id_req_package").val().replace($(this).find('h2').attr('data-value')+"|","test");
        $("#id_req_package").val($("#id_req_package").val().replace($(this).find('h2').attr('data-value')+"|",""));
        //alert(v_text_cart);

    }else{
        // alert($(this).find('h2').attr('data-value'));
        $(this).css('background-color', '#1AC369');
        $("#id_req_package").val($("#id_req_package").val()+$(this).find('h2').attr('data-value')+"|");
    }
    
});

$(function () {
    get_data_summary_trx_crm();
    
    $('#dt_summary_crm_bank tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table_summary_crm_bank.row( tr );
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
                     
            var v_bank = $(this).attr("title");   
            //alert(v_bank);                   
            var v_url = baseURL + "postilion/ajaxcontroller/get_detail_summary_crm_bank/" + v_bank; 
            $.ajax({
                url : v_url,
                type: "GET",
                async: false,
                dataType: "JSON",
                success: function(result)
                {            
                    $.each(result, function (i, item) {  
                        // alert(item.tran_type);
                      v_global_1 += '<tr><td>'+item.tran_type+'</td><td>'+item.count_txn+'</td></tr>' ;
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

    var url;
    url = baseURL + "postilion/ajaxcontroller/get_detail_trx_crm";

    var table_tran_crm = $('#dt_trx_crm').DataTable({
        iDisplayLength: 100,
        processing: true,
        // serverSide: true,
        searching: true,
        ajax: {
            url: url,
            data: {
                // terminal_name : function() {return $('#terminal_batch').val()},
                batch_nr: function () { return 2310 }
            },
            type: 'GET'
        },
        language: {
            // "processing": "Loading. Please wait..."
            "processing": '<div class="loader"><div class="m-t-30"><img class="zmdi-hc-spin" src="' + baseURL + 'assets/images/loader.svg" width="48" height="48" alt="Aero"></div><p>Processing...</p></div>'

        },
    });

    var url_summary;
    url_summary = baseURL + "postilion/ajaxcontroller/get_summary_trx_crm";

    var groupColumn = 0;
    var table = $('#dt_summary_crm').DataTable({
        processing: true,
        // serverSide: true,
        searching: true,
        ajax: {
            url: url_summary,
            data: {
                // terminal_name : function() {return $('#terminal_batch').val()},
                batch_nr: function () { return 2309 }
            },
            type: 'GET'
        },
        language: {
            // "processing": "Loading. Please wait..."
            "processing": '<div class="loader"><div class="m-t-30"><img class="zmdi-hc-spin" src="' + baseURL + 'assets/images/loader.svg" width="48" height="48" alt="Aero"></div><p>Processing...</p></div>'

        },
        "columnDefs": [
            { "visible": false, "targets": groupColumn }
        ],
        // "order": [[groupColumn, 'asc']],
        "displayLength": 10,
        "drawCallback": function (settings) {
            var api = this.api();
            var rows = api.rows({ page: 'current' }).nodes();
            var last = null;

            api.column(groupColumn, { page: 'current' }).data().each(function (group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                        '<tr class="group"><td colspan="4">' + group + '</td></tr>'
                    );

                    last = group;
                }
            });
        }
    });


    // var url_summary_bank;
    // url_summary_bank = baseURL + "postilion/ajaxcontroller/get_summary_trx_crm_bank";

    // var groupColumn = 0;
    // var table = $('#dt_summary_crm').DataTable({
    //     processing: true,
    //     // serverSide: true,
    //     searching: true,
    //     ajax: {
    //         url: url_summary,
    //         data: {
    //             // terminal_name : function() {return $('#terminal_batch').val()},
    //             batch_nr: function () { return 2309 }
    //         },
    //         type: 'GET'
    //     },
    //     language: {
    //         // "processing": "Loading. Please wait..."
    //         "processing": '<div class="loader"><div class="m-t-30"><img class="zmdi-hc-spin" src="' + baseURL + 'assets/images/loader.svg" width="48" height="48" alt="Aero"></div><p>Processing...</p></div>'

    //     },
    //     "columnDefs": [
    //         { "visible": false, "targets": groupColumn }
    //     ],
    //     "order": [[groupColumn, 'asc']],
    //     "displayLength": 10,
    //     "drawCallback": function (settings) {
    //         var api = this.api();
    //         var rows = api.rows({ page: 'current' }).nodes();
    //         var last = null;

    //         api.column(groupColumn, { page: 'current' }).data().each(function (group, i) {
    //             if (last !== group) {
    //                 $(rows).eq(i).before(
    //                     '<tr class="group"><td colspan="4">' + group + '</td></tr>'
    //                 );

    //                 last = group;
    //             }
    //         });
    //     }
    // });

    var url_summary_bank;
    url_summary_bank = baseURL + "postilion/ajaxcontroller/get_summary_trx_crm_bank";

    var table_summary_crm_bank = $('#dt_summary_crm_bank').DataTable({
        "columnDefs": [
            { "width": "15px", "targets": 0 },
            { "width": "100px", "targets": 1 },
            { "width": "50px", "targets": 2 },
          ],
        // fixedColumns: true,
        iDisplayLength:100,
        processing: true,
        "order": [[ 2, "desc" ]],
        // serverSide: true,
        searching: true,
        ajax: {
            url : url_summary_bank,
            data: {
                // terminal_name : function() {return $('#terminal_batch').val()},
                batch_nr : function() {return 2309}
            },
            type : 'GET'
        },
        createdRow: function (row, data, rowIndex) {
            $.each($('td', row), function (colIndex) {
                $(this).attr('title', data.issuer_name);
                              });
                            },
        language: {
            // "processing": "Loading. Please wait..."
            "processing": '<div class="loader"><div class="m-t-30"><img class="zmdi-hc-spin" src="'+baseURL+'assets/images/loader.svg" width="48" height="48" alt="Aero"></div><p>Processing...</p></div>'

        },
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": '',
            },
            { "data": "issuer_name" },
            { "data": "count_txn" },
            // { "data": "office" },
            // { "data": "salary" }
        ],
        
    });

});