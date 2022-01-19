<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Parameterize extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Postilion_model', '', TRUE);
  }

  function index()
  { 
    $terminal = $this->Postilion_model->get_terminal_atm();
    $term = '<option value="">Select Terminal Name</option>';

    

    foreach ($terminal as $data_terminal)
    {
        $term .= '<option value="'.$data_terminal->terminal_id."-".$data_terminal->terminal_name.'" style="font-size: 12px;">'.$data_terminal->terminal_id."-".$data_terminal->terminal_name.'</option>';
    }


    $data = array(
        'title'               => 'Monitoring-Parameterize',
        'header_view'         => 'header_view',
        'content_view'        => 'atm/parameterize_saldo',
        'sub_header_title'    => 'Parameterize',
        'header_title'        => 'PARAMETERIZE SALDO',
        'username'            => $this->session->userdata('logged_full_name'),
        'lastlogin'           => $this->session->userdata('logged_last_login'),
        'list_terminal'       => $term,
        // 'table'               => $this->table->generate(),
    );

    $terms = $this->Postilion_model->get_parameterize_saldo();

    $tmpl = array(
        'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_parameterize_saldo" width="100%">',
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
	  $this->table->set_heading(  'Terminal ID', 
                                'Terminal Name',
                                'Min Saldo (%)',
                                'Status Email',
                                'From',
                                'To',
                                'Current Saldo (%)',
                                'Action');

    foreach ($terms as $term) 
    {
      $cell_actions = '<button class="btn btn-primary btn-sm" onclick="get_data_parameterize(this.value,'."'".$term->terminal_id."'".','."'".$term->terminal_name."'".')"><i class="zmdi zmdi-edit"></i></button>
                      <button class="btn btn-danger btn-sm" onclick="delete_terminal_parameterize(this.value,'."'".$term->terminal_id."'".','."'".$term->terminal_name."'".')"><i class="zmdi zmdi-delete"></i></button>';
      $this->table->add_row($term->terminal_id, 
                            $term->terminal_name,
                            $term->percentage,
                            $term->sent_mail,
                            $term->from_date,
                            $term->to_date,
                            $term->current_percentage,
                            $cell_actions
    );  

    }

    $data['table_parameterize_saldo'] = $this->table->generate();

    $this->load->view('template', $data);
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
                $_FILES['file_xlsx[]']['name']= $files['name'][$key];
                $_FILES['file_xlsx[]']['type']= $files['type'][$key];
                $_FILES['file_xlsx[]']['tmp_name']= $files['tmp_name'][$key];
                $_FILES['file_xlsx[]']['error']= $files['error'][$key];
                $_FILES['file_xlsx[]']['size']= $files['size'][$key];
    
                $fileName = $title .'_'. $image;
    
                $images[] = $fileName;
    
                $config['file_name'] = $fileName;

                // $file_name_tmp = $_FILES['file_xlsx[]']['tmp_name'];
    
                $this->upload->initialize($config);
    
                if ($this->upload->do_upload('file_xlsx[]')) {
                    // $this->upload->data();
                    $upload_data = $this->upload->data();
                    $file_name_tmp = $upload_data['file_name'];
                    
                    $this->read_excel_file($file_name_tmp);
                    $success_json[]=$fileName;
                } else {
                    $failed_json[]=$fileName.$this->upload->display_errors();
                }
            }
        }       

        
        $result_json = array(
            'success_get'=>$success_json,
            'failed_get'=>$failed_json
        );

        echo json_encode($result_json);
        //return $images;
    }

    function read_excel_file($file_name){
        // $file_name = "dumy data.xlsx";
        $spreadsheet = new Spreadsheet();

        $inputFileName = './uploads/'.$file_name;
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadsheet = $reader->load($inputFileName);
        $d=$spreadsheet->getSheet(0)->toArray();

        echo count($d)." <br>";
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        $i=1;
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

}
