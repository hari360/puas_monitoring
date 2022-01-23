<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Iso extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Accounts_model', '', TRUE);
    $this->load->model('Postilion_model', '', TRUE);
    $this->load->library('reporttxt/wdl/acqapproved');
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

    $this->acqapproved->wdl_detail_approved('BJB');

    
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
