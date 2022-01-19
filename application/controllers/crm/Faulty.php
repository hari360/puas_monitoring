<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Faulty extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Postilioncrm_model', '', TRUE);
  }

  function index()
  { 
    $data = array(
        'title'               => 'Monitoring-Faulty Terminal',
        'header_view'         => 'header_view',
        'content_view'        => 'crm/faulty_term',
        'sub_header_title'    => 'Faulty Monitoring CRM',
        'header_title'        => 'FAULTY MONITORING CRM',
        'username'            => $this->session->userdata('logged_full_name'),
        'lastlogin'           => $this->session->userdata('logged_last_login'),
        'table'               => $this->table->generate(),
    );

    $terms = $this->Postilioncrm_model->get_faulty_crm_detail();
    
        $tmpl = array(
        'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_terminal_faulty_crm" width="100%">',
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
            'No', 'ATM ID', 'ATM Name', 'Condition', 'Faulty'
        );
        
        $no = 0;
        foreach ($terms as $term) {
            $no++;
            $this->table->add_row(
                $no,
                $term->id,
                str_replace('_', ' ', $term->short_name), 
                $term->miscellaneous,
                $term->faulty,
            );
        }

    $data['table_faulty_crm'] = $this->table->generate();
    // die('tes1234');
    $this->load->view('template', $data);
  }

}
