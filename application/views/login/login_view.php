<!doctype html>
<html class="no-js " lang="en">

<!-- Mirrored from wrraptheme.com/templates/aero/html/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 15 Feb 2021 04:32:15 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

    <title>Sign In</title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo base_url() ?>assets/images/logo-title-purwantara.ico" type="image/x-icon">
    <!-- Custom Css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style_pass.css">
</head>

<body class="theme-blush" style="background-color: #454A4E">

    <div class="authentication">
        <div class="container">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-lg-4 center">
                    <?php
                    $attributes = array(
                        'name' => 'login_form', 'id' => 'myform', 'autocomplete' => 'off', 'class' => 'card auth_form'
                    );
                    echo form_open('login/form', $attributes);
                    ?>
                    <!-- <form class="card auth_form"> -->
                    <div class="header">
                        <img class="logo" src="<?php echo base_url() ?>assets/images/logo-purwantara.png" alt="">
                        <h5>Monitoring And Reporting</h5>
                    </div>
                    <div class="body">
                        <?php
                        $flashmessage = $this->session->flashdata('messageinsertuser');
                        $flashmessagelock = $this->session->flashdata('messagelock');
                        $flashmessageexppass = $this->session->flashdata('messageexppass');
                        $flashmessageemail = $this->session->flashdata('messageemail');
                        $flashmessageuserid = $this->session->flashdata('messageuserid');
                        if (isset($flashmessageuserid)) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <strong>Failed </strong> <?php echo !empty($flashmessageuserid) ? $flashmessageuserid : ''; ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
                                    </button>
                                </div>
                            <?php } 
                        if (isset($flashmessageemail)) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <strong>Failed </strong> <?php echo !empty($flashmessageemail) ? $flashmessageemail : ''; ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
                                    </button>
                                </div>
                            <?php } 
                        if (isset($flashmessage)) {
                        ?>
                            <div class="alert alert-warning" role="alert">
                                <strong>Failed </strong> <?php echo !empty($flashmessage) ? $flashmessage : ''; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
                                </button>
                            </div>
                        <?php } 
                        if (isset($flashmessagelock)) {
                        ?>
                            <div class="alert alert-danger" role="alert">
                                <strong>Failed </strong> <?php echo !empty($flashmessagelock) ? $flashmessagelock : ''; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
                                </button>
                            </div>
                        <?php } 
                        if (isset($flashmessageexppass)) {
                        ?>
                            <div class="alert alert-danger" role="alert">
                                <strong>Failed </strong> <?php echo !empty($flashmessageexppass) ? $flashmessageexppass : ''; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
                                </button>
                            </div>
                        <?php } ?>

                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="User ID" name="username" id="txtusername" tabindex="1" autofocus value="<?php echo set_value('v_username', isset($default['v_username']) ? $default['v_username'] : ''); ?>">
                            <?php echo form_error('username', '<div class="input-group" style="height:20px"><label id="name-error" class="error" for="name" style="color: red;">', '</label></div>'); ?>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"><a href="forgot-password.html" class="forgot" title="Forgot Password"><i class="zmdi zmdi-lock"></i></a></span>
                            </div>
                            <input type="password" class="form-control" placeholder="Password" name="password" id="v_pass" tabindex="2" value="<?php echo set_value('v_password', isset($default['v_password']) ? $default['v_password'] : ''); ?>">
                            <span toggle="#v_pass" class="fa fa-fw fa-eye field-icon-log toggle-password"></span>
                            <?php echo form_error('password', '<div class="input-group" style="height:20px"><label id="name-error" class="error" for="name" style="color: red;">', '</label></div>'); ?>
                        </div>
                        <div class="row px-3 mb-4">
                        <a href="<?php echo base_url(); ?>accounts\forgotpass" class="ml-auto mb-0 text-sm">Forgot Password?</a>
                        </div>
                        <!-- <div class="row px-3 mb-4">
                            <div class="checkbox">
                                <input id="show_password" type="checkbox" onclick="myFunction()">
                                <label for="show_password">Show password</label>
                            </div>
                            <a href="<?php echo base_url(); ?>accounts\forgotpass" class="ml-auto mb-0 text-sm">Forgot Password?</a>
                        </div> -->





                        <input type="hidden" name="v_submit_login" id="submit_login_temp" />
                        <input type="submit" name="submit_login" id="submit_login" style="display: none;" />
                        <a href="javascript: $('#submit_login_temp').val('posting'); $('#myform').submit();" class="btn btn-primary btn-block waves-effect waves-light">SIGN IN</a>
                        <!-- <div class="signin_with mt-3">
                            <p class="mb-0">or Sign Up using</p>
                            <button class="btn btn-primary btn-icon btn-icon-mini btn-round facebook"><i class="zmdi zmdi-facebook"></i></button>
                            <button class="btn btn-primary btn-icon btn-icon-mini btn-round twitter"><i class="zmdi zmdi-twitter"></i></button>
                            <button class="btn btn-primary btn-icon btn-icon-mini btn-round google"><i class="zmdi zmdi-google-plus"></i></button>
                        </div> -->
                        <!-- <div class="checkbox">
                            <input id="remember_me" type="checkbox">
                            <label for="remember_me">Remember me</label>
                        </div> -->
                        Don't have an account yet? <a href="<?php echo base_url(); ?>signup">Sign Up here</a>
                    </div>
                    </form>

                    <div class="copyright text-center" style="color: white;">
                        <!-- PT ALTO Network &copy;2021  -->
                        <!-- <script>
                            document.write(new Date().getFullYear())
                        </script>,
                        <span>Designed by IT Reporting Developer</span> -->
                    </div>
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
    <script src="<?php echo base_url() ?>assets/bundles/myfunctionpass.js"></script>
</body>

<!-- Mirrored from wrraptheme.com/templates/aero/html/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 15 Feb 2021 04:32:16 GMT -->

</html>