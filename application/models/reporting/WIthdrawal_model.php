<?php

class Withdrawal_model extends CI_Model
{

    function detail_acq_approved()
    {
        // $this->db->where('settle_date', 20211113);
        // $this->db->like('file_name', 'wdl', 'both');
        // $this->db->limit(100);
        $this->db->order_by("fi_issuer", "asc");
        $this->db->order_by("date", "asc"); 
        $this->db->order_by("time", "asc"); 
        $query = $this->db->get('dummy_wdl_acq');
        // die($this->db->last_query());
        return $query;

        // if(!$query->get('raw_data_tlf'))
        // {
        //     $error = $this->db->error();
        // }else{
        //     $test = $this->db->get('raw_data_tlf')->result();
        //     return $test;
        // }
    }

    function detail_acq_rejected()
    {
        $this->db->order_by("fi_issuer", "asc");
        $this->db->order_by("date", "asc"); 
        $this->db->order_by("time", "asc"); 
        $query = $this->db->get('dummy_wdl_acq_rejected');

        return $query;

    }

    function detail_iss_approved()
    {
        // $this->db->where('settle_date', 20211113);
        // $this->db->like('file_name', 'wdl', 'both');
        // $this->db->limit(100);
        $this->db->order_by("fi_acquirer", "asc");
        $this->db->order_by("date", "asc"); 
        $this->db->order_by("time", "asc"); 
        $query = $this->db->get('dummy_wdl_iss');
        // die($this->db->last_query());
        return $query;

        // if(!$query->get('raw_data_tlf'))
        // {
        //     $error = $this->db->error();
        // }else{
        //     $test = $this->db->get('raw_data_tlf')->result();
        //     return $test;
        // }
    }
    
}
