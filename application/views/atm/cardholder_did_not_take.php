<section class="content">


<?php $this->load->view($header_view);?>
    

<div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Cardholder did not take </strong> </h2>         
                        </div>
                        <div class="body">
                        <p>Please complete the form below. Mandatory fields marked *</p>                           
                            <div class="row clearfix">

                                <div class="col-md-12">
                                    <div class="mb-6" style="border:0px solid red">
                                        <label>Terminal ID</label>
                                        <div class="input-group">
                                        <select class="form-control show-tick ms select2" data-placeholder="Select" id="sTerminal" name="txtterminalname" style="height: 35px;font-size:12px">
                                            <?php 
                                                echo $list_terminal;
                                            ?>
                                        </select>
                                        </div>
                                        
                                    </div>
                                </div>

                                <div class="col-md-12" style="padding-top:20px ;">
                                    <label>Select Date</label>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>From</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-calendar"></i></span>
                                            </div>
                                            <input type="text" class="form-control datepicker" name="txtdatetime_from" id="txt_datefrom">
                                            
                                            <!-- <input type="text" class="form-control" placeholder="Please choose date & time..." name="txtdatetime"> -->
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>To</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="test123"><i class="zmdi zmdi-calendar"></i></span>
                                            </div>
                                            <input type="text" class="form-control datepicker" name="txtdatetime_to" id="txt_dateend">
                                            
                                            <!-- <input type="text" class="form-control" placeholder="Please choose date & time..." name="txtdatetime"> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                    <button id="btn_submit_cardholder" type="button" class="btn btn-raised btn-primary btn-round waves-effect">Submit</button>
                                    </div>
                                </div>
                          
                            </div>

                            <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                            <table class="table table-bordered table-striped table-hover nowrap" id="datatable_cardholder_not_take" width="100%" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                    <thead>
                                        <tr>                                        
                                            <th>ATM Name</th>
                                            <th>Even Time</th>
                                            <th>Description</th>
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


