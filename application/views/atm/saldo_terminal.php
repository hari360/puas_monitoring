<section class="content">


<?php $this->load->view($header_view);?>
    

<div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Terminal </strong> Saldo </h2>         
                        </div>
                        <div class="body">
                        <p>Please complete the form below. Mandatory fields marked *</p>
                            
                            <div class="row clearfix">
                            
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Date Cut Off</label>
                                        <div class="input-group">
                                        <select class="form-control show-tick ms select2" data-placeholder="Select" id="sdatecutoffsaldo" name="txtdatecutoffsaldo">
                                            <?php 
                                                echo $list_cut_off_saldo;
                                            ?>
                                        </select>
                                        </div>                                    
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                    <button id="btn_submit_posti_saldo" type="button" class="btn btn-raised btn-primary btn-round waves-effect">Submit</button>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                            <table class="table table-bordered table-striped table-hover nowrap" id="datatable_saldo" width="100%" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                                    <thead>
                                        <tr>
                                            <!-- <th>No</th> -->
                                            <th>ATM ID</th>
                                            <th>ATM Name</th>
                                            <th>Nominal</th>
                                            <th>Quantity Remain</th>
                                            <th>Quantity Capacity</th> 
                                            <th>Date Cut Off</th>
                                            <th>Amount Remain</th>
                                            <th>Amount Capacity</th>
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


