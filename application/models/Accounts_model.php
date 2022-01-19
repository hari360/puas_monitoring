<?php

class Accounts_model extends CI_Model
{

    function insert_users($data, $token)
    {
        $now = date("Y-m-d H:m:s");
        $expired_link = date("Y-m-d H:i:s", strtotime('+3 hours', strtotime($now))); // $now + 3 hours
        $data_email = array(
            'user_name'       => $data['user_name'],
            'email_name'      => $data['email'],
            'date_submit'     => date('Y-m-d H:i:s'),
            'status'          => 'not confirmed',
            'expired'         => $expired_link,
            'token'           => $token
        );

        $this->db->insert('iso_email_verification', $data_email);
        $this->db->insert_id();


        $this->db->insert('iso_users', $data);
        return $this->db->insert_id();
    }

    function insert_forgot_pass($email, $token)
    {
        $now = date("Y-m-d H:m:s");
        $expired_link = date("Y-m-d H:i:s", strtotime('+3 hours', strtotime($now))); // $now + 3 hours
        $data_email = array(
            'email'         => $email,
            'token'         => $token,
            'status'        => 'not confirmed',
            'date_insert'   => date('Y-m-d H:i:s'),
        );

        $this->db->insert('iso_reset_password', $data_email);
        return $this->db->insert_id();
    }

    function profile_user()
    {
        return $this->db->get_where('iso_get_data_profile', array('user_name' => $this->session->userdata('logged_user_name')))->row();
    }

