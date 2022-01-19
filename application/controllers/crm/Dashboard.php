<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->myauth->permission_page('2');
        $this->load->model('Dashboard_model', '', TRUE);
    }

    function insert_req_deposit()
    {
        // die($this->input->post('txt_req_package'));
        $mode = explode('|', substr($this->input->post('txt_req_package'),0,-1));
        // print_r($mode);
        // die();
        // $array = array();
        // foreach ($mode as $line) {
        //      $array[] = str_getcsv($line);
        // }
        $now = new DateTime();
        $data = array();
        foreach ($mode as $row) {
            $data[] = array(
                'user_request'      => 'hari03',
                'package_selected'  => $row,
                'date_request'      => $now->format("Y-m-d H:i:s.v"),
                'status'            => 'Requested',
                'invoice_no'        => '#BTN'.$now->format("YmdHisv")
            );
        }

        //print_r($data);
        $this->Dashboard_model->insert_req_deposit($data);

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
                                                    style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">'.$data['full_name'].'</strong>,
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
                                                                                <a href=""
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
    $email->v_subject = 'Request deposit';
    $email->v_message = $body_mail;
    $email->_send();

        $this->session->set_flashdata('messageinsertuser', "Your account has been submitted, please check your email for verification");
        redirect('crm/dashboard');
    }

    function index()
    {

        $data = array(
            'title'               => 'Transaction Dashbaord',
            'header_view'         => 'header_view',
            'content_view'        => 'crm/dashboard_trans',
            'sub_header_title'    => 'Transaction Dashbaord',
            'header_title'        => 'Dashboard CRM',
            'username'            => $this->session->userdata('logged_full_name'),
            'lastlogin'           => $this->session->userdata('logged_last_login'),
            // 'table_top5_crm_7days'=> $this->table->generate()
        );

        $get_approved_dashboard = $this->Dashboard_model->get_approved_trx();
        $total_trx = 0;

        foreach ($get_approved_dashboard as $get_record) {

            $total_trx += $get_record->count_trx;
            switch ($get_record->tran_type) {
                case "01":
                    $data['withdrawal'] = $get_record->count_trx;
                    break;
                case "31":
                    $data['balance_inq'] = $get_record->count_trx;
                    break;
                    // case "54":
                    //     $data['transfer'] = $get_record->count_trx;
                    //     break;
                    // case "21":
                    //     $data['deposit'] = $get_record->count_trx;
                    //     break;
                    // case "32":
                    //     $data['inq_deposit'] = $get_record->count_trx;
                    //     break;
            }
        }

        $data['total_trx'] = $total_trx;

        $this->load->view('template', $data);
    }
}
