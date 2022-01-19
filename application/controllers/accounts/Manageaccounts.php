<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Manageaccounts extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    // $this->myauth->permission_page($this->router->fetch_class());
    $this->myauth->permission_page('5');
    $this->load->model('Postilion_model', '', TRUE);
    $this->load->model('Accounts_model', '', TRUE);
  }

  // function index(){
  //   $this->setup();
  // }

  function setup($user_reg = "")
  { 

    $menu_record = $this->Postilion_model->get_menu($user_reg);
    
    
    
    $list_menu = '';

    foreach ($menu_record as $data_list_menu)
    {
        if($data_list_menu->category=='Accounts' && $data_list_menu->cat=='1'){
          $list_menu .= '<optgroup label="Accounts">';
        }elseif($data_list_menu->category=='Home' && $data_list_menu->cat=='1'){
          $list_menu .= '</optgroup>';
          $list_menu .= '<optgroup label="Home">';
        }elseif($data_list_menu->category=='ATM' && $data_list_menu->cat=='1'){
          $list_menu .= '</optgroup>';
          $list_menu .= '<optgroup label="ATM">';
        }elseif($data_list_menu->category=='CRM' && $data_list_menu->cat=='1'){
          $list_menu .= '</optgroup>';
          $list_menu .= '<optgroup label="CRM">';
        }elseif($data_list_menu->category=='PTPR' && $data_list_menu->cat=='1'){
          $list_menu .= '</optgroup>';
          $list_menu .= '<optgroup label="PTPR">';
        }elseif($data_list_menu->category=='Reporting' && $data_list_menu->cat=='1'){
          $list_menu .= '</optgroup>';
          $list_menu .= '<optgroup label="Reporting">';
        }
        $list_menu .= '<option value="'.$data_list_menu->no.'"  '.($data_list_menu->user_name!=null ? 'selected' : '').'>'.$data_list_menu->menu.'</option>';
    }
    

    $data = array(
        'title'               => 'Monitoring-Manage Accounts',
        'header_view'         => 'header_view',
        'content_view'        => 'accounts/manage_accounts',
        'sub_header_title'    => 'Manage Accounts',
        'header_title'        => 'Manage Accounts',
        'username'            => $this->session->userdata('logged_full_name'),
        'lastlogin'           => $this->session->userdata('logged_last_login'),
        'list_menu'           => $list_menu,
        // 'table'               => $this->table->generate(),
    );

    $tmpl = array(
        'table_open'    => '<table class="table table-bordered table-striped table-hover" id="dt_manage_accounts" width="100%">',
        'thead_open'            => '<thead>',
        'thead_close'           => '</thead>',
        'heading_row_start'   => '<tr>',
        'heading_row_end'     => '</tr>',
        'heading_cell_start'  => '<th>',
        'heading_cell_end'    => '</th>',
        'row_alt_start'  => '<tr>',
        'row_alt_end'    => '</tr>'
      );
      $this->table->set_template($tmpl);
      $this->table->set_empty("&nbsp;");
      $this->table->set_heading(
                'User ID', 
                'Full Name', 
                'Gender', 
                'Email',
                'Status Active',
                'Email Verification',
                'Last Login',
                'Status Lock',
                'Role',
                array('data' => 'Action', 'align' => 'right')
      );
  
      $data_my_terminal_access = $this->Accounts_model->get_manage_accounts();
      // $terms_2 = $this->Postilion_model->term_monitor_offset_temp($this->session->userdata('logged_user_name'));
  
      foreach ($data_my_terminal_access as $my_terminal_access)
      {

        $cell_actions = '<button class="btn btn-primary btn-sm edit-accounts"><i class="zmdi zmdi-edit"></i></button>
                      <button class="btn btn-danger btn-sm" onclick="delete_manage_accounts(this.value,'."'".$my_terminal_access->user_name."'".','."'".$my_terminal_access->full_name."'".')"><i class="zmdi zmdi-delete"></i></button>';
                      
        //<button class="btn btn-success btn-sm" onclick="delete_terminal_parameterize(this.value,'."'".$my_terminal_access->user_name."'".','."'".$my_terminal_access->full_name."'".')" title="lock"><i class="zmdi zmdi-check"></i></button>
        $cell = array('data' => $cell_actions, 'style' => 'text-align:center'); 
        //$cell = array('data' => $cell_actions, 'style' => 'text-align:center;background-color:yellow'); 
        // $cell = array('data' => $cell_actions, 'class' => 'highlight', 'colspan' => 2);  
        $this->table->add_row($my_terminal_access->user_name, 
                              $my_terminal_access->full_name,
                              $my_terminal_access->gender,
                              $my_terminal_access->email,
                              // $my_terminal_access->status_active,
                              ($my_terminal_access->status_active=="0" ? "Non Active" : "Active"),
                              ($my_terminal_access->email_verification=="f" ? "False" : "True"),
                              $my_terminal_access->last_login,
                              $my_terminal_access->status_lock,
                              $my_terminal_access->role,
                              $cell
                            );  
  
      }  

      $data['table_manage_accounts'] = $this->table->generate();

    $this->load->view('template', $data);
  }

}
