<section class="content">

    <?php
    $flashmessage = $this->session->flashdata('messageinsertflm');
    if (isset($flashmessage)) {
    ?>
        <div class="alert alert-success">
            <strong>Well done!</strong> FLM Has Been Submit Succesfully
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>

    <?php $this->load->view($header_view); ?>
    <!-- <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Monitoring</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Terminal</a></li>
                    <li class="breadcrumb-item active">Cardbase</li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
        </div>
    </div>   -->

    <!-- <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <div class="header">
                    <h2><strong>Terminal Monitoring</strong> Cardless </h2>
                </div>
                <div class="body">
                    <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                    <?php echo !empty($table) ? $table : ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <ul class="nav nav-tabs pl-0 pr-0">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab_generate">Generate Report</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_card_retain">Card Retain</a></li> -->
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_summarized">Summarized</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_upload">Upload Raw Terminal</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_generate">
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

                                                            <?php
                                                            // $attributes = array(
                                                            //     'name' => 'report_iso_frm', 'id' => 'formiso', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data', 'class' => 'card auth_form'
                                                            // );
                                                            // echo form_open('reportiso/excel', $attributes);
                                                            ?>
                                                            <!-- <form action="#" name="report_iso_frm" id="formiso" autocomplete="off" enctype="multipart/form-data" class="card auth_form" method="post" accept-charset="utf-8"> -->

                                                            <?php
                                                            $attributes = array(
                                                                'name' => 'login_form', 'id' => 'form_generate_report', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data', 'class' => 'card auth_form'
                                                            );
                                                            echo form_open('reportiso/download_report', $attributes);
                                                            ?>

                                                            <input type="hidden" class="form-control" name="terminal_spesified" id="txt_terminal">

                                                            <p><strong>Select specified terminal</strong></p>
                                                            <select id="optgroup" class="ms" multiple="multiple">
                                                                <?= $list_terminal; ?>
                                                            </select>

                                                            <p></p>
                                                            <div class="row clearfix">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label><strong>Date Cutoff</strong></label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-badge-check"></i></span>
                                                                            </div>
                                                                            <select class="form-control show-tick ms select2" data-placeholder="Select" name="cmb_bsn_date">
                                                                                <!-- <option value="">Select Date</option> -->
                                                                                <?php
                                                                                foreach ($list_bsndate as $data_bsndate) { ?>
                                                                                    <option value="<?= $data_bsndate->batch_nr ?>"><?= $data_bsndate->batch_nr ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label><strong>Transaction Type</strong></label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-balance-wallet"></i></span>
                                                                            </div>
                                                                            <select class="form-control show-tick ms select2" data-placeholder="Select" name="cmb_tran_type">
                                                                                <option value="">All Tran Type</option>
                                                                                <option value="Cash Withdrawal">Withdrawal</option>
                                                                                <option value="Balance Inquiry">Balance Inquriy</option>
                                                                                <option value="Funds Transfer">Transfer</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="row clearfix">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label><strong>From Date/Time</strong></label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-calendar"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control datetimepicker" name="from_date_time" id="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label><strong>To Date/Time</strong></label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-calendar"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control datetimepicker" name="to_date_time" id="">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <p></p>
                                                                    <hr style="border: 1px solid grey;">
                                                                    <div class="mb-3">
                                                                        <label><strong>Report Type</strong></label>
                                                                        <div class="input-group">
                                                                            <div class="checkbox inlineblock m-r-20">
                                                                                <input name="report_category_detail_approved" id="category_det_app" type="checkbox" value="cat_detail_app" checked="">
                                                                                <label for="category_det_app">
                                                                                    Detail Approved
                                                                                </label>
                                                                            </div>
                                                                            <div class="checkbox inlineblock m-r-20">
                                                                                <input name="report_category_detail_reject" id="category_det_rej" type="checkbox" value="cat_detail_rej" checked="">
                                                                                <label for="category_det_rej">
                                                                                    Detail Rejected
                                                                                </label>
                                                                            </div>
                                                                            <div class="checkbox inlineblock m-r-20">
                                                                                <input name="report_category_summary" id="category_sum" type="checkbox" value="cat_summary" checked="">
                                                                                <label for="category_sum">
                                                                                    Summary
                                                                                </label>
                                                                            </div>
                                                                            <div class="checkbox inlineblock m-r-20">
                                                                                <input name="report_category_vault_settle" id="category_vault" type="checkbox" value="cat_vault_sett" checked="">
                                                                                <label for="category_vault">
                                                                                    Vault Settlement
                                                                                </label>
                                                                            </div>
                                                                            <div class="checkbox inlineblock m-r-20">
                                                                                <input name="report_category_fee_settlement" id="category_fee_sett" type="checkbox" value="cat_fee_settle" checked="">
                                                                                <label for="category_fee_sett">
                                                                                    Fee Settlement
                                                                                </label>
                                                                            </div>
                                                                            <!-- <div class="radio inlineblock m-r-20">
                                                                                <input type="radio" name="report_category" id="detail_app" class="with-gap" value="cat_detail_app">
                                                                                <label for="detail_app">Detail Approved</label>
                                                                            </div>
                                                                            <div class="radio inlineblock m-r-20">
                                                                                <input type="radio" name="report_category" id="detail_rej" class="with-gap" value="cat_detail_rej">
                                                                                <label for="detail_rej">Detail Rejected</label>
                                                                            </div>
                                                                            <div class="radio inlineblock m-r-20">
                                                                                <input type="radio" name="report_category" id="summary" class="with-gap" value="cat_summary">
                                                                                <label for="summary">Summary</label>
                                                                            </div>
                                                                            <div class="radio inlineblock m-r-20">
                                                                                <input type="radio" name="report_category" id="vault_settle" class="with-gap" value="cat_vault_sett">
                                                                                <label for="vault_settle">Vault Settlement</label>
                                                                            </div>
                                                                            <div class="radio inlineblock m-r-20">
                                                                                <input type="radio" name="report_category" id="fee_settle" class="with-gap" value="cat_fee_sett">
                                                                                <label for="fee_settle">Fee Settlement</label>
                                                                            </div> -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p></p>
                                                                    <hr style="border: 1px solid grey;">
                                                                    <div class="mb-3">
                                                                        <label><strong>Output File Type</strong></label>
                                                                        <div class="input-group">
                                                                            <div class="checkbox inlineblock m-r-20">
                                                                                <input name="report_category_xlsx" id="category_rpt_xls" type="checkbox" value="xlsx" checked="">
                                                                                <label for="category_rpt_xls">
                                                                                XLSX
                                                                                </label>
                                                                            </div>
                                                                            <div class="checkbox inlineblock m-r-20">
                                                                                <input name="report_category_pdf" id="category_rpt_pdf" type="checkbox" value="pdf" checked="">
                                                                                <label for="category_rpt_pdf">
                                                                                PDF
                                                                                </label>
                                                                            </div>
                                                                            <!-- <div class="radio inlineblock m-r-20">
                                                                                <input type="radio" name="output_file" id="xlsx" class="with-gap" value="xlsx"  checked="">
                                                                                <label for="xlsx">XLSX</label>
                                                                            </div>
                                                                            <div class="radio inlineblock m-r-20">
                                                                                <input type="radio" name="output_file" id="pdf" class="with-gap" value="pdf">
                                                                                <label for="pdf">PDF</label>
                                                                            </div>
                                                                            <div class="radio inlineblock">
                                                                                <input type="radio" name="output_file" id="csv" class="with-gap" value="csv">
                                                                                <label for="csv">CSV</label>
                                                                            </div> -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p></p>
                                                                    <hr style="border: 1px solid grey;">
                                                                    <div class="mb-3">
                                                                        <label><strong>Category</strong></label>
                                                                        <div class="input-group">

                                                                            <div class="checkbox inlineblock m-r-20">
                                                                                <input name="report_category_atmi" id="category_atmi" type="checkbox" value="atmi" checked="">
                                                                                <label for="category_atmi">
                                                                                    ATMI
                                                                                </label>
                                                                            </div>
                                                                            <div class="checkbox inlineblock m-r-20">
                                                                                <input name="report_category_atmi_ptpr" id="category_atmi_ptpr" type="checkbox" value="atmi_ptpr" checked="">
                                                                                <label for="category_atmi_ptpr">
                                                                                    ATMI-PTPR
                                                                                </label>
                                                                            </div>
                                                                            <div class="checkbox inlineblock m-r-20">
                                                                                <input name="report_category_ptpr" id="category_ptpr" type="checkbox" value="ptpr" checked="">
                                                                                <label for="category_ptpr">
                                                                                    PTPR
                                                                                </label>
                                                                            </div>
                                                                            <div class="checkbox inlineblock m-r-20">
                                                                                <input name="report_category_crm" id="category_crm" type="checkbox" value="crm" checked="">
                                                                                <label for="category_crm">
                                                                                    CRM
                                                                                </label>
                                                                            </div>


                                                                            <!-- <div class="radio inlineblock m-r-20">
                                                                                <input type="radio" name="report_category_atmi" id="category_atmi" class="with-gap" value="cat_atmi">
                                                                                <label for="detail_app">ATMI</label>
                                                                            </div>
                                                                            <div class="radio inlineblock m-r-20">
                                                                                <input type="radio" name="report_category_atmi_ptpr" id="category_atmi_ptpr" class="with-gap" value="cat_atmi_ptpr">
                                                                                <label for="detail_rej">ATMI-PTPR</label>
                                                                            </div>
                                                                            <div class="radio inlineblock m-r-20">
                                                                                <input type="radio" name="report_category_ptpr" id="category_ptpr" class="with-gap" value="cat_ptpr">
                                                                                <label for="summary">PTPR</label>
                                                                            </div> -->

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <!-- <label><strong>To Date</strong></label> -->
                                                                        <div class="input-group">
                                                                            <!-- <button id="" type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Submit</button> -->
                                                                            <button id="btn_submit_report_iso_test" type="button" class="btn btn-raised btn-primary btn-round waves-effect">Submit</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            </form>
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
                    <div class="tab-pane" id="tab_upload">
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
                                    <div class="card">
                                        <div class="header">
                                            <!-- <h2><strong>Vertical</strong> Layout</h2> -->
                                            <!-- <ul class="header-dropdown">
                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else</a></li>
                                    </ul>
                                </li>
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul> -->
                                        </div>
                                        <div class="body">
                                            <!-- <form method="POST" action="" id="uploadForm" enctype="multipart/form-data"> -->
                                            <?php
                                            $attributes = array(
                                                'name' => 'login_form', 'id' => 'formupload', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data', 'class' => 'card auth_form'
                                            );
                                            echo form_open('reportiso/upload_files', $attributes);
                                            ?>
                                            <input type="hidden" name="id_upload" id="v_id_upload">
                                            <label for="email_address">Only files with extension csv</label>
                                            <div class="form-group">
                                                <input type="file" name="file_csv[]" id="fileInput" class="form-control" accept=".csv" multiple required>
                                                <div class="progress m-b-5">
                                                    <div id="v_progress" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%"> <span class="sr-only">40% Complete (success)</span> </div>
                                                </div>
                                            </div>
                                            <!-- <label for="password">Password</label>
                                <div class="form-group">                                
                                    <input type="password" id="password" class="form-control" placeholder="Enter your password">
                                </div> -->
                                            <!-- <div class="checkbox">
                                    <input id="remember_me" type="checkbox">
                                    <label for="remember_me">
                                            Remember Me
                                    </label>
                                </div> -->
                                            <button id="btn_upload_csv" type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Upload Files</button>
                                            <button id="btn_show_table" type="button" class="btn btn-raised btn-primary btn-round waves-effect">Clear</button>
                                            </form>
                                            <div id="alert_upload">
                                                <p>Success</p>
                                                <ul id="succes_notif">
                                                    <!-- <li>test</li>
                                    <li>test</li>
                                    <li>test</li> -->
                                                </ul>
                                                <p>Failed</p>
                                                <ul id="failed_notif"></ul>
                                            </div>

                                            <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">

                                                <!-- <table class="table table-bordered table-striped table-hover nowrap" id="item-list" width="100%" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif"> -->
                                                <!-- <table id="item-list" class="table table-bordered table-striped table-hover"> -->
                                                <!-- <thead>
                                    <tr>
                                        <th>Terminal ID</th>
                                        <th>Terminal Name</th>
                                        <th>Terminal City</th>
                                        <th>Location</th>
                                        <th>Date Insert</th>
                                        <th>Status Upload</th> 
                                        <th>User Upload</th>
                                        <th>File Name</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table> -->
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_summarized">
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
                                    <div class="card">
                                        <div class="header">
                                        <h2><strong>Log</strong> Settlement </h2>
                                        </div>
                                        <div class="body">
                                            <!-- <form method="POST" action="" id="uploadForm" enctype="multipart/form-data"> -->
                                            

                                            <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                                <?php echo ! empty($table_get_settlement) ? $table_get_settlement : '';?>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="header">
                                        <h2><strong>Log</strong> Generate Report </h2>
                                        </div>
                                        <div class="body">
                                            <!-- <form method="POST" action="" id="uploadForm" enctype="multipart/form-data"> -->
                                            

                                            <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                                <?php echo ! empty($table_get_summarized) ? $table_get_summarized : '';?>
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