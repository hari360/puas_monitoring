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
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">

                <div class="header">

                </div>
                <div class="body">

                    <?php
                    $attributes = array(
                        'name' => 'login_form', 'id' => 'formupload', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data', 'class' => 'card auth_form'
                    );
                    echo form_open('reporting/uploadrawdata/upload_xlsx_files', $attributes);
                    ?>
                    <input type="hidden" name="id_upload" id="v_id_upload">
                    <label for="email_address">Only files with extension xlsx</label>
                    <div class="form-group">
                        <input type="file" name="file_xlsx[]" id="fileInput" class="form-control" accept=".xlsx" multiple required>
                        <div class="progress m-b-5">
                            <div id="v_progress" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%"> <span class="sr-only">40% Complete (success)</span> </div>
                        </div>
                    </div>

                    <button id="btn_upload_csv" type="submit" class="btn btn-success ">Upload Files</button>
                    <button id="btn_show_table" type="button" class="btn btn-danger ">Clear</button>

                    </form>
                    <div id="alert_upload">

                        <ul id="succes_notif">
                            <p>Success</p>
                        </ul>

                        <ul id="failed_notif">
                            <p>Failed</p>
                        </ul>
                    </div>

                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <div class="card">
                                <ul class="nav nav-tabs pl-0 pr-0">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab_deposit"><i class="zmdi zmdi-view-carousel"></i> Transaksi Deposit </a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_ppob"><i class="zmdi zmdi-view-dashboard"></i> Transaksi PPOB</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_setor_tunai"><i class="zmdi zmdi-view-dashboard"></i> Transaksi Setor Tarik</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_transfer"><i class="zmdi zmdi-view-dashboard"></i> Transaksi Transfer</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_deposit">
                                        <div class="container-fluid">

                                            <div class="row clearfix">
                                                <div class="header">
                                                    <h2><strong><i class="zmdi zmdi-chart"></i> Data</strong> Detail Transaksi Deposit</h2>
                                                </div>
                                                <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif;width:100%">
                                                    <table class="table table-bordered table-striped table-hover nowrap" id="dt_history_upload" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Kode</th>
                                                                <th>Agent</th>
                                                                <th>Jenis</th>
                                                                <th>Nominal</th>
                                                                <th>Admin Fee</th>
                                                                <th>Total Price</th>
                                                                <th>Status</th>
                                                                <th>Tanggal</th>
                                                                <th>Date Upload</th>
                                                                <th>File Name</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane file_manager" id="tab_ppob">
                                        <div class="container-fluid">
                                            <div class="row clearfix">
                                            <div class="header">
                                                    <h2><strong><i class="zmdi zmdi-chart"></i> Data</strong> Detail Transaksi PPOB</h2>
                                                </div>
                                                <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif;width:100%">
                                                    <table class="table table-bordered table-striped table-hover nowrap" id="dt_history_ppob" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Kode</th>
                                                                <th>Agent</th>
                                                                <th>Jenis</th>
                                                                <th>Nominal</th>
                                                                <th>Admin Fee</th>
                                                                <th>Total Price</th>
                                                                <th>Status</th>
                                                                <th>Tanggal</th>
                                                                <th>Date Upload</th>
                                                                <th>File Name</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane file_manager" id="tab_setor_tunai">
                                        <div class="container-fluid">
                                            <div class="row clearfix">
                                            <div class="header">
                                                    <h2><strong><i class="zmdi zmdi-chart"></i> Data</strong> Detail Transaksi Setor Tarik</h2>
                                                </div>
                                                <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif;width:100%">
                                                    <table class="table table-bordered table-striped table-hover nowrap" id="dt_history_setor_tarik" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Kode</th>
                                                                <th>Agent</th>
                                                                <th>Jenis</th>
                                                                <th>Nominal</th>
                                                                <th>Admin Fee</th>
                                                                <th>Total Price</th>
                                                                <th>Status</th>
                                                                <th>Tanggal</th>
                                                                <th>Date Upload</th>
                                                                <th>File Name</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane file_manager" id="tab_transfer">
                                        <div class="container-fluid">
                                            <div class="row clearfix">
                                            <div class="header">
                                                    <h2><strong><i class="zmdi zmdi-chart"></i> Data</strong> Detail Transaksi Transfer</h2>
                                                </div>
                                                <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif;width:100%">
                                                    <table class="table table-bordered table-striped table-hover nowrap" id="dt_history_transfer" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Kode</th>
                                                                <th>Agent</th>
                                                                <th>Jenis</th>
                                                                <th>Nominal</th>
                                                                <th>Admin Fee</th>
                                                                <th>Total Price</th>
                                                                <th>Status</th>
                                                                <th>Tanggal</th>
                                                                <th>Date Upload</th>
                                                                <th>File Name</th>
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



                    <!-- <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">

                    </div> -->

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