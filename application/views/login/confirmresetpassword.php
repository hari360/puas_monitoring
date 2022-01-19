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
                                
                            </div>
                        <?php } ?>     

                        <div class="alert alert-success" role="alert">
                                <strong>Success </strong> your password has been changed
                                
                            </div>      

                        <a href="<?php echo base_url(); ?>login">Sign In</a>
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