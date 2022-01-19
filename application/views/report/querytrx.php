<section class="content">

    <?php $this->load->view($header_view); ?>

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <ul class="nav nav-tabs pl-0 pr-0">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab_detail">Detail Transactions</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_card_retain">Card Retain</a></li> -->
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_summary">Summary</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_detail">
                        <div class="container-fluid">
                            <div class="row clearfix">

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="card">
                                        <div class="header">
                                            <!-- <h2><strong>Color</strong> Pickers</h2> -->

                                        </div>
                                        <div class="body">

                                            <?php
                                            $flashmessage = $this->session->flashdata('messagegeneratereport');
                                            if (isset($flashmessage)) {
                                            ?>
                                                <div class="alert alert-success" role="alert">
                                                    <strong>Success </strong> <?php echo !empty($flashmessage) ? $flashmessage : ''; ?>
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
                                                    </button>
                                                </div>
                                            <?php } ?>

                                            <!-- Multi Select -->
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="card">

                                                        <div class="body">



                                                            <p></p>
                                                            <div class="row clearfix">
                                                                <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label>From Date/Time</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-calendar"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control datetimepicker" name="from_date_time" id="from_date">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label>To Date/Time</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-calendar"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control datetimepicker" name="to_date_time" id="to_date">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label>Batch Cut-Off</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-calendar"></i></span>
                                                                            </div>
                                                                            <select id="select_batch_cutoff" class="form-control show-tick ms select2" data-placeholder="Select" name="cmb_tran_type_batch_cutoff">
                                                                                <!-- <option value="">All Issuer</option> -->
                                                                                <option value="">All Batch</option>
                                                                                <?php
                                                                                foreach ($list_batch_cut_off as $batch_cutoff) { ?>
                                                                                    <option value="<?= $batch_cutoff->batch_nr ?>"><?= $batch_cutoff->batch_nr . ' - ' . $batch_cutoff->settle_date ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- <hr style="border: 1px solid grey;"> -->
                                                            </div>
                                                            <hr style="border: 1px solid grey;">
                                                            <div class="row clearfix">
                                                                <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label>Tran Type</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-badge-check"></i></span>
                                                                            </div>
                                                                            <select id="select_tran_type" class="form-control show-tick ms select2" data-placeholder="Select" name="cmb_bsn_date">
                                                                                <!-- <option value="">Select Date</option> -->
                                                                                <option value="">All Tran Type</option>
                                                                                <option value="01">Withdrawal</option>
                                                                                <option value="31">Balance Inquriy</option>
                                                                                <option value="54">Transfer</option>
                                                                                <!-- <option value="Funds Transfer">Cardbase Deposit</option>
                                                                                <option value="Funds Transfer">Cardless Wdl</option>
                                                                                <option value="Funds Transfer">Cardless Deposit</option> -->
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label>Issuer</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-balance-wallet"></i></span>
                                                                            </div>
                                                                            <select id="select_issuer" class="form-control show-tick ms select2" data-placeholder="Select" name="cmb_tran_type">
                                                                                <option value="">All Issuer</option>
                                                                                <?php
                                                                                foreach ($list_cbc_bank as $cbc_bank) { ?>
                                                                                    <option value="<?= $cbc_bank->bank ?>"><?= $cbc_bank->cbc . ' - ' . $cbc_bank->bank ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label>Beneficiary</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-balance-wallet"></i></span>
                                                                            </div>
                                                                            <select id="select_benef" class="form-control show-tick ms select2" data-placeholder="Select" name="cmb_tran_type">
                                                                                <option value="">All Beneficiary</option>
                                                                                <?php
                                                                                foreach ($list_cbc_bank as $cbc_bank) { ?>
                                                                                    <option value="<?= sprintf("%03d", $cbc_bank->cbc) . ' - ' . $cbc_bank->bank ?>"><?= sprintf("%03d", $cbc_bank->cbc) . ' - ' . $cbc_bank->bank ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div> -->

                                                                <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label>Sink Node Name</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-balance-wallet"></i></span>
                                                                            </div>
                                                                            <select id="select_sink_node_name" class="form-control show-tick ms select2" data-placeholder="Select" name="cmb_tran_type">
                                                                                <option value="">All Sink Node</option>
                                                                                <?php
                                                                                foreach ($list_sink_node as $snk_node_name) { ?>
                                                                                    <option value="<?= $snk_node_name->node_name ?>"><?= $snk_node_name->node_name ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label>Card Number</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-balance-wallet"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="txt_card_number" id="txt_pan">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label>Retrieval Reference Number</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-balance-wallet"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="txt_rrn" id="txt_rrn">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label>Response Code</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-balance-wallet"></i></span>
                                                                            </div>
                                                                            <select id="select_resp_code" class="form-control show-tick ms select2" data-placeholder="Select" name="cmb_tran_type">
                                                                                <option value="">All Resp Code</option>
                                                                                <?php
                                                                                foreach ($list_resp_code as $response_code) { ?>
                                                                                    <option value="<?= $response_code->resp_code ?>"><?= $response_code->resp_code .' - '. $response_code->short_desc ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label>Show Records</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-balance-wallet"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="nm_show_records" id="txt_show_records" value="10">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="mb-3">
                                                                        <label>Terminal</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-balance-wallet"></i></span>
                                                                            </div>
                                                                            <select id="select_pref_term" class="form-control show-tick ms select2" data-placeholder="Select" name="cmb_tran_type">
                                                                                <option value="">All Prefix Terminal</option>
                                                                                <option value="010">010</option>
                                                                                <option value="041">041</option>
                                                                                <option value="042">042</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-balance-wallet"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="txt_card_number" id="txt_terminal_id" placeholder="Specified Terminal ID">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr style="border: 1px solid grey;">
                                                            <div class="row clearfix">



                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <!-- <label><strong>To Date</strong></label> -->
                                                                        <div class="input-group">
                                                                            <!-- <button id="" type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Submit</button> -->
                                                                            <button id="btn_search" type="button" class="btn btn-raised btn-primary btn-round waves-effect">Search</button>
                                                                            <button id="btn_export_excel_query_trx" type="button" class="btn btn-raised btn-success btn-round waves-effect">Export Result To Excel</button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="loader" id="loader_process"><div class="m-t-30"><img class="zmdi-hc-spin" src="/new_web_monitoring_atmi/assets/images/loader.svg" width="48" height="48" alt="Aero"></div><p>Processing...</p></div>

                                                                <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif;width:100%">
                                                                    <table class="table table-bordered table-striped table-hover nowrap" id="dt_query_trx" width="100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <!-- <th>Post Tran Cust ID</th>
                                                                                <th>Source Node Name</th> -->
                                                                                <th>Tran Nr</th>
                                                                                <th>Postilion Date/Time</th>
                                                                                <th>Date/Time Tran Local</th>
                                                                                <th>From Acct Type</th>
                                                                                <th>Tran Type</th>
                                                                                <th>Message Type</th>
                                                                                <th>Resp Code</th>
                                                                                <th>Amount</th>
                                                                                <th>Card Acceptor Name Loc</th>
                                                                                <th>Terminal ID</th>
                                                                                <th>Source Node</th>
                                                                                <th>Sink Node</th>
                                                                                <th>PAN</th>
                                                                                <th>Retrieval Reference Number</th>
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

                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>

                    <!-- <div class="tab-pane file_manager" id="tab_card_retain">
                        <div class="container-fluid">
                            <div class="row clearfix">

                            </div> 
                        </div>
                    </div> -->
                    <div class="tab-pane" id="tab_summary">
                        <div class="container-fluid">
                            <!-- Vertical Layout -->
                            <div class="row clearfix">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <!-- <div class="alert alert-warning" role="alert">
                        <strong>Bootstrap</strong> Better check yourself, <a target="_blank" href="https://getbootstrap.com/docs/4.2/components/forms/">View More</a>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
                        </button>
                    </div> -->
                                    <div class="card" style="border: 0px solid red;">
                                        <div class="header">
                                            <div class="row clearfix">
                                                <div class="col-md-2">
                                                    <small class="text-muted">From : </small>
                                                    <p id="lbl_date_from">-</p>
                                                    <hr>
                                                </div>
                                                <div class="col-md-2">
                                                <small class="text-muted">To : </small>
                                                    <p id="lbl_date_to">-</p>
                                                    <hr>
                                                </div>
                                                <div class="col-md-2">
                                                <small class="text-muted">Batch Cut-off : </small>
                                                    <p id="lbl_batch">All</p>
                                                    <hr>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                    <small class="text-muted">Tran Type : </small>
                                                    <p id="lbl_tran_type">All</p>
                                                    <hr>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-2">
                                                    <div class="mb-3">
                                                    <small class="text-muted">Issuer : </small>
                                                    <p id="lbl_issuer">All</p>
                                                    <hr>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                    <small class="text-muted">Beneficiary : </small>
                                                    <p id="lbl_benef">All</p>
                                                    <hr>
                                                    </div>
                                                </div> -->
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                    <small class="text-muted">Sink Node : </small>
                                                    <p id="lbl_sink_node">All</p>
                                                    <hr>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                    <small class="text-muted">Card Number : </small>
                                                    <p id="lbl_pan">-</p>
                                                    <hr>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                    <small class="text-muted">RRN : </small>
                                                    <p id="lbl_rrn">-</p>
                                                    <hr>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                    <small class="text-muted">Prefix Terminal : </small>
                                                    <p id="lbl_pref_term">All</p>
                                                    <hr>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                    <small class="text-muted">Specified Terminal : </small>
                                                    <p id="lbl_spec_term">All</p>
                                                    <hr>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                    <small class="text-muted">Response Code : </small>
                                                    <p id="lbl_resp_code">-</p>
                                                    <hr>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                    <small class="text-muted">Show Records : </small>
                                                    <p id="lbl_show_records">10</p>
                                                    <hr>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row clearfix">
                                                <div class="col-lg-3 col-md-6 col-sm-12">
                                                    <div class="card widget_2 big_icon traffic">
                                                        <div class="body">
                                                            <h6>Total Transaction</h6>
                                                            <h2 id="total_trx"></h2>
                                                            <!-- <small>2% higher than last month</small>
                                                            <div class="progress">
                                                                <div class="progress-bar l-amber" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
                                                            </div> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-sm-12">
                                                    <div class="card widget_2 big_icon sales">
                                                        <div class="body">
                                                            <h6>Approved</h6>
                                                            <h2 id="total_trx_approved"></h2>
                                                            <!-- <small>6% higher than last month</small>
                                                            <div class="progress">
                                                                <div class="progress-bar l-blue" role="progressbar" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100" style="width: 38%;"></div>
                                                            </div> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-sm-12">
                                                    <div class="card widget_2 big_icon email">
                                                        <div class="body">
                                                            <h6>Technical Reject</h6>
                                                            <h2 id="total_trx_reject_technical"></small></h2>
                                                            <!-- <small>Total Registered email</small>
                                                            <div class="progress">
                                                                <div class="progress-bar l-purple" role="progressbar" aria-valuenow="39" aria-valuemin="0" aria-valuemax="100" style="width: 39%;"></div>
                                                            </div> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-sm-12">
                                                    <div class="card widget_2 big_icon domains">
                                                        <div class="body">
                                                            <h6>Customer Reject</h6>
                                                            <h2 id="total_trx_reject_customer"></small></h2>
                                                            <!-- <small>Total Registered Domain</small>
                                                            <div class="progress">
                                                                <div class="progress-bar l-green" role="progressbar" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100" style="width: 89%;"></div>
                                                            </div> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <hr style="border: 1px solid grey;"> -->
                                            </div>

                                            <div class="body">
                                                <p></p>

                                                <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif;width:100%">
                                                                    <table class="table table-bordered table-striped table-hover nowrap" id="dt_sum_query_trx" width="100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <!-- <th>Post Tran Cust ID</th>
                                                                                <th>Source Node Name</th> -->
                                                                                <th>Response Code</th>
                                                                                <th>Category</th>
                                                                                <th>Count</th>
                                                                                <th>Rate</th>
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
                        </div>
                    </div>
                </div>
            </div>

</section>


<style>
    #succes_notif {
        list-style-image: url('<?php echo base_url(); ?>assets/images/checklist.png');
    }

    #failed_notif {
        list-style-image: url('<?php echo base_url(); ?>assets/images/failed_upload.png');
    }
</style>