<section class="content">
    <?php $this->load->view($header_view); ?>
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                <ul class="nav nav-tabs pl-0 pr-0">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab_atm"><i class="zmdi zmdi-view-carousel"></i> ATM </a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_crm"><i class="zmdi zmdi-view-dashboard"></i> CRM</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_atm">
                        <div class="container-fluid">
                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="card widget_2 big_icon allterminal">
                                        <div class="body l-purple">
                                            <h6 style="color:black">ALL TERMINAL</h6>
                                            <h2 style="color:black"><?php echo $all_terminal; ?></h2>
                                            <hr />
                                            <a href="<?php echo base_url(); ?>atm/monitoring" style="color:white"><small>Details</small></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="card widget_2 big_icon offline">
                                        <div class="body l-offline">
                                            <h6 style="color:black">OFFLINE</h6>
                                            <h2 style="color:black"><?php echo $offline; ?></h2>
                                            <hr />
                                            <a href="<?php echo base_url(); ?>offline/detail/1" style="color:white"><small>Details</small></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="card widget_2 big_icon tutup">
                                        <div class="body l-blush">
                                            <h6 style="color:black">CLOSE</h6>
                                            <h2 style="color:black"><?php echo $close; ?></h2>
                                            <hr />
                                            <a href="<?php echo base_url(); ?>offline/detail/2" style="color:white"><small>Details</small></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="card widget_2 big_icon inservice">
                                        <div class="body l-green">
                                            <h6 style="color:black">IN SERVICE</h6>
                                            <h2 style="color:black"><?php echo $inservice; ?></h2>
                                            <hr />
                                            <a href="<?php echo base_url(); ?>offline/detail/3" style="color:white"><small>Details</small></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="card widget_2 big_icon cardretain">
                                        <div class="body l-blue">
                                            <h6 style="color:black">CARD RETAIN</h6>
                                            <h2 style="color:black"><?php echo $cardretain; ?></h2>
                                            <hr />
                                            <a href="<?php echo base_url(); ?>atm/cardretain" style="color:white"><small>Details</small></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="card widget_2 big_icon saldomin">
                                        <div class="body l-amber">
                                            <h6 style="color:black">SALDO < 2 MILLION</h6>
                                                    <h2 style="color:black"><?php echo $saldomin; ?></h2>
                                                    <hr />
                                                    <a href="<?php echo base_url(); ?>offline/detail/6" style="color:white"><small>Details</small></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="card widget_2 big_icon tranidle">
                                        <div class="body l-khaki">
                                            <h6 style="color:black">TRAN IDLE</h6>
                                            <h2 style="color:black"><?php echo $tranidle; ?></h2>
                                            <hr />
                                            <a href="<?php echo base_url(); ?>offline/detail/5" style="color:white"><small>Details</small></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="card widget_2 big_icon faulty">
                                        <div class="body l-cyan">
                                            <h6 style="color:black">FAULTY</h6>
                                            <h2 style="color:black"><?php echo $faulty; ?></h2>
                                            <hr />
                                            <a href="<?php echo base_url(); ?>offline/detail/4" style="color:white"><small>Details</small></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane file_manager" id="tab_crm">
                        <div class="container-fluid">
                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-6">
                                    <div class="card big_icon allterminal">
                                        <div class="body xl-blue">
                                            <h4 class="mt-0 mb-0"><?php echo $all_terminal_crm; ?></h4>
                                            <p class="mb-0">All Terminal</p>
                                            <hr />
                                            <a href="<?php echo base_url(); ?>crm/monitoring/" style="color:white"><small>Details</small></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="card big_icon offline">
                                        <div class="body xl-blush">
                                            <h4 class="mt-0 mb-0"><?php echo $offline_crm; ?></h4>
                                            <p class="mb-0">Off-line</p>
                                            <hr />
                                            <a href="<?php echo base_url(); ?>crm/offline/" style="color:white"><small>Details</small></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="card big_icon tutup">
                                        <div class="body xl-amber">
                                            <h4 class="mt-0 mb-0"><?php echo $close_crm; ?></h4>
                                            <p class="mb-0">Closed</p>
                                            <hr />
                                            <a href="<?php echo base_url(); ?>crm/closed/" style="color:white"><small>Details</small></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="card big_icon inservice">
                                        <div class="body xl-green">
                                            <h4 class="mt-0 mb-0"><?php echo $inservice_crm; ?></h4>
                                            <p class="mb-0">In Service</p>
                                            <hr />
                                            <a href="<?php echo base_url(); ?>crm/inservice/" style="color:white"><small>Details</small></a>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-lg-3 col-md-6">
                                    <div class="card big_icon cardretain">
                                        <div class="body xl-cyan">
                                            <h4 class="mt-0 mb-0"><?php echo $cardretain_crm; ?></h4>
                                            <p class="mb-0">Card Retain</p> 
                                            <hr/>
                                            <a href="#" style="color:white"><small>Details</small></a>                       
                                        </div>
                                    </div>
                                </div> -->
                                <!-- <div class="col-lg-3 col-md-6">
                                    <div class="card big_icon saldomin">
                                        <div class="body xl-purple">
                                            <h4 class="mt-0 mb-0"><?php echo $saldomin_crm; ?></h4>
                                            <p class="mb-0">Saldo Min 2 Million</p> 
                                            <hr/>
                                            <a href="#" style="color:white"><small>Details</small></a>                       
                                        </div>
                                    </div>
                                </div> -->
                                <!-- <div class="col-lg-3 col-md-6">
                                    <div class="card big_icon tranidle">
                                        <div class="body xl-pink">
                                            <h4 class="mt-0 mb-0"><?php echo $tranidle_crm; ?></h4>
                                            <p class="mb-0">Trand Idle</p> 
                                            <hr/>
                                            <a href="#" style="color:white"><small>Details</small></a>                       
                                        </div>
                                    </div>
                                </div> -->
                                <div class="col-lg-3 col-md-6">
                                    <div class="card big_icon faulty">
                                        <div class="body xl-khaki">
                                            <h4 class="mt-0 mb-0"><?php echo $faulty_crm; ?></h4>
                                            <p class="mb-0">Faulty</p>
                                            <hr />
                                            <a href="<?php echo base_url(); ?>crm/faulty/" style="color:white"><small>Details</small></a>
                                        </div>
                                    </div>
                                </div>





                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Bar</strong> Chart</h2>
                    </div>
                    <div class="body">
                        <div id="chart-bar" class="c3_chart"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Donut</strong> Chart</h2>
                    </div>
                    <div class="body">
                        <div id="chart-donut" class="c3_chart"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Employment</strong> Growth</h2>
                    </div>
                    <div class="body">
                        <div id="chart-employment" class="c3_chart"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Pie</strong> Chart</h2>
                        </div>
                        <div class="body">
                            <div id="chart-pie" class="c3_chart"></div>
                        </div>
                    </div>                
            </div>


            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card mcard_4">
                    <div class="body">
                        <ul class="header-dropdown list-unstyled">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-menu"></i> </a>
                                <ul class="dropdown-menu slideUp">
                                    <li><a href="javascript:void(0);">Edit</a></li>
                                    <li><a href="javascript:void(0);">Delete</a></li>
                                    <li><a href="javascript:void(0);">Report</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="img">
                            <img src="assets/images/lg/avatar1.jpg" class="rounded-circle" alt="profile-image">
                        </div>
                        <div class="user">
                            <h5 class="mt-3 mb-1">Eliana Smith</h5>
                            <small class="text-muted">UI/UX Desiger</small>
                        </div>
                        <ul class="list-unstyled social-links">
                            <li><a href="javascript:void(0);"><i class="zmdi zmdi-dribbble"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="zmdi zmdi-behance"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="zmdi zmdi-pinterest"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>                
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card w_data_1">
                    <div class="body">
                        <div class="w_icon pink"><i class="zmdi zmdi-bug"></i></div>
                        <h4 class="mt-3 mb-0">12.1k</h4>
                        <span class="text-muted">Bugs Fixed</span>
                        <div class="w_description text-success">
                            <i class="zmdi zmdi-trending-up"></i>
                            <span>15.5%</span>
                        </div>
                    </div>
                </div>
                <div class="card w_data_1">
                    <div class="body">
                        <div class="w_icon cyan"><i class="zmdi zmdi-ticket-star"></i></div>
                        <h4 class="mt-3 mb-1">01.8k</h4>
                        <span class="text-muted">Submitted Tickers</span>
                        <div class="w_description text-success">
                            <i class="zmdi zmdi-trending-up"></i>
                            <span>95.5%</span>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div> -->
</section>