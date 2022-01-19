<?php

class Ptpr_model extends CI_Model
{

    function update_data_bank_sponsor($data, $where)
    {
        $this->db->update('iso_register_bank_sponsor', $data, $where);
        return $this->db->affected_rows();
    }

    function update_by_finance($data, $where)
    {
        $this->db->update('iso_history_req_topup', $data, $where);
        return $this->db->affected_rows();
    }

    function register_bank_sponsor($data)
    {
        return $this->db->insert('iso_register_bank_sponsor', $data);

        //catch error for insert records

        // if($this->db->insert('iso_register_bank_sponsor',$data))
        // {
        //     echo 'Row succesfully inserted!';
        // }else{
        //     $error = $this->db->error();
        //     print_r($error);

        // }

        // die();

    }

    function register_new_interchage($data)
    {
        //catch error for insert records

        // if($this->db->insert('iso_interchange',$data))
        // {
        //     echo 'Row succesfully inserted!';
        // }else{
        //     $error = $this->db->error();
        //     print_r($error);

        // }

        // die();

        return $this->db->insert('iso_interchange', $data);
    }

    function request_topup_package($data)
    {
        //catch error for insert records

        // if($this->db->insert('iso_history_req_topup',$data))
        // {
        //     echo 'Row succesfully inserted!';
        // }else{
        //     $error = $this->db->error();
        //     print_r($error);

        // }

        // die();

        return $this->db->insert('iso_history_req_topup', $data);
    }

    function get_data_bank_sponsor()
    {
        return $this->db->get('iso_register_bank_sponsor')->result();
    }

    function get_data_interchange()
    {
        return $this->db->get('iso_interchange')->result();
    }

    function delete_account_id($data)
    {
        $this->db->delete('iso_register_bank_sponsor', $data);
        return $this->db->affected_rows();
    }


    function register_list_package($data)
    {
        return $this->db->insert('iso_list_package', $data);
    }

    function register_list_package_fee($data)
    {
        return $this->db->insert_batch('iso_fee_bank_sponsor', $data);
    }


    function update_data_list_package($data, $where)
    {
        $this->db->update('iso_list_package', $data, $where);
        return $this->db->affected_rows();
    }

    function update_data_list_interchange($data, $where)
    {
        $this->db->update('iso_interchange', $data, $where);
        return $this->db->affected_rows();
    }
    function get_data_list_package()
    {
        $this->db->order_by('date_insert', 'desc');
        return $this->db->get('iso_list_package')->result();
    }

    function delete_list_package($data)
    {
        $this->db->delete('iso_list_package', $data);
        return $this->db->affected_rows();
    }

    function delete_package_fee($data)
    {
        $this->db->delete('iso_fee_bank_sponsor', $data);
        return $this->db->affected_rows();
    }

    function delete_list_interchange($data)
    {
        $this->db->delete('iso_interchange', $data);
        return $this->db->affected_rows();
    }


    function get_list_package()
    {
        $this->db->select('id');
        $this->db->select('package_code');
        $this->db->where('status', 'active');
        $this->db->order_by('package_code', 'asc');
        return $this->db->get('iso_list_package')->result();
    }

    function get_first_approved_rcs() {
        $this->db->select('top 1 ROW_NUMBER()over(order by date_fin_approved asc ) as nomor,invoice_no');
        return $this->db->get_where('iso_history_req_topup',array('status' => 'Approved By Finance'))->row()->invoice_no;
    }


    function get_data_history_package($where)
    {
        // $this->db->select('id');
        // $this->db->select('package_code');
        // $this->db->where('status','active');
        // $this->db->order_by('package_code', 'asc');
        // return $this->db->get_where('iso_history_req_topup', $where)->result();
        //return $this->db->get('iso_history_req_topup')->result();

        $this->db->select('ROW_NUMBER()over(order by a.date_fin_approved asc ) as nomor');
        $this->db->select('a.invoice_no');
        $this->db->select('a.package_selected');
        $this->db->select('a.user_request');
        $this->db->select('a.date_request');
        $this->db->select('a.user_finance');
        $this->db->select('a.date_fin_approved');
        $this->db->select('a.user_rcs');
        $this->db->select('a.date_rcs_approved');
        $this->db->select('b.payment_date');
        $this->db->select('a.status');
        $this->db->select('a.status_log');
        $this->db->from('iso_history_req_topup a');
        $this->db->join('iso_attach_topup b', "a.invoice_no = b.request_no",'left');
        $this->db->where('a.status',$where); 
        $this->db->order_by('a.date_fin_approved', 'desc'); 

        return  $this->db->get()->result();

    }

    function get_history_completed_package($where)
    {
        return $this->db->get_where('iso_history_req_topup', $where)->result();
    }
    function get_data_history_package_rejected($status)
    {
        $this->db->like('status', $status);
        return $this->db->get('iso_history_req_topup')->result();
    }

    function get_package_id($where)
    {
        $this->db->select('limit');
        $this->db->select('price');
        $this->db->select('minimum_limit');
        //$this->db->where('status','active');
        //$this->db->order_by('package_code', 'asc');
        return $this->db->get_where('iso_list_package', $where)->result();
    }

    function insert_attach_file_topup($data){

        // $this->db->db_debug = false;

        // if(!$this->db->insert('iso_attach_topup', $data))
        // {
        //     $error = $this->db->error();
        //     // do something in error case
        // }else{
        //     // do something in success case
        // }


        return $this->db->insert('iso_attach_topup', $data);        
    }
}
