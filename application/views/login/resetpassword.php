<!doctype html>
<html class="no-js " lang="en">

<!-- Mirrored from wrraptheme.com/templates/aero/html/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 15 Feb 2021 04:32:15 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

    <title>Sign In Monitoring ATMI</title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo base_url() ?>assets/images/logo-title-alto.ico" type="image/x-icon">
    <!-- Custom Css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.min.css">
</head>

<body class="theme-blush" style="background-color: #454A4E">

    <div class="authentication">
        <div class="container">
            <div class="row h-100 justify-content-center align-items-center">

                <div class="col-lg-4 center">
                    <?php
                    $attributes = array(
                        'enctype' => 'multipart/form-data',
                        'name' => 'signup_form', 'id' => 'myform', 'autocomplete' => 'off', 'class' => 'card auth_form'
                    );
                    echo form_open('accounts/forgotpass/resetpass/'.$gettoken, $attributes);
                    ?>
                    <!-- <form class="card auth_form"> -->
                    <div class="header">
                        <img class="logo" src="<?php echo base_url() ?>assets/images/logo-alto.png" alt="">
                        <h5>Terminal Monitoring ATMI</h5>
                    </div>
                    <div class="body">

                        <?php
                        $flashmessage = $this->session->flashdata('messagereqresetpass');
                        if (isset($flashmessage)) {
                        ?>
                            <div class="alert alert-success" role="alert">
                                <strong>Success </strong> <?php echo !empty($flashmessage) ? $flashmessage : ''; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
                                </button>
                            </div>
                        <?php } ?>


                        
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                                </div>

                                <input class="form-control" type="password" placeholder="New Password" name="password" id="v_pass" tabindex="6" value="<?php echo set_value('v_password', isset($default['v_password']) ? $default['v_password'] : ''); ?>" autofocus>
                                <span toggle="#v_pass" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                <?php echo form_error('password', '<div class="input-group" style="height:20px"><label id="name-error" class="error" for="name" style="color: red;">', '</label></div>'); ?>

                            </div>
                        
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="zmdi zmdi-lock-outline"></i></span>
                                </div>
                                <input id="v_conf_pass" type="password" class="form-control" placeholder="Confirm Password" name="conf_password" tabindex="7" value="<?php echo set_value('v_conf_password', isset($default['v_conf_password']) ? $default['v_conf_password'] : ''); ?>">
                                <span toggle="#v_conf_pass" class="fa fa-fw fa-eye field-icon-conf toggle-password"></span>
                                <?php echo form_error('conf_password', '<div class="input-group" style="height:20px"><label id="name-error" class="error" for="name" style="color: red;">', '</label></div>'); ?>
                            </div>
                     



                        <input type="hidden" name="v_token" id="submit_login_temp" value="<?= $gettoken; ?>" />
                        <input type="submit" name="submit_login" id="submit_login" style="display: none;" />
                        <a href="javascript: $('#submit_login_temp').val('posting'); $('#myform').submit();" class="btn btn-primary btn-block waves-effect waves-light">SUBMIT</a>

                        Already have an account click on <a href="<?php echo base_url(); ?>login">Sign In</a>
                    </div>
                    </form>

                </div>
                <!-- <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <img src="<?php echo base_url() ?>assets/images/signin.svg" alt="Sign In"/>
                </div>
            </div> -->
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="<?php echo base_url() ?>assets/bundles/libscripts.bundle.js"></script>
    <script src="<?php echo base_url() ?>assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
    <script src="<?php echo base_url() ?>assets/bundles/myfunction.js"></script>
</body>

<!-- Mirrored from wrraptheme.com/templates/aero/html/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 15 Feb 2021 04:32:16 GMT -->

</html>