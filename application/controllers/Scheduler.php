<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Mpdf\Mpdf;

// $selected_term = '';

class Scheduler extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Postilion_model', '', TRUE);
        $this->load->model('Reporting_model', '', TRUE);
        $this->load->model('Log_model', '', TRUE);
        $this->load->library('csvparser');
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
    }


    function get_table_log()
    {
        $terms = $this->Log_model->get_terminal_crm();

        $tmpl = array(
            'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_terminal_log_crm" width="100%">',
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
            'ATM ID',
            'Terminal Name'
        );

        foreach ($terms as $term) {

            $cell_extends = array('class' => 'details-control', 'title' => $term->short_name);

            $this->table->add_row(
                $cell_extends,
                $term->id,
                $term->short_name
            );
        }
    }

    function index()
    {
        $data = array(
            'title'               => 'Report ISO',
            'header_view'         => 'header_view',
            'content_view'        => 'report/reportiso',
            'sub_header_title'    => 'Report Tools',
            'header_title'        => 'ISO REPORTING',
            'username'            => $this->session->userdata('logged_full_name'),
            'lastlogin'           => $this->session->userdata('logged_last_login'),
        );


        $this->load->view('template', $data);
    }

    public function upload_files($id_upload)
    {
        $config = array(
            'upload_path'   => './uploads',
            'allowed_types' => 'csv',
        );

        $this->load->library('upload', $config);

        $images = array();
        $success_json = array();
        $failed_json = array();

        if (!empty($_FILES['file_csv']['name'][0])) {
            $files = $_FILES['file_csv'];
            $title = "";

            foreach ($files['name'] as $key => $image) {
                $_FILES['file_csv[]']['name'] = $files['name'][$key];
                $_FILES['file_csv[]']['type'] = $files['type'][$key];
                $_FILES['file_csv[]']['tmp_name'] = $files['tmp_name'][$key];
                $_FILES['file_csv[]']['error'] = $files['error'][$key];
                $_FILES['file_csv[]']['size'] = $files['size'][$key];

                $fileName = $title . '_' . $image;

                $images[] = $fileName;

                $config['file_name'] = $fileName;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('file_csv[]')) {
                    $this->upload->data();

                    $result =   $this->csvparser->parse_file($_FILES['file_csv[]']['tmp_name']);
                    // var_dump($result);
                    // die();
                    // $data['csvData'] =  $result;

                    // $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
                    // foreach($file_data as $row)
                    // {
                    // $data[] = array(
                    //     'first_name' => $row["First Name"],
                    //         'last_name'  => $row["Last Name"],
                    //         'phone'   => $row["Phone"],
                    //         'email'   => $row["Email"]
                    // );
                    // }
                    // $this->csv_import_model->insert($data);
                    $now = DateTime::createFromFormat('U.u', number_format(microtime(true), 3, '.', ''));
                    $local = $now->setTimeZone(new DateTimeZone('Asia/Jakarta'));
                    $data = array();
                    foreach ($result as $row) {
                        $data[] = array(
                            'id_upload'             => $id_upload,
                            'terminal_id'           => $row["terminal_id"],
                            'terminal_name'         => $row["terminal_name"],
                            'terminal_city'         => $row["terminal_city"],
                            'location'              => $row["location"],
                            'user_create'           => $this->session->userdata('logged_user_name'),
                            // 'date_insert'           => date("Y-m-d H:i:s"),
                            'date_insert'           => substr($local->format("Y-m-d H:i:s.u"), 0, 23),
                            'upload_file'           => $fileName,
                            'upload_status'         => 'submitted'
                        );
                    }

                    // $this->Postilion_model->insert_from_csv($data);
                    $success_json[] = $fileName;
                } else {
                    $failed_json[] = $fileName . $this->upload->display_errors();
                    // var_dump($failed_json);
                    //die($this->upload->display_errors());
                    // return false;
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

    // public function get_status_uplaod(){

    //     $this->csv_import_model->insert($data);
    //     echo json_encode($result_json);
    // }

    public function ajax_get_data_upload()
    {
        // $draw = intval($this->input->get("draw"));
        // $start = intval($this->input->get("start"));
        // $length = intval($this->input->get("length"));

        // $data = $this->Postilion_model->get_faulty_term_temp();
        header('Content-Type: application/json');
        // echo json_encode($data);



        $id_upload = $this->input->get('extra_search');
        $draw = intval($this->input->get("draw"));
        // $start = intval($this->input->get("start"));
        // $length = intval($this->input->get("length"));


        $query = $this->Postilion_model->get_data_upload($id_upload);


        $data = [];


        foreach ($query as $r) {
            $data[] = array(
                $r->terminal_id,
                $r->terminal_name,
                $r->terminal_city,
                $r->location,
                $r->date_insert,
                $r->upload_status,
                $r->user_create,
                $r->upload_file
            );
        }

        $result = array(
            "draw" => $draw,
            //"recordsTotal" => $query->num_rows(),
            //"recordsFiltered" => $query->num_rows(),
            "data" => $data
        );


        echo json_encode($result);
        exit();
    }

    // function test_pdf(){
    //     $this->load->view('pdf/html_to_pdf');
    // }

    

    function csv()
    {
        // create new directory
        // mkdir("./files/test 123");
        // $data = 'My Text here';

        // if (!write_file('./files/file.csv', $data)) {
        //     echo 'Unable to write the file';
        // }

        // $data_array = array (
        //     array ('1','2'),
        //     array ('2','2'),
        //     array ('3','6'),
        //     array ('4','2'),
        //     array ('6','5')
        // );

        $filename = "detail_batch_";
        $csv_filename = $filename . "_" . date("Y-m-d_H-i", time()) . ".csv";
        $fd = fopen("./files/" . $csv_filename, "w");

        // $csv = "col1|col2 \n";//Column headers
        // foreach ($data_array as $record){
        //     $csv.= $record[0].'|'.$record[1]."\n"; //Append data to csv
        // }

        // file_put_contents("./files/".$csv_filename, $csv);

        // fclose($fd);

        $data_report = $this->Reporting_model->print_report();

        // foreach ($data_report as $data_report_iso) {
        foreach ($data_report as $key => $line) {
            //fputcsv($fd, $line);
            fwrite($fd, implode("|", $line) . "\r\n");
        }

        fclose($fd);
    }

    function excel_vault($bsn_date)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle("PT. Alto Network");;
        $sheet->setCellValue('A1', 'PT. Alto Network');
        $styleArray = array(
            'font' => array(
                'bold' => true
            )
        );
        $sheet->getStyle('A1')->applyFromArray($styleArray);

        $sheet->setCellValue('A2', 'Satrio Tower Office Building Lt. 12');
        $sheet->setCellValue('A3', 'Jl. Prof. DR. Satrio,Jakarta Selatan 12950');
        $sheet->setCellValue('E1', 'Tanggal : ' . date("d M Y"));

        $sheet->setCellValue('A5', 'Kepada');
        $sheet->setCellValue('A6', 'Up');
        $sheet->setCellValue('A7', 'Fax No');

        $sheet->setCellValue('B5', ': Lippobank Cabang Kuningan LippoLife');
        $sheet->setCellValue('B6', ': Kabag Operasi');
        $sheet->setCellValue('B7', ': 2525070-71');

        $sheet->setCellValue('A9', 'Dengan ini kami kirimkan Laporan Settlement Fee Acquire dari PT. Alto Network');
        $sheet->setCellValue('A10', 'Mohon debet rekening kami A/C No. 228-80-00382 dan kredit rekening-rekening di bawah ini :');

        // $styleArray = [
        //     'borders' => [
        //         'getAllBorders' => [
        //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
        //             'color' => ['argb' => 'FF000000S'],
        //         ],
        //     ],
        // ];

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A12:E14')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)
            ->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF000000S'));

        //$sheet->getStyle('A12:E14')->applyFromArray($styleArray);



        // $settlement_amount = $this->Reporting_model->vault_settlement_xlsx($bsn_date);
        $settlement_amount = $this->Reporting_model->vault_settlement_xlsx($bsn_date)->jumlah;
        $amount = (float)$settlement_amount;
        $caption = terbilang($amount);

        $sheet->setCellValue('A12', 'No');
        $sheet->setCellValue('B12', 'No. Rekening');
        $sheet->setCellValue('C12', 'Pemilik Rekening');
        $sheet->setCellValue('D12', 'Jumlah');
        $sheet->setCellValue('E12', 'Keterangan');

        $sheet->setCellValue('A13', '1');
        $sheet->setCellValue('B13', 'BII KCP PURI KENCANA 2288004002');

        $sheet->setCellValue('C13', 'Pt Abadi Tambah Mulia Internasional');
        $sheet->setCellValue('D13', $amount);
        $spreadsheet->getActiveSheet()->getStyle('D13')->getNumberFormat()->setFormatCode('#,##0');
        $sheet->setCellValue('E13', 'Settlement_BTNPen');

        $styleArray = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];



        $sheet->getStyle('A13:E13')->applyFromArray($styleArray);


        $sheet->setCellValue('A14', '');
        $sheet->setCellValue('B14', '');
        $sheet->setCellValue('C14', 'Total');
        $sheet->setCellValue('D14', $amount);
        $spreadsheet->getActiveSheet()->getStyle('D14')->getNumberFormat()->setFormatCode('#,##0');
        $sheet->setCellValue('E14', '');

        $sheet->setCellValue('A15', 'Terbilang : (' . $caption . ' Rupiah# )');

        $sheet->setCellValue('A17', 'Hormat Kami');
        $sheet->setCellValue('A21', 'Ratna Sari Dewi');

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(24);
        $sheet->getStyle("B13")->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        //$sheet->getColumnDimension('D')->setWidth(17);
        $sheet->getColumnDimension('E')->setAutoSize(true);

        $sheet->getStyle('A12:E13')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('D13')->getAlignment()->setHorizontal('right');

        $writer = new Xlsx($spreadsheet);
        ob_end_clean();



        $filename = 'vaultsettlement-atmi-' . $bsn_date;

        //download file
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // header("Location: http://localhost:81/new_web_monitoring_atmi/reporting/iso");
        //$writer->save('php://output');

        $v_dir = 'E:\\Temporary\\Report ISO\\' . $bsn_date;
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $filename = $v_dir . '\\' . $filename . '.xlsx';
        $writer->save($filename);
        die('Output has been created at '.$filename);
        //$this->session->set_flashdata('messagegeneratereport', "Generate vaultsettlement has been successfully");
        //redirect('/reporting/iso');

        // save local server
        // $filename = './files/vaultsettlement'.$bsn_date.'.xlsx';
        // $writer->save($filename);

        // redirect('/reporting/iso');

    }

    function excel_fee($bsn_date)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle("PT. Alto Network");;
        $sheet->setCellValue('A1', 'PT. Alto Network');
        $styleArray = array(
            'font' => array(
                'bold' => true
            )
        );
        $sheet->getStyle('A1')->applyFromArray($styleArray);

        $sheet->setCellValue('A2', 'Satrio Tower Office Building Lt. 12');
        $sheet->setCellValue('A3', 'Jl. Prof. DR. Satrio,Jakarta Selatan 12950');
        $sheet->setCellValue('E1', 'Tanggal : ' . date("d M Y"));

        $sheet->setCellValue('A5', 'Kepada');
        $sheet->setCellValue('A6', 'Up');
        $sheet->setCellValue('A7', 'Fax No');

        $sheet->setCellValue('B5', ': ATMI');
        $sheet->setCellValue('B6', ': PT. Abadi Tambah Mulia International');
        $sheet->setCellValue('B7', ': 2953-3277');

        $sheet->setCellValue('A9', 'Dengan ini kami kirimkan Laporan Settlement Fee Acquire dari PT. Alto Network');
        $sheet->setCellValue('A10', 'Mohon debet rekening kami A/C No. 228-80-00382 dan kredit rekening-rekening di bawah ini :');

        // $styleArray = [
        //     'borders' => [
        //         'getAllBorders' => [
        //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
        //             'color' => ['argb' => 'FF000000S'],
        //         ],
        //     ],
        // ];

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A12:E14')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)
            ->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF000000S'));

        //$sheet->getStyle('A12:E14')->applyFromArray($styleArray);



        // $settlement_amount = $this->Reporting_model->vault_settlement_xlsx($bsn_date);
        $settlement_amount = $this->Reporting_model->fee_settlement_xlsx($bsn_date)->jumlah;
        $amount = (float)$settlement_amount;
        $caption = terbilang($amount);

        $sheet->setCellValue('A12', 'No');
        $sheet->setCellValue('B12', 'No. Rekening');
        $sheet->setCellValue('C12', 'Pemilik Rekening');
        $sheet->setCellValue('D12', 'Jumlah');
        $sheet->setCellValue('E12', 'Keterangan');

        $sheet->setCellValue('A13', '1');
        $sheet->setCellValue('B13', 'BII KCP PURI KENCANA 2288004002');

        $sheet->setCellValue('C13', 'Pt Abadi Tambah Mulia Internasional');
        $sheet->setCellValue('D13', $amount);
        $spreadsheet->getActiveSheet()->getStyle('D13')->getNumberFormat()->setFormatCode('#,##0');
        $sheet->setCellValue('E13', 'Settlement FEE_Acquire_ATMi');

        $styleArray = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];



        $sheet->getStyle('A13:E13')->applyFromArray($styleArray);


        $sheet->setCellValue('A14', '');
        $sheet->setCellValue('B14', '');
        $sheet->setCellValue('C14', 'Total');
        $sheet->setCellValue('D14', $amount);
        $spreadsheet->getActiveSheet()->getStyle('D14')->getNumberFormat()->setFormatCode('#,##0');
        $sheet->setCellValue('E14', '');

        $sheet->setCellValue('A15', 'Terbilang : (' . $caption . ' Rupiah# )');

        $sheet->setCellValue('A17', 'Hormat Kami');
        $sheet->setCellValue('A21', 'Ratna Sari Dewi');

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(24);
        $sheet->getStyle("B13")->getAlignment()->setWrapText(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        //$sheet->getColumnDimension('D')->setWidth(17);
        $sheet->getColumnDimension('E')->setAutoSize(true);

        $sheet->getStyle('A12:E13')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('D13')->getAlignment()->setHorizontal('right');

        $writer = new Xlsx($spreadsheet);
        ob_end_clean();



        $filename = 'atmi-fee-' . $bsn_date;

        //download file
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // header("Location: http://localhost:81/new_web_monitoring_atmi/reporting/iso");
        //$writer->save('php://output');

        $v_dir = 'E:\\Temporary\\Report ISO\\' . $bsn_date;
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $filename = $v_dir . '\\' . $filename . '.xlsx';
        $writer->save($filename);
        $this->session->set_flashdata('messagegeneratereport', "Generate fee settlement has been successfully");
        redirect('/reporting/iso');

        // save local server
        // $filename = './files/vaultsettlement'.$bsn_date.'.xlsx';
        // $writer->save($filename);

        // redirect('/reporting/iso');

    }

    function excel()
    {
        // ini_set('max_execution_time', 0);
        // ini_set('memory_limit', '-1');
        //die('test');
        // $this->load->model('siswa_model');
        // die($bsn_date);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle("Title");;
        $sheet->setCellValue('A2', 'PT. Alto Network');
        $sheet->setCellValue('A3', 'Transaction Type : All');
        $sheet->setCellValue('A4', 'Report Activity (Batch 2333)');

        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000S'],
                ],
            ],
        ];

        $sheet->getStyle('A6:N6')->applyFromArray($styleArray);

        $formatcell = sprintf("A%s:N%s", 6, 6);
        //$spreadsheet->getActiveSheet()->getStyle($formatcell)->getFont()->setName('Arial');
        //$spreadsheet->getActiveSheet()->getStyle($formatcell)->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->freezePane('A7');

        $sheet->setCellValue('A6', 'Seq. Number');
        $sheet->setCellValue('B6', 'Terminal ID');
        $sheet->setCellValue('C6', 'PAN');
        $sheet->setCellValue('D6', 'Issuer');
        $sheet->setCellValue('E6', 'Beneficiary');
        $sheet->setCellValue('F6', 'Date');
        $sheet->setCellValue('G6', 'Time');
        $sheet->setCellValue('H6', 'Type Trans');
        $sheet->setCellValue('I6', 'Amount Req');
        $sheet->setCellValue('J6', 'Amount Rsp');
        $sheet->setCellValue('K6', 'Tran Fee');
        $sheet->setCellValue('L6', 'Proc Fee');
        $sheet->setCellValue('M6', 'Routing');
        $sheet->setCellValue('N6', 'Description');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);

        $row_sum_amount_rsp = 0;
        $amount_request = 0;
        $no = 1;
        $row = 8;
        $data_report = $this->Reporting_model->detail_report_xlsx(
            $this->session->userdata('bsn_date'),
            'approved',
            $this->session->userdata('terminal_id'),
            $this->session->userdata('tran_type'),
            $this->session->userdata('from_date_time'),
            $this->session->userdata('to_date_time')
        )->result();
        $record_count = $this->Reporting_model->detail_report_xlsx(
            $this->session->userdata('bsn_date'),
            'approved',
            $this->session->userdata('terminal_id'),
            $this->session->userdata('tran_type'),
            $this->session->userdata('from_date_time'),
            $this->session->userdata('to_date_time')
        )->num_rows();

        foreach ($data_report as $data_report_iso) {
            if ($data_report_iso->row_num == 1) {
                if ($no == 1) {
                    $sheet->setCellValue('A' . $row, $data_report_iso->terminal_name);
                    $row = $row + 1;
                    $row_sum_amount_rsp = 0;
                } else {
                    $sheet->setCellValue('A' . $row, 'Sub Total');

                    // $sintaxamountreq = sprintf("= SUM(I%s:I%s)", $row+1, $row-1);
                    // $sheet->setCellValue('I'.$row, $sintaxamountreq);

                    $sheet->setCellValue('I' . $row, $amount_request);
                    $spreadsheet->getActiveSheet()->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0');

                    $sintaxamountrsp = sprintf("= SUM(J%s:J%s)", $row_sum_amount_rsp, $row - 1);
                    $sheet->setCellValue('J' . $row, $sintaxamountrsp);
                    $spreadsheet->getActiveSheet()->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');

                    $sintaxamountrsp = sprintf("= SUM(K%s:K%s)", $row_sum_amount_rsp, $row - 1);
                    $sheet->setCellValue('K' . $row, $sintaxamountrsp);
                    $spreadsheet->getActiveSheet()->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');

                    $sintaxamountrsp = sprintf("= SUM(L%s:L%s)", $row_sum_amount_rsp, $row - 1);
                    $sheet->setCellValue('L' . $row, $sintaxamountrsp);
                    $spreadsheet->getActiveSheet()->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');

                    // $sheet->setCellValue('J'.$row, 'Sub Total');
                    // $sheet->setCellValue('K'.$row, 'Sub Total');
                    // $sheet->setCellValue('L'.$row, 'Sub Total');
                    $row = $row + 2;
                    $sheet->setCellValue('A' . $row, $data_report_iso->terminal_name);
                    $row = $row + 1;
                    $row_sum_amount_rsp = 0;
                }
            }

            if ($row_sum_amount_rsp == 0) {
                $row_sum_amount_rsp = $row;
            }

            // $row_sum_amount_rsp++;
            $no++;
            $sheet->setCellValueExplicit('A' . $row, $data_report_iso->system_trace_audit_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('B' . $row, $data_report_iso->terminal_id);
            $sheet->setCellValue('C' . $row, $data_report_iso->pan);
            $sheet->setCellValue('D' . $row, $data_report_iso->issuer_name);
            $sheet->setCellValue('E' . $row, $data_report_iso->benef_name);
            $sheet->setCellValue('F' . $row, $data_report_iso->tgl);
            $sheet->setCellValue('G' . $row, $data_report_iso->waktu);
            $sheet->setCellValue('H' . $row, $data_report_iso->tran_type_name);
            $sheet->setCellValue('I' . $row, $data_report_iso->amount_req);
            $spreadsheet->getActiveSheet()->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('J' . $row, $data_report_iso->amount_rsp);
            $spreadsheet->getActiveSheet()->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('K' . $row, $data_report_iso->tran_fee);
            $spreadsheet->getActiveSheet()->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('L' . $row, $data_report_iso->proc_fee);
            $spreadsheet->getActiveSheet()->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('M' . $row, $data_report_iso->routing);
            $sheet->setCellValue('N' . $row, '-');
            $amount_request = $data_report_iso->jml_amount_req;
            $row++;
            // $row_sum_amount_rsp++;



            if (($no - 1) == $record_count) {
                $sheet->setCellValue('A' . $row, 'Sub Total');

                // $sintaxamountreq = sprintf("= SUM(I%s:I%s)", $row+1, $row-1);
                // $sheet->setCellValue('I'.$row, $sintaxamountreq);

                $sheet->setCellValue('I' . $row, $amount_request);
                $spreadsheet->getActiveSheet()->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0');

                $sintaxamountrsp = sprintf("= SUM(J%s:J%s)", $row_sum_amount_rsp, $row - 1);
                $sheet->setCellValue('J' . $row, $sintaxamountrsp);
                $spreadsheet->getActiveSheet()->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');

                $sintaxamountrsp = sprintf("= SUM(K%s:K%s)", $row_sum_amount_rsp, $row - 1);
                $sheet->setCellValue('K' . $row, $sintaxamountrsp);
                $spreadsheet->getActiveSheet()->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');

                $sintaxamountrsp = sprintf("= SUM(L%s:L%s)", $row_sum_amount_rsp, $row - 1);
                $sheet->setCellValue('L' . $row, $sintaxamountrsp);
                $spreadsheet->getActiveSheet()->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');
            }
        }




        // $siswa = $this->siswa_model->getAll();
        // $no = 1;
        // $x = 2;
        // foreach($siswa as $row)
        // {
        // 	$sheet->setCellValue('A'.$x, $no++);
        // 	$sheet->setCellValue('B'.$x, $row->nama);
        // 	$sheet->setCellValue('C'.$x, $row->kelas);
        // 	$sheet->setCellValue('D'.$x, $row->jenis_kelamin);
        // 	$sheet->setCellValue('E'.$x, $row->alamat);
        // 	$x++;
        // }
        $writer = new Xlsx($spreadsheet);
        ob_end_clean();


        $filename = 'detail-batch-atmi' . $this->session->userdata('bsn_date');



        //download file
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // header("Location: http://localhost:81/new_web_monitoring_atmi/reporting/iso");
        //$writer->save('php://output');

        $v_dir = 'E:\\Temporary\\Report ISO\\' . $this->session->userdata('bsn_date');
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $filename = $v_dir . '\\' . $filename . '.xlsx';
        $writer->save($filename);
        $this->session->set_flashdata('messagegeneratereport', "Generate detail-batch has been successfully");
        redirect('/reporting/iso');

        // save local server
        //$filename = 'E:\\Temporary\\Report ISO\\'.$filename.'.xlsx';
        //$writer->save($filename);
        //$this->session->set_flashdata('messagegeneratereport', "Generate report has been successfully");
    }

    function excel_reject($bsn_date)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle("Title");;
        $sheet->setCellValue('A2', 'PT. Alto Network');
        $sheet->setCellValue('A3', 'Transaction Type : All');
        $sheet->setCellValue('A4', 'Report Reject Activity (Batch ' . $bsn_date . ')');

        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000S'],
                ],
            ],
        ];

        $sheet->getStyle('A6:K6')->applyFromArray($styleArray);

        $formatcell = sprintf("A%s:K%s", 6, 6);
        $spreadsheet->getActiveSheet()->getStyle($formatcell)->getFont()->setName('Arial');
        $spreadsheet->getActiveSheet()->getStyle($formatcell)->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->freezePane('A7');

        $sheet->setCellValue('A6', 'Seq. Number');
        $sheet->setCellValue('B6', 'Terminal ID');
        $sheet->setCellValue('C6', 'PAN');
        $sheet->setCellValue('D6', 'Terminal Name');
        $sheet->setCellValue('E6', 'Date');
        $sheet->setCellValue('F6', 'Time');
        $sheet->setCellValue('G6', 'Type Trans');
        $sheet->setCellValue('H6', 'Amount Req');
        $sheet->setCellValue('I6', 'Response Code');
        $sheet->setCellValue('J6', 'Beneficiary Name');
        $sheet->setCellValue('K6', 'Description');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(30);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);

        $row_sum_amount_rsp = 0;
        $amount_request = 0;
        $no = 1;
        $row = 8;

        $data_report = $this->Reporting_model->detail_report_reject_xlsx(
            $bsn_date,
            'rejected',
            $this->session->userdata('terminal_id'),
            $this->session->userdata('tran_type'),
            $this->session->userdata('from_date_time'),
            $this->session->userdata('to_date_time')
        )->result();

        $record_count = $this->Reporting_model->detail_report_reject_xlsx(
            $bsn_date,
            'rejected',
            $this->session->userdata('terminal_id'),
            $this->session->userdata('tran_type'),
            $this->session->userdata('from_date_time'),
            $this->session->userdata('to_date_time')
        )->num_rows();

        //$data_report = $this->Reporting_model->detail_report_reject_xlsx($bsn_date, 'rejected','')->result();
        //$record_count = $this->Reporting_model->detail_report_reject_xlsx($bsn_date, 'rejected','')->num_rows();

        foreach ($data_report as $data_report_iso) {
            if ($data_report_iso->row_num == 1) {
                if ($no == 1) {
                    $sheet->setCellValue('A' . $row, $data_report_iso->issuer_name);
                    $row = $row + 1;
                    $row_sum_amount_rsp = 0;
                } else {
                    $sheet->setCellValue('A' . $row, 'Sub Total');

                    $sheet->setCellValue('H' . $row, $amount_request);
                    $spreadsheet->getActiveSheet()->getStyle('H' . $row)->getNumberFormat()->setFormatCode('#,##0');

                    $row = $row + 2;
                    $sheet->setCellValue('A' . $row, $data_report_iso->issuer_name);
                    $row = $row + 1;
                    $row_sum_amount_rsp = 0;
                }
            }

            if ($row_sum_amount_rsp == 0) {
                $row_sum_amount_rsp = $row;
            }

            $no++;
            $sheet->setCellValueExplicit('A' . $row, $data_report_iso->system_trace_audit_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('B' . $row, $data_report_iso->terminal_id);
            $sheet->setCellValue('C' . $row, $data_report_iso->pan);
            $sheet->setCellValue('D' . $row, $data_report_iso->terminal_name);
            $sheet->setCellValue('E' . $row, $data_report_iso->tgl);
            $sheet->setCellValue('F' . $row, $data_report_iso->waktu);
            $sheet->setCellValue('G' . $row, $data_report_iso->tran_type_name);
            $sheet->setCellValue('H' . $row, $data_report_iso->amount_req);
            $spreadsheet->getActiveSheet()->getStyle('H' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('I' . $row, $data_report_iso->rsp_code_rsp . ' - ' . $data_report_iso->display_name);
            $sheet->setCellValue('J' . $row, $data_report_iso->receiving_inst_id_code . ' - ' . $data_report_iso->benef_name);
            $sheet->setCellValue('K' . $row, $data_report_iso->description);

            $amount_request = $data_report_iso->jml_amount_req;
            $row++;

            if (($no - 1) == $record_count) {
                $sheet->setCellValue('A' . $row, 'Sub Total');
                $sheet->setCellValue('H' . $row, $amount_request);
                $spreadsheet->getActiveSheet()->getStyle('H' . $row)->getNumberFormat()->setFormatCode('#,##0');
            }
        }

        $writer = new Xlsx($spreadsheet);
        ob_end_clean();

        $filename = 'detail-reject-atmi-batch' . $bsn_date;

        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // $writer->save('php://output');

        $v_dir = 'E:\\Temporary\\Report ISO\\' . $bsn_date;
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $filename = $v_dir . '\\' . $filename . '.xlsx';
        $writer->save($filename);
        $this->session->set_flashdata('messagegeneratereport', "Generate detail-batch-reject has been successfully");
        redirect('/reporting/iso');
    }

    function excel_summary($bsn_date)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle("Title");;
        $sheet->setCellValue('B2', 'PT. Alto Network');
        $sheet->setCellValue('B3', 'Transaction Type : All');
        $sheet->setCellValue('B4', 'Report Reject Activity (Batch ' . $bsn_date . ')');



        $formatcell = sprintf("A%s:J%s", 1, 7);
        $spreadsheet->getActiveSheet()->getStyle($formatcell)->getFont()->setName('Arial');
        $spreadsheet->getActiveSheet()->getStyle($formatcell)->getFont()->setSize(8);
        $spreadsheet->getActiveSheet()->freezePane('A8');

        $sheet->setCellValue('A6', 'No');
        $spreadsheet->getActiveSheet()->mergeCells('A6:A7');
        $spreadsheet->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->setCellValue('B6', 'ATM Name');
        $spreadsheet->getActiveSheet()->mergeCells('B6:B7');
        $spreadsheet->getActiveSheet()->getStyle('B6')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->setCellValue('C6', 'Withdrawal');
        $spreadsheet->getActiveSheet()->mergeCells('C6:F6');
        $spreadsheet->getActiveSheet()->getStyle('C6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('C7', 'Amount');
        $sheet->setCellValue('D7', 'Surcharge');
        $sheet->setCellValue('E7', 'TXN');
        $sheet->setCellValue('F7', 'Proc Fee');


        $sheet->setCellValue('G6', 'Inquiry');
        $spreadsheet->getActiveSheet()->mergeCells('G6:H6');
        $spreadsheet->getActiveSheet()->getStyle('G6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('G7', 'TXN');
        $sheet->setCellValue('H7', 'Proc Fee');

        $sheet->setCellValue('I6', 'Fund Transfer');
        $spreadsheet->getActiveSheet()->mergeCells('I6:J6');
        $spreadsheet->getActiveSheet()->getStyle('I6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('I7', 'TXN');
        $sheet->setCellValue('J7', 'Proc Fee');


        $spreadsheet->getActiveSheet()->getStyle('C7:J7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(26);
        $sheet->getColumnDimension('C')->setAutoSize(true);

        $no = 1;
        $row = 8;
        $data_report = $this->Reporting_model->summary_xlsx($bsn_date);

        foreach ($data_report as $data_report_iso) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $data_report_iso->terminal_name);
            $sheet->setCellValue('C' . $row, $data_report_iso->amount_wdl);
            $spreadsheet->getActiveSheet()->getStyle('C' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('D' . $row, $data_report_iso->surcharge_fee_wdl);
            $sheet->setCellValue('E' . $row, $data_report_iso->txn_wdl);
            $sheet->setCellValue('F' . $row, $data_report_iso->proc_fee_wdl);
            $spreadsheet->getActiveSheet()->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('G' . $row, $data_report_iso->txn_inq);
            $sheet->setCellValue('H' . $row, $data_report_iso->proc_fee_inq);
            $spreadsheet->getActiveSheet()->getStyle('H' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('I' . $row, $data_report_iso->txn_ibft);
            $sheet->setCellValue('J' . $row, $data_report_iso->proc_fee_ibft);
            $spreadsheet->getActiveSheet()->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');

            $no++;
            $row++;
        }

        $total_row = $row++;
        $sheet->setCellValue('A' . $total_row, 'Total');
        $spreadsheet->getActiveSheet()->mergeCells('A' . $total_row . ':B' . $total_row);
        $spreadsheet->getActiveSheet()->getStyle('A' . $total_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sintaxamountrsp = sprintf("= SUM(C%s:C%s)", 8, $total_row - 1);
        $sheet->setCellValue('C' . $total_row, $sintaxamountrsp);
        $spreadsheet->getActiveSheet()->getStyle('C' . $total_row)->getNumberFormat()->setFormatCode('#,##0');

        $sintaxamountrsp = sprintf("= SUM(D%s:D%s)", 8, $total_row - 1);
        $sheet->setCellValue('D' . $total_row, $sintaxamountrsp);
        $spreadsheet->getActiveSheet()->getStyle('D' . $total_row)->getNumberFormat()->setFormatCode('#,##0');

        $sintaxamountrsp = sprintf("= SUM(E%s:E%s)", 8, $total_row - 1);
        $sheet->setCellValue('E' . $total_row, $sintaxamountrsp);
        $spreadsheet->getActiveSheet()->getStyle('E' . $total_row)->getNumberFormat()->setFormatCode('#,##0');

        $sintaxamountrsp = sprintf("= SUM(F%s:F%s)", 8, $total_row - 1);
        $sheet->setCellValue('F' . $total_row, $sintaxamountrsp);
        $spreadsheet->getActiveSheet()->getStyle('F' . $total_row)->getNumberFormat()->setFormatCode('#,##0');

        $sintaxamountrsp = sprintf("= SUM(G%s:G%s)", 8, $total_row - 1);
        $sheet->setCellValue('G' . $total_row, $sintaxamountrsp);
        $spreadsheet->getActiveSheet()->getStyle('G' . $total_row)->getNumberFormat()->setFormatCode('#,##0');

        $sintaxamountrsp = sprintf("= SUM(H%s:H%s)", 8, $total_row - 1);
        $sheet->setCellValue('H' . $total_row, $sintaxamountrsp);
        $spreadsheet->getActiveSheet()->getStyle('H' . $total_row)->getNumberFormat()->setFormatCode('#,##0');

        $sintaxamountrsp = sprintf("= SUM(I%s:I%s)", 8, $total_row - 1);
        $sheet->setCellValue('I' . $total_row, $sintaxamountrsp);
        $spreadsheet->getActiveSheet()->getStyle('I' . $total_row)->getNumberFormat()->setFormatCode('#,##0');

        $sintaxamountrsp = sprintf("= SUM(J%s:J%s)", 8, $total_row - 1);
        $sheet->setCellValue('J' . $total_row, $sintaxamountrsp);
        $spreadsheet->getActiveSheet()->getStyle('J' . $total_row)->getNumberFormat()->setFormatCode('#,##0');


        $formatcell = sprintf("A%s:J%s", 8, $total_row);
        $spreadsheet->getActiveSheet()->getStyle($formatcell)->getFont()->setName('Arial');
        $spreadsheet->getActiveSheet()->getStyle($formatcell)->getFont()->setSize(8);

        // $styleThickBlackAllBorder = array(
        //     'borders' => array(
        //         'allborders' => array(
        //             'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        //             'color' => array('argb' => 'FF000000S'),
        //         ),
        //         'vertical' => array(
        //             'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
        //             'color' => array('argb' => 'FF000000S'),
        //         ),
        //         'outline' => array(
        //             'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
        //             'color' => array('argb' => 'FF000000S'),
        //         ),
        //     ),
        // );


        // $sheet->getStyle('A6:J' . $total_row)->applyFromArray($styleThickBlackAllBorder);

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A6:J' . $total_row)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)
            ->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FF000000S'));

        $styleArray = [
            'borders' => [
                'vertical' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => 'FF000000S'],
                ],
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['argb' => 'FF000000S'],
                ],
            ],
        ];

        $sheet->getStyle('A6:J' . $total_row)->applyFromArray($styleArray);


        $writer = new Xlsx($spreadsheet);
        ob_end_clean();

        $filename = 'summary-batch' . $bsn_date;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    function download_excel()
    {
        $vBsnDate  = $this->input->get('ajaxBsnDate');
        $response =  array(
            'op' => 'http://localhost:81/new_web_monitoring_atmi/reportiso/excel/' . $vBsnDate,
            'file' => "data:application/vnd.ms-excel;base64,"
        );

        echo json_encode($response);
        exit();
    }

    function download_report()
    {

        $data = array(
            'bsn_date'          => $this->input->post('cmb_bsn_date'),
            'tran_type'         => $this->input->post('cmb_tran_type'),
            'report_type'       => $this->input->post('output_file'),
            'report_category'   => $this->input->post('report_category'),
            'selected_terminal' => $this->input->post('terminal_spesified'),
            'from_date_time' => $this->input->post('from_date_time'),
            'to_date_time' => $this->input->post('to_date_time'),
            // 'selected_tran_type' => $this->input->post('tran_type_spesified'),
        );
        // $GLOBALS['selected_term'] = $this->input->post('terminal_spesified');

        $this->session->set_userdata('bsn_date', $data['bsn_date']);
        $this->session->set_userdata('terminal_id', $data['selected_terminal']);
        $this->session->set_userdata('tran_type', $data['tran_type']);
        $this->session->set_userdata('from_date_time', $data['from_date_time']);
        $this->session->set_userdata('to_date_time', $data['to_date_time']);

        // $test = $this->session->userdata('terminal_id');
        if ($data['report_type'] == 'xlsx' && $data['report_category'] == 'cat_detail_app') {
            redirect('reportiso/excel/');
        } elseif ($data['report_type'] == 'xlsx' && $data['report_category'] == 'cat_detail_rej') {
            redirect('reportiso/excel_reject/' . $data['bsn_date']);
        } elseif ($data['report_type'] == 'xlsx' && $data['report_category'] == 'cat_vault_sett') {
            redirect('reportiso/excel_vault/' . $data['bsn_date']);
        } elseif ($data['report_type'] == 'xlsx' && $data['report_category'] == 'cat_fee_sett') {
            redirect('reportiso/excel_fee/' . $data['bsn_date']);
        } elseif ($data['report_type'] == 'pdf' && $data['report_category'] == 'cat_vault_sett') {
            redirect('reportiso/pdf/' . $data['bsn_date']);
        } elseif ($data['report_type'] == 'pdf' && $data['report_category'] == 'cat_fee_sett') {
            redirect('reportiso/pdf_fee/' . $data['bsn_date']);
        } elseif ($data['report_type'] == 'xlsx' && $data['report_category'] == 'cat_summary') {
            redirect('reportiso/excel_summary/' . $data['bsn_date']);
        } else {
            redirect('reportiso/csv/' . $data['bsn_date']);
        }

        //$this->session->set_flashdata('messagegeneratereport', "Generate report has been successfully");

        //redirect('reporting/iso');
        // $vBsnDate  = $this->input->get('ajaxBsnDate');
        // $response =  array(
        //     'op' => 'http://localhost:81/new_web_monitoring_atmi/reportiso/excel/'.$vBsnDate,
        //     'file' => "data:application/vnd.ms-excel;base64,"
        // );

        // echo json_encode($response);
        // exit();
    }

    function pdf_fee($bsn_date)
    {
        // $mpdf = new Mpdf();
        //$mpdf = new \Mpdf\Mpdf();
        $settlement_amount = $this->Reporting_model->fee_settlement_xlsx($bsn_date)->jumlah;
        $amount = (float)$settlement_amount;
        $caption = terbilang($amount);

        $data = array(
            'sign_by'            => 'Ratna Sari Dewi',
            'amount'             => number_format($amount, 0),
            'terbilang'          => $caption,
        );
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
        // $html = $this->load->view('pdf/html_to_pdf',[],true);
        $html = $this->load->view('pdf/html_to_pdf', $data, true);
        $mpdf->WriteHTML($html);
        //$mpdf->Output(); // opens in browser
        //$mpdf->Output('Settlement Fee ACQ ATMi.pdf','D'); // it downloads the file into the user system, with give name

        // save local server
        // $mpdf->Output('files/Settlement Fee ACQ ATMi.pdf', \Mpdf\Output\Destination::FILE);
        $v_dir = 'E:\\Temporary\\Report ISO\\' . $bsn_date;
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $output = $v_dir . '\\' . 'fee-atmi-' . $bsn_date . '.pdf';
        $mpdf->Output($output, \Mpdf\Output\Destination::FILE);
        $this->session->set_flashdata('messagegeneratereport', "Generate fee settlement pdf has been successfully");
        redirect('/reporting/iso');

        // directo download
        //$mpdf->Output('Settlement Fee ACQ ATMi ' . $bsn_date . '.pdf', \Mpdf\Output\Destination::DOWNLOAD);

        // redirect('/reporting/iso');
    }

    function pdf($bsn_date)
    {
        // $mpdf = new Mpdf();
        //$mpdf = new \Mpdf\Mpdf();
        $settlement_amount = $this->Reporting_model->vault_settlement_xlsx($bsn_date)->jumlah;
        $amount = (float)$settlement_amount;
        $caption = terbilang($amount);

        $data = array(
            'sign_by'            => 'Ratna Sari Dewi',
            'amount'             => number_format($amount, 0),
            'terbilang'          => $caption,
        );
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
        // $html = $this->load->view('pdf/html_to_pdf',[],true);
        $html = $this->load->view('pdf/html_to_pdf', $data, true);
        $mpdf->WriteHTML($html);
        //$mpdf->Output(); // opens in browser
        //$mpdf->Output('Settlement Fee ACQ ATMi.pdf','D'); // it downloads the file into the user system, with give name

        // save local server
        // $mpdf->Output('files/Settlement Fee ACQ ATMi.pdf', \Mpdf\Output\Destination::FILE);
        $v_dir = 'E:\\Temporary\\Report ISO\\' . $bsn_date;
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $output = $v_dir . '\\' . 'vaultsettlement-atmi-' . $bsn_date . '.pdf';
        $mpdf->Output($output, \Mpdf\Output\Destination::FILE);
        $this->session->set_flashdata('messagegeneratereport', "Generate vaultsettlement pdf has been successfully");
        redirect('/reporting/iso');

        // directo download
        //$mpdf->Output('Settlement Fee ACQ ATMi ' . $bsn_date . '.pdf', \Mpdf\Output\Destination::DOWNLOAD);

        // redirect('/reporting/iso');
    }
}
