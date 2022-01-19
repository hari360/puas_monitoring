<section class="content">


<?php $this->load->view($header_view);?>
    

<div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Log Terminal</strong> Monitoring </h2>
                            
                        </div>
                        <div class="body">
                            <div class="table-responsive" style="font-size: 12px;font-family:Arial, Helvetica, sans-serif">
                            <?php echo ! empty($table_log) ? $table_log : '';?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

</section>

<style>
    td.details-control {
        background: url('<?php echo base_url();?>assets/images/details_open.png') no-repeat center center;
        cursor: pointer;
    }

    tr.shown td.details-control {
    background: url('<?php echo base_url();?>assets/images/details_close.png') no-repeat center center;
    }

    table.dataTable tbody th, table.dataTable tbody td {
    padding: 8px; /* e.g. change 8x to 4px here */
    }
</style>



