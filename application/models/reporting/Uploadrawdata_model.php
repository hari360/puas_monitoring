<?php

class Uploadrawdata_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function insert_from_csv($data){
        return $this->db->insert('iso_batch_upload', $data);        
    }

    
    function get_data_history_upload(){
        $query = $this->db->get('iso_batch_upload');
        if(!$query){
            $error = $this->db->error();
        }else{
            return $query->result();
        }
    }

    function insert_data_atm_registration($data){
        return $this->db->insert('iso_mon_terminal', $data);        
    }

    function insert_from_excel($data)
    {
        
        $query = $this->db->insert_batch('hijrah_transaksi_deposit', $data);
        if(!$query){
            $error = $this->db->error();
            return FALSE;
        }else{
            return TRUE;
        }

        // return $this->db->insert_id();
    }

    function get_data_trx_deposit()
    {
        $query = $this->db->get('hijrah_transaksi_deposit');
        if(!$query){
            $error = $this->db->error();
        }else{
            return $query->result();
        }
    }

}
