<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Closed extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Postilion_model', '', TRUE);
  }

  function detail(){
    $tmpl = array(
        'table_open'    => '<table class="table table-bordered table-striped table-hover" id="dt_closed" width="100%">',
        'thead_open'            => '<thead>',
        'thead_close'           => '</thead>',
        'heading_row_start'   => '<tr>',
        'heading_row_end'     => '</tr>',
        'heading_cell_start'  => '<th>',
        'heading_cell_end'    => '</th>',
        'row_alt_start'  => '<tr>',
        'row_alt_end'    => '</tr>'
      );
      $this->table->set_template($tmpl);
      $this->table->set_empty("&nbsp;");
      $this->table->set_heading(
                    'No', 
                    'ATM ID', 
                    'ATM Name', 
                    'Mode', 
                    'Kelola'
      );
  
      $closed_data = $this->Postilion_model->get_closed_term();
      // $terms_2 = $this->Postilion_model->term_monitor_offset_temp($this->session->userdata('logged_user_name'));
  
      $i = 0;
      foreach ($closed_data as $data_closed)
      {
        
        $this->table->add_row(++$i, 
                              $data_closed->id, 
                              $data_closed->short_name,
                              $data_closed->mode,
                              $data_closed->kelola
                            );  
  
      }  

      $data = array(
        'title'               => 'Status Terminal',
        'header_view'         => 'header_view',
        'content_view'        => 'offline/detail',
        'sub_header_title'    => 'Terminal Detail',
        'header_title'        => 'TERMINAL STATUS',
        'username'            => $this->session->userdata('logged_full_name'),
        'lastlogin'           => $this->session->userdata('logged_last_login'),
        'table_closed'       => $this->table->generate(),
      );

      $this->load->view('template', $data);

  }

}