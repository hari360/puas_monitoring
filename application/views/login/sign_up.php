<!doctype html>
<html class="no-js " lang="en">

<!-- Mirrored from wrraptheme.com/templates/aero/html/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 15 Feb 2021 04:32:15 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

    <title>Sign Up</title>
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
            <div class="row h-500 justify-content-center align-items-center">

                <div class="col-lg-7 center">
                    <?php
                    $attributes = array(
                        'enctype' => 'multipart/form-data',
                        'name' => 'signup_form', 'id' => 'myform', 'autocomplete' => 'off', 'class' => 'card auth_form'
                    );
                    echo form_open('signup', $attributes);
                    ?>
                    <!-- <form class="card auth_form"> -->
                    <div class="header">
                        <img class="logo" src="<?php echo base_url() ?>assets/images/logo-purwantara.png" alt="">
                        <h5>Monitoring And Reporting</h5>
                    </div>
                    <div class="body">

                        <?php
                        $flashmessage = $this->session->flashdata('messageinsertuser');
                        if (isset($flashmessage)) {
                        ?>
                            <div class="alert alert-success" role="alert">
                                <strong>Success </strong> <?php echo !empty($flashmessage) ? $flashmessage : ''; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="zmdi zmdi-close"></i></span>
                                </button>
                            </div>
                        <?php } ?>

                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="zmdi zmdi-pin-account"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Full Name" name="fullname" tabindex="1" value="<?php echo set_value('v_fullname', isset($default['v_fullname']) ? $default['v_fullname'] : ''); ?>">
                                    <?php echo form_error('fullname', '<div class="input-group" style="height:20px"><label id="name-error" class="error" for="name" style="color: red;">', '</label></div>'); ?>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="User ID" name="userid" tabindex="4" value="<?php echo set_value('v_userid', isset($default['v_userid']) ? $default['v_userid'] : ''); ?>">


                                    <?php echo form_error('userid', '<div class="input-group" style="height:20px"><label id="name-error" class="error" for="name" style="color: red;">', '</label></div>'); ?>

                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Email Name" name="email" id="txtusername" tabindex="5" value="<?php echo set_value('v_email', isset($default['v_email']) ? $default['v_email'] : ''); ?>">
                                    <?php echo form_error('email', '<div class="input-group" style="height:20px"><label id="name-error" class="error" for="name" style="color: red;">', '</label></div>'); ?>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group-append">
                                    <div class="radio inlineblock m-r-20">
                                        <input type="radio" name="gender" id="male" class="with-gap" value="male" tabindex="2">
                                        <label for="male">Male</label>
                                    </div>
                                    <div class="radio inlineblock">
                                        <input type="radio" name="gender" id="Female" class="with-gap" value="female" tabindex="3">
                                        <label for="Female">Female</label>
                                    </div>
                                    <label id="name-error" class="error" for="name" style="color: red;"><?php if (!isset($default['v_gender'])) {  ?>
                                            <?php echo form_error('gender'); ?>
                                        <?php } ?></label>

                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="zmdi zmdi-face"></i></span>
                                    </div>
                                    <input type="file" name="file_avatar" class="form-control" accept="image/*">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                                    </div>

                                    <input class="form-control" type="password" placeholder="Password" name="password" id="v_pass" tabindex="6" value="<?php echo set_value('v_password', isset($default['v_password']) ? $default['v_password'] : ''); ?>">
                                    <span toggle="#v_pass" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    <?php echo form_error('password', '<div class="input-group" style="height:20px"><label id="name-error" class="error" for="name" style="color: red;">', '</label></div>'); ?>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="zmdi zmdi-lock-outline"></i></span>
                                    </div>
                                    <input id="v_conf_pass" type="password" class="form-control" placeholder="Confirm Password" name="conf_password" tabindex="7" value="<?php echo set_value('v_conf_password', isset($default['v_conf_password']) ? $default['v_conf_password'] : ''); ?>">
                                    <span toggle="#v_conf_pass" class="fa fa-fw fa-eye field-icon-conf toggle-password"></span>
                                    <?php echo form_error('conf_password', '<div class="input-group" style="height:20px"><label id="name-error" class="error" for="name" style="color: red;">', '</label></div>'); ?>
                                </div>
                            </div>


                        </div>

                        <input type="hidden" name="v_submit_login" id="submit_login_temp" />
                        <input type="submit" name="submit_login" id="submit_login" style="display: none;" />
                        <a href="javascript: $('#submit_login_temp').val('posting'); $('#myform').submit();" class="btn btn-primary btn-block waves-effect waves-light">SIGN UP</a>
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
                        Already have an account click on <a href="<?php echo base_url(); ?>login">Sign In</a>
                    </div>
                    </form>

                    <!-- <div class="copyright text-center" style="color: white;">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>,
                        <span>Designed by IT Development</span>
                    </div> -->
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