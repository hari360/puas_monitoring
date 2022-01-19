<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
        $this->load->library('myauth');
        $this->_wrapper = $this->config->item('public_view');
	}
    
    public function index()
    {
        //echo 'login coba 123';
        // die();
        // exec('c:\WINDOWS\system32\cmd.exe /c START "E:\Application\ALTO\New Apps\Copy FIle\run.bat"');
        // copy('E:\Application\ALTO\Documentation\Sertifikasi Report ATMI ISO\report fixed\20211124\TLF_ATMI_DEPOSIT_20211124.txt_PROCESSED', '\\\\10.9.11.33\rcs$\Folder HARI\TLF_ATMI_DEPOSIT_20211124.txt_PROCESSED');
        //die();
        // $cc = "hari@alto.id;sri@alto.id";
        // $multiple_cc = explode(";",$cc);
        // // Add cc or bcc 
        // foreach($multiple_cc as $v_cc_mail)
        // {
        //     echo $v_cc_mail."<br>";
        // }
        // die();

        // $settle_date = date('Ymd', (strtotime('-1 day', strtotime('20211227'))));
        // $v_dateprev = substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);
        // $v_dateprev = substr('20211227',6,2). substr('20211227',4,2). substr('20211227',2,2);
        // die($v_dateprev);
        $this->form();
    }
    
    public function form()
    {
        $this->myauth->login($this->_wrapper);
    }
    
    public function logout()
    {
        // log_message('info', 'WEB=>LOGOUT SUCCESS : '.$this->session->userdata('logged_full_name'));
        wh_log(date("Y-m-d H:i:s") . " ===> " . "LOG OUT : ".$this->session->userdata('logged_user_name'));
        $this->myauth->logout();
        
    }
}

?>