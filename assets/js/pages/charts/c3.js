function processMyJsonTrantype(json_tran_type) {
    var chart_line_tran_type = c3.generate({
        bindto: '#chart-tran-type', // id of chart wrapper   
        data: {
            json: json_tran_type,
            keys: {
                //                x: 'name', // it's possible to specify 'x' when category axis
                value: ['withdrawal', 'balance_inquiry', 'transfer'],
            },
            type: 'pie',
            colors: {
                'withdrawal': Aero.colors["lime"],
                'balance_inquiry': Aero.colors["teal"],
                'transfer': Aero.colors["gray"],
            },
            names: {
                // name of each serie
                'withdrawal': 'Cash Withdrawal',
                'balance_inquiry': 'Balance Inquiry',
                'transfer': 'Transfer',
            }
        },
        axis: {
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


function processMyJsonWeekly(json_weekly) {
    var chart_line_trx_weekly = c3.generate({
        bindto: '#chart-trx-weekly', // id of chart wrapper   
        data: {
            json: json_weekly,
            keys: {
                //                x: 'name', // it's possible to specify 'x' when category axis
                value: ['jml_trx'],
            },
            labels: { format: d3.format(",.0f") },
            type: 'line',
            colors: {
                'jml_trx': Aero.colors["pink"],
            },
            names: {
                'jml_trx': 'Weekly Transactions',
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
                categories: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
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

function processMyJson(json) {
    var chart = c3.generate({
        bindto: '#chart-bar', // id of chart wrapper
        data: {
            json: json,
            keys: {
                //                x: 'name', // it's possible to specify 'x' when category axis
                value: ['total_amount', 'total_acq_fee', 'ben_fee'],
            },
            type: 'bar',
            colors: {
                'total_amount': Aero.colors["pink"],
                'total_acq_fee': Aero.colors["cyan"],
                'ben_fee': Aero.colors["blue-dark"]
            },
            names: {
                'total_amount': 'Transfer',
                'total_acq_fee': 'Withdrawal',
                'ben_fee': 'Balance Inquiry'
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
                categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni']
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

    var chart_line = c3.generate({
        bindto: '#chart-employment', // id of chart wrapper   
        data: {
            json: json,
            keys: {
                //                x: 'name', // it's possible to specify 'x' when category axis
                value: ['total_amount', 'total_acq_fee', 'ben_fee'],
            },
            labels: { format: d3.format(",.0f") },
            type: 'line',
            colors: {
                'total_amount': Aero.colors["pink"],
                'total_acq_fee': Aero.colors["cyan"],
                'ben_fee': Aero.colors["blue-dark"]
            },
            names: {
                'total_amount': 'Transfer',
                'total_acq_fee': 'Withdrawal',
                'ben_fee': 'Balance Inquiry'
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
                categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni']
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
                'jml_trx': Aero.colors["blue-dark"],
            },
            names: {
                'jml_trx': 'Count Transactions',
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
                categories: fruits//['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni']
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

function get_data_summary_trx_weekly() {
    var url_weekly = baseURL + "chart/getsummary/ajax_get_summary_trx_weekly";
    $.getJSON(url_weekly)
        .done(function (data_weekly) {
            processMyJsonWeekly(data_weekly);
        })
        .fail(function (jqxhr, textStatus, error) {
            //var err = textStatus + ", " + error;
            alert("Request Failed 22: ");
        });
}

function get_data_tran_type() {
    var url_tran_type = baseURL + "chart/getsummary/ajax_get_summary_tran_type";
    $.getJSON(url_tran_type)
        .done(function (data_tran_type) {
            processMyJsonTrantype(data_tran_type);
        })
        .fail(function (jqxhr, textStatus, error) {
            //var err = textStatus + ", " + error;
            alert("Request Failed 331: ");
        });
}

function get_data_summary_trx() {
    var url = baseURL + "chart/getsummary/ajax_get_summary_trx";
    $.getJSON(url)
        .done(function (data) {
            processMyJson(data);
        })
        .fail(function (jqxhr, textStatus, error) {
            //   var err = textStatus + ", " + error;
            alert("Request Failed 11: ");
        });




}


// $(document).ready(function(){
//     //get_data_summary_trx();
//     //get_data_summary_trx_weekly();
//     //get_data_tran_type();
// });

$(document).ready(function () {
    get_data_summary_trx();
    get_data_summary_trx_weekly();
    get_data_tran_type();
    var chart = c3.generate({
        bindto: '#chart-donut', // id of chart wrapper
        data: {
            columns: [
                // each columns data
                ['data1', 43],
                ['data2', 37],
                ['data3', 20]
            ],
            type: 'donut', // default type of chart
            colors: {
                'data1': Aero.colors["blue"],
                'data2': Aero.colors["cyan"],
                'data3': Aero.colors["orange"]
            },
            names: {
                // name of each serie
                'data1': 'Transfer',
                'data2': 'Withdrawal',
                'data3': 'Balance Inquiry'
            }
        },
        axis: {
        },
        legend: {
            show: true, //hide legend
        },
        padding: {
            bottom: 0,
            top: 0
        },
    });
});


        // $(document).ready(function(){
        //     var chart = c3.generate({
        //         bindto: '#chart-employment', // id of chart wrapper   
        //         data: {
        //             columns: [
        //                 // each columns data
        //                 ['data1', 2, 8, 6, 7, 14, 11],
        //                 ['data2', 5, 15, 11, 15, 21, 25],
        //                 ['data3', 17, 18, 21, 20, 30, 29]
        //             ],
        //             type: 'line', // default type of chart
        //             colors: {
        //                 'data1': Aero.colors["cyan"],
        //                 'data2': Aero.colors["blue"],
        //                 'data3': Aero.colors["green"]
        //             },
        //             names: {
        //                 // name of each serie
        //                 'data1': 'Development',
        //                 'data2': 'Marketing',
        //                 'data3': 'Sales'
        //             }
        //         },
        //         axis: {
        //             x: {
        //                 type: 'category',
        //                 // name of each category
        //                 categories: ['2013', '2014', '2015', '2016', '2019', '2018']
        //             },
        //         },
        //         legend: {
        //             show: true, //hide legend
        //         },
        //         padding: {
        //             bottom: 0,
        //             top: 0
        //         },
        //     });


        // });
