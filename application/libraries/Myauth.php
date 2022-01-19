<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Myauth
{
    var $CI = NULL;
    var $_valid = NULL;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
        $this->CI->load->library('session');
        $this->CI->load->library('form_validation');
        $this->_valid = $this->CI->form_validation;
        $this->_wrapper = $this->CI->config->item('public_view');
    }

    public function login($page)
    {
        unset($_SESSION['messageinsertuser']);
        unset($_SESSION['messagelock']);
        unset($_SESSION['messageemail']);
        unset($_SESSION['messageuserid']);
        // unset($_SESSION['first_post_tran_id_topup']);
        
        $this->restrict(TRUE);

        if ($page == "") {
            $page = $this->_wrapper;
        }

        // $config = array(
        //                 array(
        //                     'field' => 'username'
        //                     ,'label'=> 'Nama'
        //                     ,'rules'=> 'trim|required|xss_clean|min_length[2]|max_length[20]'
        //                     )
        //                 ,array(
        //                     'field' => 'password'
        //                     ,'label'=> 'Password'
        //                     ,'rules'=> 'trim|required|min_length[6]'
        //                     )
        //                 );
        // $this->_valid->set_rules($config);

        $this->_valid->set_rules(
            'username',
            'user name must be filled',
            'required',
            array('required' => '%s.')
        );

        $this->_valid->set_rules(
            'password',
            'password',
            'required|min_length[6]',
            array('required' => 'You must provide a %s.')
        );

        if ($this->_valid->run() !== FALSE and ($this->CI->input->post('submit_login') != FALSE || $this->CI->input->post('v_submit_login') == 'posting')) {

            $login = array(
                'user' => $this->CI->input->post('username'), 
                'pass' => $this->CI->input->post('password')
            );

            $expired_in_days = $this->_cek_expired_password($login['user']);
            if (!$this->_cek_user_id($login['user'])){
                $this->CI->session->set_flashdata('messageuserid', "user id not registered");
            }else if ($this->_cek_email_verify($login['user'])){
                $this->CI->session->set_flashdata('messageemail', "please confirm your email addres first");
            }else if ($this->_cek_open($login['user'])){
                $this->CI->session->set_flashdata('messageemail', "your account is still NonActive");
            }else if ($this->_cek_lock($login['user'])) {
                $this->CI->session->set_flashdata('messagelock', "sory your account has been locked, please contact administrator");
            }else if($expired_in_days<0){
                $this->CI->session->set_flashdata('messageexppass', "sory your password has expired, please contact administrator");
            }else{
                if ($this->_validate_login($login)) {
                    if($expired_in_days<6){
                        $this->CI->session->set_userdata('expired_pass_in', $expired_in_days);
                    }
                    // $this->_cek_history_topup($login['user']);
                    $this->redirect();
                } else {
                    
                    $attemp_login = $this->_cek_attemp($login['user']);
                    if ($attemp_login==3){
                        $this->CI->session->set_flashdata('messagelock', "sory your account has been locked, attemp login : ".$attemp_login. " please contact administrator");
                    }else{
                        $this->CI->session->set_flashdata('messageinsertuser', "user name or password not match, attemp login : ".$attemp_login);
                    }
                    
                    // $this->redirect('login/form');
                }
            }

            
        }
        $data = array(
            'page_title' => 'Halaman Login', 'page_content' => 'login'
        );
        $data['default']['v_username'] = $this->CI->input->post('username');
        $data['default']['v_password'] = $this->CI->input->post('password');
        // $this->CI->session->set_flashdata('messageinsertuser', "Your data has been submitted");
        $this->CI->load->view($page, $data);
    }

    private function _cek_user_id($user_id){
        $this->CI->db->select('user_name');
        $this->CI->db->from('iso_users');
        $this->CI->db->where('user_name', $user_id);
        $query = $this->CI->db->get();

        if ($query->num_rows() > 0) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    private function _cek_expired_password($user_id){
        $this->CI->db->select('DATEDIFF(DAY, getdate(),expired_password) AS DateDiff');
        $this->CI->db->from('iso_users');
        $this->CI->db->where('user_name', $user_id);
        $query = $this->CI->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row(); 
            return $row->DateDiff;
        }
    }

    private function _cek_access_terminal($user_id){
        $this->CI->db->select('terminal_id');
        $this->CI->db->from('atm.tbl_user_terminal');
        $this->CI->db->where('user_id', $user_id);
        $query = $this->CI->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $val) {
                $terminal_access[]    = $val->terminal_id;
            }

            $this->CI->session->set_userdata('logged_terminal_access', $terminal_access[]);
        }


    }

    private function _cek_lock($user_id){
        $this->CI->db->select('user_name');
        $this->CI->db->from('iso_user_login');
        $this->CI->db->where('user_name', $user_id);
        $this->CI->db->where('status_lock', 'lock');
        $query = $this->CI->db->get();

        if ($query->num_rows() > 0) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    private function _cek_open($user_id){
        $this->CI->db->select('a.user_name');
        $this->CI->db->from('iso_users a');
        $this->CI->db->join('iso_email_verification b', 'a.user_name = b.user_name');

        $this->CI->db->where('a.user_name', $user_id);
        $this->CI->db->where('a.status_active', '0');
        $this->CI->db->where('b.status', 'confirmed');
        $query = $this->CI->db->get();

        // die($this->CI->db->last_query());
        if ($query->num_rows() > 0) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    private function _cek_attemp($user_id){
        $this->CI->db->select('attempt_login');
        $this->CI->db->from('iso_user_login');
        $this->CI->db->where('user_name', $user_id);
        $query = $this->CI->db->get();
        // die($this->CI->db->last_query());

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $val) {
                $v_attemp       = $val->attempt_login;
            }
            
        }
        return $v_attemp;
    }

    private function _cek_email_verify($user_id){
        $this->CI->db->select('email_verification');
        $this->CI->db->from('iso_user_login');
        $this->CI->db->where('user_name', $user_id);
        $this->CI->db->where('email_verification', 'f');
        $query = $this->CI->db->get();
        // die($this->CI->db->last_query());

        if ($query->num_rows() > 0) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    private function _cek_history_topup($user_id){

        $this->CI->db->select('invoice_no');
        $this->CI->db->from('iso_history_req_topup');
        $this->CI->db->where('user_request', $user_id);
        $this->CI->db->where('status_log', 'Active');
        $query_invoice = $this->CI->db->get()->row()->invoice_no;

        $this->CI->db->select('first_post_tran_id');
        $this->CI->db->from('iso_get_log_history_topup');
        $this->CI->db->where('request_no', $query_invoice);
        $query_first_post_tran_id = $this->CI->db->get();
        //die($this->CI->db->last_query());

        if ($query_first_post_tran_id->num_rows() > 0) {
            // foreach ($query->result() as $val) {
            //     $v_first_post_tran_id  = $val->first_post_tran_id;
            // }

            $this->CI->session->set_userdata('first_post_tran_id_topup', $query_first_post_tran_id->row()->first_post_tran_id);
            //return TRUE;
        }else{
            $this->CI->session->set_userdata('first_post_tran_id_topup', '');
            //return FALSE;
        }
    }

    private function _validate_login($login = NULL)
    {
        $this->CI->load->helper('array');
        if (!isset($login) && !is_array($login)) {
            return FALSE;
        }

        if (count($login) != 2) {
            return FALSE;
        }

        $this->CI->db->select('user_name');
        $this->CI->db->select('full_name');
        $this->CI->db->select('email');
        $this->CI->db->select('last_login');
        $this->CI->db->select('avatar');
        // $this->CI->db->select('prefix_atm');
        $this->CI->db->select('role');
        $this->CI->db->from('iso_user_login');
        $this->CI->db->where('user_name', $login['user']);
        $this->CI->db->where('password', md5($login['pass']));
        $this->CI->db->where('status_lock', 'unlock');
        $this->CI->db->where('status_active', '1');
        $query = $this->CI->db->get();
        // die($this->CI->db->last_query());

        if ($query->num_rows() > 0) {
            //$prefix_access = array();
            foreach ($query->result() as $val) {
                $v_user_name        = $val->user_name;
                $v_full_name        = $val->full_name;
                $v_last_login       = $val->last_login;
                //$prefix_access[]    = $val->prefix_atm;
                $avatar             = $val->avatar;
                $role               = $val->role;
            }

            
            $this->check_menu($v_user_name);
            
            $this->CI->session->set_userdata('logged_user_name', $v_user_name);
            $this->CI->session->set_userdata('logged_full_name', $v_full_name);
            $this->CI->session->set_userdata('logged_last_login', $v_last_login);
            // $this->CI->session->set_userdata('logged_prefix_access', $prefix_access);
            $this->CI->session->set_userdata('logged_avatar', $avatar);
            $this->CI->session->set_userdata('logged_role', $role);
            // $this->CI->session->set_userdata('expired_pass_in', $expired_in_days);

            // $this->_cek_access_terminal($v_user_name);

            $this->CI->db->update(
                'iso_users',
                array(
                    'last_login' => date('Y-m-d H:i:s'),
                    'attempt_login' => 0,
                ),
                array('user_name' => $v_user_name)
            );
            // log_message('info', 'WEB=>LOGIN SUCCESS : '.$v_user_name);
            wh_log(date("Y-m-d H:i:s") . " ===> " . "LOG IN : ".$this->CI->session->userdata('logged_user_name'));
            return TRUE;
        } else {
            
            // $array = array(
                // 'last_login' => date('Y-m-d H:i:s'),
                // 'status_lock' => 'lock',

            // );

            $this->CI->db->set('attempt_login', 'attempt_login+1', FALSE);
            // $this->CI->db->set($array, FALSE);
            $where = array('user_name' => $login['user']);
            $this->CI->db->where($where);
            $this->CI->db->update('iso_users');


            $this->CI->db->update(
                'iso_users',
                array(
                    'last_login' => date('Y-m-d H:i:s'),
                    'status_lock' => 'lock',
                ),
                array(
                    'user_name' => $login['user'],
                    'attempt_login' => 3,
                )
            );

            // $this->CI->db->update('tbl_users', 
            //                         array(
            //                             'last_login' => date('Y-m-d H:i:s'),
            //                             'attempt_login' => 'attempt_login + 1',
            //                         ), 
            //                         array('user_name' => $login['user']));
            // die($this->CI->db->last_query());
            return FALSE;
        }
    }

    public function logged_in()
    {
        if ($this->CI->session->userdata('logged_user_name') == "") {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function logout()
    {
        $this->CI->session->sess_destroy();
        redirect('login/form');
    }

    public function redirect()
    {
        //$this->check_menu("hari02");
        if ($this->CI->session->userdata('redirector') == "") {
            redirect('dashboard');
        } else {
            redirect($this->CI->session->userdata('redirector'));
        }
    }

    public function redirect_restrict()
    {
        redirect($this->CI->config->item('restrict_view'));
    }

    public function restrict($logged_out = FALSE)
    {

        
        if ($logged_out and $this->logged_in()) {
            $this->redirect();
        }

        if (!$logged_out and !$this->logged_in()) {
            $this->CI->session->set_userdata('redirector', $this->CI->uri->uri_string());
            redirect('login/form', 'location');
        }
    }

    function check_menu($user_id)
    {

        // $this->CI->db->select('page_controller');
        // $this->CI->db->from('tbl_permission_page');
        // $this->CI->db->where('user_name', $user_id);
        // $query = $this->CI->db->get()->result();

        // $menu_access = array();
        // foreach ($query as $val) {
        //     array_push($menu_access,$val->page_controller);
        //     //$menu_access = $val->page_controller;
        // }

        // $this->CI->session->set_userdata('list_access_menu', $menu_access);
        $this->CI->db->select('a.user_name');
        $this->CI->db->select('b.menu');
        $this->CI->db->select('b.category');
        $this->CI->db->from('iso_permission_page a');
        $this->CI->db->join('iso_menu b', 'a.page_controller = b.no');
        $this->CI->db->where('a.user_name', $user_id);
        $this->CI->db->order_by('b.no', 'asc');
        $query = $this->CI->db->get()->result();

        $category_access = array();
        foreach ($query as $val) {
            $array2=array($val->category,$val->menu);
            array_push ($category_access,$array2);
            // array_push();
        }
        // die();

        // $this->CI->session->set_userdata('list_access_category', $menu_access);
        $this->CI->session->set_userdata('list_access_menu', $category_access);
        // $test = $this->CI->session->set_userdata('list_access_menu', $menu_access);

    }

    public function restrict_level($level)
    {
        if (TRUE == $this->check_level($level)) {
            $this->redirect_restrict();
        }
    }

    public function check_level($level = "1")
    {
        $cookie = substr($this->CI->session->userdata('logged_user_level'), 3);
        if ($cookie != $level) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function permission_page($page)
    {
        $this->CI->db->select('page_controller');
        $this->CI->db->from('iso_permission_page');
        $this->CI->db->where('user_name', $this->CI->session->userdata('logged_user_name'));
        $this->CI->db->where('page_controller', $page);
        $query = $this->CI->db->get();

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            redirect($this->CI->config->item('restrict_view'));
        }
    }
    
}
