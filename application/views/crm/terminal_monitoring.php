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
    
<div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>CRM</strong> Monitoring </h2>
                            
                        </div>
                        <div class="body">
                            <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                            <?php echo ! empty($table_cardless) ? $table_cardless : '';?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

</section>

<div class="modal fade" id="modal_form" role="dialog" style="font-size: 12px;">
  <div class="modal-dialog modal-dialog-top" role="document">
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
            <p></p>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p><b>Vendor</b></p>
                <div class="col-md-9">
                <select class="form-control show-tick ms select2" id="sVendor" name="cmbVendor" >
                </select>
                </div>
            </div>
            <p></p>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p><b>Datetime Problem</b></p>
                <div class="col-md-9">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="test123"><i class="zmdi zmdi-calendar"></i></span>
                        </div>
                        <input type="text" class="form-control datetimepicker" name="txtdatetime">
                        
                        <!-- <input type="text" class="form-control" placeholder="Please choose date & time..." name="txtdatetime"> -->
                    </div>

                </div>
            </div>
            <p></p>
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


