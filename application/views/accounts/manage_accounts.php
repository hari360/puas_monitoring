<section class="content">


  <?php $this->load->view($header_view); ?>


  <div class="container-fluid">
    <!-- Basic Examples -->
    <div class="row clearfix">
      <div class="col-lg-12">
        <div class="card">
          <div class="header">
            <h2><strong>Manage </strong> Accounts </h2>

          </div>
          <div class="body">
            <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
              <?php echo !empty($table_manage_accounts) ? $table_manage_accounts : ''; ?>
            </div>
          </div>
        </div>
      </div>
    </div>

</section>


<div class="modal fade" id="modal_edit_accounts" role="dialog" style="font-size: 12px;">
  <div class="modal-dialog modal-lg" role="document" style="font-size: 12px;border:0px solid red;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="v_title_accounts"></h5>
      </div>
      <div class="modal-body form" style="border: 0px solid red;padding-top: 0px">
      <div class="loader" id="loader_process"><div class="m-t-30"><img class="zmdi-hc-spin" src="<?php echo base_url() ?>assets/images/loader.svg" width="48" height="48" alt="Aero"></div><p>Processing...</p></div>
        <form action="#" id="form_accounts" class="form-horizontal">
          <input type="hidden" value="" name="id" />
          <div class="form-body">
            <hr>

            <div class="row clearfix">
              <div class="col-sm-6">
                <b>Full Name</b>
                <div class="form-group">
                  <input id="txt_full_name" type="text" class="form-control" disabled />
                </div>
              </div>
              <div class="col-sm-6">
                <b>User ID</b>
                <div class="form-group">
                  <input id="txt_user_id" type="text" class="form-control" disabled />
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-sm-6">
                <b>Gender</b>
                <div class="form-group">
                  <input id="txt_gender" type="text" class="form-control" disabled />
                </div>
              </div>
              <div class="col-sm-6">
                <b>Email</b>
                <div class="form-group">
                  <input id="txt_email" type="text" class="form-control" disabled />
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-sm-6">
                <b>Active</b>
                <div class="form-group">
                  <select class="form-control show-tick ms select2" id="cActive" name="cmbProblem">
                    <!-- <option value="">Select Status</option> -->
                    <option value="1">Active</option>
                    <option value="0">Non Active</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-6">
                <b>Lock Status</b>
                <div class="form-group">
                  <select class="form-control show-tick ms select2" id="cLock" name="cmbProblem">
                    <!-- <option value="">Select Status</option> -->
                    <option value="unlock">Unlock</option>
                    <option value="lock">Lock</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-sm-6">
                <b>Role</b>
                <div class="form-group">
                  <select class="form-control show-tick ms select2" id="cRole" name="cmbProblem">
                    <!-- <option value="">Select Status</option> -->
                    <option value="1">Administrator</option>
                    <option value="2">Supervisor</option>
                    <option value="3">User</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-sm-12">
                <!-- <b>Access Menu</b> -->
                <div class="form-group">
                  <select id="optgroup" class="ms" multiple="multiple" name="searchable[]">
                    <?= $list_menu; ?>
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
          <button type="button" id="btnSave" onclick="save_account()" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <!-- <button type="button" class="btn btn-danger" data-dismiss="modal" id="test_btn">test</button> -->
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="modal_delete_account" role="dialog" style="font-size: 12px;">
  <div class="modal-dialog modal-dialog-top" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h6 class="modal-title">Delete Account</h6>
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
          <button type="button" onclick="delete_account_id()" class="btn btn-primary">Yes</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="<?php echo base_url() ?>assets/bundles/manageaccounts.js"></script>