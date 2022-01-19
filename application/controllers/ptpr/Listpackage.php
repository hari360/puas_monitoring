<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Listpackage extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->myauth->permission_page('2');
        $this->load->model('Dashboard_model', '', TRUE);
        $this->load->model('Ptpr_model', '', TRUE);
    }


    function get_table_package()
    {
        $terms = $this->Ptpr_model->get_data_list_package();

        $tmpl = array(
            'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_list_package" width="100%">',
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
        $td1 = array(
            'data'  => 'Detail Fee',
            'class' => 'no-sort'
        );
        $this->table->set_heading(
            $td1,
            'Package Code',
            'Limit',
            'Price',
            'Minimum Limit',
            'Status',
            'Actions'
        );

        foreach ($terms as $term) {

            $cell_actions = '<button class="btn btn-primary btn-sm edit-list-package"><i class="zmdi zmdi-edit"></i></button>
          <button class="btn btn-danger btn-sm" onclick="modal_delete_list_package(this.value,' . "'" . $term->package_code . "'" . ',' . "'" . $term->limit . "'" . ')"><i class="zmdi zmdi-delete"></i></button>';


            $cell_extends = array('class' => 'details-control', 'title' => $term->package_code, 'data-prefix' => $term->limit);

            $this->table->add_row(
                $cell_extends,
                $term->package_code,
                number_format($term->limit),
                number_format($term->price),
                number_format($term->minimum_limit),
                $term->status,
                $cell_actions
            );
        }
    }


    function index()
    {
        $this->get_table_package();
        $data = array(
            'title'               => 'Add List Package',
            'header_view'         => 'header_view',
            'content_view'        => 'ptpr/listpackage',
            'sub_header_title'    => 'List Package',
            'header_title'        => 'Add Package',
            'username'            => $this->session->userdata('logged_full_name'),
            'lastlogin'           => $this->session->userdata('logged_last_login'),
            'table_get_package'   => $this->table->generate()
        );

        $this->load->view('template', $data);
    }

    function insert_package()
    {

        $json = $this->input->post('data_arr_fee');
        // $json = stripslashes($json);
        // $json = json_decode($json);

        // $vUserId  = $this->input->post('ajaxUserId');
        // $vTerm    = $this->input->post('ajaxListterm');

        $arr_fee = explode('Remove', $json);

        foreach ($arr_fee as $v_arr_fee) {
            $get_data_arr = rtrim(ltrim($v_arr_fee, ','), ',');
            if ($v_arr_fee != "") {
                $arr_fee_2 = explode(',', $get_data_arr);
                // foreach ($arr_fee_2 as $v_arr_fee_2) {
                $datax[] = array(
                    'package_code' => $this->input->post('txt_package_code'),
                    'tran_type'   => $arr_fee_2[0],
                    'iss_fee'     => str_replace(".", "", $arr_fee_2[2]),
                    'acq_fee'     => str_replace(".", "", $arr_fee_2[3]),
                    'swt_fee'     => str_replace(".", "", $arr_fee_2[4]),
                    'date_insert'   => date('Y-m-d H:i:s'),
                );
                // }
            }
        }

        // $this->Ptpr_model->register_list_package_fee($datax);
        // die();


        // print_r($datax);

        // die();
        $data = array(
            'package_code'  => $this->input->post('txt_package_code'),
            'limit'         => str_replace(".", "", $this->input->post('txt_limit')),
            'price'         => str_replace(".", "", $this->input->post('txt_price')),
            'minimum_limit' => str_replace(".", "", $this->input->post('txt_min_limit')),
            'status'        => 'Active',
            'date_insert'   => date('Y-m-d H:i:s'),
        );
        // print_r($data);

        //   $data_fee = array(
        //     'package_code'  => $this->input->post('txt_package_code'),
        //     'tran_type'     => $this->input->post('cmb_tran_type'),
        //     'iss_fee'       => str_replace(".","",$this->input->post('txt_iss_fee')),
        //     'acq_fee'       => str_replace(".","",$this->input->post('txt_fee_acq')),
        //     'swt_fee'       => str_replace(".","",$this->input->post('txt_fee_swt')),
        //     'date_insert'   => date('Y-m-d H:i:s'),
        //   );
        // print_r($data);

        if ($this->Ptpr_model->register_list_package($data)) {
            $this->Ptpr_model->register_list_package_fee($datax);
            $this->session->set_flashdata('messagesuccess', "Record has been inserted");
        } else {
            $this->session->set_flashdata('messageerror', "Inserted record has failed");
        }
        redirect('ptpr/listpackage');
    }


    function update_package_fee()
    {

        $symbols = [".", ","];
        $json = $this->input->post('txt_update_list_fee');
        // $json = stripslashes($json);
        // $json = json_decode($json);

        // $vUserId  = $this->input->post('ajaxUserId');
        // $vTerm    = $this->input->post('ajaxListterm');

        if ($json != ""){
            $arr_fee = explode('RemoveChange', $json);

            foreach ($arr_fee as $v_arr_fee) {
                $get_data_arr = rtrim(ltrim($v_arr_fee, ','), ',');
                if ($v_arr_fee != "") {
                    $arr_fee_2 = explode(',', $get_data_arr);
                    // foreach ($arr_fee_2 as $v_arr_fee_2) {
                    $datax[] = array(
                        'package_code' => $this->input->post('v_edit_package_code'),
                        'tran_type'   => $arr_fee_2[0],
                        'iss_fee'     => str_replace($symbols, "", $arr_fee_2[2]),
                        'acq_fee'     => str_replace($symbols, "", $arr_fee_2[3]),
                        'swt_fee'     => str_replace($symbols, "", $arr_fee_2[4]),
                        'date_insert'   => date('Y-m-d H:i:s'),
                    );
                    // }
                }
            }
        }
        

        // $this->Ptpr_model->register_list_package_fee($datax);
        // die();


        // print_r($datax);

        // die();
        
        $data = array(
            'package_code'  => $this->input->post('v_edit_package_code'),
            'limit'         => str_replace($symbols, "", $this->input->post('v_edit_limit')),
            'price'         => str_replace($symbols, "", $this->input->post('v_edit_price')),
            'minimum_limit' => str_replace($symbols, "", $this->input->post('v_edit_min_limit')),
            'status'        => 'Active',
            'date_insert'   => date('Y-m-d H:i:s'),
        );
        // print_r($data);

        //   $data_fee = array(
        //     'package_code'  => $this->input->post('txt_package_code'),
        //     'tran_type'     => $this->input->post('cmb_tran_type'),
        //     'iss_fee'       => str_replace(".","",$this->input->post('txt_iss_fee')),
        //     'acq_fee'       => str_replace(".","",$this->input->post('txt_fee_acq')),
        //     'swt_fee'       => str_replace(".","",$this->input->post('txt_fee_swt')),
        //     'date_insert'   => date('Y-m-d H:i:s'),
        //   );
        // print_r($data);

        $data_delete = array(
            'package_code' => $this->input->post('v_edit_package_code')
          );
        $this->Ptpr_model->delete_list_package($data_delete);
        $this->Ptpr_model->delete_package_fee($data_delete);

        if ($this->Ptpr_model->register_list_package($data)) {
            if ($json != ""){
            $this->Ptpr_model->register_list_package_fee($datax);
            }
            $this->session->set_flashdata('messagesuccess', "Record has been updated");
        } else {
            $this->session->set_flashdata('messageerror', "updated record has failed");
        }
        redirect('ptpr/listpackage');
    }
}
