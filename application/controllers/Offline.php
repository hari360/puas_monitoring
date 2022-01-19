<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Offline extends MY_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Postilion_model', '', TRUE);
  }

  function detail($id){

    $tmpl = array(
        'table_open'    => '<table class="table table-bordered table-striped table-hover" id="dt_offline" width="100%">',
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
                'No', 
                'ATM ID', 
                'ATM Name', 
                'Mode', 
                'Start Time', 
                'Duration', 
                'kelola'
      );
  
      $offline_data = $this->Postilion_model->get_offline_term();
      // $terms_2 = $this->Postilion_model->term_monitor_offset_temp($this->session->userdata('logged_user_name'));
  
      $i = 0;
      foreach ($offline_data as $data_offline)
      {
        
        $this->table->add_row(++$i, 
                              $data_offline->id, 
                              $data_offline->short_name,
                              $data_offline->status,
                              $data_offline->start_time,
                              $data_offline->duration,
                              $data_offline->kelola
                            );  
  
      }  

      $data = array(
        'title'               => 'Status Terminal',
        'header_view'         => 'header_view',
        'content_view'        => 'offline/detail',
        'sub_header_title'    => 'Terminal Detail',
        'header_title'        => 'TERMINAL STATUS',
        'username'            => $this->session->userdata('logged_full_name'),
        'lastlogin'           => $this->session->userdata('logged_last_login'),
        'table_offline'       => $this->table->generate(),
        'id_menu'             => $id
      );

      $this->detail_closed();
      $data['table_closed'] = $this->table->generate();

      $this->detail_inservice();
      $data['table_inservice'] = $this->table->generate();

      $this->detail_faulty();
      $data['table_faulty'] = $this->table->generate();

      $this->detail_idle();
      $data['table_idle'] = $this->table->generate();

      $this->detail_saldo();
      $data['table_saldo_min'] = $this->table->generate();

      $this->load->view('template', $data);

  }

  function detail_closed(){
    $tmpl = array(
        'table_open'    => '<table class="table table-bordered table-striped table-hover" id="dt_closed" width="100%">',
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
                    'No', 
                    'ATM ID', 
                    'ATM Name', 
                    'Mode', 
                    'Kelola'
      );
  
      $closed_data = $this->Postilion_model->get_closed_term();
      // $terms_2 = $this->Postilion_model->term_monitor_offset_temp($this->session->userdata('logged_user_name'));
  
      $i = 0;
      foreach ($closed_data as $data_closed)
      {
        
        $this->table->add_row(++$i, 
                              $data_closed->id, 
                              $data_closed->short_name,
                              $data_closed->mode,
                              $data_closed->kelola
                            );  
  
      }  

    //   $data = array(
    //     'title'               => 'Status Terminal',
    //     'header_view'         => 'header_view',
    //     'content_view'        => 'offline/detail',
    //     'sub_header_title'    => 'Terminal Detail',
    //     'header_title'        => 'TERMINAL STATUS',
    //     'username'            => $this->session->userdata('logged_full_name'),
    //     'lastlogin'           => $this->session->userdata('logged_last_login'),
    //     'table_closed'       => $this->table->generate(),
    //   );

    //   $this->load->view('template', $data);

  }

  function detail_inservice(){
    $tmpl = array(
        'table_open'    => '<table class="table table-bordered table-striped table-hover" id="dt_inservice" width="100%">',
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
                    'No', 
                    'ATM ID', 
                    'ATM Name', 
                    'Mode', 
                    'Kelola'
      );
  
      $inservice_data = $this->Postilion_model->get_inservice_term();
  
      $i = 0;
      foreach ($inservice_data as $data_inservice)
      {
        
        $this->table->add_row(++$i, 
                              $data_inservice->id, 
                              $data_inservice->short_name,
                              $data_inservice->mode,
                              $data_inservice->kelola
                            );  
  
      }  


  }

  function detail_faulty(){
    $tmpl = array(
        'table_open'    => '<table class="table table-bordered table-striped table-hover" id="dt_faulty" width="100%">',
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
                    'No', 
                    'ATM ID', 
                    'ATM Name', 
                    'Condition', 
                    'Faulty',
                    'Kelola'
      );
  
      $faulty_data = $this->Postilion_model->get_faulty_term();
  
      $i = 0;
      foreach ($faulty_data as $data_faulty)
      {
        
        $this->table->add_row(++$i, 
                                  $data_faulty->id, 
                                  $data_faulty->short_name,
                                  $data_faulty->status = 'Faulty',
                                  $data_faulty->faulty,
                                  $data_faulty->kelola
                              );  
  
      }  


  }

  function detail_idle(){
    $tmpl = array(
      'table_open'    => '<table class="table table-bordered table-striped table-hover" id="dt_idle_term" width="100%">',
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

    $time_saldo = $this->Postilion_model->get_time_saldo();
    $this->table->set_heading(
              'ATM ID', 
              'ATM Name', 
              'Admin', 
              substr($time_saldo->saldo_awal, 0,19), 
              substr($time_saldo->saldo_mid, 0,19),
              substr($time_saldo->saldo_akhir, 0,19), 
              'Difference'
    );

    $data_terminal_saldo = $this->Postilion_model->get_terminal_saldo();

    foreach ($data_terminal_saldo as $data_term_saldo)
    {
      
      $this->table->add_row(
                            $data_term_saldo->terminal_id, 
                            $data_term_saldo->terminal_name,
                            number_format($data_term_saldo->admin_bars),
                            number_format($data_term_saldo->saldo_awal),
                            number_format($data_term_saldo->saldo_mid),
                            number_format($data_term_saldo->saldo),
                            number_format($data_term_saldo->trx)
                          );  

    }  
  }

  function detail_saldo(){
    $tmpl = array(
        'table_open'    => '<table class="table table-bordered table-striped table-hover" id="dt_saldo_min" width="100%">',
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
                    'No', 
                    'ATM ID', 
                    'ATM Name', 
                    'Nominal', 
                    'Kelola'
      );
  
      $saldo_min_data = $this->Postilion_model->get_terminal_saldo_detail();
  
      $i = 0;
      foreach ($saldo_min_data as $data_saldo)
      {
        
        $this->table->add_row(++$i, 
                                  $data_saldo->id, 
                                  $data_saldo->short_name,
                                  $data_saldo->vValueBar,
                                  $data_saldo->kelola
                              );  
  
      }  


  }

}