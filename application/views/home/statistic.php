<section class="content">
    <?php $this->load->view($header_view); ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card widget_2 big_icon alltrx">
                    <div class="body">
                        <h6>Transaction</h6>
                        <h2>20</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card widget_2 big_icon average">
                    <div class="body">
                        <h6>Average</h6>
                        <h2>16</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card widget_2 big_icon successrate">
                    <div class="body">
                        <h6>Success Rate</h6>
                        <h2>100%</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card widget_2 big_icon decrate">
                    <div class="body">
                        <h6>Decline Rate</h6>
                        <h2>0%</h2>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">

                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>From Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="test123"><i class="zmdi zmdi-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control datepicker" name="" id="from_date_statistic">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>To Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="test123"><i class="zmdi zmdi-calendar"></i></span>
                                        </div>
                                        <input type="text" class="form-control datepicker" name="" id="to_date_statistic">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <button id="btn_submit_statistic" type="button" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Last 20 days</strong> Transactions</h2>
                    </div>
                    <div class="body">
                        <div id="chart-trx-trend" class="c3_chart"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Weekly</strong> Transaction Volume</h2>
                    </div>
                    <div class="body">
                        <div id="chart-trx-weekly" class="c3_chart"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Transaction</strong> Type</h2>
                    </div>
                    <div class="body">
                        <div id="chart-tran-type" class="c3_chart"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Top 5</strong> CRM By Volume (Last 7 days)</h2>
                    </div>
                    <div class="body" style="min-height:400px;max-height:400px;overflow:auto">

                        <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif;width:100%">
                            <!-- <table class="table table-bordered table-striped table-hover nowrap" id="dt_top_5_crm_7_days" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Province</th>
                                        <th>Location Name</th>
                                        <th>Area</th>
                                        <th>#of Transactions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table> -->
                            <?= !empty($table_top5_crm_7days) ? $table_top5_crm_7days : ''; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Bottom 5</strong> CRM By Volume (Last 7 days)</h2>
                    </div>
                    <div class="body" style="min-height:400px;max-height:400px;overflow:auto">
                        <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif;width:100%">
                            <?= !empty($table_bottom_5_crm_trx) ? $table_bottom_5_crm_trx : ''; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Top 5</strong> Issuer Bank</h2>
                    </div>
                    <div class="body" style="min-height:400px;max-height:400px;overflow:auto">
                        <div class="mb-3">
                            <label><strong>Transaction Type</strong></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="test123"><i class="zmdi zmdi-badge-check"></i></span>
                                </div>
                                <select class="form-control show-tick ms select2" id="select_tran_type" data-placeholder="Select">
                                    <option></option>
                                    <option value="01">Withdrawal</option>
                                    <option value="31">Balance Inquiry</option>
                                    <option value="50">Transfer</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif;width:100%">
                            <table class="table table-bordered table-striped table-hover nowrap" id="dt_top_5_bank" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bank</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>