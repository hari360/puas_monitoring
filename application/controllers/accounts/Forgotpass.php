<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Forgotpass extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Accounts_model', '', TRUE);
  }

  function valid_email($id)
  {
    if ($this->Accounts_model->valid_field_email($id) == TRUE) {
      return TRUE;
    } else {
      $this->form_validation->set_message('valid_email', $id . " not registered");
      return FALSE;
    }
  }

  function confirmresetpassword()
  {
    $data = array(
      'gettoken'   => $this->uri->segment(4),
    );

    $this->load->view('login/confirmresetpassword', $data);
  }

  function resetpass()
  {

    // $gettoken = $this->uri->segment(4);

    $rules = array(
      [
        'field' => 'password',
        'label' => 'password',
        'rules' => 'callback_valid_password',
      ],
      [
        'field' => 'conf_password',
        'label' => 'confirm password is required',
        'rules' => 'required|matches[password]',

      ],
    );
    $this->form_validation->set_rules($rules);

    if ($this->form_validation->run() == FALSE) {
      $data['default']['v_password'] = $this->input->post('password');
      $data['default']['v_conf_password'] = $this->input->post('conf_password');
    } else {
      $data = array(
        'password'        => md5($this->input->post('password')),
        'date_update'     => date('Y-m-d H:i:s'),
      );

      // $gettoken = $this->uri->segment(4);
      $this->Accounts_model->update_password($data, $this->input->post('v_token'));
      redirect('accounts/forgotpass/confirmresetpassword');
    }

    $datax = array(
      'gettoken'   => $this->uri->segment(4),
    );

    $this->load->view('login/resetpassword', $datax);
  }

  function index()
  {
    $this->form_validation->set_rules(
      'email',
      'email name must be filled',
      'required|callback_valid_email',
      array('required' => '%s.')
    );

    if ($this->form_validation->run() == FALSE) {
      $data['default']['v_email'] = $this->input->post('email');
    } else {
      $data = array(
        'email'           => $this->input->post('email'),
        // 'date_insert'     => date('Y-m-d H:i:s'),
      );

      $this->load->helper('string');

      $token = str_replace("@", "at", $data['email']) . random_string('alnum', 8);
      $this->Accounts_model->insert_forgot_pass($data['email'], $token);
      $segments = ['accounts', 'forgotpass', 'resetpass', $token];
      $url_link = site_url($segments);



      $email = new sendmail();

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
                                
                                    Reset Password In New Web Monitoring ATM
    
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
                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">' . $data['email'] . '</strong>,
                                            </p>
                                            <p
                                                style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                                This is a email for reset password from New Web Monitoring ATM system.<br>
                                                please click link this below
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
                                                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #FFF; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #3097D1; border-top: 10px solid #3097D1; border-right: 18px solid #3097D1; border-bottom: 10px solid #3097D1; border-left: 18px solid #3097D1;">Reset Password Link</a>
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


      $email->v_to_email = $data['email'];
      $email->v_subject = 'Reset Password Web Monitoring ATM';
      $email->v_message = $body_mail;
      $email->_send();

      $this->session->set_flashdata('messagereqresetpass', "Link reset password has sent, please check your email for verification");
      redirect('accounts/forgotpass');
    }

    $this->load->view('login/forgotpassword');
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
