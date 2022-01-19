<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Terminalaccess extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Accounts_model', '', TRUE);
    $this->load->model('Postilion_model', '', TRUE);
  }

  public function upload_excel()
  {
    $config = array(
      'upload_path'   => './uploads',
      'allowed_types' => 'xlsx',
    );

    $this->load->library('upload', $config);

    $images = array();
    $success_json = array();
    $failed_json = array();

    if (!empty($_FILES['file_xlsx']['name'][0])) {
      $files = $_FILES['file_xlsx'];
      $title = "";

      foreach ($files['name'] as $key => $image) {
        $_FILES['file_xlsx[]']['name'] = $files['name'][$key];
        $_FILES['file_xlsx[]']['type'] = $files['type'][$key];
        $_FILES['file_xlsx[]']['tmp_name'] = $files['tmp_name'][$key];
        $_FILES['file_xlsx[]']['error'] = $files['error'][$key];
        $_FILES['file_xlsx[]']['size'] = $files['size'][$key];

        $fileName = $title . '_' . $image;

        $images[] = $fileName;

        $config['file_name'] = $fileName;

        // $file_name_tmp = $_FILES['file_xlsx[]']['tmp_name'];

        $this->upload->initialize($config);

        if ($this->upload->do_upload('file_xlsx[]')) {
          // $this->upload->data();
          $upload_data = $this->upload->data();
          $file_name_tmp = $upload_data['file_name'];

          $this->read_excel_file($file_name_tmp);
          $success_json[] = $fileName;
        } else {
          $failed_json[] = $fileName . $this->upload->display_errors();
        }
      }
    }


    $result_json = array(
      'success_get' => $success_json,
      'failed_get' => $failed_json
    );

    echo json_encode($result_json);
    //return $images;
  }

  function read_excel_file($file_name)
  {
    // $file_name = "dumy data.xlsx";
    $spreadsheet = new Spreadsheet();

    $inputFileName = './uploads/' . $file_name;
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

    $spreadsheet = $reader->load($inputFileName);
    $d = $spreadsheet->getSheet(0)->toArray();

    echo count($d) . " <br>";
    $sheetData = $spreadsheet->getActiveSheet()->toArray();
    $i = 1;
    unset($sheetData[0]);

    $now = DateTime::createFromFormat('U.u', number_format(microtime(true), 3, '.', ''));
    $local = $now->setTimeZone(new DateTimeZone('Asia/Jakarta'));
    $data = array();
    foreach ($sheetData as $t) {
      // echo $i."---".$t[0]."-".$t[1]."-".$t[2]." <br>";
      // $i++;
      $data[] = array(
        'terminal_id'        => $t[0],
        'terminal_name'      => $t[1],
        'percentage'         => $t[2],
        'sent_mail'          => $t[3],
        'from_date'          => $t[4],
        'to_date'            => $t[5],
      );
    }
    $this->Postilion_model->insert_from_excel($data);
  }

  function update_terminal_access()
  {
    $vUserId  = $this->input->post('ajaxUserId');
    $vTerm    = $this->input->post('ajaxListterm');

    foreach ($vTerm as $v_menu) {
      $datax[] = array(
        'user_id'         => $vUserId,
        'terminal_id'     => $v_menu,
      );
    }

    $this->Accounts_model->update_terminal_access($datax);

    echo json_encode(array("status" => TRUE));
  }

  function index()
  {

    $list_user_terminal = $this->Postilion_model->get_users_not_access_term();
    $list_user_term = '';
    foreach ($list_user_terminal as $data_list_user_terminal) {
      $list_user_term .= '<option value="' . $data_list_user_terminal->user_name . '" >' . $data_list_user_terminal->user_name . '</option>';
    }

    $menu_record = $this->Postilion_model->get_user_access_term('');
    $list_menu = '';

    foreach ($menu_record as $data_list_menu) {
      if ($data_list_menu->prefix == '010' && $data_list_menu->cat == '1') {
        $list_menu .= '<optgroup label="Cardbase">';
      } elseif ($data_list_menu->prefix == '041' && $data_list_menu->cat == '1') {
        $list_menu .= '</optgroup>';
        $list_menu .= '<optgroup label="CRM">';
      } elseif ($data_list_menu->prefix == '042' && $data_list_menu->cat == '1') {
        $list_menu .= '</optgroup>';
        $list_menu .= '<optgroup label="PTPR">';
      }
      $list_menu .= '<option value="' . $data_list_menu->terminal_id . '"  ' . ($data_list_menu->user_id != null ? 'selected' : '') . '>' . $data_list_menu->terminal_id . '</option>';
    }

    $list_menu .= '</optgroup>';

    // $terminal = $this->Postilion_model->get_terminal_atm();
    // $prefix_term = '';    
    // $term = '<optgroup label="ATM">';


    // foreach ($terminal as $data_terminal) {


    //   if(substr($data_terminal->terminal_id,0,3)=='041' && $prefix_term == '' ){
    //     $term .= '</optgroup>';
    //     $term .= '<optgroup label="CRM">';
    //     $prefix_term = 'CRM';
    //   }

    //   if (substr($data_terminal->terminal_id,0,3)=='042' && $prefix_term == 'CRM'){
    //     $term .= '</optgroup>';
    //     $term .= '<optgroup label="PTPR">';
    //     $prefix_term = 'PTPR';
    //   }
    //   // $term .= '<option value="'.$data_terminal->terminal_id."-".$data_terminal->terminal_name.'" style="font-size: 12px;">'.$data_terminal->terminal_id."-".$data_terminal->terminal_name.'</option>';
    //   $term .= '<option value="'.$data_terminal->terminal_id.'">'.$data_terminal->terminal_id."-".$data_terminal->terminal_name.'</option>';

    // }

    // $term .= '</optgroup>';

    $data = array(
      'title'               => 'Monitoring-My Terminal Access',
      'header_view'         => 'header_view',
      'content_view'        => 'accounts/terminal_access',
      'sub_header_title'    => 'Terminal Access',
      'header_title'        => 'My Terminal Access',
      'username'            => $this->session->userdata('logged_full_name'),
      'lastlogin'           => $this->session->userdata('logged_last_login'),
      // 'table'               => $this->table->generate(),
      'list_terminal'       => $list_menu,
      'list_user'           => $list_user_term,
    );

    $tmpl = array(
      'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap"  id="dt_terminal_access" width="100%">',
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
      '',
      'User ID',
      'Full Name',
      'Prefix Terminal',
      'Count',
      'Actions'
    );

    $data_my_terminal_access = $this->Accounts_model->get_my_access_terminal();
    // $terms_2 = $this->Postilion_model->term_monitor_offset_temp($this->session->userdata('logged_user_name'));

    foreach ($data_my_terminal_access as $my_terminal_access) {

      $cell_extends = array('class' => 'details-control', 'title' => $my_terminal_access->user_name, 'data-prefix' => $my_terminal_access->term);

      $cell_actions = '<button class="btn btn-primary btn-sm edit-terminal-access" ><i class="zmdi zmdi-edit"></i></button>
                      <button class="btn btn-danger btn-sm" onclick="delete_terminal_access(this.value,' . "'" . $my_terminal_access->user_name . "'" . ',' . "'" . $my_terminal_access->term . "'" . ')"><i class="zmdi zmdi-delete"></i></button>';

      // $cell_actions = '<button class="btn btn-success btn-sm edit-terminal-access" ><i class="zmdi zmdi-search"></i></button>
      // <button class="btn btn-primary btn-sm edit-terminal-access" ><i class="zmdi zmdi-edit"></i></button>
      // <button class="btn btn-danger btn-sm" onclick="delete_terminal_access(this.value,' . "'" . $my_terminal_access->user_name . "'" . ',' . "'" . $my_terminal_access->term . "'" . ')"><i class="zmdi zmdi-delete"></i></button>';
      $cell = array('data' => $cell_actions, 'style' => 'text-align:center');
      $this->table->add_row(
        $cell_extends,
        $my_terminal_access->user_name,
        $my_terminal_access->name,
        $my_terminal_access->term,
        $my_terminal_access->jml_term,
        $cell
      );
    }

    $data['table_my_terminal_access'] = $this->table->generate();

    $this->load->view('template', $data);
  }
}
