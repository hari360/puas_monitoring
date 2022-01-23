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

                                                            <!-- <p><strong>Select specified terminal</strong></p>
                                                            <select id="optgroupreport" class="ms" multiple="multiple">
                                                                <?= $list_terminal; ?>
                                                            </select> -->

                                                            <!-- <p></p> -->
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
                                                                                    Settlement
                                                                                </label>
                                                                            </div>
                                                                            
                                                                            
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
                                                                            <div class="checkbox inlineblock m-r-20">
                                                                                <input name="report_category_txt" id="category_rpt_txt" type="checkbox" value="txt" checked="">
                                                                                <label for="category_rpt_txt">
                                                                                Text File
                                                                                </label>
                                                                            </div>

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