    function check_old_password($password)
    {
        $query =  $this->db->get_where(
            'iso_users',
            array(
                'user_name' => $this->session->userdata('logged_user_name'),
                'password' => md5($password)

            )
        );
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function valid_field($id)
    {
        $query = $this->db->get_where('iso_users', "(user_name = '" . $id . "' or email = '" . $id . "')");
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function valid_field_email($email)
    {
        $query = $this->db->get_where('iso_users', array('email' => $email));
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function valid_confirm($token)
    {
        $query = $this->db->get_where('iso_email_verification', array('token' => $token, 'status' => 'confirmed'));
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function change_password($data, $where)
    {
        $this->db->set('expired_password', 'CONVERT(DATE, DATEADD(MONTH, 3, GETDATE()))', false);
        $this->db->update('iso_users', $data, $where);
        return $this->db->affected_rows();
    }

    function change_image($data, $where)
    {
        $this->db->update('iso_users', $data, $where);
        return $this->db->affected_rows();
    }

    function update_data_account($data, $where)
    {
        $this->db->update('iso_users', $data, $where);
        return $this->db->affected_rows();
    }

    function update_menu_access($data)
    {
        $user_id = $data[0]['user_name'];
        $this->db->delete('iso_permission_page', array('user_name' => $user_id));
        if ($this->db->insert_batch('iso_permission_page', $data))
        {
            return TRUE;
        }
        else
        {
            $error_query = $this->db->error(); 
            return FALSE;
        }
        // $this->db->update('tbl_users', $data, $where);
        // return $this->db->affected_rows();
    }

    function update_terminal_access($data)
    {
        $user_id = $data[0]['user_id'];
        $this->db->delete('iso_user_terminal', array('user_id' => $user_id));
        if ($this->db->insert_batch('iso_user_terminal', $data))
        {
            return TRUE;
        }
        else
        {
            $error_query = $this->db->error(); 
            return FALSE;
        }
    }

    function update_password($data, $token)
    {
        $datax = array(
            'status'               => 'confirmed',
            'date_update'          => date('Y-m-d H:i:s')
        );
        $this->db->update('iso_reset_password', $datax, array('token' => $token));

        $getemail =  $this->db->get_where('iso_reset_password', array('token' => $token))->row()->email;

        $this->db->update('tbl_users', $data, array('email' => $getemail));
        return $this->db->affected_rows();
    }

    function get_user_id($token){
        $this->db->select('a.user_name');
        $this->db->from('iso_users a');
        $this->db->join('iso_email_verification b', 'a.user_name = b.user_name');
        $array = array('b.token' => $token);
        $this->db->where($array);

        return $this->db->get()->row();
    }

    function get_data_user_register($user_id){
        return $this->db->get_where('iso_users', 
            array('user_name' => $user_id))->result();
    }

    function get_data_user_menu($user_id){
        // return $this->db->get_where('tbl_permission_page', 
        //     array('user_name' => $user_id))->result();

        $this->db->select('*');
        $this->db->from('iso_menu a');
        $this->db->join('iso_permission_page b', "a.no = b.page_controller and b.user_name = '".$user_id."'", 'left');
        $this->db->order_by('a.category', 'asc');
        return $this->db->get()->result();
        // die($this->db->last_query());   
    }

    function update_data_verify_email($data, $where, $token)
    {
        $datax = array(
            'status'               => 'confirmed',
            'date_verify'          => date('Y-m-d H:i:s')
        );
        $this->db->update('iso_email_verification', $datax, array('token' => $token));
        //$this->db->affected_rows();

        // die($token);

        $this->db->select('a.user_name');
        $this->db->from('iso_users a');
        $this->db->join('iso_email_verification b', 'a.user_name = b.user_name');
        // $array = array('b.token' => $token);
        // $this->db->where($array);

        $user_id =  $this->db->get()->row();

        // $this->db->select('*');
        // $this->db->from('tbl_user_terminal a');
        // $this->db->join('tbl_users b', 'a.user_id = b.user_name');
        // $array = array('a.user_id' => 'hari01', 'a.status' => 'aktif');
        // $this->db->where($array);
        // $test = $this->db->get()->row();



        $this->db->update('iso_users', $data, array('user_name' => $user_id->user_name));
        // $this->db->affected_rows();

        // die($test->user_name);   

        return $this->db->affected_rows();
    }

    function get_data_user_terminal_access(){
        
    }

    function get_data_terminal_access($data){
        $this->db->select('a.terminal_id
                            ,b.terminal_name
                            ,b.terminal_city');
        $this->db->from('iso_user_terminal a');
        $this->db->join('iso_terminal b', 'a.terminal_id = b.terminal_id','left');
        $this->db->where($data);
        $this->db->order_by('a.terminal_id', 'asc'); 
        return  $this->db->get()->result();

        // return $this->db->get_where('iso_user_terminal', $data)->result();
    }

    function get_data_fee_bank_sponsor($data){
        // $this->db->select('a.terminal_id
        //                     ,b.terminal_name
        //                     ,b.terminal_city');
        // $this->db->from('iso_user_terminal a');
        // $this->db->join('iso_terminal b', 'a.terminal_id = b.terminal_id','left');
        // $this->db->where($data);
        // $this->db->order_by('a.terminal_id', 'asc'); 
        // return  $this->db->get()->result();

        return $this->db->get_where('iso_fee_bank_sponsor', $data)->result();
    }

    function get_data_attachment_topup($data){
        return $this->db->get_where('iso_attach_topup', $data)->result();
    }


    function get_my_access_terminal(){
        // $this->db->select('user_create as user_name
        //                     ,max(b.full_name) as name
        //                     ,left(terminal_id,3) as term
        //                     ,count(*) as jml_term');
        // $this->db->from('tbl_terminal a');
        // $this->db->join('tbl_users b', 'a.user_create = b.user_name','left');
        // $bind = array('010', '041', '042');
        // $this->db->where_in('left(terminal_id,3)', $bind); 
        // $this->db->group_by('user_create,left(terminal_id,3)');
        // $this->db->order_by('user_create,term', 'asc'); 
        // return  $this->db->get()->result();
        // $this->db->get();
        // die($this->db->last_query());   


        $this->db->select('a.user_name
                            ,max(a.full_name) as name
                            ,left(b.terminal_id,3) as term
                            ,count(*) as jml_term');
        $this->db->from('iso_users a');
        $this->db->join('iso_user_terminal b', 'a.user_name = b.user_id','left');
        $bind = array('010', '041', '042');
        $this->db->where_in('left(b.terminal_id,3)', $bind); 
        $this->db->group_by('a.user_name,left(b.terminal_id,3)');
        $this->db->order_by('user_name,term', 'asc'); 
        return  $this->db->get()->result();
    }

    // function get_my_access_terminal()
    // {
    //     // $this->db->select('a.user_id
    //     // ,a.terminal_id
    //     // ,b.terminal_name
    //     // ,b.terminal_city
    //     // ,a.cit
    //     // ,a.jarkom');
    //     // $this->db->from('tbl_user_terminal a');
    //     // $this->db->join('tbl_terminal b', 'a.terminal_id = b.terminal_id');
    //     // // $array = array('a.user_id' => 'hari01', 'a.status' => 'aktif');
    //     // // $this->db->where($array);
    //     // $this->db->order_by('a.user_id asc,a.terminal_id asc');
    //     // // $this->db->limit(10);


    //     // return $this->db->get()->result();

    //     return $this->db->get('user_terminal_access')->result();
    // }

    function delete_accounts($data)
    {
        $this->db->delete('iso_users', $data);
        return $this->db->affected_rows();
    }

    function delete_terminal_access($data)
    {
        $this->db->delete('iso_user_terminal', $data);
        return $this->db->affected_rows();
    }

    function get_manage_accounts()
    {
        $this->db->select('a.user_name
                            ,a.full_name
                            ,a.gender
                            ,a.email
                            ,a.status_active
                            ,a.last_login
                            ,a.attempt_login
                            ,a.status_lock
                            ,a.email_verification
                            ,a.status_lock
                            ,b.role');
        $this->db->from('iso_users a');
        $this->db->join('iso_roles b', 'a.user_right = b.user_right', 'left');
        // $array = array('a.user_name !=' => $this->session->userdata('logged_user_name'));
        // $this->db->where($array);

        // $this->db->get();
        // die($this->db->last_query());   
        return $this->db->get()->result();
    }
}
