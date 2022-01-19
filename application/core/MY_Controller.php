<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* Memperluas library Controller CI 
* untuk controller2 admin yang membutuhkan proses login
*/

class MY_Controller extends CI_Controller
{
    var $_admin_view = "";

	function __construct()
	{
		parent::__construct();
        // $this->load->library('myauth');
        //membatasi hak akses halaman
        $this->myauth->restrict();
        $this->load->model('Trustee_model');
        
        //direktori view admin
        $this->_admin_view = $this->config->item('admin_view')."wrapper.php";
    }
    
    public function restrict_level($level)
    {
        $this->myauth->restrict_level($level);
        $this->_admin_view = $this->config->item('admin_view')."wrapper.php";
    }
    
    public function check_level($level)
    {
        return $this->myauth->check_level($level);
    }

}

// END Admin_Controller class

/* End of file MY_Controller.php */
/* Location: ./system/application/core/MY_Controller.php */