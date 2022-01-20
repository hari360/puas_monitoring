<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Sendmail
{
    var $CI = NULL;
    public $v_to_email  = '';
    public $v_subject   = '';
    public $v_message   = '';
    public $v_cc        = '';
    public $v_attach    = '';

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
        
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    private function load(){
        // Include PHPMailer library files
        require_once APPPATH.'third_party/PHPMailer/Exception.php';
        require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
        require_once APPPATH.'third_party/PHPMailer/SMTP.php';
        
        $mail = new PHPMailer;
        return $mail;
    }

    public function _send($attach="")
    {
    
        $mail = $this->load();
        
        // 'smtp_host' => 'smtp.office365.com',
        //     'smtp_port' => '587',
        //     'smtp_crypto' => 'tls',

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'smtp.office365.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Username = 'alert@alto.id';
        $mail->Password = '4lt0@1234';
        $mail->Port     = 587;
        // $mail->SMTPDebug = true;
        // $mail->Priority = 1;
        // $mail->Timeout       =   60;
        // $mail->SMTPKeepAlive = true;
        
        $mail->setFrom('alert@alto.id', 'New Monitoring ATMI');
        
        // Add a recipient
        $mail->addAddress($this->v_to_email);
        

        $multiple_cc = explode(";",$this->v_cc);
        // Add cc or bcc 
        foreach($multiple_cc as $v_cc_mail)
        {
            $mail->addCC($v_cc_mail);
        }

        
        // Add cc or bcc 
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');
        
        // Email subject
        $mail->Subject = $this->v_subject;
        
        // Set email format to HTML
        $mail->isHTML(true);
        $mail->AddEmbeddedImage("./assets/images/logo_email_alto.png", "my-attach", "logo_email_alto.png");
        
        // Email body content
        $mailContent = $this->v_message;
        $mail->Body = $mailContent;
        
        if($attach!=""){
            //$path       = '';
            $path       = set_realpath('attach/'.$this->v_attach.'/');
            $file_names = directory_map($path);

            foreach($file_names as $v_attach)
            {
                $mail->addAttachment($path.$v_attach);
            }
        }

        // Send email
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            die();
            return FALSE;
        }else{
            echo 'Message has been sent';
            if($attach!="")
            {
                foreach($file_names as $v_attach)
                {
                    unlink($path.$v_attach);
                }
            }   
            $mail->ClearAddresses();
            $mail->ClearAttachments();
            $mail->ClearAllRecipients();
            return TRUE;
        }
    }

    public function _send_mail_default($attach="")
    {
        $from_email = "New Web Monitoring ATMI <alert@alto.id>";
        // $to_email = $this->v_to_email;

        $config = array(
            'protocol' => 'smtp',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'crlf' => "\r\n",
            'priority' => 1,
            'smtp_host' => 'smtp.local.alto.id',
            'smtp_port' => '25',
            'smtp_crypto' => '',
            'newline' => "\r\n", //REQUIRED! Notice the double quotes!
            'smtp_user' => 'alert@alto.id',
            'smtp_pass' => '4lt0@1234',
            'smtp_timeout' => 5,
            'wordwrap' => TRUE,
            '_smtp_auth' => TRUE
        );

        $this->CI->email->initialize($config);

        $this->CI->email->from($from_email);
        $this->CI->email->to($this->v_to_email);
        $this->CI->email->cc($this->v_cc);
        $this->CI->email->subject($this->v_subject);
        $this->CI->email->message($this->v_message);
        // $this->CI->email->attach('E:\Temporary\Report ISO\Temp\20211119\ATMI\Settlement Fee ACQ ATMi 191121.pdf');
        // $this->CI->email->attach('E:\Temporary\Report ISO\Temp\20211119\PTPR\Settlement Fee ACQ PTPR 191121.pdf');

        if($attach!=""){
            //$path       = '';
            $path       = set_realpath('attach/'.$this->v_attach.'/');
            $file_names = directory_map($path);

            foreach($file_names as $v_attach)
            {
                $this->CI->email->attach($path.$v_attach);
            }
            // $this->CI->email->attach(site_url('/attach/ATMI/ptpr-detail-batch20211118.xlsx'));
            // $this->CI->email->attach(site_url('/attach/ATMI/ptpr-detail-reject-batch20211118.xlsx'));
        }
        //Send mail
        if ($this->CI->email->send()){

            // $this->v_attach = '';
            // die("Congragulation Email Send Successfully.");
            $this->CI->email->clear(TRUE);
            foreach($file_names as $v_attach)
            {
                unlink($path.$v_attach);
            }
            return TRUE;
        }else{
            echo $this->CI->email->print_debugger();
            return FALSE;
        }
    }

    public function _save_mail($attach="",$instance="")
    {
        $data = array(
            'email_institution_code'    => 'New Web Monitoring ATMI',
            'email_receiver'            => $this->v_to_email,
            'email_cc'                  => $this->v_cc,
            'email_subject'             => $this->v_subject,
            'email_content'             => $this->v_message,
            // 'email_file_path'           => '/REPORT/report_atmi_dev/attachment/',
            // 'email_file_name'           => 'detail-batch-atmi20211219.xlsx;detail_deposit-batch2623.xlsx'
        );

        if($attach!=""){
            $path       = set_realpath('\\\\10.9.11.33\\rcs$\\Report_Dev\\report_atmi_dev\\attachment\\'.$instance.'\\');
            $file_names = directory_map($path);
            $attachment = "";

            foreach($file_names as $v_attach)
            {
                $attachment .= $v_attach.';';
            }

            $data['email_file_path'] = '/REPORT/report_atmi_dev/attachment/'.$instance.'/';
            $data['email_file_name'] = $attachment;

            // print_r($data);
            // die();
        }

        

        if($this->CI->Postgre_model->insert_email($data)){
            return TRUE; 
        }
            
            
        else {
            echo $this->CI->email->print_debugger();
            return FALSE;
        }
            
    }
}
