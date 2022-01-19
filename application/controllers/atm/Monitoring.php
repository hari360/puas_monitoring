<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Monitoring extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Postilion_model', '', TRUE);
  }

  function index()
  { 
    $data = array(
        'title'               => 'Monitoring-Parameterize',
        'header_view'         => 'header_view',
        'content_view'        => 'atm/terminal_monitoring',
        'sub_header_title'    => 'Terminal Monitoring',
        'header_title'        => 'Terminal Monitoring',
        'username'            => $this->session->userdata('logged_full_name'),
        'lastlogin'           => $this->session->userdata('logged_last_login'),
        // 'table'               => $this->table->generate(),
    );

    $tmpl = array(
        'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_terminal_cardbase" width="100%">',
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
        'ATM ID',
        'Terminal Name',
        'Condition',
        'Mode',
        'Denom',
        'Admin',
        'Amount Bar',
        'Percentage',
        'Jarkon',
        'CIT',
        // 'Detail',
        'FLM/SLM'
      );
  
      $terms = $this->Postilion_model->term_monitor_offset($this->session->userdata('logged_user_name'));
      // $terms_2 = $this->Postilion_model->term_monitor_offset_temp($this->session->userdata('logged_user_name'));
      // $terms = array_merge($terms_1,$terms_2);
  
      foreach ($terms as $term) {
  
        
  
        switch ($term->worst_event_severity) {
          case "0":
            $str_condition = 'OK';
            break;
          case "1":
            $str_condition = 'CRITICAL';
            break;
          case "2":
            $str_condition = 'SUSPECT';
            break;
        }
  
  
        $status_slm = $term->status_flm;
        $status_flm = $term->status_slm;
        $date_insert_flm = $term->date_insert_flm;
        $date_insert_slm = $term->date_insert_slm;
  
        // $result=$this->Postilion_model->get_status_flm_slm($term->id,'flm');
        // foreach ($result as $v){
        //     $status_flm=$v->status_flm;
        //     $date_insert_flm = $v->date_insert;
        // }
  
        // $result=$this->Postilion_model->get_status_flm_slm($term->id,'slm');
        // foreach ($result as $v){
        //     $status_slm=$v->status_slm;
        //     $date_insert_slm = $v->date_insert;
        // }
  
        $mode = explode('|', $term->miscellaneous);
  
        if (substr($mode[0], 2, strlen($mode[0]) - 2) == 'Off-line') {
  
          if($term->duration != ""){
          // if ($this->Postilion_model->get_terminal_offline_front($term->id)->num_rows() != 0) {
            // $start_off = substr($this->Postilion_model->get_terminal_offline_front($term->id)->row()->start_time, 0, 19);
            // $duration_off = $this->Postilion_model->get_terminal_offline_front($term->id)->row()->duration;
            $start_off = substr($term->start_time, 0, 19);
            $duration_off = $term->duration;
            
          } else {
            $start_off = '-';
            $duration_off = '-';
          }
  
          $v_off = '<div style=color:black;color:black>' . substr($mode[0], 2, strlen($mode[0]) - 2) . '</br>' . $start_off . '<br><br><span style="border-top:0px solid;color:red;font-weight:bold">' . $duration_off . '</span></div>';
        } else {
          $duration_off = '';
          $v_off = '<div style=color:black;color:black>' . substr($mode[0], 2, strlen($mode[0]) - 2) . '</div>';
        }
  
        if ($term->max_percent == '') {
          $coba = '0';
        } else {
          $coba = $term->max_percent;
        }
  
        if ($term->percentage < $term->max_percent && $term->percentage > 0) {
          //$cell11 = '<span style="background:red">'.$term->max_percent.'%</span>';
          $cell_percentage = array('data' => round($term->percentage, 2) . '%', 'style' => 'background:red;font-weight: bold;color:white', 'class' => 'boxtemp', 'data-tooltip' => 'Max ' . $coba . '% to ' . $term->expired_saldo);
        } else if ($term->percentage < $term->max_percent + 5) {
          $cell_percentage = array('data' => round($term->percentage, 2) . '%', 'style' => 'background:yellow;font-weight: bold;color:black', 'class' => 'boxtemp', 'data-tooltip' => 'Max ' . $coba . '% to ' . $term->expired_saldo);
        } else {
          //$cell11 = '<span style="background-color:green">'.$term->max_percent.'%</span>';
          $cell_percentage = array('data' => round($term->percentage, 2) . '%', 'style' => 'background:white;font-weight: regular;color:black', 'class' => 'boxtemp', 'data-tooltip' => 'Max ' . $coba . '% to ' . $term->expired_saldo);
        }
  
        
  
        // if ($str_condition == 'OK' &&  $mode[0] == '6.In Service') {
        //   if ($status_flm == 'Submit' || $status_flm == 'Modify') {
        //     $this->Postilion_model->update_status_flm($term->id, 'status_flm');
        //   }
        //   if ($status_slm == 'Submit' || $status_slm == 'Modify') {
        //     $this->Postilion_model->update_status_slm($term->id, 'status_slm');
        //   }
        //   $cell_flm = '';
        //   $cell_slm = '';
        // }
  
        if ($str_condition != 'OK' || $mode[0] != '6.In Service') {
  
          $cell_flm = '<input id="flmid" type="button" onclick="add_person(this.value,' . "'" . $term->id . "','OK'" . ')" title="' . $term->id . '" value="FLM" class="btn btn-warning" 
                       onmouseover="this.title=\'\';" >';
          $cell_slm = '<input id="slmid" type=button value=SLM disabled class="btn btn-warning" 
                       >';
          if ($status_flm == 'Submit' || $status_flm == 'Modify') {
            $cell_flm = '<input id="flmid" type="button" onclick="add_person(this.value,' . "'" . $term->id . "|" .$date_insert_flm. "','Modify'" . ')" title="' . $term->id . '" value="FLM" class="btn btn-danger" 
                 onmouseover="this.title=\'\';" >';
            $cell_slm = '<input id="slmid" type="button" onclick="add_person(this.value,' . "'" . $term->id . "|" .$date_insert_slm. "','Submit'" . ')" title="' . $term->id . '" value="SLM" class="btn btn-warning" 
                 onmouseover="this.title=\'\';" >';
          }
          if ($status_slm == 'Submit' || $status_slm == 'Modify') {
            $cell_flm = '<input id="flmid" type="button" onclick="add_person(this.value,' . "'" . $term->id . "|" .$date_insert_slm. "','Modify'" . ')" title="' . $term->id . '" value="FLM" class="btn btn-danger" 
                 onmouseover="this.title=\'\';" >';
            $cell_slm = '<input id="slmid" type="button" onclick="add_person(this.value,' . "'" . $term->id . "|" .$date_insert_slm. "','Submit'" . ')" title="' . $term->id . '" value="SLM" class="btn btn-danger" 
                 onmouseover="this.title=\'\';" >';
          }
          //die($status_flm);
        }
  
      //   $cell_extends = array('class' => 'details-control', 'title' => $term->id );
  
        $this->table->add_row(
          // $cell_extends,
          array('data' => anchor('terminalcardbase/terminal_monitor_detail/'.$term->id,$term->id,array('class' => 'table-view-link')), 'class' => 'row-nav'),
          //'<a href="#">'.$term->id.'</a>',
          $term->short_name,
          $str_condition,
          '<div style=color:white;float:left;display:none>' . substr($mode[0], 0, 1) . '</div>'. $v_off,
          $term->nominal,
          '<span title=' . $term->vAdminBars . '>' . number_format($term->vAdminBars) . '</span>',
          '<span title=' . $term->vValueBars . '>' . number_format($term->vValueBars) . '</span>',
          $cell_percentage,
          $term->jarkom,
          $term->cit,
          // array('data' => anchor('postilion/terminal_monitor_detail/' . $term->id, 'View', array('class' => 'table-view-link')), 'class' => 'row-nav'),
          $cell_flm . $cell_slm
        );
  
      }

      $data['table_cardbase'] = $this->table->generate();

      $this->load->view('template', $data);
  }

}
