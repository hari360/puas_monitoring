<section class="content">


    <?php $this->load->view($header_view); ?>


    <div class="container-fluid">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>My Profile</strong> </h2>
                    </div>
                    <div class="container-fluid">
                        <div class="row clearfix">
                            <div class="col-lg-4">
                                <div class="card mcard_3" style="border: 0px solid red">
                                    <div class="body">
                                        <a href="profile.html"><img id="modify_img" src="<?php echo base_url() ?>assets/images/avatar/<?php echo $this->session->userdata('logged_avatar'); ?>" class="rounded-circle shadow " alt="profile-image" height="200" width="200"></a>
                                        <input type="file" name="file_avatar" class="form-control" accept="image/*" style="margin-top:20px;margin-bottom:20px" id="change_img">
                                        <h5 style="border: 0px solid red;"><?php echo $this->session->userdata('logged_full_name'); ?></h5>
                                        <p style="border: 0px solid red;margin-top:-15px"><?php echo $data_profile->role; ?></p>
                                        <?php
                                        $flashmessageexp = $this->session->userdata('expired_pass_in');
                                        if (isset($flashmessageexp)) {
                                        ?>
                                            <div><i><small style="color: red;">Expired password in <?php echo $this->session->userdata('expired_pass_in'); ?> day</small></i></div>
                                        <?php } ?>
                                        <button id="btn_change_img" class="btn btn-success btn-block" data-type="confirm">Submit Image</button>
                                        <button class="btn btn-danger btn-block" onclick="show_modal_change_password()">Change Password</button>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-8 col-md-12">
                                <div class="card">
                                    <div class="body">
                                        <small class="text-muted">User ID </small>
                                        <p><?php echo $this->session->userdata('logged_user_name'); ?></p>
                                        <hr>
                                        <small class="text-muted">Full Name </small>
                                        <p><?php echo $data_profile->full_name; ?></p>
                                        <hr>
                                        <small class="text-muted">Gender </small>
                                        <p><?php echo $data_profile->gender; ?></p>
                                        <hr>
                                        <small class="text-muted">Email address: </small>
                                        <p><?php echo $data_profile->email; ?></p>
                                        <hr>
                                        <small class="text-muted">Date Registered </small>
                                        <p><?php echo $data_profile->date_insert; ?></p>
                                        <hr>
                                        <small class="text-muted">Last Visit </small>
                                        <p><?php echo $data_profile->last_login; ?></p>
                                        <hr>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</section>


<div class="modal fade" id="modal_form_change_password" role="dialog" style="font-size: 12px;">
    <div class="modal-dialog modal-dialog-top" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Change Password</h5>
                <!-- <button id="test_dialog" class="btn btn-raised btn-primary waves-effect" data-type="success">CLICK ME</button> -->
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id" />
                    <div class="form-body">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <p><b>Old Password</b></p>
                            <div class="col-md-9">
                                <input type="password" class="form-control" id="txt_old_password">
                                <span toggle="#txt_old_password" class="fa fa-fw fa-eye field-icon-o toggle-password"></span>
                                <label id="name-error-old-pass" class="error" for="name" style="color: red;display:none">

                                </label>
                                </select>
                            </div>
                        </div>
                        <p></p>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <p><b>New Password</b></p>
                            <div class="col-md-9">
                                <input type="password" class="form-control" id="txt_new_password">
                                <span toggle="#txt_new_password" class="fa fa-fw fa-eye field-icon-n toggle-password"></span>
                                <label id="name-error-new-pass" class="error" for="name" style="color: red;display:none">

                                </label>
                                </select>
                            </div>
                        </div>
                        <p></p>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <p><b>Confirm New Password</b></p>
                            <div class="col-md-9">
                                <input type="password" class="form-control" id="txt_new_conf_password">
                                <span toggle="#txt_new_conf_password" class="fa fa-fw fa-eye field-icon-n-c toggle-password"></span>
                                <label id="name-error-conf-pass" class="error" for="name" style="color: red;display:none">

                                </label>
                                </select>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <button type="button" id="btnSave" onclick="save_change_password()" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->