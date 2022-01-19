<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cardretain extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Postilion_model', '', TRUE);
  }

  function index()
  { 
    $data = array(
        'title'               => 'Monitoring-Card Retain',
        'header_view'         => 'header_view',
        'content_view'        => 'atm/card_retain',
        'sub_header_title'    => 'Card Retain',
        'header_title'        => 'CARD RETAIN',
        'username'            => $this->session->userdata('logged_full_name'),
        'lastlogin'           => $this->session->userdata('logged_last_login'),
        // 'table'               => $this->table->generate(),
    );

    $tmpl = array(
        'table_open'    => '<table class="table table-bordered table-striped table-hover" id="dt_card_retain_cardbase" width="100%">',
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
                'ATM ID', 
                'ATM Name', 
                'Card Count', 
                'Kelola'
      );
  
      $card_retain_data = $this->Postilion_model->get_card_retain();
      // $terms_2 = $this->Postilion_model->term_monitor_offset_temp($this->session->userdata('logged_user_name'));
  
      foreach ($card_retain_data as $data_card_retain)
      {
        
        $this->table->add_row($data_card_retain->id, 
                              $data_card_retain->short_name,
                              $data_card_retain->count_card,
                              $data_card_retain->kelola
                            );  
  
      }  

      $data['table_card_retain'] = $this->table->generate();

    $this->load->view('template', $data);
  }

}
