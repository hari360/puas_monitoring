var y_axis = [];
var v_tran_type = "";

const monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];

// const d = new Date();
// document.write("The current month is " + monthNames[d.getMonth()]);


//single line
//var getDaysArray = function(s,e) {for(var a=[],d=new Date(s);d<=e;d.setDate(d.getDate()+1)){ a.push(new Date(d));}return a;};


//long line
var getDaysArray = function (start, end) {
    // for (var arr = [], dt = new Date(start); dt <= end; dt.setDate(dt.getDate() + 1)) {
        // arr.push(new Date(dt).toLocaleDateString());
    //     var get_day = new Date(dt).toLocaleDateString().split('/');
    //     arr.push(get_day[1] + ' ' + monthNames[new Date(dt).getMonth()]);
    // }
    // return arr;
    y_axis = []
    for (dt = new Date(start); dt <= end; dt.setDate(dt.getDate() + 1)) {
        // arr.push(new Date(dt).toLocaleDateString());
        var get_day = new Date(dt).toLocaleDateString().split('/');
        y_axis.push(get_day[1] + ' ' + monthNames[new Date(dt).getMonth()]);
    }
    return y_axis;
};

function parseDate(str) {
    var ymd = str.split('-');
    return new Date(ymd[0], ymd[1] - 1, ymd[2]);
}

function datediff(first, second) {
    return Math.round((second - first) / (1000 * 60 * 60 * 24));
}

function get_data_summary_trx_stat(from_date,to_date) {
    var url = baseURL + "chart/getsummary/ajax_get_summary_trx";
    var datapost = {
        v_from_date: from_date,
        v_to_date: to_date,
    };

    $.getJSON(url,datapost)
        .done(function (data) {
            processMyJsonStat(data);
        })
        .fail(function (jqxhr, textStatus, error) {
            var err = textStatus + ", " + error;
            alert("Request Failed 908: " + err);
        });
}

function processMyJsonStat(json) {
    var chart_line_trx_trend = c3.generate({
        bindto: '#chart-trx-trend', // id of chart wrapper   
        data: {
            json: json,
            keys: {
                //                x: 'name', // it's possible to specify 'x' when category axis
                value: ['jml_trx'],
            },
            labels: { format: d3.format(",.0f") },
            type: 'line',
            colors: {
                'total_amount': Aero.colors["blue-dark"],
            },
            names: {
                'total_amount': 'Count Transactions',
            }
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
                categories: y_axis//['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni']
            },
            y: {
                tick: {
                    format: d3.format(",.0f")
                    //                format: function (d) { return "$" + d; }
                }
            },
        },
        bar: {
            width: 20
        },
        legend: {
            show: true, //hide legend
        },
        padding: {
            bottom: 0,
            top: 0
        },
    });
}

// alert(datediff(parseDate(first.value), parseDate(second.value)));

// $('#select_tran_type').change(function () {
    // alert($(this).val());

// });

$('#btn_submit_statistic').click(function () {

    //     var currentDate = new Date(); //use your date here
    // alert(currentDate.toLocaleDateString('en-US'));


    //var daylist = getDaysArray(new Date("2021-06-30"),new Date("2021-07-05"));
    // var daylist = getDaysArray(new Date($('#from_date_statistic').val()), new Date($('#to_date_statistic').val()));
    // daylist.map((v)=>v).join("")
    // alert('es');
    // alert($('#from_date_statistic').val());
    // alert($('#to_date_statistic').val());

    // alert(datediff(parseDate($('#from_date_statistic').val()), parseDate($('#to_date_statistic').val())));
    //alert(daylist);
    let from_date = $('#from_date_statistic').val();
    let to_date = $('#to_date_statistic').val();
    // alert(from_date.replaceAll("-",""));
    getDaysArray(new Date($('#from_date_statistic').val()), new Date($('#to_date_statistic').val()));
    get_data_summary_trx_stat(from_date.replaceAll("-",""),to_date.replaceAll("-",""));
});


$(function () {

    // var table_tran_type = $('#dt_top_5_crm_7_days').DataTable({
    //     // iDisplayLength:100,
    //     paging: true,
    //     info: true,
    //     searching: true,
    // });

    var url;
    url = baseURL + "postilion/ajaxcontroller/get_top5_tran_type";
    // alert(url);

    var table_tran_type = $('#dt_top_5_bank').DataTable({
        iDisplayLength:50,
        processing: true,
        // serverSide: true,
        searching: true,
        ajax: {
            url : url,
            data: {
                // terminal_name : function() {return $('#terminal_batch').val()},
                trans_type : function() {return $('#select_tran_type').val()}
            },
            type : 'GET'
        },
        language: {
            // "processing": "Loading. Please wait..."
            "processing": '<div class="loader"><div class="m-t-30"><img class="zmdi-hc-spin" src="'+baseURL+'assets/images/loader.svg" width="48" height="48" alt="Aero"></div><p>Processing...</p></div>'
            
        },
    });

    $('#select_tran_type').change(function () {
        // alert($(this).val());
        table_tran_type.ajax.reload();
    });

    // $('#dt_top_5_crm_7_days').DataTable( {
    //     "scrollY":        "200px",
    //     "scrollCollapse": true,
    //     "paging":         false,
    //     "fixedHeader": true
    // } );

});