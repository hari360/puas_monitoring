<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cardholdernottake extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Postilion_model', '', TRUE);
  }

  function index()
  { 

    $terminal = $this->Postilion_model->get_terminal_atm();
    $term = '<option value="">Select Terminal Name</option>';

    

    foreach ($terminal as $data_terminal)
    {
        $term .= '<option value="'.$data_terminal->terminal_name.'" style="font-size: 12px;">'.$data_terminal->terminal_name.'</option>';
    }

    $data = array(
        'title'               => 'Monitoring-Cardholder Not Take',
        'header_view'         => 'header_view',
        'content_view'        => 'atm/cardholder_did_not_take',
        'sub_header_title'    => 'Cardholder Not Take',
        'header_title'        => 'CARDHOLDER NOT TAKE',
        'username'            => $this->session->userdata('logged_full_name'),
        'lastlogin'           => $this->session->userdata('logged_last_login'),
        'list_terminal'       => $term,
    );

    // $tmpl = array(
    //     'table_open'    => '<table class="table table-bordered table-striped table-hover" id="dt_batch_viewer" width="100%">',
    //     'thead_open'            => '<thead>',
    //     'thead_close'           => '</thead>',
    //     'heading_row_start'   => '<tr>',
    //     'heading_row_end'     => '</tr>',
    //     'heading_cell_start'  => '<th>',
    //     'heading_cell_end'    => '</th>',
    //     'row_alt_start'  => '<tr>',
    //     'row_alt_end'    => '</tr>'
    //   );
    //   $this->table->set_template($tmpl);
    //   $this->table->set_empty("&nbsp;");
  
    //   $this->table->set_heading(
    //     'ATM ID', 
    //     'ATM Name', 
    //     'Item End', 
    //     'Value Bar End',
    //     'Time',
    //     'Item Begin',
    //     'Value Bar Begin',
    //     'Date Begin',
    //     'CIT'
    //   );
  
      // $data_terminal_saldo = $this->Postilion_model->get_parameterize_saldo();
  
      // foreach ($data_terminal_saldo as $data_term_saldo)
      // {
        
      //   $this->table->add_row(
      //                         $data_term_saldo->terminal_id, 
      //                         $data_term_saldo->terminal_name,
      //                         number_format($data_term_saldo->admin_bars),
      //                         number_format($data_term_saldo->saldo_awal),
      //                         number_format($data_term_saldo->saldo_mid),
      //                         number_format($data_term_saldo->saldo),
      //                         number_format($data_term_saldo->trx)
      //                       );  
  
      // }   

      // $data['table_cardholder'] = $this->table->generate();

    $this->load->view('template', $data);
  }

}
