<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Statistic extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->myauth->permission_page('2');
    $this->load->model('Statistic_model', '', TRUE);
  }

  function index()
  {

    $data = array(
      'title'               => 'Monitoring-Statistic',
      'header_view'         => 'header_view',
      'content_view'        => 'home/statistic',
      'sub_header_title'    => 'Statistic Transactions',
      'header_title'        => 'Statistic',
      'username'            => $this->session->userdata('logged_full_name'),
      'lastlogin'           => $this->session->userdata('logged_last_login'),
      // 'table_top5_crm_7days'=> $this->table->generate()
    );

    $datatable_top5_crm_7days = array(
      'table_open'    => '<table class="table table-bordered table-striped table-hover" id="dt_top_5_crm_7_days" width="100%">',
      'thead_open'            => '<thead>',
      'thead_close'           => '</thead>',
      'heading_row_start'   => '<tr>',
      'heading_row_end'     => '</tr>',
      'heading_cell_start'  => '<th>',
      'heading_cell_end'    => '</th>',
      'row_alt_start'  => '<tr>',
      'row_alt_end'    => '</tr>'
    );
    $this->table->set_template($datatable_top5_crm_7days);
    $this->table->set_empty("&nbsp;");
    $this->table->set_heading(
      'No',
      'Province',
      'Location Name',
      'Area',
      '#of Transactions'
    );

    $data_top5_crm_7days = $this->Statistic_model->get_top5_crm_7days(20210704);

    $i = 1;
    foreach ($data_top5_crm_7days as $records_top5_crm_7days) {

      $this->table->add_row(
        $i++,
        $records_top5_crm_7days->city,
        $records_top5_crm_7days->location,
        $records_top5_crm_7days->city,
        $records_top5_crm_7days->jml_trx,
      );
    }

    $data['table_top5_crm_7days'] = $this->table->generate();


    $datatable_bottom5_crm_7days = array(
      'table_open'    => '<table class="table table-bordered table-striped table-hover" id="dt_bottom_5_crm_7_days" width="100%">',
      'thead_open'            => '<thead>',
      'thead_close'           => '</thead>',
      'heading_row_start'   => '<tr>',
      'heading_row_end'     => '</tr>',
      'heading_cell_start'  => '<th>',
      'heading_cell_end'    => '</th>',
      'row_alt_start'  => '<tr>',
      'row_alt_end'    => '</tr>'
    );
    $this->table->set_template($datatable_bottom5_crm_7days);
    $this->table->set_empty("&nbsp;");
    $this->table->set_heading(
      'No',
      'Province',
      'Location Name',
      'Area',
      '#of Transactions'
    );

    $data_bottom5_crm_7days = $this->Statistic_model->get_bottom5_crm_7days(20210704);

    $i = 1;
    foreach ($data_bottom5_crm_7days as $records_bottom5_crm_7days) {

      $this->table->add_row(
        $i++,
        $records_bottom5_crm_7days->city,
        $records_bottom5_crm_7days->location,
        $records_bottom5_crm_7days->city,
        $records_bottom5_crm_7days->jml_trx,
      );
    }

    $data['table_bottom_5_crm_trx'] = $this->table->generate();


    

    $this->load->view('template', $data);
  }

}
