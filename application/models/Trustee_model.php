<?php
/**
 * Trustee_model Class
 *
 */
class Trustee_model extends CI_Model {

	// Inisialisasi nama tabel user
	var $table = 'iso_auth_access';
	var $user_table = 'iso_users';
    var $application_name = 'INTISENTRAL';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function selectAll($limit, $offset)
    {
        $this->db->select('user_id');
        $this->db->select('username');
        $this->db->select('user_institution');
        $this->db->select('user_email');
        $this->db->select('user_active');
        $recno = intval($limit) + intval($offset) ;
        return $this->db->get($this->user_table, $recno);
    }

	function count_all_num_rows()
	{
		return $this->db->count_all($this->table);
	}


    function select_trustee($id) {
        $this->load->database('default', TRUE);
        $this->db->select('link_code, trustee_code');
  		$this->db->where('username', $id);
  		$this->db->where('trustee_code', '1');
  		$this->db->where('program', $this->application_name);
        $this->db->from($this->table);
        return $this->db->get();
    }

    function count_select_trustee($id) {
        $this->db->select('link_code');
  		$this->db->where('username', $id);
  		$this->db->where('trustee_code', '1');
        $this->db->from($this->table);
        return $this->db->get()->num_rows();
    }

    function select_trustee_modul($id, $link_code) {
        $this->db->select('trustee_code');
  		$this->db->where('username', $id);
  		$this->db->where('link_code', $link_code);
  		$this->db->where('program', $this->application_name);
        $this->db->from($this->table);
        return $this->db->get();
    }

    function count_select_trustee_modul($id, $link_code) {
        $this->db->select('trustee_code');
  		$this->db->where('username', $id);
  		$this->db->where('link_code', $link_code);
  		$this->db->where('program', $this->application_name);
        $this->db->from($this->table);
        return $this->db->get()->num_rows();
    }

    function userdata($id) {
        return $this->db->get_where($this->table, array('user_id'=>$id))->row();
    }

    function select_user($id) {
        return $this->db->get_where($this->table, array('user_id'=>$id))->result();
        //die($this->db->last_query());
    }


    /**
    * Mengambil semua data preferensi
    */
    public function get_preference()
    {
        $query = $this->db->get('srt_preferences');
        return $query->result_array();
    }
    
    /**
    * Mengubah data preferensi
    */
    public function set_preference()
    {
        $data['min_password_chars'] = $this->input->post('min_password_chars');
        $data['allow_admin_register_new_admin'] = $this->input->post('admin_register_new_admin');
        $data['allow_admin_edit_other_admin'] = $this->input->post('admin_edit_other_admin');
        $data['allow_admin_delete_other_admin'] = $this->input->post('admin_delete_other_admin');
        $data['allow_admin_clear_captcha'] = $this->input->post('admin_clear_captcha');
        $data['allow_admin_backup_database'] = $this->input->post('admin_backup_database');
        $data['allow_admin_optimize_database'] = $this->input->post('admin_optimize_database');
        
        foreach($data as $key=>$val)
        {
            $new_data['pitems'] = $key;
            $new_data['pvalues'] = $val;
            $this->db->where('pitems',$key);
            $this->db->update('preferences',$new_data);
        }
        return TRUE;
    }
    
    /**
    * Mengambil item data preferensi
    * lalu membalikkan nilai dari item tersebut
    * 
    * @param mixed $item
    */
    public function get_preference_item($item)
    {
        $query = $this->db->get_where('srt_preferences',array('pitems'=>$item));
        if($query->num_rows() == 1)
        {
            $row = $query->row();
            return $row->pvalues;
        }
        return FALSE;
    }
    
    /**
    * Mengambil data semua pengguna
    * 
    * @param mixed $where
    */
    public function get_user($where = array())
    {
        $this->db->select('uid,username,email,access');
        return $this->db->get_where('users',$where);
    }
    
    /**
    * Mencari ID seorang pengguna
    * 
    * @param mixed $where
    */
    public function get_user_id($where = array())
    {
        $query = $this->fetch_user($where);
        if($query->num_rows() == 1)
        {
            $row = $query->row();
            return $row->uid;
        }
        return FALSE;
    }
    
    /**
    * Untuk mengetahui apakah ada
    * pengguna berdasaran data tertentu
    * 
    * @param mixed $where
    */
    public function fetch_user($where = array())
    {
        $this->db->select('uid');
        return $this->db->get_where('users',$where);
    }
    
    /**
    * Apakah seorang pengguna
    * bertingkat highest administrator?
    * 
    * @param mixed $where
    */
    public function is_highest_administrator($where = array())
    {
        $highest_admin_num = NULL;
        $highest_admin = 'highest_administrator';
        $user_level = $this->config->item('user_level');
        while(list($key,$val) = each($user_level))
        {
            if($val == $highest_admin)
            {
                $highest_admin_num = $key;
            }
        }
        
        //kueri
        $query = $this->get_user($where);
        if($query->num_rows() == 1)
        {
            $row = $query->row();
            if($row->access == $highest_admin_num)
            {
                return TRUE;
            }
            return FALSE;            
        }
        return FALSE;
    }
}
// END Trustee_model Class

/* End of file Trustee_model.php */ 
/* Location: ./system/application/model/Trustee_model.php */
?>