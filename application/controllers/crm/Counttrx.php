<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Counttrx extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Postilion_model', '', TRUE);
  }

  function index()
  { 
    $data = array(
        'title'               => 'Monitoring-Count Transactions',
        'header_view'         => 'header_view',
        'content_view'        => 'atm/count_transaction',
        'sub_header_title'    => 'Count Transactions',
        'header_title'        => 'COUNT TRANSACTIONS',
        'username'            => $this->session->userdata('logged_full_name'),
        'lastlogin'           => $this->session->userdata('logged_last_login'),
    );

    $tmpl = array(
        'table_open'    => '<table class="table table-bordered table-striped table-hover" id="dt_count_trx_cardbase" width="100%">',
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
  
      $time_saldo = $this->Postilion_model->get_time_saldo();
      $this->table->set_heading(
                'ATM ID', 
                'ATM Name', 
                'Admin', 
                substr($time_saldo->saldo_awal, 0,19), 
                substr($time_saldo->saldo_mid, 0,19),
                substr($time_saldo->saldo_akhir, 0,19), 
                'Difference'
      );
  
      $data_terminal_saldo = $this->Postilion_model->get_terminal_saldo();
  
      foreach ($data_terminal_saldo as $data_term_saldo)
      {
        
        $this->table->add_row(
                              $data_term_saldo->terminal_id, 
                              $data_term_saldo->terminal_name,
                              number_format($data_term_saldo->admin_bars),
                              number_format($data_term_saldo->saldo_awal),
                              number_format($data_term_saldo->saldo_mid),
                              number_format($data_term_saldo->saldo),
                              number_format($data_term_saldo->trx)
                            );  
  
      }   

      $data['table_count_trx_atm'] = $this->table->generate();

    $this->load->view('template', $data);
  }

}
