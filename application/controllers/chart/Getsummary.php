<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Getsummary extends MY_Controller
{

  var $status_fields;
  var $term_type;

  function __construct()
  {
    parent::__construct();
    $this->load->model('Postilion_model', '', TRUE);
  }

  function ajax_get_summary_trx(){
    //$posting_date = $this->input->get('v_range_date');
    $data = $this->Postilion_model->get_data_summary_trx($this->input->get('v_from_date'),$this->input->get('v_to_date'));
    echo json_encode($data);
  }

  function ajax_get_summary_trx_weekly(){
    $data = $this->Postilion_model->get_data_summary_trx_weekly();
    echo json_encode($data);
  }

  function ajax_get_summary_tran_type(){
    $data = $this->Postilion_model->get_data_summary_tran_type();
    echo json_encode($data);
  }

  function ajax_get_bar_atm(){
    $data = $this->Postilion_model->get_data_bar_atm('01000900');
    echo json_encode($data);
  }

}
