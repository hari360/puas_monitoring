<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Mpdf\Mpdf;

class Tools extends CI_Controller
{

        function __construct()
        {
                parent::__construct();
                $this->load->model('Reporting_model', '', TRUE);
                $this->load->library('csvparser');
                $this->load->library('generatexl');
                $this->load->library('insertlog');
                ini_set('max_execution_time', 0);
                ini_set('memory_limit', '-1');
        }

        public function generate($bsndate = "")
        {
                
                

                

                
                if ($bsndate == "") {
                        //$bsndate = "20211205";
                        $date_now = date('Ymd');
                        $bsndate = date('Ymd', (strtotime('-1 day', strtotime($date_now))));
                }
                $assigned_time = date("Y-m-d H:i:s");
                wh_log(date("Y-m-d H:i:s") . " ===> " . "START JOB SCHEDULER ". $bsndate);
                $this->insertlog->get_log($bsndate, 'START');

                $this->generatexl->send_mail_running_scheduler($bsndate);
                wh_log(date("Y-m-d H:i:s") . " ===> " . "SEND MAIL RUNNING SCHEDULE");
                $this->insertlog->get_log($bsndate, 'SEND MAIL RUNNING SCHEDULE');


                $this->generatexl->excel($bsndate);
                $this->generatexl->excel_atmi_ptpr($bsndate);
                $this->generatexl->excel_crm($bsndate, 'cardless');
                $this->generatexl->excel_crm($bsndate, 'deposit');
                $this->generatexl->excel_ptpr($bsndate);
                
                $this->generatexl->excel_reject_atmi($bsndate);
                $this->generatexl->excel_reject_atmi_ptpr($bsndate);
                $this->generatexl->excel_reject_crm($bsndate);
                $this->generatexl->excel_reject_ptpr($bsndate);

                $this->generatexl->excel_summary_atmi($bsndate);
                $this->generatexl->excel_summary_crm($bsndate);
                $this->generatexl->excel_summary_ptpr($bsndate);

                $this->generatexl->excel_vault($bsndate);
                $this->generatexl->excel_vault_ptpr($bsndate);

                $this->generatexl->excel_fee($bsndate);
                $this->generatexl->excel_fee_ptpr($bsndate);

                $this->generatexl->pdf_fee($bsndate);
                $this->generatexl->pdf_fee_ptpr($bsndate);
                
                /*test send mail
                $email = new sendmail();

                $email->v_to_email = 'hari@alto.id';
                $email->v_subject  = 'Daily Reporting ATMI';
                $email->v_message  = 'Dear All, <br> attached file reporting batch '.$bsndate;
                $email->_send();
                */

                $this->generatexl->send_mail_report('ATMI',$bsndate);
                wh_log(date("Y-m-d H:i:s") . " ===> " . "SEND MAIL ATMI SUCCESS");
                $this->insertlog->get_log($bsndate, 'SEND MAIL ATMI SUCCESS');
                
                $this->generatexl->send_mail_report_ptpr('PTPR',$bsndate);
                wh_log(date("Y-m-d H:i:s") . " ===> " . "SEND MAIL PTPR SUCCESS");
                $this->insertlog->get_log($bsndate, 'SEND MAIL PTPR SUCCESS');

                ob_end_clean();
                echo "Generate Report ".$bsndate." Has Done";
                $completed_time= date("Y-m-d H:i:s");   
                $d1 = new DateTime($assigned_time);
                $d2 = new DateTime($completed_time);
                $interval = $d2->diff($d1);

                //echo $interval->format('%d days, %H hours, %I minutes, %S seconds');
                //echo timespan('2021-12-08 08:32:00', '2021-12-08 08:40:00');
                //die();
                wh_log(date("Y-m-d H:i:s") . " ===> " . "END JOB SCHEDULER WITH DURATION : ".$interval->format('%d days, %H hours, %I minutes, %S seconds'));
                $this->insertlog->get_log($bsndate, 'FINISH : '.$interval->format('%d days, %H hours, %I minutes, %S seconds'));
        }

        
}
