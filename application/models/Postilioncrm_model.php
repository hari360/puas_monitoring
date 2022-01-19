<?php

class Postilioncrm_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
        // $this->db_temp = $this->load->database('old_posti', TRUE);
    }

    function get_offline_crm(){
        return $this->db->get('v_term_crm_offline')->result();
    }

    function get_offline_crm_detail(){
        return $this->db->get('v_term_crm_offline_detail')->result();
    }

    function get_closed_crm_detail(){
        return $this->db->get('v_term_crm_closed_detail')->result();
    }

    function get_inservice_crm_detail(){
        $this->db->order_by("id", "asc");
        return $this->db->get('v_term_crm_inservice_detail')->result();
    }

    function get_faulty_crm_detail(){
        return $this->db->get('v_term_crm_faulty_detail')->result();
    }

    function get_transactions_crm_detail(){
        return $this->db->get('iso_term_crm_monitor_transactions')->result();
    }

    function get_history_flm_slm() {
        $this->db->order_by("date_time_problem", "desc");
        return $this->db->get('iso_get_history_flm_slm')->result();

    }

    function get_terminal_crm(){
        $this->db->select('id as terminal_id');
        $this->db->select('short_name as terminal_name');
        return $this->db->get('iso_term')->result();
    }

    function get_batch_viewer_crm($date,$user,$terminal){
        $query = $this->db->query(sprintf("exec iso_getreplenish_crm '%s','%s','%s'", $date,$user,$terminal));
        return $query->result();
    }
}
