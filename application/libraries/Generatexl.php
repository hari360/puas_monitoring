<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// class Generatexl extends CI_Controller
// {
//     function __construct()
//     {
//         //parent::__construct();
//         $this->CI = &get_instance();
//         //$this->load->model('Reporting_model', '', TRUE);
//     }
//     var $CI = NULL;

//     public function schedule()
//     {
//         //$settlement_amount = $this->CI->Reporting_model->vault_settlement_xlsx('20211004')->jumlah;
//         die('test');
//     }
// }
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Mpdf\Mpdf;

class Generatexl
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


    function result_query_transactions()
    {
        // $this->CI->insertlog->get_log($bsn_date, 'Generate Result Query Transactions');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle("PT. Alto Network");;
        $sheet->setCellValue('A2', 'PT. Alto Network');
        $sheet->setCellValue('A3', 'Result Query Transactions');

        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000S'],
                ],
            ],
        ];

        $sheet->getStyle('A5:N5')->applyFromArray($styleArray);

        // $formatcell = sprintf("A%s:N%s", 5, 5);
        $spreadsheet->getActiveSheet()->freezePane('A6');

        $sheet->setCellValue('A5', 'Tran Nr');
        $sheet->setCellValue('B5', 'Postilion Date/Time');
        $sheet->setCellValue('C5', 'Date/Time Tran Local');
        $sheet->setCellValue('D5', 'From Acct Type');
        $sheet->setCellValue('E5', 'Tran Type');
        $sheet->setCellValue('F5', 'Message Type');
        $sheet->setCellValue('G5', 'Resp Code');
        $sheet->setCellValue('H5', 'Amount');
        $sheet->setCellValue('I5', 'Card Acceptor Name Loc');
        $sheet->setCellValue('J5', 'Terminal ID');
        $sheet->setCellValue('K5', 'Source Node');
        $sheet->setCellValue('L5', 'Sink Node');
        $sheet->setCellValue('M5', 'PAN');
        $sheet->setCellValue('N5', 'Retrieval Reference Number');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);

        $no = 1;
        $row = 6;

        header('Content-Type: application/json');
        $datefrom         = $this->CI->input->post('from_date');
        $dateto           = $this->CI->input->post('to_date');
        $batch_nr         = $this->CI->input->post('batch_nr');
        $tran_type        = $this->CI->input->post('tran_type');
        $sink_node_name   = $this->CI->input->post('sink_node_name');
        $pan              = $this->CI->input->post('pan');
        $rrn              = $this->CI->input->post('rrn');
        $prefix_term      = $this->CI->input->post('prefix_term');
        $terminal_id      = $this->CI->input->post('terminal_id');
        $response_code    = $this->CI->input->post('response_code');
        $show_records     = $this->CI->input->post('show_records');

        $data_report = $this->CI->Postilion_model->get_real_transactions(
        $datefrom, 
        $dateto, 
        $batch_nr, 
        $tran_type,
        $sink_node_name,
        $pan,
        $rrn,
        $prefix_term,
        $terminal_id,
        $response_code,
        ($show_records == "" ? "10" : $show_records)
        );

        foreach ($data_report as $data_report_iso) {
            $no++;
            $sheet->setCellValueExplicit('A' . $row, $data_report_iso->tran_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('B' . $row, $data_report_iso->postilion_date_time);
            $sheet->setCellValue('C' . $row, $data_report_iso->datetime_tran_local);
            $sheet->setCellValue('D' . $row, $data_report_iso->from_account);
            $sheet->setCellValueExplicit('E' . $row, $data_report_iso->tran_type, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('F' . $row, $data_report_iso->message_type);
            $sheet->setCellValueExplicit('G' . $row, $data_report_iso->rsp_code_rsp, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('H' . $row, $data_report_iso->tran_amount_req);
            $spreadsheet->getActiveSheet()->getStyle('H' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('I' . $row, $data_report_iso->card_acceptor_name_loc);
            $sheet->setCellValue('J' . $row, $data_report_iso->terminal_id);
            $sheet->setCellValue('K' . $row, $data_report_iso->source_node_name);
            $sheet->setCellValue('L' . $row, $data_report_iso->sink_node_name);
            $sheet->setCellValue('M' . $row, substr_replace($data_report_iso->pan, "******", 6, 6));
            $sheet->setCellValue('N' . $row, $data_report_iso->retrieval_reference_nr);
            $row++;
            // $row_sum_amount_rsp++;
        }


        //log_message('info', 'GENERATE EXCEL=>LOG ROW : ' . $row);
        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE RESULT QUERY TRANSACTIONS ==> LOG ROW : ' . $row);
        $writer = new Xlsx($spreadsheet);
        // ob_end_clean();


        $filename = 'result_query_transactions';

        //download file
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // header("Location: http://localhost:81/new_web_monitoring_atmi/reporting/iso");
        // $writer->save('php://output');

        // header("Pragma: public");
        // header("Expires: 0");
        // header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        // header("Content-Type: application/force-download");
        // header("Content-Type: application/octet-stream");
        // header("Content-Type: application/download");;

        // header('Content-Type: application/vnd.ms-excel'); // generate excel file
        // header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        // header('Cache-Control: max-age=0');
        ob_start();
        $writer->save('php://output');	// download file 



        $xlsData = ob_get_contents();
        ob_end_clean();

        $response =  array(
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
            );

        die(json_encode($response));

        
    }

    function excel($bsn_date)
    {
        // ini_set('max_execution_time', 0);
        // ini_set('memory_limit', '-1');
        //die('test');
        // $this->load->model('siswa_model');
        // die($bsn_date);

        $this->CI->insertlog->get_log($bsn_date, 'Generate Detail ATMI');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle("PT. Alto Network");;
        $sheet->setCellValue('A2', 'PT. Alto Network');
        $sheet->setCellValue('A3', 'Transaction Type : All');
        $sheet->setCellValue('A4', 'Report Activity (Batch ' . $bsn_date . ')');

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
        $data_report = $this->CI->Reporting_model->detail_report_xlsx(
            $bsn_date,
            'approved',
            $this->CI->session->userdata('terminal_id'),
            $this->CI->session->userdata('tran_type'),
            $this->CI->session->userdata('from_date_time'),
            $this->CI->session->userdata('to_date_time')
        )->result();
        $record_count = $this->CI->Reporting_model->detail_report_xlsx(
            $bsn_date,
            'approved',
            $this->CI->session->userdata('terminal_id'),
            $this->CI->session->userdata('tran_type'),
            $this->CI->session->userdata('from_date_time'),
            $this->CI->session->userdata('to_date_time')
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
            $sheet->setCellValue('E' . $row, ($data_report_iso->benef_name == "" ? "-" : $data_report_iso->receiving_inst_id_code." - ".$data_report_iso->benef_name));
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

            if ($row % 10000 == 0) wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE DETAIL ATMI ==> LOG ROW : ' . $row); //log_message('info', 'GENERATE EXCEL=>LOG ROW : ' . $row);
        }


        //log_message('info', 'GENERATE EXCEL=>LOG ROW : ' . $row);
        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE DETAIL ATMI ==> LOG ROW : ' . $row);
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
        //ob_end_clean();


        $filename = 'detail-batch-atmi' . $bsn_date;



        //download file
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // header("Location: http://localhost:81/new_web_monitoring_atmi/reporting/iso");
        //$writer->save('php://output');

        $settle_date = date('Ymd', (strtotime('+1 day', strtotime($bsn_date))));
        $v_dir = $this->CI->config->item('global_dir') . '\\ATMI\\' 
                            . substr($settle_date,0,4) 
                            . '\\' 
                            . substr($settle_date,4,2). substr($settle_date,2,2)  
                            . '\\' 
                            . substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);

        //$v_dir = $this->CI->config->item('global_dir') . $bsn_date . '\\ATMI';
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        //log_message('info', 'GENERATE EXCEL=>CREATE OUTPUT FILE');
        $filename_path = $v_dir . '\\' . $filename . '.xlsx';
        //log_message('info', 'GENERATE EXCEL=>PROCESSING SAVE OUTPUT');
        $writer->save($filename_path);
        copy($filename_path, './attach/ATMI/'.$filename . '.xlsx');
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate detail-batch has been successfully");
        //log_message('info', 'GENERATE EXCEL=>OUTPUT HAS DONE');
        //redirect('/reporting/iso');
        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE DETAIL ATMI ==> DONE');

        // save local server
        //$filename = $this->CI->config->item('global_dir').$filename.'.xlsx';
        //$writer->save($filename);
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate report has been successfully");
    }

    function excel_crm($batch, $file_name)
    {
        // ini_set('max_execution_time', 0);
        // ini_set('memory_limit', '-1');
        //die('test');
        // $this->load->model('siswa_model');
        // die($bsn_date);
        $this->CI->insertlog->get_log($batch, 'Generate Detail CRM');
        $batch_crm = $this->CI->Reporting_model->get_batch_xls_crm($batch);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle("PT. Alto Network");;
        $sheet->setCellValue('A2', 'PT. Alto Network');
        $sheet->setCellValue('A3', 'Transaction Type : All');
        $sheet->setCellValue('A4', 'Report Activity (Batch ' . $batch_crm . ')');

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
        $data_report = $this->CI->Reporting_model->detail_report_xlsx_crm(
            $batch,
            'approved',
            $this->CI->session->userdata('terminal_id'),
            //$this->CI->session->userdata('tran_type'),
            ($file_name == "cardless" ? "Cardless Withdrawal" : "Cardless Deposit"),
            $this->CI->session->userdata('from_date_time'),
            $this->CI->session->userdata('to_date_time')
        )->result();
        $record_count = $this->CI->Reporting_model->detail_report_xlsx_crm(
            $batch,
            'approved',
            $this->CI->session->userdata('terminal_id'),
            ($file_name == "cardless" ? "Cardless Withdrawal" : "Cardless Deposit"),
            //$this->CI->session->userdata('tran_type'),
            $this->CI->session->userdata('from_date_time'),
            $this->CI->session->userdata('to_date_time')
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
            $sheet->setCellValue('K' . $row, 0);
            $spreadsheet->getActiveSheet()->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('L' . $row, 0);
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

            // if ($row % 10000 == 0) log_message('info', 'GENERATE EXCEL CRM=>LOG ROW : ' . $row);
        }


        // log_message('info', 'GENERATE EXCEL CRM=>LOG ROW : ' . $row);

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
        //ob_end_clean();


        $filename = 'detail_' . $file_name . '-batch' . $batch_crm;



        //download file
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // header("Location: http://localhost:81/new_web_monitoring_atmi/reporting/iso");
        //$writer->save('php://output');

        // $settle_date = date('Y-m-d', (strtotime('+1 day', strtotime($batch))));
        // $v_dir = $this->CI->config->item('global_dir') . str_replace("-", "", $settle_date) . '\\CRM';

        $settle_date = date('Ymd', (strtotime('+1 day', strtotime($batch))));
        $v_dir = $this->CI->config->item('global_dir') . '\\ATMI\\Cardless\\' 
                            . substr($settle_date,0,4) 
                            . '\\' 
                            . substr($settle_date,4,2). substr($settle_date,2,2)  
                            . '\\' 
                            . substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);

        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        // log_message('info', 'GENERATE EXCEL CRM=>CREATE OUTPUT FILE');
        $filename_path = $v_dir . '\\' . $filename . '.xlsx';
        // log_message('info', 'GENERATE EXCEL CRM=>PROCESSING SAVE OUTPUT');
        $writer->save($filename_path);
        copy($filename_path, './attach/ATMI/'.$filename . '.xlsx');
        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE DETAIL ATMI-CRM-' . $file_name . ' ===> DONE');
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate detail-batch has been successfully");
        // log_message('info', 'GENERATE EXCEL CRM=>OUTPUT HAS DONE');
        //redirect('/reporting/iso');

        // save local server
        //$filename = $this->CI->config->item('global_dir').$filename.'.xlsx';
        //$writer->save($filename);
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate report has been successfully");
    }

    function excel_atmi_ptpr($bsn_date)
    {
        // ini_set('max_execution_time', 0);
        // ini_set('memory_limit', '-1');
        //die('test');
        // $this->load->model('siswa_model');
        // die($bsn_date);
        $this->CI->insertlog->get_log($bsn_date, 'Generate Detail ATMI-PTPR');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle("PT. Alto Network");;
        $sheet->setCellValue('A2', 'PT. Alto Network');
        $sheet->setCellValue('A3', 'Transaction Type : All');
        $sheet->setCellValue('A4', 'Report Activity (Batch ' . $bsn_date . ')');

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
        $data_report = $this->CI->Reporting_model->detail_report_xlsx_atmi_ptpr(
            $bsn_date,
            'approved',
            $this->CI->session->userdata('terminal_id'),
            $this->CI->session->userdata('tran_type'),
            $this->CI->session->userdata('from_date_time'),
            $this->CI->session->userdata('to_date_time')
        )->result();
        $record_count = $this->CI->Reporting_model->detail_report_xlsx_atmi_ptpr(
            $bsn_date,
            'approved',
            $this->CI->session->userdata('terminal_id'),
            $this->CI->session->userdata('tran_type'),
            $this->CI->session->userdata('from_date_time'),
            $this->CI->session->userdata('to_date_time')
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
            $sheet->setCellValue('E' . $row, ($data_report_iso->benef_name == "" ? "-" : $data_report_iso->receiving_inst_id_code." - ".$data_report_iso->benef_name));
            $sheet->setCellValue('F' . $row, $data_report_iso->tgl);
            $sheet->setCellValue('G' . $row, $data_report_iso->waktu);
            $sheet->setCellValue('H' . $row, $data_report_iso->tran_type_name);
            $sheet->setCellValue('I' . $row, $data_report_iso->amount_req);
            $spreadsheet->getActiveSheet()->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('J' . $row, $data_report_iso->amount_rsp);
            $spreadsheet->getActiveSheet()->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('K' . $row, $data_report_iso->tran_fee);
            $spreadsheet->getActiveSheet()->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('L' . $row, 0);
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

            if ($row % 10000 == 0) wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE DETAIL ATMI-PTPR ==> LOG ROW : ' . $row); //log_message('info', 'GENERATE EXCEL=>LOG ROW ATMI PTPR : ' . $row);
        }


        // log_message('info', 'GENERATE EXCEL=>LOG ROW ATMI PTPR : ' . $row);
        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE DETAIL ATMI-PTPR ==> LOG ROW : ' . $row);
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
        //ob_end_clean();


        $filename = 'detail-batch-atmi-ptpr' . $bsn_date;



        //download file
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // header("Location: http://localhost:81/new_web_monitoring_atmi/reporting/iso");
        //$writer->save('php://output');

        $settle_date = date('Ymd', (strtotime('+1 day', strtotime($bsn_date))));
        $v_dir = $this->CI->config->item('global_dir') . '\\ATMI\\' 
                            . substr($settle_date,0,4) 
                            . '\\' 
                            . substr($settle_date,4,2). substr($settle_date,2,2)  
                            . '\\' 
                            . substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);
        // $settle_date = date('Y-m-d', (strtotime('+1 day', strtotime($bsn_date))));
        // $v_dir = $this->CI->config->item('global_dir') . str_replace("-", "", $settle_date) . '\\ATMI';
        //$v_dir = $this->CI->config->item('global_dir') . $bsn_date . '\\ATMI';
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        // log_message('info', 'GENERATE EXCEL=>CREATE OUTPUT FILE ATMI PTPR');
        $filename_path = $v_dir . '\\' . $filename . '.xlsx';
        // log_message('info', 'GENERATE EXCEL=>PROCESSING SAVE OUTPUT ATMI PTPR');
        $writer->save($filename_path);
        copy($filename_path, './attach/ATMI/'.$filename . '.xlsx');
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate detail-batch has been successfully");
        // log_message('info', 'GENERATE EXCEL=>OUTPUT ATMI PTPR HAS DONE');
        //redirect('/reporting/iso');
        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE DETAIL ATMI-PTPR ==> DONE');
        // save local server
        //$filename = $this->CI->config->item('global_dir').$filename.'.xlsx';
        //$writer->save($filename);
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate report has been successfully");
    }

    function excel_ptpr($bsn_date)
    {
        // ini_set('max_execution_time', 0);
        // ini_set('memory_limit', '-1');
        //die('test');
        // $this->load->model('siswa_model');
        // die($bsn_date);
        $this->CI->insertlog->get_log($bsn_date, 'Generate Detail PTPR');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle("PT. Alto Network");;
        $sheet->setCellValue('A2', 'Transaction Type : All');
        $sheet->setCellValue('A3', 'Report Activity (Batch ' . $bsn_date . ')');

        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000S'],
                ],
            ],
        ];

        $sheet->getStyle('A5:Q5')->applyFromArray($styleArray);

        $formatcell = sprintf("A%s:Q%s", 5, 5);
        //$spreadsheet->getActiveSheet()->getStyle($formatcell)->getFont()->setName('Arial');
        //$spreadsheet->getActiveSheet()->getStyle($formatcell)->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->freezePane('A6');

        $sheet->setCellValue('A5', 'Batch No.');
        $sheet->setCellValue('B5', 'Seq. Number');
        $sheet->setCellValue('C5', 'Terminal ID');
        $sheet->setCellValue('D5', 'Nama Lokasi');
        $sheet->setCellValue('E5', 'PAN');
        $sheet->setCellValue('F5', 'Issuer');
        $sheet->setCellValue('G5', 'Beneficiary');
        $sheet->setCellValue('H5', 'Date');
        $sheet->setCellValue('I5', 'Time');
        $sheet->setCellValue('J5', 'Type Trans');
        $sheet->setCellValue('K5', 'Amount Req');
        $sheet->setCellValue('L5', 'Amount Rsp');
        $sheet->setCellValue('M5', 'Tran Fee');
        $sheet->setCellValue('N5', 'Acquiring Fee');
        $sheet->setCellValue('O5', 'Routing');
        $sheet->setCellValue('P5', 'Description');
        $sheet->setCellValue('Q5', 'Transaction Fee');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getColumnDimension('Q')->setAutoSize(true);

        $row_sum_amount_rsp = 0;
        $amount_request = 0;
        $no = 1;
        $row = 6;
        $data_report = $this->CI->Reporting_model->detail_report_xlsx_ptpr(
            $bsn_date,
            'approved',
            $this->CI->session->userdata('terminal_id'),
            $this->CI->session->userdata('tran_type'),
            $this->CI->session->userdata('from_date_time'),
            $this->CI->session->userdata('to_date_time')
        )->result();
        $record_count = $this->CI->Reporting_model->detail_report_xlsx_ptpr(
            $bsn_date,
            'approved',
            $this->CI->session->userdata('terminal_id'),
            $this->CI->session->userdata('tran_type'),
            $this->CI->session->userdata('from_date_time'),
            $this->CI->session->userdata('to_date_time')
        )->num_rows();

        foreach ($data_report as $data_report_iso) {
            if ($data_report_iso->row_num == 1) {
                if ($no == 1) {
                    //$sheet->setCellValue('A' . $row, $data_report_iso->terminal_name);
                    //$row = $row + 1;
                    //$row_sum_amount_rsp = 0;
                } else {
                    // $sheet->setCellValue('A' . $row, 'Sub Total');

                    // $sintaxamountreq = sprintf("= SUM(I%s:I%s)", $row+1, $row-1);
                    // $sheet->setCellValue('I'.$row, $sintaxamountreq);

                    // $sheet->setCellValue('I' . $row, $amount_request);
                    // $spreadsheet->getActiveSheet()->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0');

                    // $sintaxamountrsp = sprintf("= SUM(J%s:J%s)", $row_sum_amount_rsp, $row - 1);
                    // $sheet->setCellValue('J' . $row, $sintaxamountrsp);
                    // $spreadsheet->getActiveSheet()->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');

                    // $sintaxamountrsp = sprintf("= SUM(K%s:K%s)", $row_sum_amount_rsp, $row - 1);
                    // $sheet->setCellValue('K' . $row, $sintaxamountrsp);
                    // $spreadsheet->getActiveSheet()->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');

                    // $sintaxamountrsp = sprintf("= SUM(L%s:L%s)", $row_sum_amount_rsp, $row - 1);
                    // $sheet->setCellValue('L' . $row, $sintaxamountrsp);
                    // $spreadsheet->getActiveSheet()->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');

                    // // $sheet->setCellValue('J'.$row, 'Sub Total');
                    // // $sheet->setCellValue('K'.$row, 'Sub Total');
                    // // $sheet->setCellValue('L'.$row, 'Sub Total');
                    // $row = $row + 2;
                    // $sheet->setCellValue('A' . $row, $data_report_iso->terminal_name);
                    // $row = $row + 1;
                    // $row_sum_amount_rsp = 0;
                }
            }

            if ($row_sum_amount_rsp == 0) {
                $row_sum_amount_rsp = $row;
            }

            // $row_sum_amount_rsp++;
            $no++;
            $sheet->setCellValueExplicit('A' . $row, $data_report_iso->batch_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('B' . $row, $data_report_iso->system_trace_audit_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('C' . $row, $data_report_iso->terminal_id);
            $sheet->setCellValue('D' . $row, $data_report_iso->terminal_name);
            $sheet->setCellValue('E' . $row, $data_report_iso->pan);
            $sheet->setCellValue('F' . $row, $data_report_iso->issuer_name);
            $sheet->setCellValue('G' . $row, ($data_report_iso->benef_name == "" ? "-" : $data_report_iso->receiving_inst_id_code." - ".$data_report_iso->benef_name));
            $sheet->setCellValue('H' . $row, $data_report_iso->tgl);
            $sheet->setCellValue('I' . $row, $data_report_iso->waktu);
            $sheet->setCellValue('J' . $row, $data_report_iso->tran_type_name);
            $sheet->setCellValue('K' . $row, $data_report_iso->amount_req);
            $spreadsheet->getActiveSheet()->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('L' . $row, $data_report_iso->amount_rsp);
            $spreadsheet->getActiveSheet()->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('M' . $row, $data_report_iso->tran_fee);
            $spreadsheet->getActiveSheet()->getStyle('M' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('N' . $row, $data_report_iso->proc_fee);
            $spreadsheet->getActiveSheet()->getStyle('N' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('O' . $row, $data_report_iso->routing);
            $sheet->setCellValue('P' . $row, '-');
            $sheet->setCellValue('Q' . $row, $data_report_iso->fee_issuer);
            $spreadsheet->getActiveSheet()->getStyle('Q' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $amount_request = $data_report_iso->jml_amount_req;
            $row++;
            // $row_sum_amount_rsp++;



            if (($no - 1) == $record_count) {
                //$sheet->setCellValue('A' . $row, 'Sub Total');

                // $sintaxamountreq = sprintf("= SUM(I%s:I%s)", $row+1, $row-1);
                // $sheet->setCellValue('I'.$row, $sintaxamountreq);

                // $sheet->setCellValue('I' . $row, $amount_request);
                // $spreadsheet->getActiveSheet()->getStyle('I' . $row)->getNumberFormat()->setFormatCode('#,##0');

                // $sintaxamountrsp = sprintf("= SUM(J%s:J%s)", $row_sum_amount_rsp, $row - 1);
                // $sheet->setCellValue('J' . $row, $sintaxamountrsp);
                // $spreadsheet->getActiveSheet()->getStyle('J' . $row)->getNumberFormat()->setFormatCode('#,##0');

                // $sintaxamountrsp = sprintf("= SUM(K%s:K%s)", $row_sum_amount_rsp, $row - 1);
                // $sheet->setCellValue('K' . $row, $sintaxamountrsp);
                // $spreadsheet->getActiveSheet()->getStyle('K' . $row)->getNumberFormat()->setFormatCode('#,##0');

                // $sintaxamountrsp = sprintf("= SUM(L%s:L%s)", $row_sum_amount_rsp, $row - 1);
                // $sheet->setCellValue('L' . $row, $sintaxamountrsp);
                // $spreadsheet->getActiveSheet()->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');
            }
            if ($row % 10000 == 0) wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE DETAIL PTPR ==> LOG ROW : ' . $row); //log_message('info', 'GENERATE EXCEL=>LOG ROW PTPR : ' . $row);

        }
        //log_message('info', 'GENERATE EXCEL=>LOG ROW PTPR : ' . $row);

        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE DETAIL PTPR ==> LOG ROW : ' . $row);


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
        //ob_end_clean();


        $filename = 'ptpr-detail-batch' . $bsn_date;



        //download file
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // header("Location: http://localhost:81/new_web_monitoring_atmi/reporting/iso");
        //$writer->save('php://output');

        $settle_date = date('Ymd', (strtotime('+1 day', strtotime($bsn_date))));
        $v_dir = $this->CI->config->item('global_dir') . '\\PTPR\\' 
                            . substr($settle_date,0,4) 
                            . '\\' 
                            . substr($settle_date,4,2). substr($settle_date,2,2)  
                            . '\\' 
                            . substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);
        // $settle_date = date('Y-m-d', (strtotime('+1 day', strtotime($bsn_date))));
        // $v_dir = $this->CI->config->item('global_dir') . str_replace("-", "", $settle_date) . '\\PTPR';
        //$v_dir = $this->CI->config->item('global_dir') . $bsn_date . '\\PTPR';
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        //log_message('info', 'GENERATE EXCEL=>CREATE OUTPUT FILE PTPR');
        $filename_path = $v_dir . '\\' . $filename . '.xlsx';
        //log_message('info', 'GENERATE EXCEL=>PROCESSING SAVE OUTPUT PTPR');
        $writer->save($filename_path);
        copy($filename_path, './attach/PTPR/'.$filename . '.xlsx');
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate detail-batch has been successfully");
        //log_message('info', 'GENERATE EXCEL=>OUTPUT PTPR HAS DONE');

        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE DETAIL PTPR ==> DONE');
        // $filename = $v_dir . '\\' . $filename . '.xlsx';
        // $writer->save($filename);
        // log_message('info', 'GENERATE EXCEL=>LOG ROW ATMI PTPR : '.$row);
        // $this->CI->session->set_flashdata('messagegeneratereport', "Generate detail-batch has been successfully");
        // redirect('/reporting/iso');

        // save local server
        //$filename = $this->CI->config->item('global_dir').$filename.'.xlsx';
        //$writer->save($filename);
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate report has been successfully");
    }

    function excel_reject_ptpr($bsn_date)
    {
        $this->CI->insertlog->get_log($bsn_date, 'Generate Reject PTPR');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle("PT. Alto Network");;
        // $sheet->setCellValue('A2', 'PT. Alto Network');
        $sheet->setCellValue('A2', 'Transaction Type : All');
        $sheet->setCellValue('A3', 'Report Reject Activity (Batch ' . $bsn_date . ')');

        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000S'],
                ],
            ],
        ];

        $sheet->getStyle('A5:N5')->applyFromArray($styleArray);

        $formatcell = sprintf("A%s:N%s", 5, 5);
        $spreadsheet->getActiveSheet()->getStyle($formatcell)->getFont()->setName('Arial');
        $spreadsheet->getActiveSheet()->getStyle($formatcell)->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->freezePane('A6');

        $sheet->setCellValue('A5', 'Batch No');
        $sheet->setCellValue('B5', 'Seq. Number');
        $sheet->setCellValue('C5', 'Terminal ID');
        $sheet->setCellValue('D5', 'PAN');
        $sheet->setCellValue('E5', 'Issuer Name');
        $sheet->setCellValue('F5', 'Terminal Name');
        $sheet->setCellValue('G5', 'Date');
        $sheet->setCellValue('H5', 'Time');
        $sheet->setCellValue('I5', 'Type Trans');
        $sheet->setCellValue('J5', 'Amount Req');
        $sheet->setCellValue('K5', 'Response Code');
        $sheet->setCellValue('L5', 'Beneficiary Name');
        $sheet->setCellValue('M5', 'Description');
        $sheet->setCellValue('N5', 'Acquiring Fee');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setAutoSize(20);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(30);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setWidth(40);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);

        $row_sum_amount_rsp = 0;
        $amount_request = 0;
        $no = 1;
        $row = 6;

        $data_report = $this->CI->Reporting_model->detail_report_reject_xlsx_ptpr(
            $bsn_date,
            'rejected',
            $this->CI->session->userdata('terminal_id'),
            $this->CI->session->userdata('tran_type'),
            $this->CI->session->userdata('from_date_time'),
            $this->CI->session->userdata('to_date_time')
        )->result();

        $record_count = $this->CI->Reporting_model->detail_report_reject_xlsx_ptpr(
            $bsn_date,
            'rejected',
            $this->CI->session->userdata('terminal_id'),
            $this->CI->session->userdata('tran_type'),
            $this->CI->session->userdata('from_date_time'),
            $this->CI->session->userdata('to_date_time')
        )->num_rows();

        //$data_report = $this->CI->Reporting_model->detail_report_reject_xlsx($bsn_date, 'rejected','')->result();
        //$record_count = $this->CI->Reporting_model->detail_report_reject_xlsx($bsn_date, 'rejected','')->num_rows();

        foreach ($data_report as $data_report_iso) {
            // if ($data_report_iso->row_num == 1) {
            //     if ($no == 1) {
            //         $sheet->setCellValue('A' . $row, $data_report_iso->issuer_name);
            //         $row = $row + 1;
            //         $row_sum_amount_rsp = 0;
            //     } else {
            //         $sheet->setCellValue('A' . $row, 'Sub Total');

            //         $sheet->setCellValue('H' . $row, $amount_request);
            //         $spreadsheet->getActiveSheet()->getStyle('H' . $row)->getNumberFormat()->setFormatCode('#,##0');

            //         $row = $row + 2;
            //         $sheet->setCellValue('A' . $row, $data_report_iso->issuer_name);
            //         $row = $row + 1;
            //         $row_sum_amount_rsp = 0;
            //     }
            // }

            // if ($row_sum_amount_rsp == 0) {
            //     $row_sum_amount_rsp = $row;
            // }

            $no++;
            $sheet->setCellValue('A' . $row, $data_report_iso->batch_nr);
            $sheet->setCellValueExplicit('B' . $row, $data_report_iso->system_trace_audit_nr, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('C' . $row, $data_report_iso->terminal_id);
            $sheet->setCellValue('D' . $row, $data_report_iso->pan);
            $sheet->setCellValue('E' . $row, $data_report_iso->issuer_name);
            $sheet->setCellValue('F' . $row, $data_report_iso->terminal_name);
            $sheet->setCellValue('G' . $row, $data_report_iso->tgl);
            $sheet->setCellValue('H' . $row, $data_report_iso->waktu);
            $sheet->setCellValue('I' . $row, $data_report_iso->tran_type_name);
            $sheet->setCellValue('J' . $row, $data_report_iso->amount_req);
            $spreadsheet->getActiveSheet()->getStyle('j' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('K' . $row, $data_report_iso->rsp_code_rsp . ' - ' . $data_report_iso->display_name);
            $sheet->setCellValue('L' . $row, $data_report_iso->receiving_inst_id_code . ' - ' . $data_report_iso->benef_name);
            $sheet->setCellValue('M' . $row, $data_report_iso->description);
            $sheet->setCellValue('N' . $row, 0);

            $amount_request = $data_report_iso->jml_amount_req;
            $row++;

            // if (($no - 1) == $record_count) {
            //     $sheet->setCellValue('A' . $row, 'Sub Total');
            //     $sheet->setCellValue('H' . $row, $amount_request);
            //     $spreadsheet->getActiveSheet()->getStyle('H' . $row)->getNumberFormat()->setFormatCode('#,##0');
            // }
        }

        $writer = new Xlsx($spreadsheet);
        //ob_end_clean();

        $filename = 'ptpr-detail-reject-batch' . $bsn_date;

        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // $writer->save('php://output');

        $settle_date = date('Ymd', (strtotime('+1 day', strtotime($bsn_date))));
        $v_dir = $this->CI->config->item('global_dir') . '\\PTPR\\' 
                            . substr($settle_date,0,4) 
                            . '\\' 
                            . substr($settle_date,4,2). substr($settle_date,2,2)  
                            . '\\' 
                            . substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);
        // $settle_date = date('Y-m-d', (strtotime('+1 day', strtotime($bsn_date))));
        // $v_dir = $this->CI->config->item('global_dir') . str_replace("-", "", $settle_date) . '\\PTPR';
        //$v_dir = $this->CI->config->item('global_dir') . $bsn_date . "\\PTPR";
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $filename_path = $v_dir . '\\' . $filename . '.xlsx';
        $writer->save($filename_path);
        copy($filename_path, './attach/PTPR/'.$filename . '.xlsx');
        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE DETAIL REJECT PTPR ==> DONE');
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate detail-batch-reject has been successfully");
        //redirect('/reporting/iso');
    }

    function excel_reject_atmi_ptpr($bsn_date)
    {
        $this->CI->insertlog->get_log($bsn_date, 'Generate Reject ATMI-PTPR');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle("PT. Alto Network");;
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

        $data_report = $this->CI->Reporting_model->detail_report_reject_xlsx_atmi_ptpr(
            $bsn_date,
            'rejected',
            $this->CI->session->userdata('terminal_id'),
            $this->CI->session->userdata('tran_type'),
            $this->CI->session->userdata('from_date_time'),
            $this->CI->session->userdata('to_date_time')
        )->result();

        $record_count = $this->CI->Reporting_model->detail_report_reject_xlsx_atmi_ptpr(
            $bsn_date,
            'rejected',
            $this->CI->session->userdata('terminal_id'),
            $this->CI->session->userdata('tran_type'),
            $this->CI->session->userdata('from_date_time'),
            $this->CI->session->userdata('to_date_time')
        )->num_rows();

        //$data_report = $this->CI->Reporting_model->detail_report_reject_xlsx($bsn_date, 'rejected','')->result();
        //$record_count = $this->CI->Reporting_model->detail_report_reject_xlsx($bsn_date, 'rejected','')->num_rows();

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
        //ob_end_clean();

        $filename = 'detail-reject-atmi-ptpr-batch' . $bsn_date;

        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // $writer->save('php://output');

        $settle_date = date('Ymd', (strtotime('+1 day', strtotime($bsn_date))));
        $v_dir = $this->CI->config->item('global_dir') . '\\ATMI\\' 
                            . substr($settle_date,0,4) 
                            . '\\' 
                            . substr($settle_date,4,2). substr($settle_date,2,2)  
                            . '\\' 
                            . substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);
        // $settle_date = date('Y-m-d', (strtotime('+1 day', strtotime($bsn_date))));
        // $v_dir = $this->CI->config->item('global_dir') . str_replace("-", "", $settle_date) . '\\ATMI';
        //$v_dir = $this->CI->config->item('global_dir') . $bsn_date . "\\ATMI";
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $filename_path = $v_dir . '\\' . $filename . '.xlsx';
        $writer->save($filename_path);
        copy($filename_path, './attach/ATMI/'.$filename . '.xlsx');
        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE DETAIL REJECT ATMI-PTPR ==> DONE');
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate detail-batch-reject has been successfully");
        //redirect('/reporting/iso');
    }

    function excel_reject_atmi($bsn_date)
    {
        $this->CI->insertlog->get_log($bsn_date, 'Generate Reject ATMI');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle("PT. Alto Network");;
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

        $data_report = $this->CI->Reporting_model->detail_report_reject_xlsx(
            $bsn_date,
            'rejected',
            $this->CI->session->userdata('terminal_id'),
            $this->CI->session->userdata('tran_type'),
            $this->CI->session->userdata('from_date_time'),
            $this->CI->session->userdata('to_date_time')
        )->result();

        $record_count = $this->CI->Reporting_model->detail_report_reject_xlsx(
            $bsn_date,
            'rejected',
            $this->CI->session->userdata('terminal_id'),
            $this->CI->session->userdata('tran_type'),
            $this->CI->session->userdata('from_date_time'),
            $this->CI->session->userdata('to_date_time')
        )->num_rows();

        //$data_report = $this->CI->Reporting_model->detail_report_reject_xlsx($bsn_date, 'rejected','')->result();
        //$record_count = $this->CI->Reporting_model->detail_report_reject_xlsx($bsn_date, 'rejected','')->num_rows();

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
        //ob_end_clean();

        $filename = 'detail-reject-atmi-batch' . $bsn_date;

        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // $writer->save('php://output');

        $settle_date = date('Ymd', (strtotime('+1 day', strtotime($bsn_date))));
        $v_dir = $this->CI->config->item('global_dir') . '\\ATMI\\' 
                            . substr($settle_date,0,4) 
                            . '\\' 
                            . substr($settle_date,4,2). substr($settle_date,2,2)  
                            . '\\' 
                            . substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);

        // $settle_date = date('Y-m-d', (strtotime('+1 day', strtotime($bsn_date))));
        // $v_dir = $this->CI->config->item('global_dir') . str_replace("-", "", $settle_date) . '\\ATMI';
        //$v_dir = $this->CI->config->item('global_dir') . $bsn_date . "\\ATMI";
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $filename_path = $v_dir . '\\' . $filename . '.xlsx';
        $writer->save($filename_path);
        copy($filename_path, './attach/ATMI/'.$filename . '.xlsx');
        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE DETAIL REJECT ATMI ==> DONE');
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate detail-batch-reject has been successfully");
        //redirect('/reporting/iso');
    }

    function excel_reject_crm($bsn_date)
    {
        $this->CI->insertlog->get_log($bsn_date, 'Generate Reject CRM');
        $batch_crm = $this->CI->Reporting_model->get_batch_xls_crm($bsn_date);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle("PT. Alto Network");;
        $sheet->setCellValue('A2', 'PT. Alto Network');
        $sheet->setCellValue('A3', 'Transaction Type : All');
        $sheet->setCellValue('A4', 'Report Reject Activity (Batch ' . $batch_crm . ')');

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

        $data_report = $this->CI->Reporting_model->detail_report_reject_xlsx_crm(
            $bsn_date,
            'rejected',
            $this->CI->session->userdata('terminal_id'),
            $this->CI->session->userdata('tran_type'),
            $this->CI->session->userdata('from_date_time'),
            $this->CI->session->userdata('to_date_time')
        )->result();

        $record_count = $this->CI->Reporting_model->detail_report_reject_xlsx_crm(
            $bsn_date,
            'rejected',
            $this->CI->session->userdata('terminal_id'),
            $this->CI->session->userdata('tran_type'),
            $this->CI->session->userdata('from_date_time'),
            $this->CI->session->userdata('to_date_time')
        )->num_rows();

        //$data_report = $this->CI->Reporting_model->detail_report_reject_xlsx($bsn_date, 'rejected','')->result();
        //$record_count = $this->CI->Reporting_model->detail_report_reject_xlsx($bsn_date, 'rejected','')->num_rows();

        foreach ($data_report as $data_report_iso) {
            if ($data_report_iso->row_num == 1) {
                if ($no == 1) {
                    $sheet->setCellValue('A' . $row, ($data_report_iso->issuer_name == "" ? "Other" : $data_report_iso->issuer_name));
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
            $sheet->setCellValue('J' . $row, $data_report_iso->benef_name);
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
        //ob_end_clean();

        $filename = 'detail-reject-cardless-batch' . $batch_crm;

        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // $writer->save('php://output');

        // $settle_date = date('Y-m-d', (strtotime('+1 day', strtotime($bsn_date))));
        // $v_dir = $this->CI->config->item('global_dir') . str_replace("-", "", $settle_date) . '\\CRM';
        $settle_date = date('Ymd', (strtotime('+1 day', strtotime($bsn_date))));
        $v_dir = $this->CI->config->item('global_dir') . '\\ATMI\\Cardless\\' 
                            . substr($settle_date,0,4) 
                            . '\\' 
                            . substr($settle_date,4,2). substr($settle_date,2,2)  
                            . '\\' 
                            . substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);
        //$v_dir = $this->CI->config->item('global_dir') . $bsn_date . "\\CRM";
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $filename_path = $v_dir . '\\' . $filename . '.xlsx';
        $writer->save($filename_path);
        copy($filename_path, './attach/ATMI/'.$filename . '.xlsx');
        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE DETAIL REJECT ATMI-CRM ==> DONE');
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate detail-batch-reject has been successfully");
        //redirect('/reporting/iso');
    }

    function excel_summary_atmi($bsn_date)
    {
        $this->CI->insertlog->get_log($bsn_date, 'Generate Summary ATMI');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle("PT. Alto Network");;
        $sheet->setCellValue('B2', 'PT. Alto Network');
        $sheet->setCellValue('B3', 'Transaction Type : All');
        $sheet->setCellValue('B4', 'Report Activity (Batch ' . $bsn_date . ')');



        $formatcell = sprintf("A%s:L%s", 1, 7);
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

        $sheet->setCellValue('K6', 'Cardbase Deposit');
        $spreadsheet->getActiveSheet()->mergeCells('K6:K6');
        $spreadsheet->getActiveSheet()->getStyle('K6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('K7', 'TXN');
        $sheet->setCellValue('L7', 'Proc Fee');


        $spreadsheet->getActiveSheet()->getStyle('C7:L7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(26);
        $sheet->getColumnDimension('C')->setAutoSize(true);

        $no = 1;
        $row = 8;
        $data_report = $this->CI->Reporting_model->summary_xlsx($bsn_date);

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
            $sheet->setCellValue('K' . $row, $data_report_iso->txn_deposit);
            $sheet->setCellValue('L' . $row, $data_report_iso->proc_fee_deposit);
            $spreadsheet->getActiveSheet()->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');

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

        $sintaxamountrsp = sprintf("= SUM(K%s:K%s)", 8, $total_row - 1);
        $sheet->setCellValue('K' . $total_row, $sintaxamountrsp);
        $spreadsheet->getActiveSheet()->getStyle('K' . $total_row)->getNumberFormat()->setFormatCode('#,##0');

        $sintaxamountrsp = sprintf("= SUM(L%s:L%s)", 8, $total_row - 1);
        $sheet->setCellValue('L' . $total_row, $sintaxamountrsp);
        $spreadsheet->getActiveSheet()->getStyle('L' . $total_row)->getNumberFormat()->setFormatCode('#,##0');


        $formatcell = sprintf("A%s:L%s", 8, $total_row);
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
            ->getStyle('A6:L' . $total_row)
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

        $sheet->getStyle('A6:L' . $total_row)->applyFromArray($styleArray);


        $writer = new Xlsx($spreadsheet);
        //ob_end_clean();

        $filename = 'summary-atmi-batch' . $bsn_date;

        $settle_date = date('Ymd', (strtotime('+1 day', strtotime($bsn_date))));
        $v_dir = $this->CI->config->item('global_dir') . '\\ATMI\\' 
                            . substr($settle_date,0,4) 
                            . '\\' 
                            . substr($settle_date,4,2). substr($settle_date,2,2)  
                            . '\\' 
                            . substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);
        // $settle_date = date('Y-m-d', (strtotime('+1 day', strtotime($bsn_date))));
        // $v_dir = $this->CI->config->item('global_dir') . str_replace("-", "", $settle_date) . '\\ATMI';
        //$v_dir = $this->CI->config->item('global_dir') . $bsn_date . "\\ATMI";
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $filename = $v_dir . '\\' . $filename . '.xlsx';

        $writer->save($filename);
        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE DETAIL SUMMARY ATMI ==> DONE');
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate summary-batch has been successfully");
        //redirect('/reporting/iso');

        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // $writer->save('php://output');
    }

    function excel_summary_crm($bsn_date)
    {
        $this->CI->insertlog->get_log($bsn_date, 'Generate Summary CRM');
        $batch_crm = $this->CI->Reporting_model->get_batch_xls_crm($bsn_date);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle("PT. Alto Network");;
        $sheet->setCellValue('B2', 'PT. Alto Network');
        $sheet->setCellValue('B3', 'Transaction Type : All');
        $sheet->setCellValue('B4', 'Report Activity (Batch ' . $batch_crm . ')');



        $formatcell = sprintf("A%s:G%s", 1, 7);
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
        $spreadsheet->getActiveSheet()->mergeCells('C6:D6');
        $spreadsheet->getActiveSheet()->getStyle('C6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('C7', 'Amount');
        //$sheet->setCellValue('D7', 'Surcharge');
        $sheet->setCellValue('D7', 'TXN');
        //$sheet->setCellValue('F7', 'Proc Fee');


        $sheet->setCellValue('E6', 'Inquiry');
        //$spreadsheet->getActiveSheet()->mergeCells('G6:H6');
        $spreadsheet->getActiveSheet()->getStyle('E6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('E7', 'TXN');


        $sheet->setCellValue('F6', 'Deposit');
        $spreadsheet->getActiveSheet()->mergeCells('F6:G6');
        $spreadsheet->getActiveSheet()->getStyle('F6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('F7', 'Amount');
        $sheet->setCellValue('G7', 'TXN');




        $spreadsheet->getActiveSheet()->getStyle('C7:G7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(26);
        $sheet->getColumnDimension('C')->setAutoSize(true);

        $no = 1;
        $row = 8;
        $data_report = $this->CI->Reporting_model->summary_xlsx_crm($bsn_date);

        foreach ($data_report as $data_report_iso) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $data_report_iso->terminal_name);
            $sheet->setCellValue('C' . $row, $data_report_iso->amount_wdl);
            $spreadsheet->getActiveSheet()->getStyle('C' . $row)->getNumberFormat()->setFormatCode('#,##0');
            //$sheet->setCellValue('D' . $row, $data_report_iso->surcharge_fee_wdl);
            $sheet->setCellValue('D' . $row, $data_report_iso->txn_wdl);
            //$sheet->setCellValue('F' . $row, $data_report_iso->proc_fee_wdl);
            //$spreadsheet->getActiveSheet()->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->setCellValue('E' . $row, $data_report_iso->txn_inq);
            //$sheet->setCellValue('H' . $row, $data_report_iso->proc_fee_inq);
            $sheet->setCellValue('F' . $row, $data_report_iso->amount_deposit);
            $spreadsheet->getActiveSheet()->getStyle('F' . $row)->getNumberFormat()->setFormatCode('#,##0');

            $sheet->setCellValue('G' . $row, $data_report_iso->txn_deposit);


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

        // $sintaxamountrsp = sprintf("= SUM(H%s:H%s)", 8, $total_row - 1);
        // $sheet->setCellValue('H' . $total_row, $sintaxamountrsp);
        // $spreadsheet->getActiveSheet()->getStyle('H' . $total_row)->getNumberFormat()->setFormatCode('#,##0');

        // $sintaxamountrsp = sprintf("= SUM(I%s:I%s)", 8, $total_row - 1);
        // $sheet->setCellValue('I' . $total_row, $sintaxamountrsp);
        // $spreadsheet->getActiveSheet()->getStyle('I' . $total_row)->getNumberFormat()->setFormatCode('#,##0');

        // $sintaxamountrsp = sprintf("= SUM(J%s:J%s)", 8, $total_row - 1);
        // $sheet->setCellValue('J' . $total_row, $sintaxamountrsp);
        // $spreadsheet->getActiveSheet()->getStyle('J' . $total_row)->getNumberFormat()->setFormatCode('#,##0');

        // $sintaxamountrsp = sprintf("= SUM(K%s:K%s)", 8, $total_row - 1);
        // $sheet->setCellValue('K' . $total_row, $sintaxamountrsp);
        // $spreadsheet->getActiveSheet()->getStyle('K' . $total_row)->getNumberFormat()->setFormatCode('#,##0');

        // $sintaxamountrsp = sprintf("= SUM(L%s:L%s)", 8, $total_row - 1);
        // $sheet->setCellValue('L' . $total_row, $sintaxamountrsp);
        // $spreadsheet->getActiveSheet()->getStyle('L' . $total_row)->getNumberFormat()->setFormatCode('#,##0');


        $formatcell = sprintf("A%s:G%s", 8, $total_row);
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
            ->getStyle('A6:G' . $total_row)
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

        $sheet->getStyle('A6:G' . $total_row)->applyFromArray($styleArray);


        $writer = new Xlsx($spreadsheet);
        //ob_end_clean();

        $filename = 'summary-batch' . $batch_crm;

        // $settle_date = date('Y-m-d', (strtotime('+1 day', strtotime($bsn_date))));
        // $v_dir = $this->CI->config->item('global_dir') . str_replace("-", "", $settle_date) . '\\CRM';
        $settle_date = date('Ymd', (strtotime('+1 day', strtotime($bsn_date))));
        $v_dir = $this->CI->config->item('global_dir') . '\\ATMI\\Cardless\\' 
                            . substr($settle_date,0,4) 
                            . '\\' 
                            . substr($settle_date,4,2). substr($settle_date,2,2)  
                            . '\\' 
                            . substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);
        //$v_dir = $this->CI->config->item('global_dir') . $bsn_date . "\\CRM";
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $filename = $v_dir . '\\' . $filename . '.xlsx';

        $writer->save($filename);
        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE DETAIL SUMMARY ATMI-CRM ==> DONE');
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate summary-batch has been successfully");
        //redirect('/reporting/iso');

        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // $writer->save('php://output');
    }

    function excel_summary_ptpr($bsn_date)
    {
        $this->CI->insertlog->get_log($bsn_date, 'Generate Summary PTPR');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle("PT. Alto Network");;
        $sheet->setCellValue('B2', 'PT. Alto Network');
        $sheet->setCellValue('B3', 'Transaction Type : All');
        $sheet->setCellValue('B4', 'Report Activity (Batch ' . $bsn_date . ')');



        $formatcell = sprintf("A%s:L%s", 1, 7);
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

        $sheet->setCellValue('K6', 'Cardbase Deposit');
        $spreadsheet->getActiveSheet()->mergeCells('K6:K6');
        $spreadsheet->getActiveSheet()->getStyle('K6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('K7', 'TXN');
        $sheet->setCellValue('L7', 'Proc Fee');


        $spreadsheet->getActiveSheet()->getStyle('C7:L7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(26);
        $sheet->getColumnDimension('C')->setAutoSize(true);

        $no = 1;
        $row = 8;
        $data_report = $this->CI->Reporting_model->summary_xlsx_ptpr($bsn_date);

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
            $sheet->setCellValue('K' . $row, $data_report_iso->txn_deposit);
            $sheet->setCellValue('L' . $row, $data_report_iso->proc_fee_deposit);
            $spreadsheet->getActiveSheet()->getStyle('L' . $row)->getNumberFormat()->setFormatCode('#,##0');

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

        $sintaxamountrsp = sprintf("= SUM(K%s:K%s)", 8, $total_row - 1);
        $sheet->setCellValue('K' . $total_row, $sintaxamountrsp);
        $spreadsheet->getActiveSheet()->getStyle('K' . $total_row)->getNumberFormat()->setFormatCode('#,##0');

        $sintaxamountrsp = sprintf("= SUM(L%s:L%s)", 8, $total_row - 1);
        $sheet->setCellValue('L' . $total_row, $sintaxamountrsp);
        $spreadsheet->getActiveSheet()->getStyle('L' . $total_row)->getNumberFormat()->setFormatCode('#,##0');


        $formatcell = sprintf("A%s:L%s", 8, $total_row);
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
            ->getStyle('A6:L' . $total_row)
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

        $sheet->getStyle('A6:L' . $total_row)->applyFromArray($styleArray);


        $writer = new Xlsx($spreadsheet);
        //ob_end_clean();

        $filename = 'ptpr-summary-batch' . $bsn_date;

        $settle_date = date('Ymd', (strtotime('+1 day', strtotime($bsn_date))));
        $v_dir = $this->CI->config->item('global_dir') . '\\PTPR\\' 
                            . substr($settle_date,0,4) 
                            . '\\' 
                            . substr($settle_date,4,2). substr($settle_date,2,2)  
                            . '\\' 
                            . substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);

        // $settle_date = date('Y-m-d', (strtotime('+1 day', strtotime($bsn_date))));
        // $v_dir = $this->CI->config->item('global_dir') . str_replace("-", "", $settle_date) . '\\PTPR';
        //$v_dir = $this->CI->config->item('global_dir') . $bsn_date . "\\PTPR";
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $filename = $v_dir . '\\' . $filename . '.xlsx';

        $writer->save($filename);
        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE DETAIL SUMMARY PTPR ==> DONE');
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate summary-batch has been successfully");
        //redirect('/reporting/iso');

        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // $writer->save('php://output');
    }

    function excel_vault($bsn_date)
    {
        $this->CI->insertlog->get_log($bsn_date, 'Generate Vault Settlement ATMI');
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



        // $settlement_amount = $this->CI->Reporting_model->vault_settlement_xlsx($bsn_date);
        $settlement_amount = $this->CI->Reporting_model->vault_settlement_xlsx($bsn_date)->amount;
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
        //ob_end_clean();



        $filename = 'vaultsettlement-atmi-' . $bsn_date;

        //download file
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // header("Location: http://localhost:81/new_web_monitoring_atmi/reporting/iso");
        //$writer->save('php://output');

        $settle_date = date('Ymd', (strtotime('+1 day', strtotime($bsn_date))));
        $v_dir = $this->CI->config->item('global_dir') . '\\ATMI\\' 
                            . substr($settle_date,0,4) 
                            . '\\' 
                            . substr($settle_date,4,2). substr($settle_date,2,2)  
                            . '\\' 
                            . substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);
        // $settle_date = date('Y-m-d', (strtotime('+1 day', strtotime($bsn_date))));
        // $v_dir = $this->CI->config->item('global_dir') . str_replace("-", "", $settle_date) . '\\ATMI';
        //$v_dir = $this->CI->config->item('global_dir') . $bsn_date . "\\ATMI";
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $filename = $v_dir . '\\' . $filename . '.xlsx';
        $writer->save($filename);
        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE VAULT SETTLEMENT ATMI ==> DONE');
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate vaultsettlement has been successfully");
        //redirect('/reporting/iso');

        // save local server
        // $filename = './files/vaultsettlement'.$bsn_date.'.xlsx';
        // $writer->save($filename);

        // redirect('/reporting/iso');

    }

    function excel_vault_ptpr($bsn_date)
    {
        $this->CI->insertlog->get_log($bsn_date, 'Generate Vault Settlement PTPR');
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

        $sheet->setCellValue('A9', 'Dengan ini kami kirimkan Laporan Settlement dari PT. Alto Network');
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



        // $settlement_amount = $this->CI->Reporting_model->vault_settlement_xlsx($bsn_date);
        $settlement_amount = $this->CI->Reporting_model->vault_settlement_xlsx_ptpr($bsn_date)->amount;
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
        $sheet->setCellValue('E13', 'Settlement_PTPR');

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
        //ob_end_clean();



        $filename = 'ptpr-settlement' . $bsn_date;

        //download file
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // header("Location: http://localhost:81/new_web_monitoring_atmi/reporting/iso");
        //$writer->save('php://output');

        // $settle_date = date('Y-m-d', (strtotime('+1 day', strtotime($bsn_date))));
        // $v_dir = $this->CI->config->item('global_dir') . str_replace("-", "", $settle_date) . '\\PTPR';
        $settle_date = date('Ymd', (strtotime('+1 day', strtotime($bsn_date))));
        $v_dir = $this->CI->config->item('global_dir') . '\\PTPR\\' 
                            . substr($settle_date,0,4) 
                            . '\\' 
                            . substr($settle_date,4,2). substr($settle_date,2,2)  
                            . '\\' 
                            . substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);
        //$v_dir = $this->CI->config->item('global_dir') . $bsn_date . "\\PTPR";
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $filename = $v_dir . '\\' . $filename . '.xlsx';
        $writer->save($filename);
        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE VAULT SETTLEMENT PTPR ==> DONE');
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate vaultsettlement has been successfully");
        //redirect('/reporting/iso');

        // save local server
        // $filename = './files/vaultsettlement'.$bsn_date.'.xlsx';
        // $writer->save($filename);

        // redirect('/reporting/iso');

    }

    function excel_fee($bsn_date)
    {
        $this->CI->insertlog->get_log($bsn_date, 'Generate Fee ATMI');
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



        // $settlement_amount = $this->CI->Reporting_model->vault_settlement_xlsx($bsn_date);
        $settlement_amount = $this->CI->Reporting_model->fee_settlement_xlsx($bsn_date)->amount;
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
        //ob_end_clean();



        $filename = 'atmi-fee-' . $bsn_date;

        //download file
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // header("Location: http://localhost:81/new_web_monitoring_atmi/reporting/iso");
        //$writer->save('php://output');

        // $settle_date = date('Y-m-d', (strtotime('+1 day', strtotime($bsn_date))));
        // $v_dir = $this->CI->config->item('global_dir') . str_replace("-", "", $settle_date) . '\\ATMI';
        $settle_date = date('Ymd', (strtotime('+1 day', strtotime($bsn_date))));
        $v_dir = $this->CI->config->item('global_dir') . '\\ATMI\\' 
                            . substr($settle_date,0,4) 
                            . '\\' 
                            . substr($settle_date,4,2). substr($settle_date,2,2)  
                            . '\\' 
                            . substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);
        //$v_dir = $this->CI->config->item('global_dir') . $bsn_date . "\\ATMI";
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $filename = $v_dir . '\\' . $filename . '.xlsx';
        $writer->save($filename);
        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE FEE SETTLEMENT ATMI ==> DONE');
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate fee settlement has been successfully");
        //redirect('/reporting/iso');

        // save local server
        // $filename = './files/vaultsettlement'.$bsn_date.'.xlsx';
        // $writer->save($filename);

        // redirect('/reporting/iso');

    }

    function excel_fee_ptpr($bsn_date)
    {
        $this->CI->insertlog->get_log($bsn_date, 'Generate Fee PTPR');
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
        // $sheet->setCellValue('A7', 'Fax No');

        $sheet->setCellValue('B5', ': PT. Rajawali Telekomunikasi Seluler');
        $sheet->setCellValue('B6', ': Operations RTS');
        // $sheet->setCellValue('B7', ': 2953-3277');

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



        // $settlement_amount = $this->CI->Reporting_model->vault_settlement_xlsx($bsn_date);
        $settlement_amount = $this->CI->Reporting_model->fee_settlement_xlsx_ptpr($bsn_date)->amount;
        $amount = (float)$settlement_amount;
        $caption = terbilang($amount);

        $sheet->setCellValue('A12', 'No');
        $sheet->setCellValue('B12', 'No. Rekening');
        $sheet->setCellValue('C12', 'Pemilik Rekening');
        $sheet->setCellValue('D12', 'Jumlah');
        $sheet->setCellValue('E12', 'Keterangan');

        $sheet->setCellValue('A13', '1');
        $sheet->setCellValue('B13', 'BCA KCU Denpasar 0408787222');

        $sheet->setCellValue('C13', 'PT RAJAWALI TELEKOMUNIKASI SELULAR');
        $sheet->setCellValue('D13', $amount);
        $spreadsheet->getActiveSheet()->getStyle('D13')->getNumberFormat()->setFormatCode('#,##0');
        $sheet->setCellValue('E13', 'Settlement_PTPR');

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
        //ob_end_clean();



        $filename = 'ptpr-fee-' . $bsn_date;

        //download file
        // header('Content-Type: application/vnd.ms-excel');
        // header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        // header('Cache-Control: max-age=0');
        // header("Location: http://localhost:81/new_web_monitoring_atmi/reporting/iso");
        //$writer->save('php://output');

        // $settle_date = date('Y-m-d', (strtotime('+1 day', strtotime($bsn_date))));
        // $v_dir = $this->CI->config->item('global_dir') . str_replace("-", "", $settle_date) . '\\PTPR';

        $settle_date = date('Ymd', (strtotime('+1 day', strtotime($bsn_date))));
        $v_dir = $this->CI->config->item('global_dir') . '\\PTPR\\' 
                            . substr($settle_date,0,4) 
                            . '\\' 
                            . substr($settle_date,4,2). substr($settle_date,2,2)  
                            . '\\' 
                            . substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);
        //$v_dir = $this->CI->config->item('global_dir') . $bsn_date . "\\PTPR";
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $filename = $v_dir . '\\' . $filename . '.xlsx';
        $writer->save($filename);
        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE FEE SETTLEMENT PTPR ==> DONE');
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate fee settlement has been successfully");
        //redirect('/reporting/iso');

        // save local server
        // $filename = './files/vaultsettlement'.$bsn_date.'.xlsx';
        // $writer->save($filename);

        // redirect('/reporting/iso');

    }


    function pdf_fee($bsn_date)
    {
        // $mpdf = new Mpdf();
        //$mpdf = new \Mpdf\Mpdf();
        $this->CI->insertlog->get_log($bsn_date, 'Generate PDF Fee ATMI');
        $settlement_amount = $this->CI->Reporting_model->fee_settlement_xlsx($bsn_date)->amount;
        $amount = (float)$settlement_amount;
        $caption = terbilang($amount);

        $data = array(
            'sign_by'            => 'Ratna Sari Dewi',
            'amount'             => number_format($amount, 0),
            'terbilang'          => $caption,
        );
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
        // $html = $this->load->view('pdf/html_to_pdf',[],true);
        $html = $this->CI->load->view('pdf/html_to_pdf', $data, true);
        $mpdf->WriteHTML($html);
        //$mpdf->Output(); // opens in browser
        //$mpdf->Output('Settlement Fee ACQ ATMi.pdf','D'); // it downloads the file into the user system, with give name

        // save local server
        // $mpdf->Output('files/Settlement Fee ACQ ATMi.pdf', \Mpdf\Output\Destination::FILE);
        // $settle_date = date('Y-m-d', (strtotime('+1 day', strtotime($bsn_date))));
        // $v_dir = $this->CI->config->item('global_dir') . str_replace("-", "", $settle_date) . '\\ATMI';

        $settle_date = date('Ymd', (strtotime('+1 day', strtotime($bsn_date))));
        $v_dir = $this->CI->config->item('global_dir') . '\\ATMI\\' 
                            . substr($settle_date,0,4) 
                            . '\\' 
                            . substr($settle_date,4,2). substr($settle_date,2,2)  
                            . '\\' 
                            . substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);

        //$v_dir = $this->CI->config->item('global_dir') . $bsn_date . "\\ATMI";
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $settle_date = date('Y-m-d', (strtotime('+1 day', strtotime($bsn_date))));
        $bsn_date = substr($settle_date, 8) . substr($settle_date, 5, 2) . substr($settle_date, 2, 2);
        $output = $v_dir . '\\' . 'Settlement Fee ACQ ATMi ' . $bsn_date . '.pdf';
        $mpdf->Output($output, \Mpdf\Output\Destination::FILE);
        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE PDF FEE ATMI ==> DONE');
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate fee settlement pdf has been successfully");
        //redirect('/reporting/iso');

        // directo download
        //$mpdf->Output('Settlement Fee ACQ ATMi ' . $bsn_date . '.pdf', \Mpdf\Output\Destination::DOWNLOAD);

        // redirect('/reporting/iso');
    }

    function pdf_fee_ptpr($bsn_date)
    {
        // $mpdf = new Mpdf();
        //$mpdf = new \Mpdf\Mpdf();
        // wh_log(date("Y-m-d H:i:s") . " ===> " . "Generate PDF Fee PTPR");
        $this->CI->insertlog->get_log($bsn_date, 'Generate PDF Fee PTPR');
        $settlement_amount = $this->CI->Reporting_model->fee_settlement_xlsx_ptpr($bsn_date)->amount;
        $amount = (float)$settlement_amount;
        $caption = terbilang($amount);

        $data = array(
            'sign_by'            => 'Ratna Sari Dewi',
            'amount'             => number_format($amount, 0),
            'terbilang'          => $caption,
        );
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
        // $html = $this->load->view('pdf/html_to_pdf',[],true);
        $html = $this->CI->load->view('pdf/html_to_pdf_ptpr', $data, true);
        $mpdf->WriteHTML($html);
        //$mpdf->Output(); // opens in browser
        //$mpdf->Output('Settlement Fee ACQ ATMi.pdf','D'); // it downloads the file into the user system, with give name

        // save local server
        // $mpdf->Output('files/Settlement Fee ACQ ATMi.pdf', \Mpdf\Output\Destination::FILE);

        // $settle_date = date('Y-m-d', (strtotime('+1 day', strtotime($bsn_date))));
        // $v_dir = $this->CI->config->item('global_dir') . str_replace("-", "", $settle_date) . '\\PTPR';

        $settle_date = date('Ymd', (strtotime('+1 day', strtotime($bsn_date))));
        $v_dir = $this->CI->config->item('global_dir') . '\\PTPR\\' 
                            . substr($settle_date,0,4) 
                            . '\\' 
                            . substr($settle_date,4,2). substr($settle_date,2,2)  
                            . '\\' 
                            . substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);
        //$v_dir = $this->CI->config->item('global_dir') . $bsn_date . "\\PTPR";
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $settle_date = date('Y-m-d', (strtotime('+1 day', strtotime($bsn_date))));
        $bsn_date = substr($settle_date, 8) . substr($settle_date, 5, 2) . substr($settle_date, 2, 2);
        $output = $v_dir . '\\' . 'Settlement Fee ACQ PTPR ' . $bsn_date . '.pdf';
        $mpdf->Output($output, \Mpdf\Output\Destination::FILE);
        wh_log(date("Y-m-d H:i:s") . " ===> " . 'GENERATE PDF FEE PTPR ==> DONE');
        //$this->CI->session->set_flashdata('messagegeneratereport', "Generate fee settlement pdf has been successfully");
        //redirect('/reporting/iso');

        // directo download
        //$mpdf->Output('Settlement Fee ACQ ATMi ' . $bsn_date . '.pdf', \Mpdf\Output\Destination::DOWNLOAD);

        // redirect('/reporting/iso');
    }

    function send_mail_report($dir_rpt,$bsn_date)
    {
        $settle_date = date('Ymd');
        $v_datenow = substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);

        $email = new sendmail();
        // $v_email = new sendmail();

        // $filename = site_url('/assets/images/logo_email_alto.png');
        $filename = './assets/images/logo_email_alto.png';
        $this->CI->email->attach($filename);
        $cidx = $this->CI->email->attachment_cid($filename);

        $body_mail = '<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    </head>
    
    <body
        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; color: #74787E; height: 100%; hyphens: auto; line-height: 1.4; margin: 0; -moz-hyphens: auto; -ms-word-break: break-all; width: 100% !important; -webkit-hyphens: auto; -webkit-text-size-adjust: none; word-break: break-word;">
        <style>
            @media only screen and (max-width: 600px) {
                .inner-body {
                    width: 100% !important;
                }
    
                .footer {
                    width: 100% !important;
                }
            }
    
            @media only screen and (max-width: 500px) {
                .button {
                    width: 100% !important;
                }
            }
        </style>
        
        <table>
            <tr>
                <td>
                Dengan Hormat,<br><br>   
                Berikut kami kirimkan Report transaksi di ATMi dan berkas settlement untuk periode tanggal 061221.<br> 
                Terlampir detail transaksi di ATMi, detail transaksi reject, Report ATMi CRM dan terlampir juga detail transaksi di PTPR, detail transaksi reject PTPR.<br><br><br>
                </td>
            </tr>
        </table>

        <table >
                                    
            <tr>
            <td>Best Regards,</td>
            </tr>
