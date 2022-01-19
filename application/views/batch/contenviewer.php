<section class="content">

<?php $this->load->view($header_view);?>
    

    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card">
                        <ul class="nav nav-tabs pl-0 pr-0">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab_terminal">Terminal Batch Viewer</a></li>
                            <!-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_card_retain">Card Retain</a></li> -->
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_log">Log</a></li>
                        </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_terminal">
                        <div class="container-fluid">
                            <div class="row clearfix">
                                <div class="body" style="width: 100%;">
                                    <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                    <?php echo ! empty($table_batch_viewer) ? $table_batch_viewer : '';?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="tab-pane file_manager" id="tab_card_retain">
                        <div class="container-fluid">
                            <div class="row clearfix">

                            </div> 
                        </div>
                    </div> -->
                    <div class="tab-pane" id="tab_log">
                        <div class="container-fluid">        
                            <div class="row clearfix">
                                <div class="body" style="width: 100%;">
                                    <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                        <!-- <?php echo ! empty($table_log) ? $table_log : '';?> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


