<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    // $controller = $this->router->fetch_class();
    // print_r($controller);
    // die();
    $this->myauth->permission_page('3');
    $this->load->model('Accounts_model', '', TRUE);
  }

  function index()
  { 

    // $controller = $this->router->fetch_class();
    // $method = $this->router->fetch_class();

    // print_r($controller);
    // print_r($method);
    // die();
    $data_user = $this->Accounts_model->profile_user();
    $data = array(
        'title'               => 'Accounts - My Profile ',
        'header_view'         => 'header_view',
        'content_view'        => 'accounts/profile',
        'sub_header_title'    => 'My Profile',
        'header_title'        => 'User Account',
        'username'            => $this->session->userdata('logged_full_name'),
        'lastlogin'           => $this->session->userdata('logged_last_login'),
        'data_profile'        => $data_user
    );
   
    
    $this->load->view('template', $data);
  }

  function update_password()
  {
    
    $result = array();

    $result['status_field_old']="";
    if($this->input->post('ajaxOldPassword')==""){
      $result['status_field_old'] = "old password blank";
    }else{
      if(!$this->Accounts_model->check_old_password($this->input->post('ajaxOldPassword'))){
        $result['status_field_old'] = "wrong old password";
      };
    }

    if($this->input->post('ajaxNewPassword')==""){
      $result['status_field_new'] = "new password blank";
    }else{
      $result['status_field_new'] = $this->valid_password($this->input->post('ajaxNewPassword'));
    }

    if($this->input->post('ajaxConfPassword')==""){
      $result['status_field_conf'] = "conf password blank";
    }else{
      if($this->input->post('ajaxConfPassword') != $this->input->post('ajaxNewPassword')){
        $result['status_field_conf'] = "conf password not match";
      }else{
        $result['status_field_conf'] = "";
      }
    }
    
    
    if($result['status_field_old']=="" && 
        $result['status_field_new']=="" && 
        $result['status_field_conf']==""){
      $vNewPassword    = md5($this->input->post('ajaxNewPassword'));
      $data = array(
        'password'     => $vNewPassword,
        );
        $this->Accounts_model->change_password($data,array('user_name' => $this->session->userdata('logged_user_name')));
        $result = array(
          "status_field" => "success",
          // "data" => $data
        );
      }

    echo json_encode($result);


      // echo json_encode(array("status" => TRUE));
  } 

  function send_mail() {
    $from_email = "alert@alto.id";
    $to_email = "hari@alto.id";
    //Load email library
    $this->load->library('email');

    $config = array (
      'protocol' => 'smtp',
      'mailtype' => 'html',
      'charset' => 'utf-8',
      'crlf' => "rn",
      'priority' => 3,
      'smtp_host' => 'smtp.office365.com',
      'smtp_port' => '587',
      'smtp_crypto' => 'tls',
      'newline' => "\r\n", //REQUIRED! Notice the double quotes!
      'smtp_user' => 'alert@alto.id',
      'smtp_pass' =>'4lt0@1234',
      'smtp_timeout' => 5
      );
    $this->email->initialize($config);

    $this->email->from($from_email, 'Identification');
    $this->email->to($to_email);
    $this->email->subject('Send Email Codeigniter');
    $this->email->message('The email send using codeigniter library');
    //Send mail
    if($this->email->send())
        die("Congragulation Email Send Successfully.");
    else
    echo $this->email->print_debugger();
  }

  private function valid_password($password = '')
  {
    $password = trim($password);

    $regex_lowercase = '/[a-z]/';
    $regex_uppercase = '/[A-Z]/';
    $regex_number = '/[0-9]/';
    $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';

    
    if (preg_match_all($regex_lowercase, $password) < 1)
    {
      return 'password must be at least one lowercase letter';
    }

    if (preg_match_all($regex_uppercase, $password) < 1)
    {
      return 'password must be at least one uppercase letter';
    }

    if (preg_match_all($regex_number, $password) < 1)
    {
      return 'password must have at least one number';
    }

    if (preg_match_all($regex_special, $password) < 1)
    {
      return 'password must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>§~');
    }

    if (strlen($password) < 8)
    {
      return 'password must be at least 8 characters in length';
    }

    if (strlen($password) > 32)
    {
      return 'password cannot exceed 32 characters in length';
    }

    return '';
  }

}