<tr>
                <td>
                    <img src="cid:my-attach" alt="photo1" />
                </td>   
            </tr>
            
        </table>
        
    </body>
    
    </html>
        ';

        // $report_file[] = array(
        //     'user_request'      => 'hari03',
        //     'package_selected'  => $row,
        //     'date_request'      => $now->format("Y-m-d H:i:s.v"),
        //     'status'            => 'Requested',
        //     'invoice_no'        => '#BTN'.$now->format("YmdHisv")
        // );

        //send email with php  
        $email->v_to_email  = 'hari@alto.id';
        // $email->v_cc        = 'hari@alto.id';
        $email->v_subject   = 'Report ATMi - '.$v_datenow;
        $email->v_message   = $body_mail;
        $email->v_attach    = $dir_rpt;
        $email->_send("with-attachment");

        // send email with java
        // $email->v_to_email = 'hari@alto.id';
        // $email->v_cc       = 'dprayoga@alto.id';
        // $email->v_subject  = 'Report ATMi - '.$bsn_date;
        // $email->v_message  = $body_mail;
        // $email->_save_mail("true","atmi");
    }

    function send_mail_report_ptpr($dir_rpt_ptpr,$bsn_date)
    {
        $settle_date = date('Ymd');
        $v_datenow = substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);

        $settle_date = date('Ymd', (strtotime('-1 day', strtotime($bsn_date))));
        $v_dateprev = substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);

        $email = new sendmail();
        // $v_email = new sendmail();

        //$filename = site_url('/assets/images/logo_email_alto.png');
        $filename = './assets/images/logo_email_alto.png';
        $this->CI->email->attach($filename);
        $cidx = $this->CI->email->attachment_cid($filename);

        $body_mail = '<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    </head>
    
    <body
        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; color: #74787E; height: 100%; hyphens: auto; line-height: 1.4; margin: 0; -moz-hyphens: auto; -ms-word-break: break-all; width: 100% !important; -webkit-hyphens: auto; -webkit-text-size-adjust: none; word-break: break-word;">
        <style>
            @media only screen and (max-width: 600px) {
                .inner-body {
                    width: 100% !important;
                }
    
                .footer {
                    width: 100% !important;
                }
            }
    
            @media only screen and (max-width: 500px) {
                .button {
                    width: 100% !important;
                }
            }
        </style>
        
        <table>
            <tr>
                <td>
                Dengan Hormat,<br>
                Dear Tim,<br><br>   
                Berikut kami kirimkan Report transaksi PTPR dan berkas settlement untuk periode tanggal '.$v_datenow.' (transaksi tanggal '.$v_dateprev.')<br> 
                Terlampir detail transaksi di PTPR dan detail transaksi reject PTPR.<br><br>
                NB: berkas settlement akan dikirimkan email terpisah.<br><br>
                </td>
            </tr>
        </table>

        <table >
                                    
            <tr>
            <td>Best Regards,</td>
            </tr>
            <tr>
                <td>
                    <img src="cid:my-attach" alt="photo1" />
                </td>   
            </tr>
            
        </table>
        
    </body>
    
    </html>
        ';

        // $report_file[] = array(
        //     'user_request'      => 'hari03',
        //     'package_selected'  => $row,
        //     'date_request'      => $now->format("Y-m-d H:i:s.v"),
        //     'status'            => 'Requested',
        //     'invoice_no'        => '#BTN'.$now->format("YmdHisv")
        // );

        //send email with php  
        $email->v_to_email  = 'hari@alto.id';
        // $email->v_cc        = 'hari@alto.id';
        $email->v_subject   = 'Report PTPR - '.$v_datenow;
        $email->v_message   = $body_mail;
        $email->v_attach    = $dir_rpt_ptpr;
        $email->_send("with-attachment");

        // send email with java
        // $email->v_to_email = 'hari@alto.id';
        // $email->v_cc       = 'dprayoga@alto.id';
        // $email->v_subject  = 'Report PTPR - '.$bsn_date;
        // $email->v_message  = $body_mail;
        // $email->_save_mail("true","ptpr");
    }

    function send_mail_running_scheduler($bsn_date)
    {
        $settle_date = date('Ymd');
        // $v_datenow = substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);
        $v_datenow = date('Y-m-d H:i:s');
        // $settle_date = date('Ymd', (strtotime('-1 day', strtotime($bsn_date))));
        // $v_dateprev = substr($settle_date,6,2). substr($settle_date,4,2). substr($settle_date,2,2);


        $v_dateprev = substr($bsn_date,6,2). substr($bsn_date,4,2). substr($bsn_date,2,2);

        $email = new sendmail();
        // $v_email = new sendmail();

        //$filename = site_url('/assets/images/logo_email_alto.png');
        $filename = './assets/images/logo_email_alto.png';
        $this->CI->email->attach($filename);
        $cidx = $this->CI->email->attachment_cid($filename);

        $body_mail = '<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    </head>
    
    <body
        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; color: #74787E; height: 100%; hyphens: auto; line-height: 1.4; margin: 0; -moz-hyphens: auto; -ms-word-break: break-all; width: 100% !important; -webkit-hyphens: auto; -webkit-text-size-adjust: none; word-break: break-word;">
        <style>
            @media only screen and (max-width: 600px) {
                .inner-body {
                    width: 100% !important;
                }
    
                .footer {
                    width: 100% !important;
                }
            }
    
            @media only screen and (max-width: 500px) {
                .button {
                    width: 100% !important;
                }
            }
        </style>
        
        <table>
            <tr>
                <td>
                Scheduler has been started at '.$v_datenow.'
                </td>
            </tr>
        </table>

        <table >
                                    
            <tr>
            <td>Best Regards,</td>
            </tr>
            <tr>
                <td>
                    <img src="cid:my-attach" alt="photo1" />
                </td>   
            </tr>
            
        </table>
        
    </body>
    
    </html>
        ';

        // $report_file[] = array(
        //     'user_request'      => 'hari03',
        //     'package_selected'  => $row,
        //     'date_request'      => $now->format("Y-m-d H:i:s.v"),
        //     'status'            => 'Requested',
        //     'invoice_no'        => '#BTN'.$now->format("YmdHisv")
        // );

        //send email with php  
        $email->v_to_email  = 'sri@alto.id';
        $email->v_cc        = 'hari@alto.id;ulfa@alto.id;rafent@alto.id';
        $email->v_subject   = 'Running Scheduler - '.$v_datenow;
        $email->v_message   = $body_mail;
        $email->v_attach    = "";
        $email->_send();

        // send email with java
        // $email->v_to_email = 'hari@alto.id';
        // $email->v_cc       = 'dprayoga@alto.id';
        // $email->v_subject  = 'Report PTPR - '.$bsn_date;
        // $email->v_message  = $body_mail;
        // $email->_save_mail("true","ptpr");
    }


    

    function send_mail_rcs_approve($data)
    {
        $email = new sendmail();

        $filename = './assets/images/logo_email_alto.png';
        $this->CI->email->attach($filename);
        $cidx = $this->CI->email->attachment_cid($filename);

        $body_mail = '<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    </head>
    
    <body
        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; color: #74787E; height: 100%; hyphens: auto; line-height: 1.4; margin: 0; -moz-hyphens: auto; -ms-word-break: break-all; width: 100% !important; -webkit-hyphens: auto; -webkit-text-size-adjust: none; word-break: break-word;">
        <style>
            @media only screen and (max-width: 600px) {
                .inner-body {
                    width: 100% !important;
                }
    
                .footer {
                    width: 100% !important;
                }
            }
    
            @media only screen and (max-width: 500px) {
                .button {
                    width: 100% !important;
                }
            }
        </style>
        
        <table>
            <tr>
                <td>
                Dear Rekan (Bank Name), ,
                </td>
            </tr>

            <tr>
                <td>
                <br>Dengan ini kami sampaikan bahwa, pembayaran atas request topup quota bright telah berhasil dilakukan. Dengan detail sebagai berikut: <br><br>
                    -	User Request: '.$data['user_request'].'<br>
                    -	Date Request: '.$data['date_request'].'<br>
                    -	Request No: '.$data['invoice_no'].'<br>
                    -	Package Name: '.$data['package_selected'].'<br>

                </td>
            </tr>

            <tr>
                <td>
                <br>Atas perhatiaannya kami sampaikan, terima kasih.  <br>
                <br><br>
                Atas perhatiaannya kami sampaikan, terima kasih.
                </td>
            </tr>
        </table>

        <table >
                                    
            <tr>
            <td>Best Regards,</td>
            </tr>
            <tr>
                <td>
                    <img src="cid:my-attach" alt="photo1" />
                </td>   
            </tr>
            
        </table>
        
    </body>
    
    </html>
        ';

        // $report_file[] = array(
        //     'user_request'      => 'hari03',
        //     'package_selected'  => $row,
        //     'date_request'      => $now->format("Y-m-d H:i:s.v"),
        //     'status'            => 'Requested',
        //     'invoice_no'        => '#BTN'.$now->format("YmdHisv")
        // );

        //send email with php  
        $email->v_to_email  = 'hari@alto.id';
        // $email->v_cc        = 'hari@alto.id;ulfa@alto.id;rafent@alto.id';
        $email->v_subject   = 'Payment Confirmation Notification - '.$data['invoice_no'];
        $email->v_message   = $body_mail;
        $email->v_attach    = "";
        $email->_send();

        // send email with java
        // $email->v_to_email = 'hari@alto.id';
        // $email->v_cc       = 'dprayoga@alto.id';
        // $email->v_subject  = 'Report PTPR - '.$bsn_date;
        // $email->v_message  = $body_mail;
        // $email->_save_mail("true","ptpr");
    }

    function send_mail_payment_finance($data)
    {
        $email = new sendmail();

        $filename = './assets/images/logo_email_alto.png';
        $this->CI->email->attach($filename);
        $cidx = $this->CI->email->attachment_cid($filename);

        $body_mail = '<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    </head>
    
    <body
        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; color: #74787E; height: 100%; hyphens: auto; line-height: 1.4; margin: 0; -moz-hyphens: auto; -ms-word-break: break-all; width: 100% !important; -webkit-hyphens: auto; -webkit-text-size-adjust: none; word-break: break-word;">
        <style>
            @media only screen and (max-width: 600px) {
                .inner-body {
                    width: 100% !important;
                }
    
                .footer {
                    width: 100% !important;
                }
            }
    
            @media only screen and (max-width: 500px) {
                .button {
                    width: 100% !important;
                }
            }
        </style>
        
        <table>
            <tr>
                <td>
                Dear Tim RCS ALTO,
                </td>
            </tr>

            <tr>
                <td>
                <br>Member (Bank Name) telah melakukan konfirmasi pembayaran quota bright. Dengan detail sebagai berikut: <br><br>
                    -	User Request: '.$data['user_request'].'<br>
                    -	Date Request: '.$data['date_request'].'<br>
                    -	Request No: '.$data['invoice_no'].'<br>
                    -	Package Name: '.$data['package_selected'].'<br>

                </td>
            </tr>

            <tr>
                <td>
                <br>Mohon untuk segera menyelesaikan pembayaran ke Rekening  berikut: <br>
                Nama Bank: MAYBANK/RTGS<br>
                Nama Perusahaan:<br>
                No Rekening: <br>
                <br><br>
                Atas perhatiaannya kami sampaikan, terima kasih.


                </td>
            </tr>
        </table>

        <table >
                                    
            <tr>
            <td>Best Regards,</td>
            </tr>
            <tr>
                <td>
                    <img src="cid:my-attach" alt="photo1" />
                </td>   
            </tr>
            
        </table>
        
    </body>
    
    </html>
        ';

        // $report_file[] = array(
        //     'user_request'      => 'hari03',
        //     'package_selected'  => $row,
        //     'date_request'      => $now->format("Y-m-d H:i:s.v"),
        //     'status'            => 'Requested',
        //     'invoice_no'        => '#BTN'.$now->format("YmdHisv")
        // );

        //send email with php  
        $email->v_to_email  = 'hari@alto.id';
        // $email->v_cc        = 'hari@alto.id;ulfa@alto.id;rafent@alto.id';
        $email->v_subject   = 'Alert Payment Confirmation - '.$data['invoice_no'];
        $email->v_message   = $body_mail;
        $email->v_attach    = "";
        $email->_send();

        // send email with java
        // $email->v_to_email = 'hari@alto.id';
        // $email->v_cc       = 'dprayoga@alto.id';
        // $email->v_subject  = 'Report PTPR - '.$bsn_date;
        // $email->v_message  = $body_mail;
        // $email->_save_mail("true","ptpr");
    }

    function send_mail_request_topup($data)
    {
        $email = new sendmail();

        $filename = './assets/images/logo_email_alto.png';
        $this->CI->email->attach($filename);
        $cidx = $this->CI->email->attachment_cid($filename);

        $body_mail = '<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    </head>
    
    <body
        style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; color: #74787E; height: 100%; hyphens: auto; line-height: 1.4; margin: 0; -moz-hyphens: auto; -ms-word-break: break-all; width: 100% !important; -webkit-hyphens: auto; -webkit-text-size-adjust: none; word-break: break-word;">
        <style>
            @media only screen and (max-width: 600px) {
                .inner-body {
                    width: 100% !important;
                }
    
                .footer {
                    width: 100% !important;
                }
            }
    
            @media only screen and (max-width: 500px) {
                .button {
                    width: 100% !important;
                }
            }
        </style>
        
        <table>
            <tr>
                <td>
                Dear Tim Finance BTN,
                </td>
            </tr>

            <tr>
                <td>
                <br>Dengan ini kami sampaikan bahwa, request topup quota bright telah submit. Dengan detail sebagai berikut:<br><br>
                    -	User Request: '.$data['user_request'].'<br>
                    -	Date Request: '.$data['date_request'].'<br>
                    -	Request No: '.$data['invoice_no'].'<br>
                    -	Package Name: '.$data['package_selected'].'<br>

                </td>
            </tr>

            <tr>
                <td>
                <br>Mohon untuk segera menyelesaikan pembayaran ke Rekening  berikut: <br>
                Nama Bank: MAYBANK/RTGS<br>
                Nama Perusahaan:<br>
                No Rekening: <br>
                <br><br>
                Atas perhatiaannya kami sampaikan, terima kasih.


                </td>
            </tr>
        </table>

        <table >
                                    
            <tr>
            <td>Best Regards,</td>
            </tr>
            <tr>
                <td>
                    <img src="cid:my-attach" alt="photo1" />
                </td>   
            </tr>
            
        </table>
        
    </body>
    
    </html>
        ';

        // $report_file[] = array(
        //     'user_request'      => 'hari03',
        //     'package_selected'  => $row,
        //     'date_request'      => $now->format("Y-m-d H:i:s.v"),
        //     'status'            => 'Requested',
        //     'invoice_no'        => '#BTN'.$now->format("YmdHisv")
        // );

        //send email with php  
        $email->v_to_email  = 'hari@alto.id';
        // $email->v_cc        = 'hari@alto.id;ulfa@alto.id;rafent@alto.id';
        $email->v_subject   = 'Request Topup Member Bright - ';
        $email->v_message   = $body_mail;
        $email->v_attach    = "";
        $email->_send();

        // send email with java
        // $email->v_to_email = 'hari@alto.id';
        // $email->v_cc       = 'dprayoga@alto.id';
        // $email->v_subject  = 'Report PTPR - '.$bsn_date;
        // $email->v_message  = $body_mail;
        // $email->_save_mail("true","ptpr");
    }
}
