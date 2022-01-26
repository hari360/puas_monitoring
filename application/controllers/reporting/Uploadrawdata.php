<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Uploadrawdata extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('reporting/uploadrawdata_model', 'upload_model', TRUE);
    }

    function get_table_register_interchange()
    {
        $terms = $this->Ptpr_model->get_data_interchange();

        $tmpl = array(
            'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_register_interchange" width="100%">',
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
            'FI Number',
            'Interchange',
            'Source Node',
            'Sink Node',
            'Bank Code',
            'Total Group',
            'Bussiness Entity Name',
            'Actions'
        );

        foreach ($terms as $term) {

            $cell_actions = '<button class="btn btn-primary btn-sm edit-interchange-bank"><i class="zmdi zmdi-edit"></i></button>
          <button class="btn btn-danger btn-sm" onclick="modal_delete_list_interchange(this.value,' . "'" . $term->fi_number . "'" . ',' . "'" . $term->interchange . "'" . ')"><i class="zmdi zmdi-delete"></i></button>';


            $this->table->add_row(
                $term->fi_number,
                $term->interchange,
                $term->source_node,
                $term->sink_node,
                $term->cbc,
                $term->totals_group,
                $term->business_entity_name,
                $cell_actions
            );
        }
    }

    function index()
    {
        // $month = 'Jan';
        // echo date('m', strtotime($month));

        // echo substr("22 Jan 2022 17:40:15",12,8)."<br>";
        // echo substr("22 Jan 2022 17:40:15",0,2)."<br>";
        // echo substr("22 Jan 2022 17:40:15",3,3)."<br>";
        // echo substr("22 Jan 2022 17:40:15",7,4)."<br>";
        // die();
//         $file_name = "Test";
//         if(strpos($file_name, 'Deposit')){
// echo "true";
//         }else{
//             echo "false";
//         }
//         die();
        $data = array(
            'title'               => 'Upload Raw Data',
            'header_view'         => 'header_view',
            'content_view'        => 'report/uploadraw',
            'sub_header_title'    => 'Upload Raw Data',
            'parent_menu'         => 'Reporting > Upload Raw Data',
            'header_title'        => 'Upload Raw Data',
            'username'            => $this->session->userdata('logged_full_name'),
            'lastlogin'           => $this->session->userdata('logged_last_login'),
        );

        $this->load->view('template', $data);
    }

    function upload_xlsx_files()
    {
        $config = array(
            'upload_path'   => './upload_files',
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

                $this->upload->initialize($config);

                if ($this->upload->do_upload('file_xlsx[]')) {
                    $upload_data =  $this->upload->data();
                    $file_name = $upload_data['file_name'];

                    $this->read_excel_file($file_name);


                    // $data = array(
                    //     'iso_batch_file_name'      => $file_name,
                    //     'iso_batch_upload_user'    => $this->session->userdata('logged_user_name'),
                    //     'iso_batch_upload_date'    => date("Y-m-d H:i:s"),
                    //     'iso_batch_status'         => 'uploaded',
                    //     'iso_batch_status_note'    => 'file is being process'
                    // );


                    // $this->Atmregistration_model->insert_from_csv($data);

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
    }

    function get_data_history_upload()
    {
        header('Content-Type: application/json');
        $draw = intval($this->input->get("draw"));

        $query = $this->Atmregistration_model->get_data_history_upload();
        $no = 1;
        $data = [];
        foreach ($query as $r) {
            $data[] = array(
                $r->iso_batch_upload_user,
                $r->iso_batch_upload_date,
                $r->iso_batch_status,
                $r->iso_batch_status_note,
                $r->iso_batch_file_name,
            );
        }
        $result = array(
            "draw" => $draw,
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    function read_excel_file($file_name)
    {
        // $file_name = "dumy data.xlsx";
        $spreadsheet = new Spreadsheet();

        $inputFileName = './upload_files/' . $file_name;
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadsheet = $reader->load($inputFileName);
        $d = $spreadsheet->getSheet(0)->toArray();

        // echo count($d) . " <br>";
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
        $i = 1;
        unset($sheetData[0]);

        $now = DateTime::createFromFormat('U.u', number_format(microtime(true), 3, '.', ''));
        $local = $now->setTimeZone(new DateTimeZone('Asia/Jakarta'));
        $data = array();
        $i = 0;
        

        // print_r($data);
        if(strpos($file_name, 'Deposit')){
            foreach ($sheetData as $t) {
                // echo $i."---".$t[0]."-".$t[1]."-".$t[2]." <br>";
                $i++;
                if($t[1] != '' && $i > 2 ){
                    $data[] = array(
                        'file_name'     => $file_name,
                        'kode'          => $t[1],
                        'agent'         => $t[2],
                        'jenis'         => $t[3],
                        'nominal'       => $t[4],
                        'admin_fee'     => $t[5],
                        'total_price'   => $t[6],
                        'status'        => $t[7],
                        'date_time'     => $t[8],
                        'date_insert'   => date('Y-m-d H:i:s')
                    );
                }
                
            }

            $this->upload_model->insert_from_excel_deposit($data);
        }elseif(strpos($file_name, 'PPOB')){

            foreach ($sheetData as $t) {
                // echo $i."---".$t[0]."-".$t[1]."-".$t[2]." <br>";
                $i++;
                if($t[1] != '' && $i > 3 ){
                    // echo substr("22 Jan 2022 17:40:15",12,8)."<br>";
        // echo substr("22 Jan 2022 17:40:15",0,2)."<br>";
        // echo substr("22 Jan 2022 17:40:15",3,3)."<br>";
        // echo substr("22 Jan 2022 17:40:15",7,4)."<br>";
                    $year = substr($t[1],7,4);
                    $number_month = substr($t[1],3,3);
                    $day = substr($t[1],0,2);
                    $waktu = substr($t[1],12,8);

                    // $tanggal = substr($t[1],7,4).'-'.date('m', strtotime($number_month)).'-'.substr($t[1],2).' '.substr($t[1],12,8);
                    $tanggal = $year.'-'.date('m', strtotime($number_month)).'-'.$day.' '.$waktu;
                    $data[] = array(
                        'file_name'         => $file_name,
                        'tanggal'           => $tanggal,
                        'kode'              => $t[2],
                        'agent'             => $t[3],
                        'pelanggan'         => $t[4],
                        'type'              => $t[5],
                        'nominal_loket'     => trim(str_replace(".","",$t[6])),
                        'price_loket'       => trim(str_replace(".","",$t[7])),
                        'admin_fee_loket'   => trim(str_replace(".","",$t[8])),
                        'diskon'            => trim(str_replace(".","",$t[9])),
                        'total_price'       => trim(str_replace(".","",str_replace(".00","",$t[10]))),
                        'price_mp'          => trim(str_replace(",","",str_replace(".00","",$t[11]))),
                        // 'price_mp'          => trim(str_replace(".","",$t[11])),
                        'selling_price_mp'  => trim(str_replace(".","",($t[12]=="" ? "0" : $t[12]))),
                        'admin_fee_mp'      => trim(str_replace(".","",($t[12]=="" ? "0" : $t[13]))),
                        'status'            => $t[14],
                        // 'total_price'
                        // 'date_insert'   => date('Y-m-d H:i:s')
                    );
                }
                
            }

            $this->upload_model->insert_from_excel_ppob($data);
        }elseif(strpos($file_name, 'Setor')){

            foreach ($sheetData as $t) {
                // echo $i."---".$t[0]."-".$t[1]."-".$t[2]." <br>";
                $i++;
                if($t[1] != '' && $i > 3 ){
                    // echo substr("22 Jan 2022 17:40:15",12,8)."<br>";
        // echo substr("22 Jan 2022 17:40:15",0,2)."<br>";
        // echo substr("22 Jan 2022 17:40:15",3,3)."<br>";
        // echo substr("22 Jan 2022 17:40:15",7,4)."<br>";
                    $year = substr($t[1],7,4);
                    $number_month = substr($t[1],3,3);
                    $day = substr($t[1],0,2);
                    $waktu = substr($t[1],12,8);

                    // $tanggal = substr($t[1],7,4).'-'.date('m', strtotime($number_month)).'-'.substr($t[1],2).' '.substr($t[1],12,8);
                    $tanggal = $year.'-'.date('m', strtotime($number_month)).'-'.$day.' '.$waktu;
                    $data[] = array(
                        
                        'tanggal'            => $tanggal,
                        'kode'               => $t[2],
                        'agent'              => $t[3],
                        'bank_penerima'      => $t[4],
                        'rek_penerima'       => $t[5],
                        'nama_penerima'      => $t[6],
                        'nominal_hijrah'     => trim(str_replace(".","",$t[7])),
                        'admin_fee_hijrah'   => trim(str_replace(".","",$t[8])),
                        'total_price_hijrah' => trim(str_replace(".","",$t[9])),
                        'status_hijrah'      => $t[10],
                        'transfer_oy'        => $t[11],
                        'admin_fee_oy'       => $t[12],
                        'amount_oy'          => $t[13],
                        'file_name'          => $file_name,
                        'date_insert'        => date('Y-m-d H:i:s')
                        // 'total_price'
                        // 'date_insert'   => date('Y-m-d H:i:s')
                    );
                }
                
            }

            $this->upload_model->insert_from_excel_setor_tarik($data);
        }elseif(strpos($file_name, 'Transfer')){

            foreach ($sheetData as $t) {
                // echo $i."---".$t[0]."-".$t[1]."-".$t[2]." <br>";
                $i++;
                if($t[1] != '' && $i > 3 ){
                    // echo substr("22 Jan 2022 17:40:15",12,8)."<br>";
        // echo substr("22 Jan 2022 17:40:15",0,2)."<br>";
        // echo substr("22 Jan 2022 17:40:15",3,3)."<br>";
        // echo substr("22 Jan 2022 17:40:15",7,4)."<br>";
                    $year = substr($t[1],7,4);
                    $number_month = substr($t[1],3,3);
                    $day = substr($t[1],0,2);
                    $waktu = substr($t[1],12,8);

                    // $tanggal = substr($t[1],7,4).'-'.date('m', strtotime($number_month)).'-'.substr($t[1],2).' '.substr($t[1],12,8);
                    $tanggal = $year.'-'.date('m', strtotime($number_month)).'-'.$day.' '.$waktu;
                    $data[] = array(
                        
                        'tanggal'            => $tanggal,
                        'kode'               => $t[2],
                        'agent'              => $t[3],
                        'bank_penerima'      => $t[4],
                        'rek_penerima'       => $t[5],
                        'nama_penerima'      => $t[6],
                        'nominal_hijrah'     => trim(str_replace(".","",$t[7])),
                        'admin_fee_hijrah'   => trim(str_replace(".","",$t[8])),
                        'total_price_hijrah' => trim(str_replace(".","",$t[9])),
                        'status_hijrah'      => $t[10],
                        'transfer_oy'        => $t[11],
                        'admin_fee_oy'       => $t[12],
                        'amount_oy'          => $t[13],
                        'file_name'          => $file_name,
                        'date_insert'        => date('Y-m-d H:i:s')
                        // 'total_price'
                        // 'date_insert'   => date('Y-m-d H:i:s')
                    );
                }
                
            }

            $this->upload_model->insert_from_excel_transfer($data);
        }
        
    }

    function get_data_transaksi_deposit()
    {
        header('Content-Type: application/json');
        $draw = intval($this->input->get("draw"));

        $query = $this->upload_model->get_data_trx_deposit();
        $no = 1;
        $data = [];
        foreach ($query as $r) {
            $data[] = array(
                $r->kode,
                $r->agent,
                $r->jenis,
                number_format($r->nominal),
                number_format($r->admin_fee),
                number_format($r->total_price),
                $r->status,
                $r->date_time,
                $r->date_insert,
                $r->file_name,
            );
        }
        $result = array(
            "draw" => $draw,
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    function get_data_transaksi_ppob()
    {
        header('Content-Type: application/json');
        $draw = intval($this->input->get("draw"));

        $query = $this->upload_model->get_data_trx_ppob();
        $no = 1;
        $data = [];
        foreach ($query as $r) {
            $data[] = array(
                $r->tanggal,
                $r->kode,
                $r->agent,
                $r->pelanggan,
                $r->type,
                number_format($r->nominal_loket),
                number_format($r->price_loket),
                number_format($r->admin_fee_loket),
                number_format($r->diskon),
                number_format($r->total_price),
                number_format($r->price_mp),
                number_format($r->selling_price_mp),
                number_format($r->admin_fee_mp),
                $r->status,
                // $r->file_name,
            );
        }
        $result = array(
            "draw" => $draw,
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    function get_data_transaksi_setor_tarik()
    {
        header('Content-Type: application/json');
        $draw = intval($this->input->get("draw"));

        $query = $this->upload_model->get_data_trx_setor_tarik();
        $no = 1;
        $data = [];
        foreach ($query as $r) {
            $data[] = array(
                $r->tanggal,
                $r->kode,
                $r->agent,
                $r->bank_penerima,
                $r->rek_penerima,
                $r->nama_penerima,
                number_format($r->nominal_hijrah),
                number_format($r->admin_fee_hijrah),
                number_format($r->total_price_hijrah),
                $r->status_hijrah,
                number_format($r->transfer_oy),
                number_format($r->admin_fee_oy),
                number_format($r->amount_oy),
                // number_format($r->admin_fee_mp),
                // $r->status,
            );
        }
        $result = array(
            "draw" => $draw,
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    function get_data_transaksi_transfer()
    {
        header('Content-Type: application/json');
        $draw = intval($this->input->get("draw"));

        $query = $this->upload_model->get_data_trx_transfer();
        $no = 1;
        $data = [];
        foreach ($query as $r) {
            $data[] = array(
                $r->tanggal,
                $r->kode,
                $r->agent,
                $r->bank_penerima,
                $r->rek_penerima,
                $r->nama_penerima,
                number_format($r->nominal_hijrah),
                number_format($r->admin_fee_hijrah),
                number_format($r->total_price_hijrah),
                $r->status_hijrah,
                number_format($r->transfer_oy),
                number_format($r->admin_fee_oy),
                number_format($r->amount_oy),
            );
        }
        $result = array(
            "draw" => $draw,
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }
}
