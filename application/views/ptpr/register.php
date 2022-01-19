<section class="content">


    <?php $this->load->view($header_view); ?>


    <div class="container-fluid">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Form </strong> Register </h2>
                    </div>
                    <div class="body">
                        <!-- <p>Please complete the form below. Mandatory fields marked *</p> -->
                        <?php
                        $attributes = array(
                            'enctype' => 'multipart/form-data', 'name' => 'signup_form', 'id' => 'myform', 'autocomplete' => 'off', 'class' => 'card auth_form'
                        );
                        $hidden = array(
                            'txt_bank_code' => '', 'txt_fi_code' => '', 'txt_entity' => ''
                        );
                        echo form_open('ptpr/register/insert_reg', $attributes, $hidden);
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

                        <!-- <div id="alert_delete_success" class="alert alert-success" role="alert">
                            <strong>Success </strong> <span id="success_delete"></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
                            </button>
                        </div>
                        <div id="alert_delete_danger" class="alert alert-danger" role="alert">
                            <strong>Failed </strong> <span id="delete_failed"></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
                            </button>
                        </div> -->

                        <div class="row clearfix">


                            <div class="col-lg-4 col-md-6">
                                <div class="mb-3">
                                    <small class="text-muted">Select Interchange</small>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="test123"><i class="zmdi zmdi-account-box-mail"></i></span>
                                        </div>
                                        <select class="form-control show-tick ms select2" data-placeholder="Select" id="terminal_batch" name="interchange">
                                            <option value=""></option>
                                            <?php
                                            foreach ($list_interchange as $data_interchange) { ?>
                                                <option value="<?= $data_interchange->interchange ?>"><?= $data_interchange->interchange ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">Email PIC</small>
                                <div class="input-group masked-input mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
                                    </div>
                                    <input type="text" class="form-control email" name="email_pic">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">Email Finance</small>
                                <div class="input-group masked-input mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
                                    </div>
                                    <input type="text" class="form-control email" name="email_finance">
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">Bank Code : </small>
                                <p id="bank_code"></p>
                                <hr>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">FI Code : </small>
                                <p id="fi_code"></p>
                                <hr>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">Business Entity Name : </small>
                                <p id="entity"></p>
                                <hr>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12">
                                <!-- <small class="text-muted">For Payment </small>  -->
                                <hr style="border-top: 1px dashed gray;">
                                <p style="font-weight: bold;">For Payment</p>
                                <hr style="border-top: 1px dashed gray;">
                            </div>
                            <!-- <div class="col-lg-4 col-md-6">
                                <label>Bank Name</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-balance"></i></span>
                                    </div>
                                    <input type="text" class="form-control">
                                </div>
                            </div> -->
                            <div class="col-lg-4 col-md-6">
                                <label>Account ID</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="account_id">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label>Bank Account Name</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="account_name">
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <button id="btn_submit_reg_bank" type="submit" class="btn btn-raised btn-primary btn-round waves-effect">Submit</button>
                                    <button id="btn_cancel" type="reset" class="btn btn-raised btn-danger btn-round waves-effect">Cancel</button>
                                </div>
                            </div>

                        </div>
                        </form>
                        <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                            <!-- <table class="table table-bordered table-striped table-hover nowrap" id="datatable_batch_viewer" width="100%" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                <thead>
                                    <tr>
                                        <th>CBC</th>
                                        <th>FI Code</th>
                                        <th>Bank Name</th>
                                        <th>Business Entity Name</th>
                                        <th>Email PIC</th>
                                        <th>Email Finance</th>
                                        <th>Bank Account</th>
                                        <th>Account ID</th>
                                        <th>Account Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table> -->
                            <?php echo !empty($table_get_register) ? $table_get_register : ''; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

</section>

<div class="modal fade" id="modal_delete_register" role="dialog" style="font-size: 12px;">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h6 class="modal-title">Delete Bank Account</h6>
            </div>
            <div class="modal-body form" style="border:0px solid red; padding-top: 1px;padding-bottom: 1px;">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id" />
                    <div class="form-body">
                        <hr>
                        <p id="confirm_delete"></p>
                        <hr>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-lg-12 col-md-12 col-sm-12" style="border: 0px solid red;padding:0px">
                    <button type="button" onclick="delete_account_bank()" class="btn btn-primary">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="modal_edit_account_bank" role="dialog" style="font-size: 12px;">
    <div class="modal-dialog modal-lg" role="document" style="font-size: 12px;border:0px solid red;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="v_title_accounts"></h5>
            </div>
            <div class="modal-body form" style="border: 0px solid red;padding-top: 0px">
                <!-- <div class="loader" id="loader_process">
                    <div class="m-t-30"><img class="zmdi-hc-spin" src="/new_web_monitoring_atmi/assets/images/loader.svg" width="48" height="48" alt="Aero"></div>
                    <p>Processing...</p>
                </div> -->
                <form action="#" id="form_accounts" class="form-horizontal">
                    <input type="hidden" value="" name="id" />
                    <div class="form-body">
                        <hr>

                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">Bank Code : </small>
                                <p id="m_bank_code"></p>
                                <hr>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">FI Code : </small>
                                <p id="m_fi_code"></p>
                                <hr>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">Business Entity Name : </small>
                                <p id="m_entity"></p>
                                <hr>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">Email PIC : </small>
                                <input id="m_mail_pic" type="text" class="form-control" />
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">Email Finance : </small>
                                <input id="m_mail_finance" type="text" class="form-control" />
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">Account ID : </small>
                                <input id="m_account_id" type="text" class="form-control" />
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">Bank Account Name : </small>
                                <input id="m_account_name" type="text" class="form-control" />
                            </div>
                        </div>





                        <hr>


                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <button type="button" id="btnSave" onclick="save_account_bank()" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal" id="test_btn">test</button> -->
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->