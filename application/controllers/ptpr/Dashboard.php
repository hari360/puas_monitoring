<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->myauth->permission_page('2');
        $this->load->model('Dashboard_model', '', TRUE);
    }

    function index()
    {

        $data = array(
            'title'               => 'Dashboard CRM',
            'header_view'         => 'header_view',
            'content_view'        => 'ptpr/dashboard',
            'sub_header_title'    => 'PTPR',
            'header_title'        => 'Dashboard CRM',
            'username'            => $this->session->userdata('logged_full_name'),
            'lastlogin'           => $this->session->userdata('logged_last_login'),
            // 'table_top5_crm_7days'=> $this->table->generate()
        );

        $get_approved_dashboard = $this->Dashboard_model->get_approved_trx();
        $total_trx = 0;

        foreach ($get_approved_dashboard as $get_record) {

            $total_trx += $get_record->count_trx;
            switch ($get_record->tran_type) {
                case "01":
                    $data['withdrawal'] = $get_record->count_trx;
                    break;
                case "31":
                    $data['balance_inq'] = $get_record->count_trx;
                    break;
                case "54":
                    $data['transfer'] = $get_record->count_trx;
                    break;
                    // case "21":
                    //     $data['deposit'] = $get_record->count_trx;
                    //     break;
                    // case "32":
                    //     $data['inq_deposit'] = $get_record->count_trx;
                    //     break;
            }
        }

        $get_active_topup = $this->Dashboard_model->get_history_req_topup();

        $data['total_trx'] = $total_trx;
        $data['get_active_topup'] = $get_active_topup;

        $get_post_tran_id_topup = $this->Dashboard_model->cek_request_no_topup();

        if($get_post_tran_id_topup==""){
            $get_counter = $this->Dashboard_model->get_counter_trx();
        }else{
            $get_counter = $this->Dashboard_model->get_counter_trx($get_post_tran_id_topup);
        }
        
        $data['data_counter'] = $get_counter->count_trx;

        $this->load->view('template', $data);
    }
}
