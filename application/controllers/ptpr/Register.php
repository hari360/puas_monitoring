<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Register extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->myauth->permission_page('2');
        $this->load->model('Ptpr_model', '', TRUE);
        $this->load->model('Postilion_model', '', TRUE);
    }

    function get_table_register()
    {
        $terms = $this->Ptpr_model->get_data_bank_sponsor();

        $tmpl = array(
            'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_register_bank_sponsor" width="100%">',
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
            'CBC',
            'FI Code',
            'Bank Name',
            'Business Entity Name',
            'Email PIC',
            'Email Finance',
            'Bank Account',
            'Account ID',
            'Account Name',
            'Actions'
        );

        foreach ($terms as $term) {

          $cell_actions = '<button class="btn btn-primary btn-sm edit-accounts-bank"><i class="zmdi zmdi-edit"></i></button>
          <button class="btn btn-danger btn-sm" onclick="modal_delete_register(this.value,'."'".$term->fi_number."'".','."'".$term->bank_name."'".')"><i class="zmdi zmdi-delete"></i></button>';
  

            $this->table->add_row(
                $term->cbc,
                $term->fi_number,
                $term->bank_name,
                $term->business_entity,
                $term->email_pic,
                $term->email_finance,
                $term->bank_name,
                $term->account_id,
                $term->account_name,
                $cell_actions
            );
        }
    }

    function index()
    {

      $this->get_table_register();
        $data = array(
            'title'               => 'Register Bank Sponsor',
            'header_view'         => 'header_view',
            'content_view'        => 'ptpr/register',
            'sub_header_title'    => 'Register Bank Sponsor',
            'header_title'        => 'Register Bank Sponsor',
            'username'            => $this->session->userdata('logged_full_name'),
            'lastlogin'           => $this->session->userdata('logged_last_login'),
            'list_interchange'    => $this->Postilion_model->get_list_interchange(),
            'table_get_register'  => $this->table->generate()
        );


        $this->load->view('template', $data);
    }

    function insert_reg(){
        $data = array(
            'cbc'               => $this->input->post('txt_bank_code'),
            'fi_number'         => $this->input->post('txt_fi_code'),
            'bank_name'         => $this->input->post('interchange'),
            'business_entity'   => $this->input->post('txt_entity'),
            'email_pic'         => $this->input->post('email_pic'),
            'email_finance'     => $this->input->post('email_finance'),
            'account_id'        => $this->input->post('account_id'),
            'account_name'      => $this->input->post('account_name'),
            'date_insert'       => date('Y-m-d H:i:s'),
          );
          // print_r($data);
    
          if($this->Ptpr_model->register_bank_sponsor($data))
          {
            $this->session->set_flashdata('messagesuccess', "Record has been inserted");
          }else{
            $this->session->set_flashdata('messageerror', "Inserted record has failed");
          }

          


          redirect('ptpr/register');
    }

}