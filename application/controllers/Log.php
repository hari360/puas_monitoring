<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Log extends MY_Controller
{

  var $title = 'Log Terminal';
  var $limit = 200;

  function __construct()
  {
    parent::__construct();
    $this->load->model('Log_model', '', TRUE);
  }

  function terminal()
  {
    $terms = $this->Log_model->get_terminal();

    foreach ($terms as $term) {

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

      $cell_extends = array('class' => 'details-control', 'title' => $term->short_name );

      $this->table->add_row(
        $cell_extends,
        $term->id,
        $term->short_name
      );

    }
    
    $data = array(
        'title'               => 'Monitoring-Log',
        'header_view'         => 'header_view',
        'content_view'        => 'log/terminal',
        'username'            => $this->session->userdata('logged_full_name'),
        'lastlogin'           => $this->session->userdata('logged_last_login'),
        'table'               => $this->table->generate(),
    );

    $this->load->view('template', $data);
  }

  function ajax_get_history_offline($term_id){
    $data = $this->Log_model->get_data_offline_history($term_id);
    echo json_encode($data);
  }

  function ajax_get_history_offline_crm($term_id){
    $data = $this->Log_model->get_data_offline_history_crm($term_id);
    echo json_encode($data);
  }
}
