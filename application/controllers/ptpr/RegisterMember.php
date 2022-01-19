<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class RegisterMember extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->myauth->permission_page('2');
        $this->load->model('Ptpr_model', '', TRUE);
        $this->load->model('Postilion_model', '', TRUE);
    }

    function get_table_register_interchange()
    {
        $terms = $this->Ptpr_model->get_data_interchange();

        $tmpl = array(
            'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_register_interchange" width="100%">',
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
            'FI Number',
            'Interchange',
            'Source Node',
            'Sink Node',
            'Bank Code',
            'Total Group',
            'Bussiness Entity Name',
            'Actions'
        );

        foreach ($terms as $term) {

          $cell_actions = '<button class="btn btn-primary btn-sm edit-interchange-bank"><i class="zmdi zmdi-edit"></i></button>
          <button class="btn btn-danger btn-sm" onclick="modal_delete_list_interchange(this.value,'."'".$term->fi_number."'".','."'".$term->interchange."'".')"><i class="zmdi zmdi-delete"></i></button>';
  

            $this->table->add_row(
                $term->fi_number,
                $term->interchange,
                $term->source_node,
                $term->sink_node,
                $term->cbc,
                $term->totals_group,
                $term->business_entity_name,
                $cell_actions
            );
        }
    }

    function index()
    {

      $this->get_table_register_interchange();
        $data = array(
            'title'               => 'Register New Member ALTO',
            'header_view'         => 'header_view',
            'content_view'        => 'ptpr/register_member',
            'sub_header_title'    => 'Register New Member ALTO',
            'header_title'        => 'Register New Member ALTO',
            'username'            => $this->session->userdata('logged_full_name'),
            'lastlogin'           => $this->session->userdata('logged_last_login'),
            'list_interchange'    => $this->Postilion_model->get_list_interchange(),
            'table_get_register_interchange'  => $this->table->generate()
        );


        $this->load->view('template', $data);
    }

    function insert_reg_member(){
        $data = array(
            'interchange'           => $this->input->post('interchange'),
            'fi_number'             => $this->input->post('fi_number'),
            'source_node'           => $this->input->post('source_node'),
            'sink_node'             => $this->input->post('sink_node'),
            'cbc'                   => $this->input->post('bank_code'),
            'totals_group'          => $this->input->post('total_group'),
            'business_entity_name'  => $this->input->post('bussiness_entity_name'),
          );
          // print_r($data);
    
          if($this->Ptpr_model->register_new_interchage($data))
          {
            $this->session->set_flashdata('messagesuccess', "Record has been inserted");
          }else{
            $this->session->set_flashdata('messageerror', "Inserted record has failed");
          }

          


          redirect('ptpr/registermember');
    }

}