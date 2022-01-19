<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Verifyemail extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Accounts_model', '', TRUE);
  }


  function verification(){

    // $data_view = array(
    //   'message'               => 'Thank you, your email has been verified. your account will be soon activated by administrator',
    // );
    // echo $this->uri->segment(4);
    if($this->Accounts_model->valid_confirm($this->uri->segment(4))){
      // die('confirmed');
      $data_view['message'] = 'Oops, sory your link has been confirmed';
      $data_view['image_notif'] = '<img src="'.site_url("assets/images/gif/close-icon-13602.png").'" width="90" height="90" style="border:0px solid red"  >';
      

    }else{
      // die('not confirm');
      $data = array(
        'email_verification'   => 't',
        'date_update'          => date('Y-m-d H:i:s')
        
        );
      $this->Accounts_model->update_data_verify_email($data,array('user_name' => $this->uri->segment(4)),$this->uri->segment(4));
      $data_view['message'] = 'Thank you, your email has been verified. your account will be soon activated by administrator';
      $data_view['image_notif'] = '<img src="'.site_url("assets/images/gif/streaq-icon-seamless.gif").'" width="90" height="90" style="border:0px solid red"  >';
      
      $user_reg = $this->Accounts_model->get_user_id($this->uri->segment(4));
      $this->email_to_admin($user_reg);

    }
    $this->load->view('login/verifyemail',$data_view);
  }

  function email_to_admin($user_reg){
    $email = new sendmail();

        $filename = site_url('/assets/images/logo_email_alto.png');
        $this->email->attach($filename);
        $cidx = $this->email->attachment_cid($filename);

        $segments = ['accounts', 'manageaccounts','setup',$user_reg->user_name];
        $url_link = site_url($segments);

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
                                
                                            Review user account that was registered
    
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
                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">Administrator</strong>,
                                            </p>
                                            <p
                                                style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">
                                                Need your review for open access user '.$user_reg->user_name.'<br>
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
                                                                                <a href="'.$url_link.'"
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
                                            <img src="cid:'. $cidx .'" alt="photo1" />
        </td>   
        </tr>
    </table>
    </body>
    
    </html>
        ';

    
    $email->v_to_email = 'hari@alto.id';
    $email->v_subject = 'Review user registration';
    $email->v_message = $body_mail;
    $email->_send();
  }

}