<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logterminal extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Log_model', '', TRUE);
  }

  function index()
  { 
    $data = array(
        'title'               => 'Monitoring-Log Terminal',
        'header_view'         => 'header_view',
        'content_view'        => 'atm/log_terminal',
        'sub_header_title'    => 'Log Terminal',
        'header_title'        => 'LOG TERMINAL',
        'username'            => $this->session->userdata('logged_full_name'),
        'lastlogin'           => $this->session->userdata('logged_last_login'),
        'table'               => $this->table->generate(),
    );

    $terms = $this->Log_model->get_terminal();

    $tmpl = array(
      'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_terminal_log" width="100%">',
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
      '',
      'ATM ID',
      'Terminal Name'
    );

    foreach ($terms as $term) {

      $cell_extends = array('class' => 'details-control', 'title' => $term->short_name );

      $this->table->add_row(
        $cell_extends,
        $term->id,
        $term->short_name
      );

    }

    $data['table_log'] = $this->table->generate();

    $this->load->view('template', $data);
  }

}
