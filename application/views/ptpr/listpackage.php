<section class="content">


    <?php $this->load->view($header_view); ?>


    <div class="container-fluid">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Form </strong> Register Package </h2>
                    </div>
                    <div class="body">
                        <!-- <p>Please complete the form below. Mandatory fields marked *</p> -->
                        <?php
                        $attributes = array(
                            'enctype' => 'multipart/form-data', 'name' => 'signup_form', 'id' => 'form_add_package', 'autocomplete' => 'off', 'class' => 'card auth_form'
                        );
                        $hidden = array(
                            'txt_bank_code' => '', 'txt_fi_code' => '', 'txt_entity' => ''
                        );
                        echo form_open('ptpr/listpackage/insert_package', $attributes, $hidden);
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


                        <div class="row clearfix">
                            <input type="hidden" value="" id="txt_fee_selected" name="data_arr_fee" />
                            <div class="col-lg-4 col-md-6">
                                <label>Kode Paket</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-balance"></i></span>
                                    </div>
                                    <!-- <input type="text" class="form-control" name="txt_package_code" maxlength="1" onkeyup="this.value = this.value.toUpperCase();" > -->
                                    <input type="text" class="form-control" name="txt_package_code">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label>Limit Transaksi</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                    </div>
                                    <input type="text" class="form-control uang" name="txt_limit">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label>Harga Paket</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                    </div>
                                    <input type="text" class="form-control uang" name="txt_price">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label>Minimum Limit</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                    </div>
                                    <input type="text" class="form-control uang" name="txt_min_limit">
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <!-- <small class="text-muted">For Payment </small>  -->
                                <hr style="border-top: 1px dashed gray;">
                                <p style="font-weight: bold;">Setting Fee</p>
                                <hr style="border-top: 1px dashed gray;">
                            </div>


                            <div class="col-lg-4 col-md-6">
                                <label>Tran Type</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                    </div>
                                    <select class="form-control show-tick ms select2" data-placeholder="Select" name="cmb_tran_type" id="v_tran_type">
                                        <option value="">All Tran Type</option>
                                        <option value="01">Withdrawal</option>
                                        <option value="31">Balance Inquriy</option>
                                        <option value="50">Fund Transfer</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label>Issuer Fee</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                    </div>
                                    <input type="text" class="form-control uang" name="txt_iss_fee" id="v_iss_fee">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label>Acquirer Fee</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                    </div>
                                    <input type="text" class="form-control uang" name="txt_fee_acq" id="v_acq_fee">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <label>Switch Fee</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                    </div>
                                    <input type="text" class="form-control uang" name="txt_fee_swt" id="v_swt_fee">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label> </label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <!-- <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span> -->
                                    </div>
                                    <button type="button" class="btn btn-success" style="margin-top: 10px;" id="btn_add_fee">Add Fee</button>
                                    <!-- <button type="button" class="btn btn-success" style="margin-top: 10px;" id="btn_add_fee_test">Add Fee</button> -->
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12">
                                <div class="table-responsive social_media_table">
                                    <table class="table table-hover c_table" id="table_fee">
                                        <hr style="border-top: 1px solid gray;">
                                        <thead>

                                            <tr>
                                                <th>Tran Type</th>
                                                <th>Tran Type Name</th>
                                                <th>Issuer Fee</th>
                                                <th>Acquirer Fee</th>
                                                <th>Switch Fee</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- <tr>
                                                <td>Withdrawal
                                                </td>
                                                <td>6.500</td>
                                                <td>5.000</td>
                                                <td>1.500</td>
                                            </tr>
                                            <tr>
                                                <td>Balance Inquiry
                                                </td>
                                                <td>4.500</td>
                                                <td>4.000</td>
                                                <td>500</td>
                                            </tr>
                                            <tr>
                                                <td>Fund Transfer
                                                </td>
                                                <td>7.500</td>
                                                <td>6.000</td>
                                                <td>2.500</td>
                                            </tr> -->
                                        </tbody>
                                    </table>
                                    <hr style="border-top: 1px solid gray;">
                                </div>
                            </div>

                        </div>
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <button id="btn_submit_reg_bank" type="button" class="btn btn-raised btn-primary btn-round waves-effect" onclick="modal_add_list_package()">Submit</button>
                                    <button id="btn_cancel" type="button" class="btn btn-raised btn-danger btn-round waves-effect">Cancel</button>
                                </div>
                            </div>

                        </div>
                        </form>
                        <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                            <?php echo !empty($table_get_package) ? $table_get_package : ''; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</section>

