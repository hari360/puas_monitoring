<div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2><?php echo isset($header_title) ? $header_title : '';?></h2>
                <p></p>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><?= $parent_menu; ?></li>
                    
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">   
            <div class="float-right">
                    <div class="chat-about">
                        <!-- <div class="chat-with"><strong id="usrLogin"><?php echo isset($username) ? $username : '';?> </strong> &nbsp;| &nbsp;<a href="<?php echo base_url();?>login/logout">Logout</a></div> -->

                        <div class="chat-with"><strong id="usrLogin"><?php echo $this->session->userdata('logged_user_name');?> </strong> &nbsp;| &nbsp;<a href="<?php echo base_url();?>login/logout">Logout</a></div>
                        <div class="chat-num-messages"><small>Last Login: <?php echo isset($lastlogin) ? $lastlogin : '';?></small></div>
                        
                        <?php
                        $flashmessageexp = $this->session->userdata('expired_pass_in');
                        if (isset($flashmessageexp)) {
                        ?>
                        <div class="chat-num-messages"><i><small style="color: red;">Expired Password In : <?php echo $this->session->userdata('expired_pass_in');?> Days</small></i></div>
                        <?php } ?>
                    
                    </div>
            </div>             
            </div>
        </div>
    </div>