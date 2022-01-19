<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Historyflmslm extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Postilioncrm_model', '', TRUE);
  }

  function index()
  { 
    $data = array(
        'title'               => 'Monitoring-History FLM/SLM',
        'header_view'         => 'header_view',
        'content_view'        => 'crm/history_flm_slm',
        'sub_header_title'    => 'History Flm Slm',
        'header_title'        => 'HISTORY FLM SLM',
        'username'            => $this->session->userdata('logged_full_name'),
        'lastlogin'           => $this->session->userdata('logged_last_login'),
        // 'table'               => $this->table->generate(),
    );

    $terms = $this->Postilioncrm_model->get_history_flm_slm();

    $tmpl = array(
        'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_crm_history_flm_slm" width="100%">',
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
	$this->table->set_heading('Terminal ID'
                              ,'Terminal Name'
                              ,'ATMi Problem'
                              ,'Vendor'
                              ,'Description'
                              ,'Date/Time Problem'
                              ,'Type');
    foreach ($terms as $term) 
    {
      $this->table->add_row($term->terminal_id, 
                            $term->short_name,
                            $term->atmi_problem,
                            $term->vendor,                           
                            $term->description,
                            $term->date_time_problem,
                            $term->type
      ); 
    }
    $data['table_crm_flm_slm'] = $this->table->generate();
    $this->load->view('template', $data);
  }

  function download_excel()
  {
			$spreadsheet = new Spreadsheet();
      $terms = $this->Postilioncrm_model->get_history_flm_slm();

      $i = 1;
      $spreadsheet->setActiveSheetIndex(0)
                                  ->setCellValue('A1', 'No')
                                  ->setCellValue('B1', 'Terminal ID')
                                  ->setCellValue('C1', 'Terminal Name')
                                  ->setCellValue('D1', 'ATMi Problem')
                                  ->setCellValue('E1', 'Vendor')
                                  ->setCellValue('F1', 'Description')
                                  ->setCellValue('G1', 'Date/Time Problem')
                                  ->setCellValue('H1', 'Type');

      $formatcell = sprintf("A%s:H%s", 1, 1);
                  $spreadsheet->getActiveSheet()->getStyle($formatcell)->getFont()->setName('Arial');
                  $spreadsheet->getActiveSheet()->getStyle($formatcell)->getFont()->setSize(10);
                  $spreadsheet->getActiveSheet()->freezePane('A2');
                  $spreadsheet->getActiveSheet()->setAutoFilter('A1:H1');
      $recno = 0;
            foreach ($terms as $term)
            {
                $recno++;
                    $x = ++$i;
                    $spreadsheet->getActiveSheet()->getCell('B'.$x)->setValueExplicit($term->terminal_id, DataType::TYPE_STRING);
                    $spreadsheet->setActiveSheetIndex(0)                                                           
                                        ->setCellValue('A'.$x, $x-1)                                                               
                                        ->setCellValue('C'.$x, $term->short_name)
                                        ->setCellValue('D'.$x, $term->atmi_problem)
                                        ->setCellValue('E'.$x, $term->vendor)
                                        ->setCellValue('F'.$x, $term->description)
                                        ->setCellValue('G'.$x, $term->date_time_problem)
                                        ->setCellValue('H'.$x, $term->type);

            }


            for($col = 'A'; $col !== 'H'; $col++) {
                $spreadsheet->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
            }
            $border_style = array('borders' => array('allborders' 
                            => array('style' => Border::BORDER_THIN)));

            $sheet = $spreadsheet->getActiveSheet();
            $sheet->getStyle("A1:H".$x)->applyFromArray($border_style);

            $sheet->getStyle('A1:H1')->applyFromArray(
                array(
                'fill' => array(
                'type' => Fill::FILL_SOLID,
                'color' => array('rgb' => '808080')
                )
                )
            );

      $spreadsheet->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
            
      $spreadsheet->getActiveSheet()->setTitle('History Data FLM_SLM');
			$writer = new Xlsx($spreadsheet);
            ob_end_clean();
			$filename = 'History Data FLM / SLM';
			
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
			header('Cache-Control: max-age=0');


	
			$writer->save('php://output');
		}

}