<div class="modal fade" id="modal_delete_package" role="dialog" style="font-size: 12px;">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h6 class="modal-title">Delete Package</h6>
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
                    <button type="button" onclick="delete_package()" class="btn btn-primary">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="modal_add_package" role="dialog" style="font-size: 12px;">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h6 class="modal-title">Add List Package</h6>
            </div>
            <div class="modal-body form" style="border:0px solid red; padding-top: 1px;padding-bottom: 1px;">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id" />
                    <div class="form-body">
                        <hr>
                        <p id="confirm_add"></p>
                        <hr>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-lg-12 col-md-12 col-sm-12" style="border: 0px solid red;padding:0px">
                    <button id="submit_add_package" type="button" class="btn btn-primary">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="modal_edit_list_package" role="dialog" style="font-size: 12px;">
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
                <!-- <form action="#" id="form_edit_package" class="form-horizontal"> -->

                    <?php
                    $attributes = array(
                        'enctype' => 'multipart/form-data', 'name' => 'signup_form', 'id' => 'form_edit_package', 'autocomplete' => 'off', 'class' => 'card auth_form'
                    );
                    $hidden = array(
                        'txt_update_list_fee' => '', 'txt_fi_code' => '', 'txt_entity' => ''
                    );
                    echo form_open('ptpr/listpackage/update_package_fee', $attributes, $hidden);
                    ?>


                    <!-- <input type="hidden" value="" name="id" /> -->
                    <!-- <input type="hidden" value="" id="txt_update_list_fee" name="data_arr_fee" /> -->
                    <div class="form-body">
                        <hr>

                        <!-- <div class="row clearfix">
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">Package Code : </small>
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
                        </div> -->

                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">Package Code : </small>
                                <input name="v_edit_package_code" id="m_package_code" type="text" class="form-control" maxlength="10" readonly />
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">Limit : </small>
                                <input name="v_edit_limit" id="m_limit" type="text" class="form-control uang" />
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">Price : </small>
                                <input name="v_edit_price" id="m_price" type="text" class="form-control uang" />
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <small class="text-muted">Minimum Limit : </small>
                                <input name="v_edit_min_limit" id="m_minimum_limit" type="text" class="form-control uang" />
                            </div>
                            <div class="col-lg-4 col-md-6">
                            <label> </label>
                                <div class="input-group mb-3" style="border: 0px solid red;padding-top:0px">
                                    
                                    <button type="button" class="btn btn-success" style="margin-top: 0px;" id="btn_add_list_fee">Add Fee</button>
                                </div>
                                
                            </div>
                            
                        </div>
                        <br>
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12">
                                <div class="table-responsive social_media_table">
                                    <table class="table table-hover" id="edit_table_fee" style="font-size: 12px;">
                                        <!-- <hr style="border-top: 1px solid gray;"> -->
                                        <thead>

                                            <tr>
                                                <th>Tran Type</th>
                                                <th>Tran Type Name</th>
                                                <th>Issuer Fee</th>
                                                <th>Acquirer Fee</th>
                                                <th>Switch Fee</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <!-- <hr style="border-top: 1px solid gray;"> -->
                                </div>
                            </div>
                        </div>





                        <hr>


                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <button type="button" id="btnSave" onclick="update_list_package()" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal" id="test_btn">test</button> -->
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="modal_change_fee_package" role="dialog" style="font-size: 12px;">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h6 class="modal-title" id="update_list_package_modal"></h6>
            </div>
            <div class="modal-body form" style="border:0px solid red; padding-top: 1px;padding-bottom: 1px;">
                <form action="#" id="form_update_package" class="form-horizontal">
                    <input type="hidden" value="" name="id" />
                    <div class="form-body">
                        <hr>
                        <div class="col-lg-12 col-md-12">
                            <label>Tran Type</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                </div>
                                <select class="form-control show-tick ms select2" data-placeholder="Select" name="cmb_tran_type_edit" id="v_tran_type_edit">
                                    <option value="">All Tran Type</option>
                                    <option value="01">Withdrawal</option>
                                    <option value="31">Balance Inquriy</option>
                                    <option value="50">Fund Transfer</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12">
                            <label>Issuer Fee</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                </div>
                                <input type="text" class="form-control uang" name="txt_iss_fee_edit" id="v_iss_fee_edit">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <label>Acquirer Fee</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                </div>
                                <input type="text" class="form-control uang" name="txt_fee_acq_edit" id="v_acq_fee_edit">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <label>Switch Fee</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                </div>
                                <input type="text" class="form-control uang" name="txt_fee_swt_edit" id="v_swt_fee_edit">
                            </div>
                        </div>


                        <hr>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-lg-12 col-md-12 col-sm-12" style="border: 0px solid red;padding:0px">
                    <input type="hidden" value="" id="v_index_row" />
                    <button id="submit_change_package_fee" type="button" class="btn btn-primary">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal_update_package" role="dialog" style="font-size: 12px;">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h6 class="modal-title">Update Package</h6>
            </div>
            <div class="modal-body form" style="border:0px solid red; padding-top: 1px;padding-bottom: 1px;">
                <form action="#" id="" class="form-horizontal">
                    <input type="hidden" value="" name="id" />
                    <div class="form-body">
                        <hr>
                        <p id="confirm_update"></p>
                        <hr>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-lg-12 col-md-12 col-sm-12" style="border: 0px solid red;padding:0px">
                    <button type="button" onclick="update_package()" class="btn btn-primary">Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
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