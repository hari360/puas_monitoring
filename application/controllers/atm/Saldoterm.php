<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Saldoterm extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Postilion_model', '', TRUE);
  }

  function index()
  { 

    $saldo_cut_off = $this->Postilion_model->date_cut_off_saldo();
    $saldo_date = '<option value="">Select Date Cutoff</option>';

    foreach ($saldo_cut_off as $data_saldo_cut_off)
    {
        $saldo_date .= '<option value="'.$data_saldo_cut_off->settle_date.'" style="font-size: 12px;">'.$data_saldo_cut_off->settle_date.'</option>';
    }

    $data = array(
        'title'               => 'Monitoring-Terminal Saldo',
        'header_view'         => 'header_view',
        'content_view'        => 'atm/saldo_terminal',
        'sub_header_title'    => 'Terminal Saldo',
        'header_title'        => 'TERMINAL SALDO',
        'username'            => $this->session->userdata('logged_full_name'),
        'lastlogin'           => $this->session->userdata('logged_last_login'),
        'list_cut_off_saldo'  => $saldo_date,
    );

    

    $this->load->view('template', $data);
  }

}
