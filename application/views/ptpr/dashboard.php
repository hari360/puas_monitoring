<section class="content">
    <?php $this->load->view($header_view); ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12" style="margin-bottom: -30px;">
                <div class="card">
                    <div class="header">
                        <h2><strong>Bank Sponsor</strong> BTN</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card widget_2 big_icon alltrx">
                    <div class="body">
                        <h6>Approved</h6>
                        <h2><?= number_format($data_counter); ?> <small class="info">of <?= number_format($get_active_topup->limit);?> Trx</small></h2>
                        <small>Start from : <?= explode('.', $get_active_topup->date_rcs_approved)[0]; ?></small>
                        <div class="progress">
                            <div class="progress-bar.sm  <?php 
                                    if($data_counter>0){
                                        if(($data_counter/$get_active_topup->limit)*100 < 70){
                                            echo 'progress-bar-success';
                                        }else if(($data_counter/$get_active_topup->limit)*100 >= 100){
                                            echo 'progress-bar-danger';
                                        }else {
                                            echo 'progress-bar-warning';
                                        } 
                                    }else{
                                        echo 'progress-bar';
                                    }
                                    
                                    ?> " role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="<?= $get_active_topup->limit;?>" style="width: 
                                    <?php 
                                    if($data_counter>0){
                                        echo (number_format((float)($data_counter/$get_active_topup->limit)*100, 2, '.', '')).'%';
                                    }else{
                                        echo '0%';
                                    }
                                    
                                    
                                    ?>
                                    ;color:white;text-align: center">
                                    
                                    </div>
                                    <?php 
                                    if($data_counter>0){
                                        if(($data_counter/$get_active_topup->limit)*100 > 100){
                                            echo 'over limit';
                                        }else {
                                            echo (number_format((float)($data_counter/$get_active_topup->limit)*100, 2, '.', '')).'%';
                                        } 
                                    }
                                    ?>
                        </div>
                        <hr>
                        <table style="width: 100%;border:0px solid red">
                            <!-- <tr>
                                <td>Withdrawal</td>
                                <td style="text-align: right;"><?= number_format($withdrawal); ?></td>
                            </tr>
                            <tr>
                                <td>Balance Inquiry</td>
                                <td style="text-align: right;"><?= number_format($balance_inq); ?></td>
                            </tr>
                            <tr>
                                <td>IBFT</td>
                                <td style="text-align: right;"><?= number_format($transfer); ?></td>
                            </tr> -->
                            <!-- <tr>
                                <td>Deposit</td>
                                <td style="text-align: right;"><?= number_format($deposit); ?></td>
                            </tr>
                            <tr>
                                <td>Inquiry Deposit</td>
                                <td style="text-align: right;"><?= number_format($inq_deposit); ?></td>
                            </tr> -->

                        </table>
                    </div>
                </div>
            </div>

            <!-- <div class="col-lg-12 col-md-12" style="margin-bottom: -30px;">
                <div class="card">
                    <div class="header">
                        <h2><strong>Add Deposit</strong></h2>
                    </div>
                </div>
            </div> -->

            <div class="col-lg-9 col-md-9 col-sm-9">
                <div class="card widget_2 big_icon alltrx">
                    <div class="body">
                        <h6>Active Package : <?= $get_active_topup->invoice_no; ?></h6>

                        <hr>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 c_table">
                                <thead>
                                    <tr>
                                        <th>Kode Paket</th>
                                        <th data-breakpoints="xs">Limit</th>
                                        <th data-breakpoints="xs sm md">Date Request </th>
                                        <th data-breakpoints="xs">Date Finance Approved</th>
                                        <th data-breakpoints="xs">Date RCS Approved</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="border-top: 1px solid">
                                        <td><?= $get_active_topup->package_selected; ?></td>
                                        <td><?= number_format($get_active_topup->limit); ?></td>
                                        <td><?= explode('.', $get_active_topup->date_request)[0]; ?></td>
                                        <td><?= explode('.', $get_active_topup->date_fin_approved)[0]; ?></td>
                                        <td><?= explode('.', $get_active_topup->date_rcs_approved)[0]; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- <table style="width: 100%;border:0px solid red">
                            <tr style="border-bottom: 10px solid transparent;">
                                <td>Kode Paket</td>
                                <td>Limit</td>
                                <td>Date Request</td>
                                <td>Date Finance Approved</td>
                                <td>Date RCS Approved</td>
                            </tr>
                            <tr style="border-top: 1px solid">
                                <td><?= $get_active_topup->package_selected; ?></td>
                                <td>10,000</td>
                                <td><?= $get_active_topup->date_request; ?></td>
                                <td><?= $get_active_topup->date_fin_approved; ?></td>
                                <td><?= $get_active_topup->date_rcs_approved; ?></td>
                            </tr>

                        </table> -->
                        <!-- <div class="d-flex justify-content-between" style="margin-top: 20px;">
                            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#largeModal">Add Deposit</a> -->
                        <!-- <button type="button" class="btn btn-info waves-effect m-r-20" data-toggle="modal" data-target="#largeModal">MODAL - LARGE SIZE</button> -->
                        <!-- <a href="https://themeforest.net/item/arrowlite-responsive-admin-dashboard-template/23656497" class="btn btn-danger">Download Now</a> -->
                        <!-- </div> -->
                    </div>
                </div>
            </div>

            <!-- <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card widget_2 big_icon decrate">
                    <div class="body">
                        <h6>REJECTED</h6>
                        <h2>1200</h2>
                        <small>Start from : 2021-09-01 00:00</small>
                        <div class="progress">
                            <div class="progress-bar l-amber" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
                        </div>
                        <hr>
                        <table style="width: 100%;border:0px solid red">
                            <tr>
                                <td>Technical</td>
                                <td style="text-align: right;">6</td>
                            </tr>
                            <tr>
                                <td>Procedural</td>
                                <td style="text-align: right;">90</td>
                            </tr>
                            <tr>
                                <td>Customer</td>
                                <td style="text-align: right;">278</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card widget_2 big_icon email">
                    <div class="body">
                        <h6>Reversed</h6>
                        <h2>100</h2>
                        <small>Start from : 2021-09-01 00:00</small>
                        <div class="progress">
                            <div class="progress-bar l-amber" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
                        </div>
                        <hr>
                        <table style="width: 100%;border:0px solid red">
                            <tr>
                                <td>Partial</td>
                                <td style="text-align: right;">6</td>
                            </tr>
                            <tr>
                                <td>Full</td>
                                <td style="text-align: right;">90</td>
                            </tr>
                            <tr>
                                <td>Timeout</td>
                                <td style="text-align: right;">278</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div> -->

            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Detail Transactions</strong> </h2>
                    </div>
                    <ul class="nav nav-tabs pl-0 pr-0">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#view_details"><i class="zmdi zmdi-view-carousel"></i> Details </a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#view_summary"><i class="zmdi zmdi-view-dashboard"></i> Summary</a></li>
                        <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#view_statistic"><i class="zmdi zmdi-view-dashboard"></i> Statistic</a></li> -->
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="view_details">
                            <div class="body" style="min-height:1400px;max-height:400px;overflow:auto">
                                <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif;width:100%">
                                    <table class="table table-bordered table-striped table-hover nowrap" id="dt_trx_crm" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Terminal ID</th>
                                                <th>Terminal Name</th>
                                                <th>City</th>
                                                <th>Datetime</th>
                                                <th>Tran Type</th>
                                                <th>PAN</th>
                                                <th>Issuer</th>
                                                <th>Beneficiary</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane file_manager" id="view_summary">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="card">
                                        <div class="header">
                                            <h2><strong>ALL Transactions</strong></h2>
                                        </div>
                                        <div class="body" style="min-height:150px;max-height:400px;overflow:auto">
                                            <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif;width:100%">
                                                <table class="table table-bordered table-hover table_bank" id="dt_summary_crm_bank" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Issuer Name</th>
                                                            <th>Count</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="card">
                                        <div class="header">
                                            <h2><strong>Chart</strong> Transactions</h2>
                                        </div>
                                        <div class="body" style="min-height:200px;max-height:400px;overflow:auto">
                                            <div id="chart-trx-sum-crm" class="c3_chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <p></p>
                            <hr style="border: 1px solid;">
                            <div class="body" style="min-height:400px;max-height:400px;overflow:auto">
                                <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif;width:100%">
                                    <table class="table table-bordered table-hover nowrap" id="dt_summary_crm" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Issuer Name</th>
                                                <th>Issuer Name</th>
                                                <th>Count</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



