<!doctype html>
<html class="no-js " lang="en">

<!-- Mirrored from wrraptheme.com/templates/aero/html/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 15 Feb 2021 04:31:43 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
    <title><?php echo $title; ?></title>
    <link rel="icon" href="<?php echo base_url() ?>assets/images/logo-title-purwantara.ico" type="image/x-icon"> <!-- Favicon-->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/charts-c3/plugin.css" />

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/morrisjs/morris.min.css" />

    <!-- JQuery DataTable Css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css">

    <link href="<?php echo base_url() ?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <link href="<?php echo base_url() ?>assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/select2/select2.css" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/mystyle.css">

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/datetimepicker/bootstrap-clockpicker.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/sweetalert/sweetalert.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/multi-select/css/multi-select.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/nouislider/nouislider.min.css">


    <link rel="stylesheet" href="<?php echo base_url() ?>assets_x/style.css">

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style_pass.css">



    <style>
        .icon-badge-group .icon-badge-container {
            display: inline-block;
            margin-left: 5px;
        }

        .icon-badge-group .icon-badge-container:first-child {
            margin-left: 0
        }

        .icon-badge-container {
            margin-top: 5px;
            position: relative;
            display: inline-block;
        }

        .icon-badge-icon {
            font-size: 22px;
            position: relative;
        }

        .icon-badge {
            background-color: red;
            font-size: 10px;
            color: white;
            text-align: center;
            width: 15px;
            height: 15px;
            border-radius: 35%;
            position: absolute;
            top: -12px;
            right: -10px;
        }
    </style>

    <?php if ($content_view == "crm/dashboard_trans") { ?>
        <style>
            tr.group,
            tr.group:hover {
                background-color: #ddd !important;
            }
        </style>
    <?php } ?>

</head>

