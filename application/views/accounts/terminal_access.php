<section class="content">


    <?php $this->load->view($header_view); ?>


    <?php
    $flashmessage = $this->session->flashdata('messageinserttermaccess');
    $flashmessagefailed = $this->session->flashdata('messageinserttermaccessfailed');
    if (isset($flashmessage)) {
    ?>
        <div class="alert alert-success" role="alert">
            <strong>Success </strong> <?php echo !empty($flashmessage) ? $flashmessage : ''; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
            </button>
        </div>
    <?php }if (isset($flashmessagefailed)) { ?>
        <div class="alert alert-danger" role="alert">
            <strong>Failed </strong> <?php echo !empty($flashmessagefailed) ? $flashmessagefailed : ''; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
            </button>
        </div>
    <?php } ?>

    <div class="container-fluid">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Set </strong> Terminal Access </h2>

                    </div>
                    <div class="body">


                    <!-- <?php
                                $attributes = array('name' => 'upload_form_terminal'
                                                    ,'id' => 'formuploadterminal'
                                                    ,'autocomplete' => 'off'
                                                    ,'enctype' => 'multipart/form-data'
                                                    ,'class' => 'card auth_form');
                                echo form_open('accounts/terminalaccess/upload_excel', $attributes);
                            ?> -->
                    <!-- <label for="email_address">only excel files</label>
                                <div class="form-group">                                
                                    <input type="file" name="file_xlsx[]" id="fileInput" class="form-control" accept=".xlsx" multiple>
                                    <div class="progress m-b-5">
                                        <div id="v_progress" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%"> <span class="sr-only">40% Complete (success)</span> </div>
                                    </div>
                                </div>

                        <button id="btn_upload_excel" type="submit" class="btn btn-raised btn-primary">Upload File</button> -->
                        <button id="btn_add_terminal_access" type="button" class="btn btn-raised btn-success">Add New Data</button>
                        <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif;">
                            <?php echo !empty($table_my_terminal_access) ? $table_my_terminal_access : ''; ?>
                        </div>

                        <!-- </form> -->


                    </div>
                </div>
            </div>
        </div>

         

</section>
<div class="modal fade" id="modal_delete_term_access" role="dialog" style="font-size: 12px;">
  <div class="modal-dialog modal-dialog-top" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h6 class="modal-title">Delete Terminal Access</h6> 
      </div>
      <div class="modal-body form" style="border:0px solid red; padding-top: 1px;padding-bottom: 1px;">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="id"/> 
          <div class="form-body">
          <hr>
            <p id="confirm_delete"></p>
            <hr>
          </div>
        </form>
    </div>
          <div class="modal-footer">
          <div class="col-lg-12 col-md-12 col-sm-12" style="border: 0px solid red;padding:0px">
            <button type="button" onclick="delete_terminal_id_access()" class="btn btn-primary">Yes</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
          </div>
          </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div class="modal fade" id="modal_edit_term_access" role="dialog" style="font-size: 12px;">
  <div class="modal-dialog modal-lg" role="document" style="font-size: 12px;border:0px solid red;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="v_title_accounts"></h5>
      </div>
      <div class="modal-body form" style="border: 0px solid red;padding-top: 0px">
      <div class="loader" id="loader_process_edit"><div class="m-t-30"><img class="zmdi-hc-spin" src="/new_web_monitoring_atmi/assets/images/loader.svg" width="48" height="48" alt="Aero"></div><p>Processing...</p></div>
        <form action="#" id="form_terminal_access" class="form-horizontal">
          <input type="hidden" value="" name="id" />
          <div class="form-body">
            <hr>

            <div class="row clearfix">
            <div class="col-sm-6">
                <b>User ID</b>
                <div class="form-group">
                  <input id="txt_user_id" type="text" class="form-control" disabled />

                  <div id="cmbSelect2">
                  <!-- <select class="form-control show-tick ms select2" id="cobaCmb">
                      <option value="1">One</option>
                  </select> -->
                  <select class="form-control show-tick ms select2" id="cAddUserTerm" name="cmbAddUserTerm" >
                  <option value="">Please select user id</option>
                  <?= $list_user; ?>
                  </select>
                  </div>
                  
                </div>
              </div>

              <div class="col-sm-6">
                <b>Full Name</b>
                <div class="form-group">
                  <input id="txt_full_name" type="text" class="form-control" disabled />
                </div>
              </div>
              
            </div>

            <!-- <div class="row clearfix">
              <div class="col-sm-6">
                <b>Prefix ATM</b>
                <div class="form-group">
                  <input id="txt_prefix_atm" type="text" class="form-control" disabled />
                </div>
              </div>
            </div> -->

            <div class="row clearfix">
              <div class="col-sm-12">
                <!-- <b>Access Menu</b> -->
                <div class="form-group">
                  <select id="optgroup" class="ms" multiple="multiple" name="searchable[]">
                    <?php echo $list_terminal; ?>
                  </select>
                </div>
              </div>
            </div>



            <hr>


          </div>
        </form>
      </div>
      <div class="modal-footer">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <button type="button" id="btnSave" onclick="update_terminal_user()" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <!-- <button type="button" class="btn btn-danger" data-dismiss="modal" id="test_btn">test</button> -->
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