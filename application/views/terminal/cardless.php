<section class="content">

<?php 
            $flashmessage = $this->session->flashdata('messageinsertflm'); 
            if (isset($flashmessage)) { 
          ?>
            <div class="alert alert-success" >
                <strong>Well done!</strong> FLM Has Been Submit Succesfully
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          <?php } ?>

<?php $this->load->view($header_view);?>
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
                    <?php echo ! empty($table) ? $table : '';?>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                        <ul class="nav nav-tabs pl-0 pr-0">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab_terminal">Terminal</a></li>
                            <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_card_retain">Card Retain</a></li> -->
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_log">Log</a></li>
                        </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_terminal">
                        <div class="container-fluid">
                            <div class="row clearfix">
                                <div class="body" style="width: 100%;">
                                    <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                    <?php echo ! empty($table) ? $table : '';?>
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
                    <div class="tab-pane" id="tab_log">
                        <div class="container-fluid">        
                            <div class="row clearfix">
                                <div class="body" style="width: 100%;">
                                    <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                        <?php echo ! empty($table_log) ? $table_log : '';?>
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
