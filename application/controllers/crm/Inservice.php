<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inservice extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Postilioncrm_model', '', TRUE);
  }

  function index()
  { 
    $data = array(
        'title'               => 'Monitoring-Offline Terminal',
        'header_view'         => 'header_view',
        'content_view'        => 'crm/inservice_term',
        'sub_header_title'    => 'In Service Monitoring CRM',
        'header_title'        => 'IN SERVICE MONITORING CRM',
        'username'            => $this->session->userdata('logged_full_name'),
        'lastlogin'           => $this->session->userdata('logged_last_login'),
        'table'               => $this->table->generate(),
    );

    $terms = $this->Postilioncrm_model->get_inservice_crm_detail();

        $tmpl = array(
        'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_terminal_inservice_crm" width="100%">',
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
            'No', 'ATM ID', 'ATM Name', 'Mode'
        );

        $no = 0;
        foreach ($terms as $term) {
            $no++;
            $this->table->add_row(
                $no,
                $term->id,
                $term->short_name,
                $term->mode,
            );
        }

    $data['table_inservice_crm'] = $this->table->generate();

    $this->load->view('template', $data);
  }

}
