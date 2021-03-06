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

    function insert_from_excel_deposit($data)
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

    function insert_from_excel_ppob($data)
    {
        
        $query = $this->db->insert_batch('hijrah_transaksi_ppob', $data);
        if(!$query){
            $error = $this->db->error();
            return FALSE;
        }else{
            return TRUE;
        }

        // return $this->db->insert_id();
    }

    function insert_from_excel_setor_tarik($data)
    {
        
        $query = $this->db->insert_batch('hijrah_transaksi_setor_tarik', $data);
        if(!$query){
            $error = $this->db->error();
            return FALSE;
        }else{
            return TRUE;
        }

        // return $this->db->insert_id();
    }

    function insert_from_excel_transfer($data)
    {
        
        $query = $this->db->insert_batch('hijrah_transaksi_transfer', $data);
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

    function get_data_trx_ppob()
    {
        $query = $this->db->get('hijrah_transaksi_ppob');
        if(!$query){
            $error = $this->db->error();
        }else{
            return $query->result();
        }
    }

    function get_data_trx_setor_tarik()
    {
        $query = $this->db->get('hijrah_transaksi_setor_tarik');
        if(!$query){
            $error = $this->db->error();
        }else{
            return $query->result();
        }
    }

    function get_data_trx_transfer()
    {
        $query = $this->db->get('hijrah_transaksi_transfer');
        if(!$query){
            $error = $this->db->error();
        }else{
            return $query->result();
        }
    }

}
