

<section class="content">

    <?php $this->load->view($header_view); ?>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="card" style="margin-bottom: -10px;border:0px solid red">
                    <div class="header">
                        <h2><strong>TERMINAL </strong> DETAIL </h2>
                    </div>
                  
                        <div class="table-responsive">
                            <?php echo !empty($table_terminal_monitor_detail) ? $table_terminal_monitor_detail : ''; ?>
                        </div>


                        <div class="gauge-container">
                            <div class="gauge"></div>
                        </div>
                        

                </div>

                <div class="card">
                    <div class="header">
                        <h2><strong>STATUS </strong> FIELDS </h2>
                    </div>
                    <div class="card project_list">
                        <div class="table-responsive">
                            <?php echo !empty($table_terminal_monitor_status_fields) ? $table_terminal_monitor_status_fields : ''; ?>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="header">
                        <h2><strong>EVENTS </strong> TERMINAL </h2>
                    </div>
                    <div class="card project_list">
                        <div class="table-responsive">
                            <?php echo !empty($table_terminal_monitor_events) ? $table_terminal_monitor_events : ''; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</section>

<svg width="0" height="0" version="1.1" class="gradient-mask" xmlns="http://www.w3.org/2000/svg">
  <defs>
      <linearGradient id="gradientGauge">
        <stop class="color-red" offset="0%"/>
        <stop class="color-yellow" offset="17%"/>
        <stop class="color-green" offset="40%"/>
        <stop class="color-yellow" offset="87%"/>
        <stop class="color-red" offset="100%"/>
      </linearGradient>
  </defs>  
</svg>






