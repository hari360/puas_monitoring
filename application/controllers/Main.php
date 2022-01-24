<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Pusher\Pusher;

class Main extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->myauth->permission_page('1');
    $this->load->model('Dashboard_model', '', TRUE);
  }

  // private function sendMessage()
  // {
  //   $content      = array(
  //     "en" => 'Test Dari Web Monitoring ATMI'
  //   );
  //   $hashes_array = array();
  //   array_push($hashes_array, array(
  //     "id" => "like-button",
  //     "text" => "Like",
  //     "icon" => "http://i.imgur.com/N8SN8ZS.png",
  //     "url" => "https://yoursite.com"
  //   ));
  //   array_push($hashes_array, array(
  //     "id" => "like-button-2",
  //     "text" => "Like2",
  //     "icon" => "http://i.imgur.com/N8SN8ZS.png",
  //     "url" => "https://yoursite.com"
  //   ));
  //   $fields = array(
  //     'app_id' => "d95396f1-8d70-4eae-b2b5-a5b59ac108aa",
  //     'included_segments' => array(
  //       'Subscribed Users'
  //     ),
  //     'data' => array(
  //       "foo" => "bar"
  //     ),
  //     'contents' => $content,
  //     'web_buttons' => $hashes_array
  //   );

  //   $fields = json_encode($fields);
  //   print("\nJSON sent:\n");
  //   print($fields);

  //   $ch = curl_init();
  //   curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
  //   curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  //     'Content-Type: application/json; charset=utf-8',
  //     'Authorization: Basic MWQ3MTllNjMtYzU5Mi00MDJiLWFlZGMtNjVmYTk0YTAwMjA0'
  //   ));
  //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  //   curl_setopt($ch, CURLOPT_HEADER, FALSE);
  //   curl_setopt($ch, CURLOPT_POST, TRUE);
  //   curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
  //   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

  //   $response = curl_exec($ch);
  //   curl_close($ch);

  //   return $response;
  // }

  function index()
  {

    // $response = $this->sendMessage();
    // $return["allresponses"] = $response;
    // $return = json_encode($return);

    // $data = json_decode($response, true);
    // print_r($data);
    // $id = $data['id'];
    // print_r($id);

    // print("\n\nJSON received:\n");
    // print($return);
    // print("\n");

    // print_r($this->session->userdata('list_access_menu'));
    // die();
    $data = array(
      'title'               => 'Monitoring-Dashboard',
      'header_view'         => 'header_view',
      'content_view'        => 'home/dashboard',
      'sub_header_title'    => '',
      'parent_menu'         => 'Dashboard',
      'header_title'        => 'DASHBOARD',
      'username'            => $this->session->userdata('logged_full_name'),
      'lastlogin'           => $this->session->userdata('logged_last_login'),
    );

    $get_status_dashboard = $this->Dashboard_model->status_dashboard($this->session->userdata('logged_user_name'),'010');

    foreach ($get_status_dashboard as $get_status) {

      switch ($get_status->status_term) {
        case "all_terminal":
          $data['all_terminal'] = $get_status->count_trx;
          break;
        case "off_line":
          $data['offline'] = $get_status->count_trx;
          break;
        case "closed":
          $data['close'] = $get_status->count_trx;
          break;
        case "in_service":
          $data['inservice'] = $get_status->count_trx;
          break;
        case "card_retain":
          $data['cardretain'] = $get_status->count_trx;
          break;
        case "saldo_min":
          $data['saldomin'] = $get_status->count_trx;
          break;
        case "faulty":
          $data['faulty'] = $get_status->count_trx;
          break;
      }


      $get_status_dashboard_crm = $this->Dashboard_model->status_dashboard($this->session->userdata('logged_user_name'),'041');
      foreach ($get_status_dashboard_crm as $get_status) {

        switch ($get_status->status_term) {
          case "all_terminal":
            $data['all_terminal_crm'] = $get_status->count_trx;
            break;
          case "off_line":
            $data['offline_crm'] = $get_status->count_trx;
            break;
          case "closed":
            $data['close_crm'] = $get_status->count_trx;
            break;
          case "in_service":
            $data['inservice_crm'] = $get_status->count_trx;
            break;
          case "card_retain":
            $data['cardretain_crm'] = $get_status->count_trx;
            break;
            // case "saldo_min":
            //   $data['saldomin_crm'] = $get_status->count_trx;
            //   break;
          case "faulty":
            $data['faulty_crm'] = $get_status->count_trx;
            break;
        }
      }


      $get_status_dashboard_ptpr = $this->Dashboard_model->status_dashboard($this->session->userdata('logged_user_name'),'042');
      foreach ($get_status_dashboard_ptpr as $get_status) {

        switch ($get_status->status_term) {
          case "all_terminal":
            $data['all_terminal_ptpr'] = $get_status->count_trx;
            break;
          case "off_line":
            $data['offline_ptpr'] = $get_status->count_trx;
            break;
          case "closed":
            $data['close_ptpr'] = $get_status->count_trx;
            break;
          case "in_service":
            $data['inservice_ptpr'] = $get_status->count_trx;
            break;
          case "card_retain":
            $data['cardretain_ptpr'] = $get_status->count_trx;
            break;
            // case "saldo_min":
            //   $data['saldomin_crm'] = $get_status->count_trx;
            //   break;
          case "faulty":
            $data['faulty_ptpr'] = $get_status->count_trx;
            break;
        }
      }

      $data['tranidle'] = 23;
      // $data['tranidle_crm'] = 23;

    }



    // $options = array(
    //   'cluster' => 'ap1',
    //   'useTLS' => true
    // );

    // // 'Pusher' => Pusher\Pusher::class,

    // $pusher = new Pusher(
    //   '278e9f87cd57bcdd00f0',
    //   'b9c43e0bfc88500e0ba6',
    //   '1202504',
    //   $options
    // );

    // $data['message'] = 'Welcome to MonitoringWeb';
    // $pusher->trigger('my-channel', 'my-event', $data['message']);

    $this->load->view('template', $data);
  }

  function restricted_screen()
  {

    $data = array(
      'title'     =>  $this->title,
      'subtitle'  =>  '<p><a href="' . base_url() . 'dashboard">Dashboard</a></p>',
      'h2_title'  =>  'Restricted Screen',
      'username'  =>  $this->session->userdata('logged_user'),
      'main_view' =>  'main/main',
      'message'   =>  'Oops! Sorry, an error has occured. Access forbidden.',
    );
    $this->load->view('template', $data);
  }

  function restrict()
  {
    $this->load->view('main/restrict');
  }
}
