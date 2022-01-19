<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Insertlog
{

    var $CI = NULL;
    var $_valid = NULL;
    // public $v_to_email  = '';
    // public $v_subject   = '';
    // public $v_message   = '';
    // public $v_cc        = '';

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
        //$this->CI->load->model('Postgre_model', '', TRUE);
    }

    function get_log($bsn_date, $log_desc)
    {
        $now = new DateTime();
        //echo $now->format("Y-m-d H:i:s.v");
        $data = array(
            'bsn_date'      => $bsn_date,
            'date_insert'   => $now->format("Y-m-d H:i:s.v"),//date('Y-m-d H:i:s.v'),
            'log_desc'      => $log_desc,

        );
        $this->CI->Reporting_model->insert_log_generate($data);
    }

    // function _save_mail()
    // {
    //     $data = array(
    //         'email_institution_code'    => 'Web ATMI',
    //         'email_receiver'            => $this->v_to_email,
    //         'email_cc'                  => $this->v_cc,
    //         'email_subject'             => $this->v_subject,
    //         'email_content'             => $this->v_message,
    //         'email_file_path'           => 'file_path',
    //         'email_file_name'           => 'file_name'
    //     );

    //     //$this->CI->Reporting_model->insert_log_generate($data);
    //     if($this->CI->Postgre_model->insert_email($data))
    //        //
    //         return TRUE;
    //     else
    //         echo $this->CI->email->print_debugger();
    //         return FALSE;
    // }


}
