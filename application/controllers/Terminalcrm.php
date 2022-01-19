<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Terminalcrm extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Postilion_model', '', TRUE);
    $this->load->model('Log_model', '', TRUE);
  }


  function get_table_log(){
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

        $cell_extends = array('class' => 'details-control', 'title' => $term->short_name );

        $this->table->add_row(
            $cell_extends,
            $term->id,
            $term->short_name
        );

        }
  }

  function index()
  {
    $terms = $this->Postilion_model->term_monitor_crm($this->session->userdata('logged_user_name'));

    $tmpl = array(
        'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_terminal_crm" width="100%">',
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
                                // 'No', 
                                'ATM ID', 
                                'ATM Name', 
                                'Condition', 
                                'Mode', 
                                'Amount 50', 
                                '%',
                                'Amount 100',
                                '%',
                                'Problem',
                                'Faulty', 
                                'FLM/SLM');


    $i = 0; $recno = 0;
    $str_condition = '';
    foreach ($terms as $term) 
    {
        $recno++;
                if ($recno > $i) {
                    $mode = explode('|', $term->miscellaneous);
                    if ($term->value_bars!=NULL && trim($term->value_bars, ' ')!='') {
                        $valuebar = explode('|', $term->value_bars);
                        $nominal = explode('~', $valuebar[0]);
                        $nominal100 = explode('~', $valuebar[2]);
                        $totalamount = explode('~', $valuebar[1]);
                        $totalamount100 = explode('~', $valuebar[3]);

                    } else {
                        $nominal[0] = '0';
                        $nominal100[0] = '0';
                        $totalamount[0] = '0';
                        $totalamount[1] = '0';
                        $totalamount100[0] = '0';
                        $totalamount100[1] = '0';
                    }
                    if ($this->config->item('realtime_version') == '4') {
                        switch ($term->condition) {
                            case "0":
                                $str_condition = 'OK';
                                break;
                            case "1":
                                $str_condition = array('data' => 'CRITICAL', 'style' => 'background:#C82333;font-weight: bold;color:black');
                                break;
                            case "2":
                                $str_condition = array('data' => 'SUSPECT', 'style' => 'background:#E0A800;font-weight: bold;color:black');
                                break;
                        }
                    }                    
                    if ($this->config->item('realtime_version') == '5') {
                        switch ($term->worst_event_severity) {
                            case "0":
                                $str_condition = 'OK';
                                break;
                            case "1":
                                $str_condition = array('data' => 'CRITICAL', 'style' => 'background:#C82333;font-weight: bold;color:black');
                                break;
                            case "2":
                                $str_condition = array('data' => 'SUSPECT', 'style' => 'background:#E0A800;font-weight: bold;color:black');
                                break;
                        }
                    }

                $problem = ''; 

                // $result=$this->Postilion_model->terminal_problem($term->id)->result();
                //     foreach ($result as $v){
                //         //$v->status_flm;
                //         $problem=$v->problem;
                //         //echo $v['title'];
                //     }

                $faulty = ''; 

                // $result1=$this->Postilion_model->terminal_faulty($term->id)->result();
                //     foreach ($result1 as $v){
                //         //$v->status_flm;
                //         $faulty=$v->faulty;
                //         //echo $v['title'];
                //     }

    				// Penyusunan data baris per baris
                    //$cell = array('data' => $term->id, 'class' => 'col-first');
        $cell8 = anchor('postilion/terminal_monitor_detail/'.$term->id,'<i class="fa fa-eye"></i>',array('class'=>'table-actions', 'rel'=>'tooltip', 'data-placement'=>'top', 'data-original-title'=>'view'));

                    //$cell8 = '<div class="btn-group"><a class="btn btn-small" rel="tooltip" data-placement="top" data-original-title="View"><i class="gicon-eye-open"></i></a></div>';
        $persen50 = (floatval(str_replace('IDR',' ',$totalamount[1])) / 260000000) * 100;
        $persen100 = (floatval(str_replace('IDR',' ',$totalamount100[1])) / 520000000) * 100;
        //die($persen50);
        //$persen50 = '<font color="red">'.$persen50.'</font>';

        if((round($persen50,2) < 20) || (round($persen50,2) > 90))  {
            $str_condition_denom_50 = array('data' => round($persen50,2).' %', 'style' => 'background:#C82333;font-weight: bold;color:white');
        }elseif(((round($persen50,2) > 20) && (round($persen50,2) < 25)) || ((round($persen50,2) > 85) && (round($persen50,2) < 90)))  {
            $str_condition_denom_50 = array('data' => round($persen50,2).' %', 'style' => 'background:#E0A800;font-weight: bold;color:black');
        }else{
            $str_condition_denom_50 = round($persen50,2).' %';
        }

        if((round($persen100,2) < 20) || (round($persen100,2) > 90))  {
            $str_condition_denom_100 = array('data' => round($persen100,2).' %', 'style' => 'background:#C82333;font-weight: bold;color:white');
        }elseif(((round($persen100,2) > 20) && (round($persen100,2) < 25)) || ((round($persen100,2) > 85) && (round($persen100,2) < 90)))  {
            $str_condition_denom_100 = array('data' => round($persen100,2).' %', 'style' => 'background:#E0A800;font-weight: bold;color:black');
        }else{
            $str_condition_denom_100 = round($persen100,2).' %';
        }


        $status_slm = '';
        $status_flm = '';

        $result=$this->Postilion_model->get_status_flm_slm($term->id,'flm');
        foreach ($result as $v){
            $status_flm=$v->status_flm;
        }

        $result=$this->Postilion_model->get_status_flm_slm($term->id,'slm');
        foreach ($result as $v){
            $status_slm=$v->status_slm;
        }

        if ($str_condition == 'OK' &&  $mode[0] == 'In Service') {
            if ($status_flm == 'Submit' || $status_flm == 'Modify') {
              $this->Postilion_model->update_status_flm($term->id, 'status_flm');
            }
            if ($status_slm == 'Submit' || $status_slm == 'Modify') {
              $this->Postilion_model->update_status_slm('tbl_slm', $term->id, 'status_slm');
            }
            $cell_flm = '';
            $cell_slm = '';
          }
    
          if ($str_condition != 'OK' || $mode[0] != 'In Service') {
    
            $cell_flm = '<input id="flmid" type="button" onclick="add_person(this.value,' . "'" . $term->id . "','Submit'" . ')" title="' . $term->id . '" value="FLM" class="btn btn-warning" 
                         onmouseover="this.title=\'\';" >';
            $cell_slm = '<input id="slmid" type=button value=SLM disabled class="btn btn-warning" 
                         >';
            if ($status_flm == 'Submit' || $status_flm == 'Modify') {
    
              $cell_flm = '<input id="flmid" type="button" onclick="add_person(this.value,' . "'" . $term->id . "','Modify'" . ')" title="' . $term->id . '" value="FLM" class="btn btn-danger" 
                   onmouseover="this.title=\'\';" >';
              $cell_slm = '<input id="slmid" type=button onclick=add_person(this.value,' . "'" . $term->id . "','Submit'" . ') value=SLM class="btn btn-warning" 
                  >';
            }
            if ($status_slm == 'Submit' || $status_slm == 'Modify') {
    
              $cell_flm = '<input id="flmid" type="button" onclick="add_person(this.value,' . "'" . $term->id . "','Modify'" . ')" title="' . $term->id . '" value="FLM" class="btn btn-danger" 
                   onmouseover="this.title=\'\';" >';
    
              $cell_slm = '<input id="slmid" type=button onclick="add_person(this.value,' . "'" . $term->id . "','Modify'" . ')" value=SLM class="btn btn-danger" 
                  >';
            }
            //die($status_flm);
          }



                    $this->table->add_row(
                                            // ++$i, 
                                            $term->id, 
                                            str_replace('_', ' ', $term->short_name), 
                                            $str_condition, 
                                            $mode[0], 
                                            //number_format(str_replace('IDR',' ',$nominal[0])),  
                                            number_format(str_replace('IDR',' ',$totalamount[1])),
                                            $str_condition_denom_50,
                                            //number_format(str_replace('IDR',' ',$nominal100[0])), 
                                            number_format(str_replace('IDR', ' ',$totalamount100[1])),
                                            $str_condition_denom_100,
                                            $problem,
                                            $faulty,
                                            $cell_flm . $cell_slm);
    				//$this->table->add_row(++$i, $term->id, str_replace('_', ' ', $term->short_name), $str_condition, $cell8);                    
                }
    }

    

    $data = array(
        'title'               => 'Monitoring-Cardless',
        'header_view'         => 'header_view',
        'content_view'        => 'terminal/cardless',
        'sub_header_title'    => 'Terminal Monitoring',
        'header_title'        => 'CARDLESS',
        'username'            => $this->session->userdata('logged_full_name'),
        'lastlogin'           => $this->session->userdata('logged_last_login'),
    //   'table'               => $this->table->generate(),
    //   'table_log'           => $this->table->generate();
    );

    $data['table'] = $this->table->generate();


    $this->get_table_log();
    $data['table_log'] = $this->table->generate();

    $this->load->view('template', $data);
  }

  public function get_datetime_server()
  {
        echo date('Y-m-d H:i:s');
  }

  public function ajax_get_history_offline($term_id){
    $data = $this->vModal->get_data_offline_history($term_id);
    echo json_encode($data);
  }

}
