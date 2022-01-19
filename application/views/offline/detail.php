<section class="content">

<?php $this->load->view($header_view);?>

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                        <ul class="nav nav-tabs pl-0 pr-0">
                            <li class="nav-item"><a class="nav-link <?php echo ($id_menu=='1' ? 'active' : ''); ?>" data-toggle="tab" href="#tab_offline">Offline</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo ($id_menu=='2' ? 'active' : ''); ?>" data-toggle="tab" href="#tab_closed">Closed</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo ($id_menu=='3' ? 'active' : ''); ?>" data-toggle="tab" href="#tab_inservice">In Service</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo ($id_menu=='4' ? 'active' : ''); ?>" data-toggle="tab" href="#tab_faulty">Faulty</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo ($id_menu=='5' ? 'active' : ''); ?>" data-toggle="tab" href="#tab_idle">Tran Idle</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo ($id_menu=='6' ? 'active' : ''); ?>" data-toggle="tab" href="#tab_saldo_min">Saldo < 2M</a></li>
                        </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="tab_offline">
                        <div class="container-fluid">
                            <div class="row clearfix">
                                <div class="body" style="width: 100%;">
                                    <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                    <?php echo ! empty($table_offline) ? $table_offline : '';?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane active" id="tab_closed">
                        <div class="container-fluid">
                            <div class="row clearfix">
                                <div class="body" style="width: 100%;">
                                    <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                    <?php echo ! empty($table_closed) ? $table_closed : '';?>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_inservice">
                        <div class="container-fluid">        
                            <div class="row clearfix">
                                <div class="body" style="width: 100%;">
                                    <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                        <?php echo ! empty($table_inservice) ? $table_inservice : '';?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_faulty">
                        <div class="container-fluid">        
                            <div class="row clearfix">
                                <div class="body" style="width: 100%;">
                                    <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                        <?php echo ! empty($table_faulty) ? $table_faulty : '';?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_idle">
                        <div class="container-fluid">        
                            <div class="row clearfix">
                                <div class="body" style="width: 100%;">
                                    <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                        <?php echo ! empty($table_idle) ? $table_idle : '';?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_saldo_min">
                        <div class="container-fluid">        
                            <div class="row clearfix">
                                <div class="body" style="width: 100%;">
                                    <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                        <?php echo ! empty($table_saldo_min) ? $table_saldo_min : '';?>
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

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog" style="font-size: 12px;">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id"/> 
          <div class="form-body">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p><b>Problem</b></p>
                <div class="col-md-9">
                    <select class="form-control show-tick ms select2" data-placeholder="Select" id="sProblem" name="cmbProblem">
                    <option value="">Select Problem</option>
                    <option value="1. CASH HANDLER">1. CASH HANDLER</option>
                    <option value="2. RECEIPT FAULTY">2. RECEIPT FAULTY</option>
                    <option value="3. CARD READER FAULTY">3. CARD READER FAULTY</option>
                    <option value="4. SOFTWARE">4. SOFTWARE</option>
                    <option value="5. DOWN">5. DOWN</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p><b>Vendor</b></p>
                <div class="col-md-9">
                <select class="form-control show-tick ms select2" id="sVendor" name="cmbVendor" >
                </select>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p><b>Date/Time Problem</b></p>
                <div class="col-md-9">
                <input name="txtdatetime" placeholder="Date/Time Problem" class="form-control" type="text" id="basic_example_1" >
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p><b>Description</b></p>
                <div class="col-md-9">
                <textarea name="txtdescription" placeholder="Description" class="form-control" rows="3"></textarea>
                </div>
            </div>     
          </div>
        </form>
    </div>
          <div class="modal-footer">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
          </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<style>
    td.details-control {
        background: url('<?php echo base_url();?>assets/images/details_open.png') no-repeat center center;
        cursor: pointer;
    }

    tr.shown td.details-control {
    background: url('<?php echo base_url();?>assets/images/details_close.png') no-repeat center center;
    }

    table.dataTable tbody th, table.dataTable tbody td {
    padding: 8px; /* e.g. change 8x to 4px here */
    }
</style>
