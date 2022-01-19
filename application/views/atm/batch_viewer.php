<section class="content">


<?php $this->load->view($header_view);?>
    

<div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Batch </strong> Viewer </h2>         
                        </div>
                        <div class="body">
                        <p>Please complete the form below. Mandatory fields marked *</p>
                            
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Select Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-calendar"></i></span>
                                            </div>
                                            <input type="text" class="form-control datepicker" name="" id="date_batch">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Terminal ID</label>
                                        <div class="input-group">
                                        <select class="form-control show-tick ms select2" data-placeholder="Select" id="terminal_batch" name="" style="height: 35px;font-size:12px">                                                                                      
                                        <?php 
                                                echo $list_terminal;
                                            ?>
                                        </select>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                    <button id="btn_submit_batch_viewer" type="button" class="btn btn-raised btn-primary btn-round waves-effect">Submit</button>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                <table class="table table-bordered table-striped table-hover nowrap" id="datatable_batch_viewer" width="100%" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                    <thead>
                                        <tr>
                                            <!-- <th>No</th> -->
                                            <th>ATM ID</th>
                                            <th>ATM Name</th>
                                            <th>Item End</th>
                                            <th>Value Bar End</th>
                                            <th>Time</th> 
                                            <th>Item Begin</th>
                                            <th>Value Bar Begin</th>
                                            <th>Date Begin</th>
                                            <th>CIT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

</section>


