<?php

class Postgre_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
        $this->db_postgre = $this->load->database('postgre', TRUE);
    }

    function insert_email($data_email)
    {
        return $this->db_postgre->insert('send_email_request', $data_email);
    }
}