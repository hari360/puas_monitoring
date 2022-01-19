<?php

class Log_model extends CI_Model {

    var $v_term = 'iso_term';
    var $v_term_crm = 'iso_term_crm';

    function __construct()
    {
        parent::__construct();
    }

    function get_terminal() {
        return $this->db->get($this->v_term)->result();         
    }

    function get_terminal_crm() {
        return $this->db->get($this->v_term_crm)->result();         
    }

    function get_data_offline_history($entity_name) {
        $query = $this->db->query("exec iso_get_data_offline_history ?",urldecode($entity_name));
        return $query->result();   
    }

    function get_data_detail_summary_crm_bank($entity_name) {
        // $query = $this->db->query("exec get_data_detail_summary_crm_bank ?",urldecode($entity_name));
        // return $query->result();   
        $this->db->select("case when tran_type = '01' 
                                    then 'Cash Withdrawal' 
                                    when tran_type = '31' 
                                    then 'Balance Inquiry' 
                                    when tran_type = '54' 
                                    then 'Fund Transfer' 
                                    else 'Others' end as tran_type",FALSE);
        $this->db->select('count_txn');
        $this->db->from('pan_office..v_get_summary_trx_crm');
        //$this->db->where('issuer_name !=', NULL); 
        $this->db->where('issuer_name', $entity_name); 
        $this->db->order_by('issuer_name');
        // $this->db->get();
        // die($this->db->last_query());
        return $this->db->get()->result();
    }

    function get_data_offline_history_crm($entity_name) {
        $query = $this->db->query("exec iso_get_data_offline_history_crm ?",urldecode($entity_name));
        return $query->result();   
    }

}