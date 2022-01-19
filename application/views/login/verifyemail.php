<!doctype html>
<html class="no-js " lang="en">

<!-- Mirrored from wrraptheme.com/templates/aero/html/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 15 Feb 2021 04:32:15 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

    <title>Verification Email</title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo base_url() ?>assets/images/logo-title-alto.ico" type="image/x-icon">
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
            <div class="col-lg-7 center">
                    <?php
                    $attributes = array(
                        'enctype' => 'multipart/form-data',
                        'name' => 'signup_form', 'id' => 'myform', 'autocomplete' => 'off', 'class' => 'card auth_form'
                    );
                    echo form_open('signup', $attributes);
                    ?>
                    <!-- <form class="card auth_form"> -->
                    <div class="header" style="text-align: center;border:0px solid red;padding-bottom:0px">
                        <img class="logo" src="<?php echo base_url() ?>assets/images/logo-alto.png" alt="">
                        <h5>Verification Email Address</h5>
                    </div>
                    <div class="body" style="text-align: center;border:0px solid red;padding-top:0px">
                    <?= $image_notif ?>
                    
                    <br>
                    <?= $message ?>
                    <!-- <a href="javascript: $('#submit_login_temp').val('posting'); $('#myform').submit();" class="btn btn-primary btn-block waves-effect waves-light">SIGN IN</a> -->
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