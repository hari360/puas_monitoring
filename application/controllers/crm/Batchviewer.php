<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Batchviewer extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Postilioncrm_model', '', TRUE);
  }

  function index()
  { 

    $terminal = $this->Postilioncrm_model->get_terminal_crm();
    $term = '<option value="">All Terminal</option>';

    

    foreach ($terminal as $data_terminal)
    {
        $term .= '<option value="'.$data_terminal->terminal_name.'" style="font-size: 12px;">'.$data_terminal->terminal_name.'</option>';
    }

    $data = array(
        'title'               => 'Monitoring CRM-Batch Viewer',
        'header_view'         => 'header_view',
        'content_view'        => 'crm/batch_viewer',
        'sub_header_title'    => 'CRM Batch Viewer',
        'header_title'        => 'CRM BATCH VIEWER',
        'username'            => $this->session->userdata('logged_full_name'),
        'lastlogin'           => $this->session->userdata('logged_last_login'),
        'list_terminal'       => $term,
    );

    
    $this->load->view('template', $data);
  }

}
