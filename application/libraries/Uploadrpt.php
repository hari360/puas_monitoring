<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Uploadrpt
{
    var $CI = NULL;
    var $_valid = NULL;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
        $this->CI->load->library('session');
        $this->CI->load->library('insertlog');
    }

    function upload($bsn_date)
    {
        
    }

}