<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajaxcontroller extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Accounts_model', '', TRUE);
    $this->load->model('Postilioncrm_model', '', TRUE);
    $this->load->model('Postilion_model', '', TRUE);
    $this->load->model('Ptpr_model', '', TRUE);
    //$this->load->model('Log_model', '', TRUE);
  }


  function get_detail_trx_crm()
  {
    header('Content-Type: application/json');
    // $terminal_name = $this->input->get('terminal_name');
    $tran_type = $this->input->get('batch_nr');
    $draw = intval($this->input->get("draw"));

    $query = $this->Postilion_model->get_detail_trx_crm($tran_type);
    $no = 1;
    $data = [];
    foreach ($query as $r) {
      switch ($r->tran_type) {
        case "01":
          $trx_type = "Withdrawal";
          break;
        case "31":
          $trx_type = "Balance Inquiry";
          break;
        case "54":
          $trx_type = "Fund Transfer";
          break;
      }
      $data[] = array(
        // $no++,
        $r->terminal_id,
        $r->terminal_name,
        $r->terminal_city,
        $r->datetime_tran_local,
        $trx_type,
        substr_replace($r->pan, "******", 6, 6),
        $r->issuer,
        $r->benef,
        number_format($r->settle_amount_rsp),
      );
    }
    $result = array(
      "draw" => $draw,
      "data" => $data
    );
    echo json_encode($result);
    exit();
  }

  function get_summary_trx_crm()
  {
    header('Content-Type: application/json');
    // $terminal_name = $this->input->get('terminal_name');
    $tran_type = $this->input->get('batch_nr');
    $draw = intval($this->input->get("draw"));

    $query = $this->Postilion_model->get_detail_summary_crm($tran_type);
    $no = 1;
    $data = [];
    foreach ($query as $r) {
      switch ($r->tran_type) {
        case "01":
          $trx_type = "Withdrawal";
          break;
        case "31":
          $trx_type = "Balance Inquiry";
          break;
        case "54":
          $trx_type = "Fund Transfer";
          break;
      }
      $data[] = array(
        // $no++,
        $r->issuer_name,
        $trx_type,
        number_format($r->count_txn),
        number_format($r->amount_txn),
      );
    }
    $result = array(
      "draw" => $draw,
      "data" => $data
    );
    echo json_encode($result);
    exit();
  }

  function get_detail_summary_crm_bank($issuer)
  {
    $data = $this->Log_model->get_data_detail_summary_crm_bank($issuer);
    echo json_encode($data);
  }



  function get_summary_trx_crm_bank()
  {
    header('Content-Type: application/json');
    // $terminal_name = $this->input->get('terminal_name');
    $tran_type = $this->input->get('batch_nr');
    $draw = intval($this->input->get("draw"));

    $query = $this->Postilion_model->get_detail_summary_crm_bank($tran_type);
    $no = 1;
    $data = [];
    foreach ($query as $r) {
      // switch ($r->tran_type) {
      //   case "01":
      //     $trx_type = "Withdrawal";
      //     break;
      //   case "31":
      //     $trx_type = "Balance Inquiry";
      //     break;
      //   case "54":
      //     $trx_type = "Fund Transfer";
      //     break;
      // }
      $data[] = array(
        // $no++,
        'issuer_name'        => $r->issuer_name,
        //$trx_type,
        'count_txn'        => number_format($r->count_txn),
        //number_format($r->amount_txn),
      );
    }
    $result = array(
      "draw" => $draw,
      "data" => $data
    );
    echo json_encode($result);
    exit();
  }

  function get_query_trx()
  {
    $trans_type = '';
    header('Content-Type: application/json');
    // $terminal_name = $this->input->get('terminal_name');
    $datefrom         = $this->input->get('from_date');
    $dateto           = $this->input->get('to_date');
    $batch_nr         = $this->input->get('batch_nr');
    $tran_type        = $this->input->get('tran_type');
    // $issuer_name      = $this->input->get('issuer');
    // $benef_name       = $this->input->get('benef');
    $sink_node_name   = $this->input->get('sink_node_name');
    $pan              = $this->input->get('pan');
    $rrn              = $this->input->get('rrn');
    $prefix_term      = $this->input->get('prefix_term');
    $terminal_id      = $this->input->get('terminal_id');
    $response_code    = $this->input->get('response_code');
    $show_records     = $this->input->get('show_records');

    $draw         = intval($this->input->get("draw"));

    $query = $this->Postilion_model->get_real_transactions(
      $datefrom,
      $dateto,
      $batch_nr,
      $tran_type,
      // $issuer_name,
      // $benef_name,
      $sink_node_name,
      $pan,
      $rrn,
      $prefix_term,
      $terminal_id,
      $response_code,
      ($show_records == "" ? "10" : $show_records)
    );
    $no = 1;
    $data = [];
    foreach ($query as $r) {
      switch ($r->tran_type) {
        case '01':
          $trans_type = '01 - WDL';
          break;
        case '31':
          $trans_type = '31 - INQ';
          break;
        case '50':
        case '54':
          $trans_type = '50 - PMT';
          break;
        case '32':
          $trans_type = '32 - DEP';
          break;
        default:
          $trans_type = $r->tran_type . ' - ???';
      }
      $data[] = array(
        //$no++,
        // $r->post_tran_cust_id,
        // $r->source_node_name,
        $r->tran_nr,
        $r->postilion_date_time,
        $r->datetime_tran_local,
        $r->from_account,
        $r->tran_type,
        $r->message_type,
        $r->rsp_code_rsp,
        number_format($r->tran_amount_req),
        $r->card_acceptor_name_loc,
        $r->terminal_id,
        $r->source_node_name,
        $r->sink_node_name,
        substr_replace($r->pan, "******", 6, 6),
        $r->retrieval_reference_nr,

      );
    }
    $result = array(
      "draw" => $draw,
      "data" => $data
    );
    echo json_encode($result);
    exit();
  }

  function get_sum_query_trx()
  {
    $trans_type = '';
    header('Content-Type: application/json');
    // $terminal_name = $this->input->get('terminal_name');
    $datefrom         = $this->input->get('from_date');
    $dateto           = $this->input->get('to_date');
    $batch_nr         = $this->input->get('batch_nr');
    $tran_type        = $this->input->get('tran_type');
    $issuer_name      = $this->input->get('issuer');
    $benef_name       = $this->input->get('benef');
    $sink_node_name   = $this->input->get('sink_node_name');
    $pan              = $this->input->get('pan');
    $rrn              = $this->input->get('rrn');
    $prefix_term      = $this->input->get('prefix_term');
    $terminal_id      = $this->input->get('terminal_id');
    $response_code    = $this->input->get('response_code');
    $show_records     = $this->input->get('show_records');

    $draw         = intval($this->input->get("draw"));

    $query = $this->Postilion_model->get_summary_query_trx(
      $datefrom,
      $dateto,
      $batch_nr,
      $tran_type,
      $issuer_name,
      $benef_name,
      $sink_node_name,
      $pan,
      $rrn,
      $prefix_term,
      $terminal_id,
      $response_code,
      ($show_records == "" ? "10" : $show_records)
    );
    $total_approved = 0;
    $total_reject_customer = 0;
    $total_reject_technical = 0;
    $total_trx = 0;

    $no = 1;
    $data = [];
    foreach ($query as $r) {

      $data[] = array(
        //$no++,
        // $r->post_tran_cust_id,
        // $r->source_node_name,
        $r->response_code,
        $r->category,
        $r->total,
        $r->rate,
      );

      $total_trx += $r->total;
      if ($r->category == "Customer") {
        $total_reject_customer += $r->total;
      }
      if ($r->category == "Technical") {
        $total_reject_technical += $r->total;
      }
      if ($r->response_code == "00 - APPROVED") {
        $total_approved += $r->total;
      }
    }
    $result = array(
      "draw" => $draw,
      "data" => $data,
      "total_trx" => $total_trx,
      "total_approved" => $total_approved,
      "total_reject_customer" => $total_reject_customer,
      "total_reject_technical" => $total_reject_technical,
    );
    echo json_encode($result);
    exit();
  }


  function get_top5_tran_type()
  {
    header('Content-Type: application/json');
    // $terminal_name = $this->input->get('terminal_name');
    $tran_type = $this->input->get('trans_type');
    $draw = intval($this->input->get("draw"));

    $query = $this->Postilion_model->get_top_5_tran_type('', '', $tran_type);
    $no = 1;
    $data = [];
    foreach ($query as $r) {
      $data[] = array(
        $no++,
        $r->issuer_name,
        $r->tran_type,
        $r->jml_trx,
        // $r->jml_trx,
      );
    }
    $result = array(
      "draw" => $draw,
      "data" => $data
    );
    echo json_encode($result);
    exit();
  }

  function batch_viewer()
  {
    header('Content-Type: application/json');
    $terminal_name = $this->input->get('terminal_name');
    $date_batch = $this->input->get('datebatch');
    $draw = intval($this->input->get("draw"));
    $user = $this->session->userdata('logged_user_name');
    $query = $this->Postilion_model->get_batch_viewer($date_batch,  $user, $terminal_name);
    $data = [];
    foreach ($query as $r) {
      $data[] = array(
        $r->terminal_id,
        $r->short_name,
        $r->nom_item_end,
        $r->item_count,
        $r->time,
        $r->nom_item_begin,
        $r->item_begin,
        $r->date_time_begin,
        $r->cit
      );
    }
    $result = array(
      "draw" => $draw,
      "data" => $data
    );
    echo json_encode($result);
    exit();
  }

  function batch_viewer_crm()
  {
    header('Content-Type: application/json');
    $terminal_name = $this->input->get('terminal_name');
    $date_batch = $this->input->get('datebatch');
    $draw = intval($this->input->get("draw"));
    $user = $this->session->userdata('logged_user_name');
    $query = $this->Postilioncrm_model->get_batch_viewer_crm($date_batch,  $user, $terminal_name);
    $data = [];
    foreach ($query as $r) {
      $data[] = array(
        $r->terminal_id,
        $r->short_name,
        $r->nom_item_end,
        $r->item_count,
        $r->time,
        $r->nom_item_begin,
        $r->item_begin,
        $r->date_time_begin,
        $r->cit
      );
    }
    $result = array(
      "draw" => $draw,
      "data" => $data
    );
    echo json_encode($result);
    exit();
  }

  function saldo_terminal()
  {
    header('Content-Type: application/json');
    $date_batch = $this->input->get('datebatch');
    $draw = intval($this->input->get("draw"));
    $query = $this->Postilion_model->get_saldo($date_batch);
    $data = [];
    foreach ($query as $r) {
      $data[] = array(
        $r->terminal_id,
        $r->terminal_name,
        $r->nominal,
        $r->rem,
        $r->cap,
        $r->tran_cut_off,
        $r->nom_rem,
        $r->nom_cap
      );
    }
    $result = array(
      "draw" => $draw,
      "data" => $data
    );
    echo json_encode($result);
    exit();
  }

  function cardholder_not_take()
  {
    header('Content-Type: application/json');
    $date_from = $this->input->get('datefrom');
    $date_end = $this->input->get('dateend');
    $terminal_name = $this->input->get('terminal_name');
    $draw = intval($this->input->get("draw"));
    $query = $this->Postilion_model->search_terminal_card($date_from, $date_end, $terminal_name);
    $data = [];
    foreach ($query as $r) {
      $data[] = array(
        $r->entity,
        $r->event_time,
        $r->message,
      );
    }
    $result = array(
      "draw" => $draw,
      "data" => $data
    );
    echo json_encode($result);
    exit();
  }

  function ajax_delete_terminal_parameterize()
  {
    $data = array(
      'terminal_id' => $this->input->post('ajaxTerminalID')
    );
    $delete = $this->Postilion_model->delete_parameterize_id($data);

    if ($delete) {
      echo "Success";
    } else {
      echo "Error";
    }
  }

  function ajax_delete_bank_sponsor()
  {
    $data = array(
      'fi_number' => $this->input->post('ajaxFi')
    );
    $delete = $this->Ptpr_model->delete_account_id($data);

    if ($delete) {
      $this->session->set_flashdata('msgsuccessdelete', "Delete fi code " . $data['fi_number'] . " has success");
      echo "Success";
    } else {
      $this->session->set_flashdata('msgfaileddelete', "Delete fi code " . $data['fi_number'] . " has failed");
      echo "Error";
    }
  }

  function ajax_delete_list_package()
  {
    $data = array(
      'package_code' => $this->input->post('ajaxPackageCode')
    );
    $delete = $this->Ptpr_model->delete_list_package($data);

    if ($delete) {
      $this->Ptpr_model->delete_package_fee($data);
      $this->session->set_flashdata('msgsuccessdelete', "Delete package code " . $data['package_code'] . " has success");
      echo "Success";
    } else {
      $this->session->set_flashdata('msgfaileddelete', "Delete package code " . $data['package_code'] . " has failed");
      echo "Error";
    }
  }

  function ajax_delete_list_interchange()
  {
    $data = array(
      'fi_number' => $this->input->post('ajaxFiNumber')
    );
    $delete = $this->Ptpr_model->delete_list_interchange($data);

    if ($delete) {
      $this->session->set_flashdata('msgsuccessdelete', "Delete interchange with fi number " . $data['fi_number'] . " has success");
      echo "Success";
    } else {
      $this->session->set_flashdata('msgfaileddelete', "Delete interchange with fi number " . $data['fi_number'] . " has failed");
      echo "Error";
    }
  }

  function ajax_delete_accounts()
  {
    $data = array(
      'user_name' => $this->input->post('ajaxUserID')
    );
    $delete = $this->Accounts_model->delete_accounts($data);

    if ($delete) {
      echo "Success";
    } else {
      echo "Error";
    }
  }

  function ajax_delete_access_terminal()
  {
    $data = array(
      'user_id' => $this->input->post('ajaxUserID'),
      'left(terminal_id,3)' => $this->input->post('ajaxTerminalID')
    );
    $delete = $this->Accounts_model->delete_terminal_access($data);

    if ($delete) {
      $this->session->set_flashdata('messageinserttermaccess', $this->input->post('ajaxUserID') . ' - ' . $this->input->post('ajaxTerminalID') . ' has been deleted');
      echo "Success";
    } else {
      $this->session->set_flashdata('messageinserttermaccessfailed', 'deleted' . $this->input->post('ajaxUserID') . ' - ' . $this->input->post('ajaxTerminalID') . 'has failed');
      echo "Error";
    }
  }

  function add_parameterize()
  {
    $vTerminal    = $this->input->post('ajaxTerminalID');
    $vGetTerminal = explode('-', $vTerminal);

    $data = array(
      'terminal_id'     => $vGetTerminal[0],
      'terminal_name'   => $vGetTerminal[1],
      'percentage'      => $this->input->post('ajaxMinSaldo'),
      'sent_mail'       => 'False',
      'from_date'       => $this->input->post('ajaxDateFrom'),
      'to_date'         => $this->input->post('ajaxDateTo')

    );
    $this->Postilion_model->save_parameterize($data);
    echo json_encode(array("status" => TRUE));
  }

  function ajax_update_terminal_access()
  {
    $vTerminal    = $this->input->post('ajaxTerminalID');
    $vUser        = $this->input->post('ajaxUserID');

    //   $data = array(
    //     array(
    //        'user_id' => 'hari01' ,
    //        'terminal_id' => '0100001',
    //     ),
    //     array(
    //        'user_id' => 'hari01' ,
    //        'terminal_id' => '0100002'
    //     )
    //  );

    foreach ($vTerminal as $contact) {
      $data[] = array(
        'user_id'     => 'hari01',
        'terminal_id' => $contact,
      );
    }

    // $data = array($vTerminal);

    // $data = array(
    //   'user_id'       => $vTerminal[0],
    //   'terminal_id'   => $vTerminal[1],
    // );
    $this->Postilion_model->update_terminal_access($data);
    // echo json_encode(array("status" => 'Success'));
    echo "Success";
  }


  function update_parameterize()
  {
    $vTerminal    = $this->input->post('ajaxTerminalID');
    $vGetTerminal = explode('-', $vTerminal);

    $data = array(
      'terminal_id'     => $vGetTerminal[0],
      'terminal_name'   => $vGetTerminal[1],
      'percentage'      => $this->input->post('ajaxMinSaldo'),
      'sent_mail'       => 'False',
      'from_date'       => $this->input->post('ajaxDateFrom'),
      'to_date'         => $this->input->post('ajaxDateTo')

    );
    $this->Postilion_model->update_data_parameterize($data, array('terminal_id' => $vGetTerminal[0]));
    echo json_encode(array("status" => TRUE));
  }

  function finance_upload_image()
  {

    $vRequestNo  = $this->input->post('sReqNo');
    $vPaymentDate  = $this->input->post('sPaymentDate');
    $data = array(
      'user_finance'        => $this->session->userdata('logged_user_name'),
      'status'              => 'Approved By Finance',
      'date_fin_approved'   => date('Y-m-d H:i:s'),
    );
    $udpate_app_fin = $this->Ptpr_model->update_by_finance($data, array('invoice_no' => $vRequestNo));
    // $this->finance_upload_image($vRequestNo);

    if ($udpate_app_fin) {
      $this->session->set_flashdata('messagesuccess', "This Request No : " . $vRequestNo . " has been approved");
      //echo "Success";
    } else {
      $this->session->set_flashdata('messagesuccess', "Delete fi code " . $vRequestNo . " has failed");
      //echo "Error";
    }




    // sleep(3);
    if ($_FILES["files"]["name"] != '') {
      // $output = '';
      $config["upload_path"] = './topup/';
      $config["allowed_types"] = 'jpeg|jpg|png';
      $this->load->library('upload', $config);
      $this->upload->initialize($config);
      for ($count = 0; $count < count($_FILES["files"]["name"]); $count++) {
        $_FILES["file"]["name"] = $_FILES["files"]["name"][$count];
        $_FILES["file"]["type"] = $_FILES["files"]["type"][$count];
        $_FILES["file"]["tmp_name"] = $_FILES["files"]["tmp_name"][$count];
        $_FILES["file"]["error"] = $_FILES["files"]["error"][$count];
        $_FILES["file"]["size"] = $_FILES["files"]["size"][$count];
        if ($this->upload->do_upload('file')) {
          // $data = $this->upload->data();
          //       $output .= '
          //  <div class="col-md-3">
          //   <img src="' . base_url() . 'upload/' . $data["file_name"] . '" class="img-responsive img-thumbnail" />
          //  </div>
          //  ';
          $upload_data =  $this->upload->data();
          $data = array(
            'request_no'    => $vRequestNo,
            'file_name'     => $upload_data['file_name'],
            'size_file'     => $upload_data['file_size'] . ' KB',
            'payment_date'  => $vPaymentDate,
            'date_uploaded' => date("Y-m-d H:i:s"),
          );


          $this->Ptpr_model->insert_attach_file_topup($data);
        }
      }
      // echo $output;
    }

    $this->generatexl->send_mail_payment_finance($data);
    echo json_encode(array("status" => TRUE));
  }

  function upload_image_files()
  {
    $countfiles = count($_FILES['file_image']['name']);

    $config = array(
      'upload_path'   => './topup',
      'allowed_types' => 'jpg|png',
    );

    $this->load->library('upload', $config);

    $images = array();
    $success_json = array();
    $failed_json = array();

    if (!empty($_FILES['file']['name'][0])) {
      $files = $_FILES['file'];
      $title = "";

      foreach ($files['name'] as $key => $image) {
        $_FILES['file[]']['name'] = $files['name'][$key];
        $_FILES['file[]']['type'] = $files['type'][$key];
        $_FILES['file[]']['tmp_name'] = $files['tmp_name'][$key];
        $_FILES['file[]']['error'] = $files['error'][$key];
        $_FILES['file[]']['size'] = $files['size'][$key];

        $fileName = $title . '_' . $image;

        $images[] = $fileName;

        $config['file_name'] = $fileName;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('file')) {
          $upload_data =  $this->upload->data();
          $file_name = $upload_data['file_name'];


          $data = array(
            'request_no'    => $file_name,
            'file_name'     => $this->session->userdata('logged_user_name'),
            'size_file'     => $upload_data['file_size'],
            'payment_date'  => '',
            'date_uploaded' => date("Y-m-d H:i:s"),
          );


          $this->Ptpr_model->insert_attach_file_topup($data);

          $success_json[] = $fileName;
        } else {
          $failed_json[] = $fileName . $this->upload->display_errors();
        }
      }
    }
  }

  function updated_by_finance()
  {
    $vRequestNo  = $this->input->post('ajaxReqNo');
    $vFiles  = $this->input->post('ajaxFiles');
    $vPaymentDate  = $this->input->post('ajaxPaymentDate');
    $data = array(
      'user_finance'        => $this->session->userdata('logged_user_name'),
      'status'              => 'Approved By Finance',
      'date_fin_approved'   => date('Y-m-d H:i:s'),
    );
    $udpate_app_fin = $this->Ptpr_model->update_by_finance($data, array('invoice_no' => $vRequestNo));
    $this->finance_upload_image($vRequestNo);

    if ($udpate_app_fin) {
      $this->session->set_flashdata('messagesuccess', "This Request No : " . $vRequestNo . " has been approved");
      //echo "Success";
    } else {
      $this->session->set_flashdata('messagesuccess', "Delete fi code " . $vRequestNo . " has failed");
      //echo "Error";
    }

    echo json_encode(array("status" => TRUE));
  }

  function updated_reject_by_finance()
  {
    $vRequestNo  = $this->input->post('ajaxReqNo');
    $data = array(
      'user_finance'        => $this->session->userdata('logged_user_name'),
      'status'              => 'Rejected By Finance',
      'date_fin_rejected'   => date('Y-m-d H:i:s'),
    );
    $udpate_app_fin = $this->Ptpr_model->update_by_finance($data, array('invoice_no' => $vRequestNo));

    if ($udpate_app_fin) {
      $this->session->set_flashdata('messagesuccess', "This Request No : " . $vRequestNo . " has been rejected");
      //echo "Success";
    } else {
      $this->session->set_flashdata('messagesuccess', "Delete fi code " . $vRequestNo . " has failed");
      //echo "Error";
    }
    echo json_encode(array("status" => TRUE));
  }

  function updated_by_rcs()
  {
    $vRequestNo  = $this->input->post('ajaxReqNo');
    $user_request  = $this->input->post('ajaxUserRequest');
    $date_request  = $this->input->post('ajaxDateReq');
    $package_selected  = $this->input->post('ajaxPackage');
    // $vQueu  = $this->input->post('ajaxQueu');

    $data = array(
      'user_rcs'            => $this->session->userdata('logged_user_name'),
      'status'              => 'Approved By RCS',
      'date_rcs_approved'   => date('Y-m-d H:i:s'),
      // 'queueing'   => $vQueu,
    );
    // $this->Ptpr_model->update_by_finance($data, array('invoice_no' => $vRequestNo));

    $udpate_app_fin = $this->Ptpr_model->update_by_finance($data, array('invoice_no' => $vRequestNo));

    if ($udpate_app_fin) {
      $this->session->set_flashdata('messagesuccess', "This Request No : " . $vRequestNo . " has been approved");
      //echo "Success";
    } else {
      $this->session->set_flashdata('messagesuccess', "Delete fi code " . $vRequestNo . " has failed");
      //echo "Error";
    }

    $this->generatexl->send_mail_rcs_approve(
      array('invoice_no'        => $vRequestNo,
            'user_request'      => $user_request,
            'date_request'      => $date_request,
            'package_selected'  => $package_selected,
      
      )
    );
    $data_json = array(
      'status'         => 'True',
    );

    echo json_encode($data_json);
  }

  function updated_reject_by_rcs()
  {
    $vRequestNo  = $this->input->post('ajaxReqNo');
    $data = array(
      'user_rcs'            => $this->session->userdata('logged_user_name'),
      'status'              => 'Rejected By RCS',
      'date_rcs_rejected'   => date('Y-m-d H:i:s'),
    );
    $udpate_app_fin = $this->Ptpr_model->update_by_finance($data, array('invoice_no' => $vRequestNo));

    if ($udpate_app_fin) {
      $this->session->set_flashdata('messagesuccess', "This Request No : " . $vRequestNo . " has been rejected");
      //echo "Success";
    } else {
      $this->session->set_flashdata('messagesuccess', "Delete fi code " . $vRequestNo . " has failed");
      //echo "Error";
    }
    echo json_encode(array("status" => TRUE));
  }

  function update_account()
  {
    // $vMenu = array();
    $vUserId  = $this->input->post('ajaxUserId');
    $vActive  = $this->input->post('ajaxActive');
    $vLock    = $this->input->post('ajaxLock');
    $vRole    = $this->input->post('ajaxRole');
    $vMenu    = $this->input->post('ajaxListmenu');

    foreach ($vMenu as $v_menu) {
      $datax[] = array(
        'user_name'           => $vUserId,
        'page_controller'     => $v_menu,
        'date_update'         => date('Y-m-d H:i:s')
      );
    }

    $this->Accounts_model->update_menu_access($datax);

    $data = array(
      'status_active'      => $vActive,
      'status_lock'        => $vLock,
      'user_right'         => $vRole,
      'date_update'        => date('Y-m-d H:i:s')
    );
    $this->Accounts_model->update_data_account($data, array('user_name' => $vUserId));

    echo json_encode(array("status" => TRUE));
  }

  function update_account_bank()
  {
    $vFi      = $this->input->post('ajaxFi');
    $vMailPic = $this->input->post('ajaxMailPic');
    $vMailFin = $this->input->post('ajaxMailFin');
    $vAcct    = $this->input->post('ajaxAcct');
    $vName    = $this->input->post('ajaxName');

    $data = array(
      'email_pic'     => $vMailPic,
      'email_finance' => $vMailFin,
      'account_id'    => $vAcct,
      'account_name'  => $vName,

    );
    $this->Ptpr_model->update_data_bank_sponsor($data, array('fi_number' => $vFi));
    echo json_encode(array("status" => TRUE));
  }


  function update_list_package()
  {
    $vId        = $this->input->post('ajaxId');
    $vPackage   = $this->input->post('ajaxPackage');
    $vLimit     = str_replace(",", "", $this->input->post('ajaxLimit'));
    $vPrice     = str_replace(",", "", $this->input->post('ajaxPrice'));
    $vFee       = str_replace(".", "", $this->input->post('ajaxFee'));

    $data = array(
      'package_code'    => $vPackage,
      'limit'           => $vLimit,
      'price'           => $vPrice,
      'fee'             => $vFee,

    );
    $this->Ptpr_model->update_data_list_package($data, array('package_code' => $vPackage));
    echo json_encode(array("status" => TRUE));
  }


  function update_list_interchange()
  {
    // ajaxFi         : sFI, 
    // ajaxSource     : sSourceNode, 
    // ajaxSink       : sSinkNode,
    // ajaxTotal      : sTotalGroup, 
    // ajaxEntity     : sEntity

    $vFi        = $this->input->post('ajaxFi');
    $vSource    = $this->input->post('ajaxSource');
    $vSink      = $this->input->post('ajaxSink');
    $vTotal     = $this->input->post('ajaxTotal');
    $vEntity    = $this->input->post('ajaxEntity');

    $data = array(
      'source_node'           => $vSource,
      'sink_node'             => $vSink,
      'totals_group'          => $vTotal,
      'business_entity_name'  => $vEntity,

    );
    $this->Ptpr_model->update_data_list_interchange($data, array('fi_number' => $vFi));
    echo json_encode(array("status" => TRUE));
  }

  function get_parameterize()
  {
    $data = $this->Postilion_model->get_data_parameterize($this->input->get('term_id'));
    echo json_encode($data);
  }

  function get_data_register()
  {
    $data = $this->Accounts_model->get_data_user_register($this->input->get('user_id'));
    echo json_encode($data);
  }

  function get_data_package()
  {
    $data_id = array(
      'package_code'    => $this->input->post('ajaxId'),
    );
    $data = $this->Ptpr_model->get_package_id($data_id);
    echo json_encode($data);
  }

  function get_data_menu()
  {
    $data = $this->Accounts_model->get_data_user_menu($this->input->get('user_id'));
    echo json_encode($data);
  }

  function get_data_user_terminal()
  {
    $data = $this->Postilion_model->get_users_term($this->input->get('user_id'));
    echo json_encode($data);
  }


  function get_terminal_access()
  {
    $userid = $this->input->post('ajaxUserID');
    $prefix = $this->input->post('ajaxTerminalID');

    $data_where = array(
      'a.user_id'         => $userid,
      'left(a.terminal_id,3)'   => $prefix,
    );

    $data = $this->Accounts_model->get_data_terminal_access($data_where);
    echo json_encode($data);
  }

  function get_fee_package()
  {
    $v_package = $this->input->post('ajaxPackageCode');

    $data_where = array(
      'package_code'         => $v_package,
    );

    $data = $this->Accounts_model->get_data_fee_bank_sponsor($data_where);
    echo json_encode($data);
  }

  function get_attachment_topup()
  {
    $v_req_no = $this->input->post('ajaxRequestNo');

    $data_where = array(
      'request_no'         => $v_req_no,
    );

    $data = $this->Accounts_model->get_data_attachment_topup($data_where);
    echo json_encode($data);
  }


  function get_data_interchange()
  {
    $interchange = $this->input->post('ajaxInterchange');


    $data_where = array(
      'interchange'         => $interchange,
    );

    $query = $this->Postilion_model->get_data_interchange($data_where);
    // foreach ($query as $r) {
    //   $data[] = array(
    //     $r->fi_number
    //   );
    // }
    // $result = array(
    //   "data" => $data
    // );
    // $result = array(
    //   "status_field" => "success",
    //   // "data" => $data
    // );
    echo json_encode($query);
    //exit();

    //echo json_encode($data);
  }

  function ajax_change_image()
  {
    $config = array(
      'upload_path'   => './assets/images/avatar/',
      'allowed_types' => 'jpg|png|jpeg|bmp',
    );

    $this->load->library('upload', $config);


    if (!empty($_FILES['file_avatar']['name'][0])) {
      $files = $_FILES['file_avatar'];
      $title = "";
      $config['file_name'] = 'upload_avatar';
      $this->upload->initialize($config);

      if ($this->upload->do_upload('file_avatar')) {
        $upload_data = $this->upload->data();
        $file_name_tmp = $upload_data['file_name'];

        $data = array(
          'avatar'     => $file_name_tmp,
        );
      } else {
        // $failed_json[]=$fileName.$this->upload->display_errors();
      }
    } else {
      // $data['avatar'] = 'profile10.png';
    }

    $this->Accounts_model->change_image($data, array('user_name' => $this->session->userdata('logged_user_name')));
    // $this->CI->session->set_userdata('logged_avatar', $avatar);
    $this->session->set_userdata('logged_avatar', $data['avatar']);
    echo json_encode($data);
  }
}
