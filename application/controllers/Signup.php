<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Accounts_model', '', TRUE);
    // $this->load->library('form_validation');
  }

  function valid_id($id)
  {
    if ($this->Accounts_model->valid_field($id) == TRUE) {
      $this->form_validation->set_message('valid_id', $id . " already registered.");
      return FALSE;
    } else {
      return TRUE;
    }
  }

  function index()
  {
    // $email = new sendmail();
    // $email->v_to_email = 'hari@alto.id';
    // $email->v_subject = 'New Registration TEST';
    // $email->_send();

    $this->form_validation->set_rules(
      'fullname',
      'full name must be filled',
      'required',
      array('required' => '%s.')
    );
    $this->form_validation->set_rules(
      'gender',
      'please select one of gender',
      'required',
      array('required' => '%s.')
    );
    $this->form_validation->set_rules(
      'userid',
      'user id must be filled',
      'required|callback_valid_id',
      array('required' => '%s.')
    );
    $this->form_validation->set_rules(
      'email',
      'email must be filled',
      'required|callback_valid_id',
      array('required' => '%s.')
    );


    $rules = array(
      [
        'field' => 'password',
        'label' => 'password',
        'rules' => 'callback_valid_password',
      ],
      [
        'field' => 'conf_password',
        'label' => 'confirm password',
        'rules' => 'matches[password]',

      ],
    );
    $this->form_validation->set_rules($rules);
    // $this->form_validation->set_rules('password', 'password', 'required|min_length[6]|matches[conf_password]',
    //         array('required' => 'You must provide a %s.')
    // );
    // $this->form_validation->set_rules('conf_password', 'password not match', 'required|min_length[6]',
    // array('required' => '%s.')
    // );


    if ($this->form_validation->run() == FALSE) {
      $data['default']['v_fullname'] = $this->input->post('fullname');
      $data['default']['v_gender'] = $this->input->post('gender');
      $data['default']['v_userid'] = $this->input->post('userid');
      $data['default']['v_email'] = $this->input->post('email');
      $data['default']['v_password'] = $this->input->post('password');
      $data['default']['v_conf_password'] = $this->input->post('conf_password');
    } else {
      $data = array(
        'user_name'       => $this->input->post('userid'),
        'password'        => md5($this->input->post('password')),
        'full_name'       => $this->input->post('fullname'),
        'gender'          => $this->input->post('gender'),
        'email'           => $this->input->post('email'),
        'status_active'   => '0',
        'avatar'          => $this->input->post('ajaxDateTo'),
        'attempt_login'   => '0',
        'status_lock'     => 'unlock',
        'email_verification'     => 'f',
        // 'last_login'      => $this->input->post('ajaxDateTo'),
        'date_insert'     => date('Y-m-d H:i:s'),
        // 'date_update'     => $this->input->post('ajaxDateTo'),
      );

      $config = array(
        'upload_path'   => './uploads',
        'allowed_types' => 'jpg|png|jpeg|bmp',
      );

      $this->load->library('upload', $config);

      if (!empty($_FILES['file_avatar']['name'][0])) {
        $files = $_FILES['file_avatar'];
        $title = "";

        // $_FILES['file_avatar']['name']= $files['name'][$key];
        // $_FILES['file_avatar']['type']= $files['type'][$key];
        // $_FILES['file_avatar']['tmp_name']= $files['tmp_name'][$key];
        // $_FILES['file_avatar']['error']= $files['error'][$key];
        // $_FILES['file_avatar']['size']= $files['size'][$key];

        // $fileName = $title .'_'. $image;
        $config['file_name'] = 'upload_avatar';
        $this->upload->initialize($config);

        if ($this->upload->do_upload('file_avatar')) {
          $upload_data = $this->upload->data();
          $file_name_tmp = $upload_data['file_name'];

          $data['avatar'] = $file_name_tmp;
        } else {
          // $failed_json[]=$fileName.$this->upload->display_errors();
        }
      } else {
        $data['avatar'] = 'profile10.png';
      }

      $this->load->helper('string');

      $token = $data['user_name'] . random_string('alnum', 8);
      $this->Accounts_model->insert_users($data, $token);
      $segments = ['accounts', 'verifyemail', 'verification', $token];
      $url_link = site_url($segments);

      // $body_mail = '<html>
      // <head>
      //     <style type="text/css">
      //         body {background-color: #CCD9F9;
      //              font-family: Verdana, Geneva, sans-serif}
      //         h3 {color:#4C628D}
      //         p {font-weight:bold}
      //         a {
      //           background-color: red;
      //           color: white;
      //           padding: 1em 1.5em;
      //           cursor:pointer
      //         }
      //     </style>
      // </head>
      // <body>
      //     <h3>Hi, '.$data['full_name'].' </h3>
      //     <h3>Thanks for your registration</h3> 
      //     Please click on below URL to verify your email address
      //     <br>
      //     <a href="'.$url_link.'">Activation Link</a>

      // </body>
      // </html>';

      $email = new sendmail();
      // $v_email = new sendmail();

      $filename = site_url('/assets/images/logo_email_alto.png');
      $this->email->attach($filename);
      $cidx = $this->email->attachment_cid($filename);

      $body_mail = '<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    </head>
    
    <body
        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; color: #74787E; height: 100%; hyphens: auto; line-height: 1.4; margin: 0; -moz-hyphens: auto; -ms-word-break: break-all; width: 100% !important; -webkit-hyphens: auto; -webkit-text-size-adjust: none; word-break: break-word;">
        <style>
            @media only screen and (max-width: 600px) {
                .inner-body {
                    width: 100% !important;
                }
    
                .footer {
                    width: 100% !important;
                }
            }
    
            @media only screen and (max-width: 500px) {
                .button {
                    width: 100% !important;
                }
            }
        </style>
        <table class="wrapper" width="100%" cellpadding="0" cellspacing="0"
            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
            <tr>
                <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                    <table class="content" width="100%" cellpadding="0" cellspacing="0"
                        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                        <tr>
                            <td class="content-cell"
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
                                
                                    User Registration In New Web Monitoring ATM
    
                            </td>
                        </tr>
                        <!-- Email Body -->
                        <tr>
                            <td class="body" width="100%" cellpadding="0" cellspacing="0"
                                style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #FFFFFF; border-bottom: 1px solid #EDEFF2; border-top: 1px solid #EDEFF2; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                                <table class="inner-body" align="left" width="570" cellpadding="0" cellspacing="0"
                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #FFFFFF; margin: 0 auto; padding: 0; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                                    <!-- Body content -->
                                    <tr>
                                        <td class="content-cell"
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
                                            <p
                                                style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                                Dear <strong
                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">' . $data['full_name'] . '</strong>,
                                            </p>
                                            <p
                                                style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                                This is a email verification from New Web Monitoring ATM system.<br>
                                                For complete registration process, please click link this below
                                            </p>
    
                                            <table class="action" align="center" width="100%" cellpadding="0"
                                                cellspacing="0"
                                                style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0px auto; padding: 0; text-align: center; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                                                <tr>
                                                    <td align="center"
                                                        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                        <table width="100%" border="0" cellpadding="0" cellspacing="0"
                                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                            <tr>
                                                                <td align="left"
                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                                    <table border="0" cellpadding="0" cellspacing="0"
                                                                        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                                        <tr>
                                                                            <td
                                                                                style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                                                                <a href="' . $url_link . '"
                                                                                    class="button button-primary"
                                                                                    target="_blank"
                                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #FFF; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #3097D1; border-top: 10px solid #3097D1; border-right: 18px solid #3097D1; border-bottom: 10px solid #3097D1; border-left: 18px solid #3097D1;">Activation Link</a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0"
                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0 auto; padding: 0; text-align: left; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;">
                                    <tr>
                                        <td class="content-cell" align="center"
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 0px;">
    
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    
        <table >
                                    <!-- Body content -->
                                    <tr>
        <td class="content-cell"
                                            style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px;">
                                            <img src="cid:' . $cidx . '" alt="photo1" />
        </td>   
        </tr>
    </table>
    </body>
    
    </html>
        ';


      // send email with php  
      // $email->v_to_email = $data['email'];
      // $email->v_subject = 'Email Verification Web Monitoring ATM';
      // $email->v_message = $body_mail;
      // $email->_send();


      // send email with java
      $email->v_to_email = $data['email'];
      $email->v_cc       = 'hari@alto.id';
      $email->v_subject  = 'Email Verification Web Monitoring ATM';
      $email->v_message  = $body_mail;
      $email->_save_mail();

      $this->session->set_flashdata('messageinsertuser', "Your account has been submitted, please check your email for verification");
      redirect('signup');
    }


    $this->load->view('login/sign_up', $data);
  }

  function insert()
  {

    // $this->load->helper(array('form', 'url'));

    // $this->load->library('form_validation');


    $this->form_validation->set_rules('userid', 'Username', 'required');
    $this->form_validation->set_rules(
      'password',
      'Password',
      'required',
      array('required' => 'You must provide a %s.')
    );
    $this->form_validation->set_rules('conf_password', 'Password Confirmation', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required');

    if ($this->form_validation->run() == FALSE) {
      $this->load->view('login/sign_up');
    } else {
      $data = array(
        'user_name'       => $this->input->post('userid'),
        'password'        => md5($this->input->post('password')),
        'full_name'       => $this->input->post('fullname'),
        'gender'          => $this->input->post('gender'),
        'email'           => $this->input->post('email'),
        'status_active'   => '0',
        'avatar'          => $this->input->post('ajaxDateTo'),
        // 'last_login'      => $this->input->post('ajaxDateTo'),
        'date_insert'     => date('Y-m-d H:i:s'),
        // 'date_update'     => $this->input->post('ajaxDateTo'),
      );
      // print_r($data);

      $this->Accounts_model->insert_users($data);
      redirect('signup');
    }
  }


  function valid_password($password = '')
  {
    $password = trim($password);

    $regex_lowercase = '/[a-z]/';
    $regex_uppercase = '/[A-Z]/';
    $regex_number = '/[0-9]/';
    $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';

    if (empty($password)) {
      $this->form_validation->set_message('valid_password', '{field} is required.');

      return FALSE;
    }

    if (preg_match_all($regex_lowercase, $password) < 1) {
      $this->form_validation->set_message('valid_password', '{field} field must be at least one lowercase letter.');

      return FALSE;
    }

    if (preg_match_all($regex_uppercase, $password) < 1) {
      $this->form_validation->set_message('valid_password', '{field} field must be at least one uppercase letter.');

      return FALSE;
    }

    if (preg_match_all($regex_number, $password) < 1) {
      $this->form_validation->set_message('valid_password', '{field} field must have at least one number.');

      return FALSE;
    }

    if (preg_match_all($regex_special, $password) < 1) {
      $this->form_validation->set_message('valid_password', '{field} field must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>§~'));

      return FALSE;
    }

    if (strlen($password) < 8) {
      $this->form_validation->set_message('valid_password', '{field} field must be at least 8 characters in length.');

      return FALSE;
    }

    if (strlen($password) > 32) {
      $this->form_validation->set_message('valid_password', '{field} field cannot exceed 32 characters in length.');

      return FALSE;
    }

    return TRUE;
  }
}
