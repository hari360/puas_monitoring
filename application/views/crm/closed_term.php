<section class="content">


<?php $this->load->view($header_view);?>
    

<div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Closed CRM</strong> Monitoring </h2>
                            
                        </div>
                        <div class="body">
                            <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                            <?php echo ! empty($table_closed_crm) ? $table_closed_crm : '';?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

</section>


