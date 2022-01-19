<?php

class Dashboard_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_counter_trx($post_tran_id = 1000000000000){
        $this->db->select('count(*) as count_trx');
        return $this->db->get_where('iso_history_detail_trans',array('post_tran_id >= ' => $post_tran_id))->row();
    }

    function insert_req_deposit($data){
        $this->db->insert_batch('iso_history_req_topup', $data);

        // $this->db->db_debug = false;

        // if(!$this->db->insert_batch('iso_history_req_topup', $data))
        // {
        //     $error = $this->db->error();
        //     return $error;
        // }else{
        //     // do something in success case
        //     return $this->db->insert_id();
        // }

        return $this->db->insert_id();
        
    }

    function status_dashboard($userid, $prefix)
    {
        $query = $this->db->query("exec iso_get_status_dashboard '" . $userid . "', '" . $prefix . "'");
        return $query->result();
    }

    function status_dashboard_crm($userid)
    {
        $query = $this->db->query("exec iso_get_status_dashboard_crm ?", $userid);
        return $query->result();
    }

    function get_history_req_topup()
    {

        $this->db->select('a.*');
        $this->db->select('b.limit');
        $this->db->from('iso_history_req_topup a');
        $this->db->join('iso_list_package b', "a.package_selected = b.package_code",'left');
        $this->db->where('a.status', 'Approved By RCS');
        $this->db->where('a.status_log', 'Active');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            $this->db->select('0 as limit');
            $this->db->select('\'-\' as date_rcs_approved');
            $this->db->select('\'-\' as date_request');
            $this->db->select('\'-\' as date_fin_approved');
            $this->db->select('\'-\' as package_selected');
            $this->db->select('\'-\' as invoice_no');
            
            return $this->db->get()->row();

            return FALSE;
        }

        
        // return $this->db->get_where('iso_history_req_topup a',array('a.status' => 'Approved By RCS'))->row();
    }

    function get_approved_trx()
    {
        // $sql = "select  cast(datetime_tran_local as date) as date_trx
        //                 ,tran_type
        //                 ,rsp_code_rsp
        //                 ,message_type
        //                 ,count(*) as count_trx
        //         from pan_office..tbl_detail_transactions
        //         where datetime_tran_local > '2021-09-12' and rsp_code_rsp = '00'
        //         group by cast(datetime_tran_local as date)
        //                 ,tran_type,rsp_code_rsp
        //                 ,message_type";
        // $query = $this->db->query($sql);
        // $this->db->select("case when tran_type = '01' 
        //                             then 'Cash Withdrawal' 
        //                             when tran_type = '31' 
        //                             then 'Balance Inquiry' 
        //                             when tran_type = '54' 
        //                             then 'Fund Transfer' 
        //                             else 'Others' end as tran_type",FALSE);
        $this->db->select('tran_type,sum(count_txn) as count_trx');
        $this->db->from('pan_office..v_get_summary_trx_crm');
        //$this->db->where('issuer_name !=', NULL); 
        $this->db->where('issuer_name', 'BTN'); 
        $this->db->group_by('issuer_name,tran_type');
        // $this->db->order_by('issuer_name');
        // $this->db->get();
        // die($this->db->last_query());
        return $this->db->get()->result();

        // return $query->result();
    }

    function cek_request_no_topup(){
        $this->db->select('invoice_no');
        $this->db->from('iso_history_req_topup');
        $this->db->where('user_request', $this->session->userdata('logged_user_name'));
        $this->db->where('status_log', 'Active');
        $query_invoice = $this->db->get();//->row()->invoice_no;

        
        //die($this->db->last_query());

        if ($query_invoice->num_rows() > 0) {
            // foreach ($query->result() as $val) {
            //     $v_first_post_tran_id  = $val->first_post_tran_id;
            // }

            // $this->session->set_userdata('first_post_tran_id_topup', $query_first_post_tran_id->row()->first_post_tran_id);
            $this->db->select('first_post_tran_id');
            $this->db->from('iso_get_log_history_topup');
            $this->db->where('request_no', $query_invoice->row()->invoice_no);
            $query_first_post_tran_id = $this->db->get();
            //die($this->db->last_query());
            return $query_first_post_tran_id->row()->first_post_tran_id;
        }else{
            // $this->session->set_userdata('first_post_tran_id_topup', '');
            return "";
        }
    }

    
}