</section>

<style>
    .table_bank {
        margin: 0 auto;
        width: 100%;
        clear: both;
        border-collapse: collapse;
        table-layout: fixed;
        word-wrap: break-word;
    }

    td.details-control {
        background: url('<?php echo base_url(); ?>assets/images/details_open.png') no-repeat center center;
        cursor: pointer;
    }

    tr.shown td.details-control {
        background: url('<?php echo base_url(); ?>assets/images/details_close.png') no-repeat center center;
    }

    table.dataTable tbody th,
    table.dataTable tbody td {
        padding: 8px;
        /* e.g. change 8x to 4px here */
    }
</style>


<div class="modal fade" id="largeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <?php
        $attributes = array(
            'name' => 'form_req_deposit', 'id' => 'formreqdep', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data'
        );
        echo form_open('crm/dashboard/insert_req_deposit', $attributes);
        ?>
        <div class="modal-content" style="background-color: #EFF0F1;">
            <div class="modal-header">
                <h4 class="title" id="largeModalLabel">Select Package</h4>
            </div>
            <div class="modal-body">
                <div class="row clearfix">

                    <input type="hidden" name="txt_req_package" id="id_req_package" />
                    <div class="col-lg-3 col-md-6 col-sm-12" style="cursor:pointer;">
                        <div class="card widget_2">
                            <div class="body div_package">
                                <h6>Package A</h6>
                                <h2 data-value="100">100 <small class="info">Transactions</small></h2>
                                <!-- <small>2% higher than last month</small>
                        <div class="progress">
                            <div class="progress-bar l-amber" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
                        </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12" style="cursor:pointer;">
                        <div class="card widget_2 ">
                            <div class="body div_package">
                                <h6>Package B</h6>
                                <h2 data-value="200">200 <small class="info">Transactions</small></h2>
                                <!-- <small>6% higher than last month</small>
                        <div class="progress">
                            <div class="progress-bar l-blue" role="progressbar" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100" style="width: 38%;"></div>
                        </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12" style="cursor:pointer;">
                        <div class="card widget_2">
                            <div class="body div_package">
                                <h6>Package C</h6>
                                <h2 data-value="300">300 <small class="info">Transactions</small></h2>
                                <!-- <small>Total Registered email</small>
                        <div class="progress">
                            <div class="progress-bar l-purple" role="progressbar" aria-valuenow="39" aria-valuemin="0" aria-valuemax="100" style="width: 39%;"></div>
                        </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12" style="cursor:pointer;">
                        <div class="card widget_2 ">
                            <div class="body div_package">
                                <h6>Package D</h6>
                                <h2 data-value="500">500 <small class="info">Transactions</small></h2>
                                <!-- <small>Total Registered Domain</small>
                        <div class="progress">
                            <div class="progress-bar l-green" role="progressbar" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100" style="width: 89%;"></div>
                        </div> -->
                            </div>
                        </div>
                    </div>



                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btn-round waves-effect">Submit</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
            </div>

        </div>

        </form>
    </div>
</div>