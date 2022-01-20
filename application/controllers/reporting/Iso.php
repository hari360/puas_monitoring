<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Iso extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Accounts_model', '', TRUE);
    $this->load->model('Postilion_model', '', TRUE);
  }

  // function stringInsert($str, $insertstr, $pos)
  // {
  //   $str = substr($str, 0, $pos) . $insertstr . substr($str, $pos);
  //   return $str;
  // }

  //   function send(){
  //     // Load PHPMailer library
  //     $this->load->library('sendmail');

  //     // PHPMailer object
  //     $mail = $this->sendmail->load();

  //     // SMTP configuration
  //     $mail->isSMTP();
  //     $mail->Host     = 'smtp.office365.com';
  //     $mail->SMTPAuth = true;
  //     $mail->Username = 'alert@alto.id';
  //     $mail->Password = '4lt0@1234';
  //     $mail->SMTPSecure = 'tls';
  //     $mail->Port     = 587;

  //     $mail->setFrom('alert@alto.id', 'Web ATMI');
  //     // $mail->addReplyTo('info@example.com', 'CodexWorld');

  //     // Add a recipient
  //     $mail->addAddress('hari@alto.id');

  //     // Add cc or bcc 
  //     // $mail->addCC('cc@example.com');
  //     // $mail->addBCC('bcc@example.com');

  //     // Email subject
  //     $mail->Subject = 'Send Email via SMTP using PHPMailer in CodeIgniter';

  //     // Set email format to HTML
  //     $mail->isHTML(true);

  //     // Email body content
  //     $mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
  //         <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
  //     $mail->Body = $mailContent;

  //     // Send email
  //     if(!$mail->send()){
  //         echo 'Message could not be sent.';
  //         echo 'Mailer Error: ' . $mail->ErrorInfo;
  //     }else{
  //         echo 'Message has been sent';
  //     }
  // }

  function index()
  {

    // $lines = file('./uploads/Report ATMI/ATMi_transfer_acq_reject.111121.rpt'); // gets file in array using new lines character
    // echo "/uploads/Report ATMI/ATMi_transfer_acq_reject.111621.rpt"."<br>";
    // $i=0;
    // foreach ($lines as $line) {
    //   if (substr($line, 72, 1) == ":") {
    //     //echo $line.'<br>';
    //     $i++;
    //     $data[] = array(
    //       'bsn_date'          => '111121',
    //       'terminal_id'       => substr($line, 3, 8),
    //       'trace_acq'         => substr($line, 13, 6),
    //       'trace_swt'         => substr($line, 22, 6),
    //       'pan'               => substr($line, 30, 19),
    //       'rcpt_number'       => substr($line, 51, 4),
    //       'date_trans'        => '20'.substr($line, 63, 2).'-'.substr($line, 60, 2).'-'.substr($line, 57, 2).' '.substr($line, 67, 8),
    //       'tran_type'         => substr($line, 77, 6),
    //       //'from_account'      => substr($line, 72, 1),
    //       'to_account'        => trim(substr($line, 85, 18)),
    //       'amount'            => str_replace(",","",substr($line, 105, 20)),
    //       'resp_code'         => trim(substr($line, 129, 2)),
    //       'reject_code'       => trim(substr($line, 135, 2)),
    //       'description_code'  => trim(substr($line, 139, 22)),
    //       'reject_class'      => trim(substr($line, 163, 5)),
    //       'reject_fee'        => trim(substr($line, 170, 6)),
    //       'reference_number'  => trim(substr($line, 178, 18)),
    //       'file_name'         => 'ATMi_transfer_acq_reject.111121.rpt',
    //       'date_insert'       => date("Y-m-d H:i:s"),
    //     );
    //   }
    //   //echo substr($line,69,1).'<br>';
    //   //echo $line;
    // }
    // echo $i."<br>";
    // $this->Postilion_model->insert_from_rpt($data);

    // $lines = file('./uploads/Report ATMI/ATMi_acq_reject.111121.rpt'); // gets file in array using new lines character
    // echo "/uploads/Report ATMI/ATMi_acq_reject.111121.rpt"."<br>";
    // $i=0;
    // foreach ($lines as $line) {
    //   $i++;
    //   if (substr($line, 72, 1) == ":") {
    //     //echo $line.'<br>';
    //     $data2[] = array(
    //       'bsn_date'          => '111621',
    //       'terminal_id'       => substr($line, 3, 8),
    //       'trace_acq'         => substr($line, 13, 6),
    //       'trace_swt'         => substr($line, 22, 6),
    //       'pan'               => substr($line, 30, 19),
    //       'rcpt_number'       => substr($line, 51, 4),
    //       'date_trans'        => '20'.substr($line, 63, 2).'-'.substr($line, 60, 2).'-'.substr($line, 57, 2).' '.substr($line, 67, 8),
    //       'tran_type'         => substr($line, 77, 6),
    //       //'from_account'      => substr($line, 72, 1),
    //       //'to_account'        => trim(substr($line, 85, 18)),
    //       'amount'            => str_replace(",","",substr($line, 85, 16)),
    //       'resp_code'         => trim(substr($line, 121, 4)),
    //       'reject_code'       => trim(substr($line, 127, 2)),
    //       'description_code'  => trim(substr($line, 133, 22)),
    //       'reject_class'      => trim(substr($line, 157, 5)),
    //       'reject_fee'        => trim(substr($line, 164, 6)),
    //       //'reference_number'  => trim(substr($line, 178, 18)),
    //       'file_name'         => 'ATMi_acq_reject.111121.rpt',
    //       'date_insert'       => date("Y-m-d H:i:s"),
    //     );
    //   }
    //   //echo substr($line,69,1).'<br>';

    // }
    // echo $i."<br>";
    // $this->Postilion_model->insert_from_rpt($data2);

    // $lines = file('./uploads/Report ATMI/ATMI AJ/ATMi_transfer_acq_reject.111121.rpt'); // gets file in array using new lines character
    // echo "/uploads/Report ATMI/ATMI AJ/ATMi_transfer_acq_reject.111121.rpt"."<br>";
    // $i=0;
    // foreach ($lines as $line) {
    //   $i++;
    //   if (substr($line, 72, 1) == ":") {
    //     //echo $line.'<br>';
    //     $data3[] = array(
    //       'bsn_date'          => '111121',
    //       'terminal_id'       => substr($line, 3, 8),
    //       'trace_acq'         => substr($line, 13, 6),
    //       'trace_swt'         => substr($line, 22, 6),
    //       'pan'               => substr($line, 30, 19),
    //       'rcpt_number'       => substr($line, 51, 4),
    //       'date_trans'        => '20'.substr($line, 63, 2).'-'.substr($line, 60, 2).'-'.substr($line, 57, 2).' '.substr($line, 67, 8),
    //       'tran_type'         => substr($line, 77, 6),
    //       //'from_account'      => substr($line, 72, 1),
    //       'to_account'        => trim(substr($line, 85, 18)),
    //       'amount'            => str_replace(",","",substr($line, 105, 20)),
    //       'resp_code'         => trim(substr($line, 129, 2)),
    //       'reject_code'       => trim(substr($line, 135, 2)),
    //       'description_code'  => trim(substr($line, 139, 22)),
    //       'reject_class'      => trim(substr($line, 163, 5)),
    //       'reject_fee'        => trim(substr($line, 170, 6)),
    //       'reference_number'  => trim(substr($line, 178, 18)),
    //       'file_name'         => 'ATMI AJ-ATMi_transfer_acq_reject.111121.rpt',
    //       'date_insert'       => date("Y-m-d H:i:s"),
    //     );
    //   }
    //   //echo substr($line,69,1).'<br>';
    //   //echo $line;
    // }
    // echo $i."<br>";
    // $this->Postilion_model->insert_from_rpt($data3);

    // $lines = file('./uploads/Report ATMI/ATMI AJ/ATMi_acq_reject.111121.rpt'); // gets file in array using new lines character
    // echo "/uploads/Report ATMI/ATMI AJ/ATMi_acq_reject.111121.rpt"."<br>";
    // $i=0;

    // foreach ($lines as $line) {
    //   $i++;
    //   if (substr($line, 72, 1) == ":") {
    //     //echo $line.'<br>';
    //     $data4[] = array(
    //       'bsn_date'          => '111121',
    //       'terminal_id'       => substr($line, 3, 8),
    //       'trace_acq'         => substr($line, 13, 6),
    //       'trace_swt'         => substr($line, 22, 6),
    //       'pan'               => substr($line, 30, 19),
    //       'rcpt_number'       => substr($line, 51, 4),
    //       'date_trans'        => '20'.substr($line, 63, 2).'-'.substr($line, 60, 2).'-'.substr($line, 57, 2).' '.substr($line, 67, 8),
    //       'tran_type'         => substr($line, 77, 6),
    //       //'from_account'      => substr($line, 72, 1),
    //       //'to_account'        => trim(substr($line, 85, 18)),
    //       'amount'            => str_replace(",","",substr($line, 85, 16)),
    //       'resp_code'         => trim(substr($line, 121, 4)),
    //       'reject_code'       => trim(substr($line, 127, 2)),
    //       'description_code'  => trim(substr($line, 133, 22)),
    //       'reject_class'      => trim(substr($line, 157, 5)),
    //       'reject_fee'        => trim(substr($line, 164, 6)),
    //       //'reference_number'  => trim(substr($line, 178, 18)),
    //       'file_name'         => 'ATMI AJ-ATMi_acq_reject.111121.rpt',
    //       'date_insert'       => date("Y-m-d H:i:s"),
    //     );
    //   }
    //   //echo substr($line,69,1).'<br>';
    //   //echo $line;
    // }
    // echo $i."<br>";
    // $this->Postilion_model->insert_from_rpt($data4);
    // die();
    // $assigned_time = "2021-12-08 08:00:00";
    // $completed_time= "2021-12-08 08:15:00";   

    // $d1 = new DateTime($assigned_time);
    // $d2 = new DateTime($completed_time);
    // $interval = $d2->diff($d1);

    // echo $interval->format('%d days, %H hours, %I minutes, %S seconds');
    // //echo timespan('2021-12-08 08:32:00', '2021-12-08 08:40:00');
    // die();
    // copy("\\\\10.9.11.33\\rcs$\\Folder HARI\\Verifikasi New Report ISO\\20211206\\CRM\\detail_cardless-batch2603.xlsx","./attach/ATMI/detail_cardless-batch2603.xlsx");
    // die(site_url('/attach/ATMI/detail_cardless-batch2603.xlsx'));


    // $email = new sendmail();

    //             $email->v_to_email = 'hari@alto.id';
    //             $email->v_subject  = 'Daily Reporting ATMI';
    //             $email->v_message  = 'Dear All, <br><br> Please find attached the reporting file for the ATMI transactions of batch '.'20211118';
    //             $email->_send();
    //             die();
    // $bsn_date = 20211122;
    // echo date('Y-m-d',(strtotime ( '+1 day' , strtotime ( $bsn_date) ) ));
    // die();
    //die(substr_replace(substr_replace($bsn_date, "-", 4, 0),"-",7,0));
    //die($this->stringInsert($bsn_date, "-", 4));
    // $angka = 1530093;
    // echo terbilang($angka);
    // die();
    $terminal_cardbase = $this->Postilion_model->get_iso_terminal('010');
    $term_cardbase = '<optgroup label="Cardbase">';

    foreach ($terminal_cardbase as $data_terminal_cardbase) {
      $term_cardbase .= '<option value="' . $data_terminal_cardbase->id . '">
                        ' . $data_terminal_cardbase->id . ' - ' . $data_terminal_cardbase->short_name . '</option>';
    }
    $term_cardbase .= '</optgroup>';

    $terminal_cardless = $this->Postilion_model->get_iso_terminal('041');
    $term_cardless = '<optgroup label="Cardless">';

    foreach ($terminal_cardless as $data_terminal_cardless) {
      $term_cardless .= '<option value="' . $data_terminal_cardless->id . '">
                        ' . $data_terminal_cardless->id . ' - ' . $data_terminal_cardless->short_name . '</option>';
    }
    $term_cardless .= '</optgroup>';

    $all_terminal = $term_cardbase . $term_cardless;

    //$list_bsn_date = $this->Postilion_model->get_list_bsndate();


    $data = array(
      'title'               => 'Reporting',
      'header_view'         => 'header_view',
      'content_view'        => 'report/reportiso',
      'sub_header_title'    => 'Report',
      'header_title'        => 'Generate Report',
      'username'            => $this->session->userdata('logged_full_name'),
      'lastlogin'           => $this->session->userdata('logged_last_login'),
      'list_terminal'       => $all_terminal,
      'list_bsndate'        => $this->Postilion_model->get_list_bsndate(),
      //'table_get_summarized' => $this->table->generate(),
      //'table_get_settlement' => $this->table_settlement->generate()
    );

    $tmpl = array(
      'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_summarized_iso" width="100%">',
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
      'Bsn Date',
      'Date/Time Generate',
      'Description',
    );

    $data_summarized = $this->Postilion_model->get_summarized_generate();
    // $terms_2 = $this->Postilion_model->term_monitor_offset_temp($this->session->userdata('logged_user_name'));

    foreach ($data_summarized as $data_sum) {

      $this->table->add_row(
        $data_sum->bsn_date,
        $data_sum->date_insert,
        $data_sum->log_desc,
      );
    }

    $data['table_get_summarized'] = $this->table->generate();

    $tmpl = array(
      'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_settlement_iso" width="100%">',
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
      'Bsn Date',
      'Description',
      'Amount',
    );

    $data_summarized = $this->Postilion_model->get_summarized_settlement();
    // $terms_2 = $this->Postilion_model->term_monitor_offset_temp($this->session->userdata('logged_user_name'));

    foreach ($data_summarized as $data_sum) {

      $this->table->add_row(
        $data_sum->bsn_date,
        $data_sum->vault_description,
        number_format($data_sum->amount),
      );
    }

    $data['table_get_settlement'] = $this->table->generate();



    $this->load->view('template', $data);
  }
}
