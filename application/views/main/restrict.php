<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
    <title>Restricted Page</title>
    <link rel="icon" href="<?php echo base_url() ?>assets/images/logo-title-alto.ico" type="image/x-icon"> <!-- Favicon-->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.min.css">

</head>

<body class="theme-blush">

<div class="authentication">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <form class="card auth_form">
                    <div class="header">
                        <img class="logo" src="<?php echo base_url() ?>assets/images/logo-alto.png" alt="">
                        <h5>Restricted Account</h5>
                        <span>Your account has been restricted for URL access</span>
                    </div>
                    <div class="body">
                        
                        <a href="<?php echo base_url(); ?>dashboard" class="btn btn-primary btn-block waves-effect waves-light">GO TO HOMEPAGE</a>                        
                        <div class="signin_with mt-3">
                            <a href="javascript:void(0);" class="link">Need Help?</a>
                        </div>
                    </div>
                </form>
                <div class="copyright text-center">
                    &copy;
                    <script>document.write(new Date().getFullYear())</script>,
                    <span>Designed by IT Reporting Developer</span>
                </div>
            </div>
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <img src="<?php echo base_url() ?>assets/images/restrict_page.png" alt="403" />
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Jquery Core Js -->
<script src="<?php echo base_url() ?>assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) -->
    <script src="<?php echo base_url() ?>assets/bundles/vendorscripts.bundle.js"></script> <!-- slimscroll, waves Scripts Plugin Js -->
</body>

<!-- Mirrored from wrraptheme.com/templates/aero/html/404.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 15 Feb 2021 04:33:03 GMT -->
</html>