<body class="theme-blush right_icon_toggle ls-toggle-menu">

    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
        <div class="m-t-30"><img class="zmdi-hc-spin" src="<?php echo base_url() ?>assets/images/loader.svg" width="48" height="48" alt="Aero"></div>
            <p>Please wait...</p>
        </div>
    </div>

    <aside id="leftsidebar" class="sidebar">
        <div class="navbar-brand">
            <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
            <a href="index.html"><img src="<?php echo base_url() ?>assets/images/logo-purwantara.png" height="30" width="30" alt="Purwantara"><span class="m-l-10">Monitoring</span></a>
        </div>
        <div class="menu">
            <ul class="list">
                <li>
                    <div class="user-info">
                        <a class="image" style="cursor: default;">
                            <img src="<?php echo base_url() ?>assets/images/avatar/<?php echo $this->session->userdata('logged_avatar'); ?>" alt="User">
                        </a>
                        <div class="detail">
                            <h4><?php echo $this->session->userdata('logged_full_name'); ?></h4>
                            <small><?php echo $this->session->userdata('logged_role'); ?></small>

                        </div>
                    </div>
                </li>
                <li class="active open"><a href="<?php echo base_url(); ?>dashboard"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
                <!-- <li><a href="<?php echo base_url(); ?>crm/dashboard"><i class="zmdi zmdi-camera-alt"></i><span>Dashboard CRM</span></a></li> -->
                <!-- <li><a href="<?php echo base_url(); ?>chart/statistic"><i class="zmdi zmdi-chart"></i><span>Statistic</span></a></li> -->

                <?php
                $close_bracket = '';
                $i = 0;
                foreach ($this->session->userdata('list_access_menu') as $get_menu_home) {
                    if ($get_menu_home[0] == 'Accounts') {
                        if ($i == 0) {
                            echo '<li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account"></i><span>Accounts</span></a>
                                            <ul class="ml-menu">';
                            $close_bracket = '</ul></li>';
                        }
                        switch ($get_menu_home[1]) {
                            case "Profile":
                                echo '<li><a href="' . base_url() . 'accounts/profile">' . $get_menu_home[1] . '</a></li>';
                                break;
                            case "Terminal Access":
                                echo '<li><a href="' . base_url() . 'accounts/terminalaccess">' . $get_menu_home[1] . '</a></li><hr>';
                                break;
                            case "Manage Accounts":
                                echo '<li><a href="' . base_url() . 'accounts/manageaccounts/setup">' . $get_menu_home[1] . '</a></li>';
                                break;
                        }
                        $i++;
                    }
                }
                echo $close_bracket;

                $close_bracket = '';
                $i_atm = 0;
                foreach ($this->session->userdata('list_access_menu') as $get_menu) {
                    if ($get_menu[0] == 'ATM') {
                        if ($i_atm == 0) {
                            echo '<li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-apps"></i><span>ATM</span></a>
                                            <ul class="ml-menu">';
                            $close_bracket = '</ul></li>';
                        }
                        switch ($get_menu[1]) {
                            case "Terminal Monitoring":
                                echo '<li><a href="' . base_url() . 'atm/monitoring">' . $get_menu[1] . '</a></li>';
                                break;
                            case "Card Retain":
                                echo '<li><a href="' . base_url() . 'atm/cardretain">' . $get_menu[1] . '</a></li>';
                                break;
                            case "Log Terminal":
                                echo '<li><a href="' . base_url() . 'atm/logterminal">' . $get_menu[1] . '</a></li>';
                                break;
                            case "Count Transaction":
                                echo '<li><a href="' . base_url() . 'atm/counttrx">' . $get_menu[1] . '</a></li><hr>';
                                break;
                            case "Batch Viewer":
                                echo '<li><a href="' . base_url() . 'atm/batchviewer">' . $get_menu[1] . '</a></li>';
                                break;
                            case "Saldo Terminal":
                                echo '<li><a href="' . base_url() . 'atm/saldoterm">' . $get_menu[1] . '</a></li>';
                                break;
                            case "Cardholder Did Not Take":
                                echo '<li><a href="' . base_url() . 'atm/cardholdernottake">' . $get_menu[1] . '</a></li>';
                                break;
                            case "Parameterize Saldo":
                                echo '<li><a href="' . base_url() . 'atm/parameterize">' . $get_menu[1] . '</a></li>';
                                break;
                            case "History FLM/SLM":
                                echo '<li><a href="' . base_url() . 'atm/historyflmslm">' . $get_menu[1] . '</a></li>';
                                break;
                                // default:
                                //   echo "Your favorite color is neither red, blue, nor green!";
                        }
                        $i_atm++;
                    }
                }
                echo $close_bracket;
                ?>


                <!-- <li><a href="<?php echo base_url(); ?>atm/logterminal">Log Terminal</a></li>
                        <li><a href="<?php echo base_url(); ?>atm/counttrx">Count Transaction</a></li>
                        <hr>
                        <li><a href="<?php echo base_url(); ?>atm/batchviewer">Batch Viewer</a></li>
                        <li><a href="<?php echo base_url(); ?>atm/saldoterm">Saldo Terminal</a></li> -->
                <!-- <li><a href="<?php echo base_url(); ?>atm/cardholdernottake">Cardholder Did Not Take</a></li>
                        <li><a href="<?php echo base_url(); ?>atm/parameterize">Parameterize Saldo</a></li>
                        <li><a href="<?php echo base_url(); ?>atm/historyflmslm">History FLM/SLM</a></li> -->
                <!-- </ul>
                </li> -->

                <!-- <?php
                        //if ($this->session->userdata('logged_role') == "User") {
                        ?> -->
                <!-- <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-assignment"></i><span>CRM</span></a>
                    <ul class="ml-menu"> -->

                <?php
                $close_bracket = '';
                $i = 0;
                foreach ($this->session->userdata('list_access_menu') as $get_menu_crm) {
                    if ($get_menu_crm[0] == 'CRM') {
                        if ($i == 0) {
                            echo '<li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-cast"></i><span>CRM</span></a>
                                            <ul class="ml-menu">';
                            $close_bracket = '</ul></li>';
                        }
                        switch ($get_menu_crm[1]) {
                                // case "Dashboard CRM":
                                //     echo '<li><a href="' . base_url() . 'crm/dashboard">' . $get_menu_crm[1] . '</a></li>';
                                //     break;
                            case "Terminal Monitoring":
                                echo '<li><a href="' . base_url() . 'crm/monitoring">' . $get_menu_crm[1] . '</a></li>';
                                break;
                            case "Card Retain":
                                echo '<li><a href="' . base_url() . 'crm/counttrx">' . $get_menu_crm[1] . '</a></li>';
                                break;
                            case "Log Terminal":
                                echo '<li><a href="' . base_url() . 'crm/logterminal">' . $get_menu_crm[1] . '</a></li><hr>';
                                break;
                            case "Count Transaction":
                                echo '<li><a href="' . base_url() . 'crm/transactions">' . $get_menu_crm[1] . '</a></li>';
                                break;
                            case "Batch Viewer":
                                echo '<li><a href="' . base_url() . 'crm/batchviewer">' . $get_menu_crm[1] . '</a></li>';
                                break;
                            case "History Data FLM/SLM":
                                echo '<li><a href="' . base_url() . 'crm/historyflmslm">' . $get_menu_crm[1] . '</a></li>';
                                break;
                        }
                        $i++;
                    }
                }
                echo $close_bracket;
                ?>

                <!-- <li><a href="<?php echo base_url(); ?>log/terminal">Log Terminal</a></li> -->
                <!-- <li><a href="<?php echo base_url(); ?>crm/monitoring">Terminal Monitoring</a></li>
                            <li><a href="<?php echo base_url(); ?>crm/logterminal">Log Terminal</a></li>
                            <li><a href="<?php echo base_url(); ?>crm/counttrx">Count Transaction</a></li>
                            <hr>
                            <li><a href="<?php echo base_url(); ?>crm/transactions">Terminal Monitor Transactions</a></li>
                            <li><a href="<?php echo base_url(); ?>crm/batchviewer">Batch Viewer</a></li>
                            <li><a href="<?php echo base_url(); ?>crm/historyflmslm">History Data FLM/SLM</a></li> -->


                <!-- <li>
                <a href="javascript:void(0);" title="Notifications" data-toggle="dropdown" role="button"> -->
                <!-- <i class="zmdi zmdi-notifications"></i> -->
                <!-- <div class="icon-badge-container">
                        <i class="zmdi zmdi-notifications icon-badge-icon"></i>
                        <div class="icon-badge">6</div>
                    </div>
                    <span>Notifications</span>
                </a>
            </li> -->

                <!-- <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-assignment"></i><span>Reporting</span></a>
                    <ul class="ml-menu">
                        <li><a href="<?php echo base_url(); ?>reporting/iso">Generate Report ISO</a></li>
                        <li><a href="<?php echo base_url(); ?>reporting/querytrx">Query Transactions</a></li>
                    </ul>

                </li> -->

                <?php
                $close_bracket = '';
                                $i = 0;
                foreach ($this->session->userdata('list_access_menu') as $get_menu_home) {
                    if ($get_menu_home[0] == 'Reporting') {
                        if ($i == 0) {
                            echo '<li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-assignment"></i><span>Reporting</span></a>
                                            <ul class="ml-menu">';
                            $close_bracket = '</ul></li>';
                        }
                        switch ($get_menu_home[1]) {
                            case "Generate Report":
                                echo '<li><a href="' . base_url() . 'reporting/iso">' . $get_menu_home[1] . '</a></li>';
                                break;
                            case "Query Transactions":
                                echo '<li><a href="' . base_url() . 'reporting/querytrx">' . $get_menu_home[1] . '</a></li><hr>';
                                break;

                        }
                        $i++;
                    }
                }
                echo $close_bracket;
                ?>

                <li class="open"><a href="<?php echo base_url(); ?>login/logout"><i class="zmdi zmdi-power"></i><span>LogOut</span></a></li>


                <!-- <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-assignment"></i><span>Terminal</span></a>
                <ul class="ml-menu">
                    <li><a href="project-list.html">Projects List</a></li>
                    <li><a href="taskboard.html">Taskboard</a></li>
                    <li><a href="ticket-list.html">Ticket List</a></li>
                    <li><a href="ticket-detail.html">Ticket Detail</a></li>
                </ul>
            </li>
            <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-folder"></i><span>File Manager</span></a>
                <ul class="ml-menu">
                    <li><a href="file-dashboard.html">All File</a></li>
                    <li><a href="file-documents.html">Documents</a></li>
                    <li><a href="file-images.html">Images</a></li>
                    <li><a href="file-media.html">Media</a></li>
                </ul>
            </li>
            <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-blogger"></i><span>Blog</span></a>
                <ul class="ml-menu">
                    <li><a href="blog-dashboard.html">Dashboard</a></li>
                    <li><a href="blog-post.html">Blog Post</a></li>
                    <li><a href="blog-list.html">List View</a></li>
                    <li><a href="blog-grid.html">Grid View</a></li>
                    <li><a href="blog-details.html">Blog Details</a></li>
                </ul>
            </li>
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Ecommerce</span></a>
                <ul class="ml-menu">
                    <li><a href="ec-dashboard.html">Dashboard</a></li>
                    <li><a href="ec-product.html">Product</a></li>
                    <li><a href="ec-product-List.html">Product List</a></li>
                    <li><a href="ec-product-detail.html">Product detail</a></li>
                </ul>
            </li>
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-swap-alt"></i><span>Components</span></a>
                <ul class="ml-menu">
                    <li><a href="ui_kit.html">Aero UI KIT</a></li>                    
                    <li><a href="alerts.html">Alerts</a></li>                    
                    <li><a href="collapse.html">Collapse</a></li>
                    <li><a href="colors.html">Colors</a></li>
                    <li><a href="dialogs.html">Dialogs</a></li>                    
                    <li><a href="list-group.html">List Group</a></li>
                    <li><a href="media-object.html">Media Object</a></li>
                    <li><a href="modals.html">Modals</a></li>
                    <li><a href="notifications.html">Notifications</a></li>                    
                    <li><a href="progressbars.html">Progress Bars</a></li>
                    <li><a href="range-sliders.html">Range Sliders</a></li>
                    <li><a href="sortable-nestable.html">Sortable & Nestable</a></li>
                    <li><a href="tabs.html">Tabs</a></li>
                    <li><a href="waves.html">Waves</a></li>
                </ul>
            </li>
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-flower"></i><span>Font Icons</span></a>
                <ul class="ml-menu">
                    <li><a href="icons.html">Material Icons</a></li>
                    <li><a href="icons-themify.html">Themify Icons</a></li>
                    <li><a href="icons-weather.html">Weather Icons</a></li>
                </ul>
            </li>
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-assignment"></i><span>Forms</span></a>
                <ul class="ml-menu">
                    <li><a href="basic-form-elements.html">Basic Form</a></li>
                    <li><a href="advanced-form-elements.html">Advanced Form</a></li>
                    <li><a href="form-examples.html">Form Examples</a></li>
                    <li><a href="form-validation.html">Form Validation</a></li>
                    <li><a href="form-wizard.html">Form Wizard</a></li>
                    <li><a href="form-editors.html">Editors</a></li>
                    <li><a href="form-upload.html">File Upload</a></li>
                    <li><a href="form-summernote.html">Summernote</a></li>
                </ul>
            </li>
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-grid"></i><span>Tables</span></a>
                <ul class="ml-menu">
                    <li><a href="normal-tables.html">Normal Tables</a></li>
                    <li><a href="jquery-datatable.html">Jquery Datatables</a></li>
                    <li><a href="editable-table.html">Editable Tables</a></li>
                    <li><a href="footable.html">Foo Tables</a></li>
                    <li><a href="table-color.html">Tables Color</a></li>
                </ul>
            </li>            
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-chart"></i><span>Charts</span></a>
                <ul class="ml-menu">
                    <li><a href="echarts.html">E Chart</a></li>
                    <li><a href="c3.html">C3 Chart</a></li>
                    <li><a href="morris.html">Morris</a></li>
                    <li><a href="flot.html">Flot</a></li>
                    <li><a href="chartjs.html">ChartJS</a></li>
                    <li><a href="sparkline.html">Sparkline</a></li>
                    <li><a href="jquery-knob.html">Jquery Knob</a></li>
                </ul>
            </li>            
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-delicious"></i><span>Widgets</span></a>
                <ul class="ml-menu">
                    <li><a href="widgets-app.html">Apps Widgets</a></li>
                    <li><a href="widgets-data.html">Data Widgets</a></li>
                </ul>
            </li>
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-lock"></i><span>Authentication</span></a>
                <ul class="ml-menu">
                    <li><a href="sign-in.html">Sign In</a></li>
                    <li><a href="sign-up.html">Sign Up</a></li>
                    <li><a href="forgot-password.html">Forgot Password</a></li>
                    <li><a href="404.html">Page 404</a></li>
                    <li><a href="500.html">Page 500</a></li>
                    <li><a href="page-offline.html">Page Offline</a></li>
                    <li><a href="locked.html">Locked Screen</a></li>
                </ul>
            </li>
            <li class="open_top"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-copy"></i><span>Sample Pages</span></a>
                <ul class="ml-menu">
                    <li><a href="blank.html">Blank Page</a></li>
                    <li><a href="image-gallery.html">Image Gallery</a></li>
                    <li><a href="profile.html">Profile</a></li>
                    <li><a href="timeline.html">Timeline</a></li>
                    <li><a href="pricing.html">Pricing</a></li>
                    <li><a href="invoices.html">Invoices</a></li>
                    <li><a href="invoices-list.html">Invoices List</a></li>
                    <li><a href="search-results.html">Search Results</a></li>
                </ul>
            </li>
            <li class="open_top"><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-map"></i><span>Maps</span></a>
                <ul class="ml-menu">
                    <li><a href="google.html">Google Map</a></li>
                    <li><a href="yandex.html">YandexMap</a></li>
                    <li><a href="jvectormap.html">jVectorMap</a></li>
                </ul>
            </li>
            <li>
                <div class="progress-container progress-primary m-t-10">
                    <span class="progress-badge">Traffic this Month</span>
                    <div class="progress">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100" style="width: 67%;">
                            <span class="progress-value">67%</span>
                        </div>
                    </div>
                </div>
                <div class="progress-container progress-info">
                    <span class="progress-badge">Server Load</span>
                    <div class="progress">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="86" aria-valuemin="0" aria-valuemax="100" style="width: 86%;">
                            <span class="progress-value">86%</span>
                        </div>
                    </div>
                </div>
            </li> -->
            </ul>
        </div>
    </aside>

    <?php $this->load->view($content_view); ?>

    <!-- Jquery Core Js -->
    <script src="<?php echo base_url() ?>assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) -->
    <script src="<?php echo base_url() ?>assets/bundles/vendorscripts.bundle.js"></script> <!-- slimscroll, waves Scripts Plugin Js -->

    <script src="<?php echo base_url() ?>assets/bundles/jvectormap.bundle.js"></script> <!-- JVectorMap Plugin Js -->
    <script src="<?php echo base_url() ?>assets/bundles/sparkline.bundle.js"></script> <!-- Sparkline Plugin Js -->
    <script src="<?php echo base_url() ?>assets/bundles/c3.bundle.js"></script>
    <script src="<?php echo base_url() ?>assets/bundles/mainscripts.bundle.js"></script><!-- Custom Js -->

    <?php if ($content_view == "home/statistic") { ?>
        <script src="<?php echo base_url() ?>assets/js/pages/charts/c3.js"></script>
    <?php } ?>



    <script src="<?php echo base_url() ?>assets/js/pages/index.js"></script>

    <!-- Jquery DataTable Plugin Js -->
    <script src="<?php echo base_url() ?>assets/bundles/datatablescripts.bundle.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/jquery-datatable/buttons/buttons.flash.min.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/jquery-datatable/buttons/buttons.html5.min.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/jquery-datatable/buttons/buttons.print.min.js"></script>

    <script src="<?php echo base_url() ?>assets/js/pages/tables/jquery-datatable.js"></script>

    <script src="<?php echo base_url() ?>assets/plugins/momentjs/moment.js"></script> <!-- Moment Plugin Js -->
    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?php echo base_url() ?>assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- <script src="assets/bundles/mainscripts.bundle.js"></script>Custom Js  -->
    <script src="<?php echo base_url() ?>assets/bundles/quicksearch.js"></script>
    <script src="<?php echo base_url() ?>assets/js/pages/forms/basic-form-elements.js"></script>
    <script src="<?php echo base_url() ?>assets/js/datetimepicker/bootstrap-clockpicker.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/select2/select2.min.js"></script> <!-- Select2 Js -->
    <script src="<?php echo base_url() ?>assets/js/pages/forms/advanced-form-elements.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> <!-- Bootstrap Colorpicker Js -->
    <script src="<?php echo base_url() ?>assets/plugins/multi-select/js/jquery.multi-select.js"></script> <!-- Multi Select Plugin Js -->
    <script src="<?php echo base_url() ?>assets/js/pages/forms/advanced-form-elements.js"></script>

    <script type="text/javascript">
        var baseURL = '<?php echo base_url(); ?>';

        // $('.clockpicker').clockpicker({
        //     donetext: 'Done'
        // });

        // $('.datetimepicker').bootstrapMaterialDatePicker({ 
        //     // format : 'YYYY-MM-dd HH:mm',
        //     format : 'yyyy-mm-dd',
        // }); 
    </script>
    <script src="<?php echo base_url() ?>assets/bundles/myfunction.js"></script>
    <script src="<?php echo base_url() ?>assets/bundles/uploadcsv.js"></script>
    <script src="<?php echo base_url() ?>assets/bundles/postilion.js"></script>
    <script src="<?php echo base_url() ?>assets/bundles/postilion_saldo.js"></script>
    <script src="<?php echo base_url() ?>assets/bundles/postilion_cardholder_not_take.js"></script>
    <script src="<?php echo base_url() ?>assets/bundles/uploadexcel.js"></script>
    <script src="<?php echo base_url() ?>assets/bundles/terminal_crm.js"></script>

    <!-- <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/pusher/pusher.min.js"></script>
    <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('278e9f87cd57bcdd00f0', {
      cluster: 'ap1'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
    //    alert(JSON.stringify(data));
    });
    </script> -->

    <script src="<?php echo base_url() ?>assets/bundles/waitingfor.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/pages/ui/sweetalert.js"></script>
    <script src="<?php echo base_url() ?>assets/bundles/accounts.js"></script>
    <script src="<?php echo base_url() ?>assets/bundles/myfunctionpass.js"></script>



    <?php if ($content_view == "accounts/manage_accounts") { ?>
        <script src="<?php echo base_url() ?>assets/bundles/manageaccounts.js"></script>
    <?php } ?>

    <?php if ($content_view == "report/reportiso") { ?>
        <script src="<?php echo base_url() ?>assets/bundles/reporting.js"></script>
    <?php } ?>

    <?php if ($content_view == "accounts/terminal_access") { ?>
        <script src="<?php echo base_url() ?>assets/bundles/terminal_access.js"></script>
    <?php } ?>


    <script src="<?php echo base_url() ?>assets/bundles/statistic.js"></script>



    <script src='https://cdn3.devexpress.com/jslib/17.1.6/js/dx.all.js'></script>
    <?php if ($content_view == "terminal/details") { ?>
        <script src="<?php echo base_url() ?>assets_x/script.js"></script>
    <?php } ?>

    <?php if ($content_view == "ptpr/dashboard") { ?>
        <script src="<?php echo base_url() ?>assets/bundles/dashboard_crm_trans.js"></script>
    <?php } ?>

    <?php if ($content_view == "report/querytrx") { ?>
        <script src="<?php echo base_url() ?>assets/bundles/query_trx.js"></script>
    <?php } ?>

    <?php if ($content_view == "ptpr/listpackage") { ?>
        <script src="<?php echo base_url() ?>assets/js/maskmoney.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                // Format mata uang.
                $('.uang').mask('0.000.000.000.000.000', {
                    reverse: true
                });
            })
        </script>
    <?php } ?>

    <?php if ($content_view == "ptpr/register") { ?>
        <script src="<?php echo base_url() ?>assets/bundles/topup.js"></script>
    <?php } ?>

    <?php if ($content_view == "ptpr/listpackage") { ?>
        <script src="<?php echo base_url() ?>assets/bundles/list_package.js"></script>
    <?php } ?>

    <?php if ($content_view == "ptpr/topup") { ?>
        <script src="<?php echo base_url() ?>assets/bundles/request_topup.js"></script>
    <?php } ?>

    <?php if ($content_view == "ptpr/register_member") { ?>
        <script src="<?php echo base_url() ?>assets/bundles/register_new_interchange.js"></script>
    <?php } ?>

</body>

</html>