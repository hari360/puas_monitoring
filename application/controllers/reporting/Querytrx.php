<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Querytrx extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Postilion_model', '', TRUE);
  }

  function index()
  { 

    $list_batch_nr = $this->Postilion_model->get_list_batch_nr();
    $list_sink_node = $this->Postilion_model->get_list_sink_node();
    $list_cbc_bank  = $this->Postilion_model->get_list_cbc_bank();
    $list_resp_code  = $this->Postilion_model->get_list_resp_code();

    $data = array(
        'title'               => 'Query Transactions',
        'header_view'         => 'header_view',
        'content_view'        => 'report/querytrx',
        'sub_header_title'    => 'Query Transaction',
        'header_title'        => 'Query Transaction ATMI',
        'username'            => $this->session->userdata('logged_full_name'),
        'lastlogin'           => $this->session->userdata('logged_last_login'),
        'list_sink_node'      => $list_sink_node,
        'list_cbc_bank'       => $list_cbc_bank,
        'list_batch_cut_off'  => $list_batch_nr,
        'list_resp_code'      => $list_resp_code,

    );

    $this->load->view('template', $data);
  }


  function get_result_excel(){
    $this->generatexl->result_query_transactions();
  }

}
