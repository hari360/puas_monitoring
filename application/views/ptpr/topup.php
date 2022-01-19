<section class="content">


    <?php $this->load->view($header_view); ?>


    <div class="container-fluid">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Form </strong> Topup </h2>
                    </div>
                    <div class="body">
                        <?php
                        $attributes = array(
                            'enctype' => 'multipart/form-data', 'name' => 'signup_form', 'id' => 'form_req_package', 'autocomplete' => 'off', 'class' => 'card auth_form'
                        );
                        $hidden = array(
                            'txt_bank_code' => '', 'txt_fi_code' => '', 'txt_entity' => ''
                        );
                        echo form_open('ptpr/topup/insert_req_package', $attributes, $hidden);
                        ?>
                        <?php
                        $flashsuccess = $this->session->flashdata('messagesuccess');
                        $flasherror = $this->session->flashdata('messageerror');

                        $flashsuccessdelete = $this->session->flashdata('msgsuccessdelete');
                        $flasherrordelete = $this->session->flashdata('msgfaileddelete');

                        if (isset($flashsuccess)) {
                        ?>
                            <div class="alert alert-success" role="alert">
                                <strong>Success </strong> <?php echo !empty($flashsuccess) ? $flashsuccess : ''; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
                                </button>
                            </div>
                        <?php
                        }
                        if (isset($flasherror)) {
                        ?>
                            <div class="alert alert-danger" role="alert">
                                <strong>Error </strong> <?php echo !empty($flasherror) ? $flasherror : ''; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
                                </button>
                            </div>
                        <?php
                        }
                        ?>

                        <?php
                        if (isset($flashsuccessdelete)) {
                        ?>
                            <div class="alert alert-success" role="alert">
                                <strong>Success </strong> <?php echo !empty($flashsuccessdelete) ? $flashsuccessdelete : ''; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
                                </button>
                            </div>
                        <?php
                        }
                        ?>

                        <?php
                        if (isset($flasherrordelete)) {
                        ?>
                            <div class="alert alert-danger" role="alert">
                                <strong>Failed </strong> <?php echo !empty($flasherrordelete) ? $flasherrordelete : ''; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
                                </button>
                            </div>
                        <?php
                        }
                        ?>
                        <!-- <p>Please complete the form below. Mandatory fields marked *</p> -->
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">FI Code : </small>
                                <p>1065</p>
                                <hr>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">Business Entity Name : </small>
                                <p>PT Bank BTN Persero</p>
                                <hr>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-6">
                                <div class="mb-3">
                                    <small class="text-muted">Select Package</small>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="test123"><i class="zmdi zmdi-account-box-mail"></i></span>
                                        </div>
                                        <select class="form-control show-tick ms select2" data-placeholder="Select" id="sPackageCode" name="cmb_package_selected">
                                            <option value=""></option>
                                            <?php
                                            foreach ($list_package as $data_package) { ?>
                                                <option value="<?= $data_package->package_code ?>"><?= $data_package->package_code ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">Price</small>
                                <p id="sPrice"></p>
                                <hr>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">Limit</small>
                                <p id="sLimit"></p>
                                <hr>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">Alert Minimum Limit</small>
                                <p id="sFee"></p>
                                <hr>
                            </div>
                        </div>



                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <button id="btn_submit_req_package" type="button" class="btn btn-raised btn-primary btn-round waves-effect" onclick="modal_req_package()">Submit</button>
                                    <button id="btn_cancel" type="button" class="btn btn-raised btn-danger btn-round waves-effect">Cancel</button>
                                </div>
                            </div>

                        </div>
                        </form>


                        <ul class="nav nav-tabs p-0 mb-3 nav-tabs-success" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home_with_icon_title"> <i class="zmdi zmdi-home"></i> Requested </a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile_with_icon_title"><i class="zmdi zmdi-account"></i> Approved </a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#messages_with_icon_title"><i class="zmdi zmdi-email"></i> Rejected </a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#completed_tab"><i class="zmdi zmdi-email"></i> Completed </a></li>

                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane in active" id="home_with_icon_title">
                                <div class="header">
                                    <h2><strong>Detail History Requested Topup</strong></h2>
                                    <hr>

                                </div>
                                <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                    <?php echo !empty($table_req_package) ? $table_req_package : ''; ?>

                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="profile_with_icon_title">
                                <div class="header">
                                    <h2><strong>Detail History Approved Topup</strong></h2>
                                    <hr>

                                </div>
                                <ul class="nav nav-tabs p-0 mb-3 nav-tabs-success" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#approved_by_finance"> <i class="zmdi zmdi-home"></i> Finance </a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#approved_by_rcs"><i class="zmdi zmdi-account"></i> RCS </a></li>
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane in active" id="approved_by_finance">
                                        <div class="header">
                                            <!-- <h2><strong>Detail History Requested Topup</strong></h2>
                                            <hr> -->

                                        </div>
                                        <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                            <?php echo !empty($table_app_package) ? $table_app_package : ''; ?>

                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="approved_by_rcs">
                                        <div class="header">
                                            <!-- <h2><strong>Detail History Requested Topup</strong></h2>
                                            <hr> -->

                                        </div>
                                        <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                            <?php echo !empty($table_app_rcs_package) ? $table_app_rcs_package : ''; ?>

                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div role="tabpanel" class="tab-pane" id="messages_with_icon_title">
                                <div class="header">
                                    <h2><strong>Detail History Rejected Topup</strong></h2>
                                    <hr>

                                </div>

                                <ul class="nav nav-tabs p-0 mb-3 nav-tabs-success" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#rejected_by_finance"> <i class="zmdi zmdi-home"></i> Finance </a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#rejected_by_rcs"><i class="zmdi zmdi-account"></i> RCS </a></li>
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane in active" id="rejected_by_finance">
                                        <div class="header">
                                            <!-- <h2><strong>Detail History Requested Topup</strong></h2>
                                            <hr> -->

                                        </div>
                                        <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                            <?php echo !empty($table_rej_package) ? $table_rej_package : ''; ?>

                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="rejected_by_rcs">
                                        <div class="header">
                                            <!-- <h2><strong>Detail History Requested Topup</strong></h2>
                                            <hr> -->

                                        </div>
                                        <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                            <?php echo !empty($table_rej_rcs_package) ? $table_rej_rcs_package : ''; ?>

                                        </div>
                                    </div>
                                </div>



                            </div>

                            <div role="tabpanel" class="tab-pane" id="completed_tab">
                                <div class="header">
                                    <h2><strong>Detail History Completed</strong></h2>
                                    <hr>

                                </div>
                                <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                    <?php echo !empty($table_completed_package) ? $table_completed_package : ''; ?>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>

</section>


<div class="modal bigEntrance" id="modal_req_package" role="dialog" style="font-size: 12px;">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h6 class="modal-title">Request Package</h6>
            </div>
            <div class="modal-body form" style="border:0px solid red; padding-top: 1px;padding-bottom: 1px;">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id" />
                    <div class="form-body">
                        <hr>
                        <p id="confirm_req"></p>
                        <hr>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-lg-12 col-md-12 col-sm-12" style="border: 0px solid red;padding:0px">
                    <button id="submit_req_package" type="button" class="btn btn-primary">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="modal_reject_invoice" role="dialog" style="font-size: 12px;">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h6 class="modal-title" style="color: #C82333;">Reject Request Topup Package</h6>
            </div>
            <div class="modal-body form" style="border:0px solid red; padding-top: 1px;padding-bottom: 1px;">
                <form action="#" id="form_reject" class="form-horizontal">
                    <input type="hidden" value="" name="reject_id" id="reject_req_no" />
                    <input type="hidden" value="" name="nm_user_fin" id="v_reject_user_fin" />
                    <div class="form-body">
                        <hr>
                        <p id="confirm_reject_invoice"></p>
                        <hr>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-lg-12 col-md-12 col-sm-12" style="border: 0px solid red;padding:0px">
                    <button type="button" onclick="rejected_topup()" class="btn btn-primary">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fadeIn" id="modal_approve_invoice" role="dialog" style="font-size: 12px;">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h6 class="modal-title" style="color: #218838;">Approve Request Topup Package</h6>
            </div>
            <div class="modal-body form" style="border:0px solid red; padding-top: 1px;padding-bottom: 1px;">
                <form action="#" id="form_approve" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" value="" name="nm_req_no" id="v_req_no" />
                    <input type="hidden" value="" name="nm_user_fin" id="v_user_fin" />
                    <input type="hidden" value="" name="nm_user_req" id="v_user_req" />
                    <input type="hidden" value="" name="nm_date_req" id="v_date_req" />
                    <input type="hidden" value="" name="nm_package_topup" id="v_package_user" />
                    <div class="form-body">
                        <hr>
                        <p id="confirm_approve_invoice"></p>
                        <hr>
                        <div id="attached_topup_file">
                            <label for="email_address">Attache File (jpg or png)</label>
                            <div class="form-group">
                                <input type="file" name="files" id="files" class="form-control" accept="image/jpeg, image/png" multiple />
                                <!-- <input type="file" name="file_image[]" id="fileInputimage" class="form-control" accept="image/jpeg, image/png" multiple required> -->
                                <!-- <div class="progress m-b-5">
                                <div id="v_progress" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%"> <span class="sr-only">40% Complete (success)</span> </div>
                            </div> -->
                            </div>

                            <div class="form-group">
                                <label><strong>Payment Date</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="test123"><i class="zmdi zmdi-calendar"></i></span>
                                    </div>
                                    <input type="text" class="form-control datetimepickertopup" name="v_payment_date" id="payment_date_topup">
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- <div class="input-group" id="queueing_topup">
                        <div class="checkbox inlineblock m-r-20">
                            <input name="checked_queu" id="queu_topup" type="checkbox" value="TRUE" >
                            <label for="queu_topup">
                                Queueing Topup
                            </label>
                        </div>
                    </div> -->
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-lg-12 col-md-12 col-sm-12" style="border: 0px solid red;padding:0px">
                    <button type="button" onclick="approved_topup()" class="btn btn-primary">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fadeIn" id="modal_approve_check" role="dialog" style="font-size: 12px;">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h6 class="modal-title" style="color: #218838;">Warning !</h6>
            </div>
            <div class="modal-body form" style="border:0px solid red; padding-top: 1px;padding-bottom: 1px;">
                <form action="#" id="form_approve" class="form-horizontal" >
                    <!-- <input type="hidden" value="" name="nm_req_no" id="v_req_no" />
                    <input type="hidden" value="" name="nm_user_fin" id="v_user_fin" /> -->
                    <div class="form-body">
                        <hr>
                        <p id="confirm_approve_check"></p>
                        <hr>
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-lg-12 col-md-12 col-sm-12" style="border: 0px solid red;padding:0px">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<style>
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

    table.datatable thead th.no-sort {
        background: none;
        pointer-events: none;
    }
</style>