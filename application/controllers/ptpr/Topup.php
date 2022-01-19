<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Topup extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->myauth->permission_page('2');
        $this->load->model('Dashboard_model', '', TRUE);
        $this->load->model('Ptpr_model', '', TRUE);
    }

    function get_table_req_package()
    {
        $data_where = array(
            'status'    => 'Requested',
        );
        $terms = $this->Ptpr_model->get_data_history_package('Requested');

        $tmpl = array(
            'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_req_package" width="100%">',
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
            'Request No',
            'Package',
            'User Request',
            'Date Request',
            // 'Date Approved',
            'Status',
            'Actions',
        );

        foreach ($terms as $term) {

            //   $cell_actions = '<button class="btn btn-primary btn-sm edit-list-package"><i class="zmdi zmdi-edit"></i></button>
            //   <button class="btn btn-danger btn-sm" onclick="modal_delete_list_package(this.value,'."'".$term->id."'".','."'".$term->limit."'".')"><i class="zmdi zmdi-delete"></i></button>';
            // $cell_actions = '<button class="btn btn-success btn-sm" onclick="approve_req_topup(this.value,' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->invoice_no . "'" . ')"><i class="zmdi zmdi-check"></i></button>
            // <button class="btn btn-primary btn-sm edit-terminal-access" ><i class="zmdi zmdi-edit"></i></button>
            // <button class="btn btn-danger btn-sm" onclick="reject_req_topup(this.value,' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->invoice_no . "'" . ')"><i class="zmdi zmdi-close-circle"></i></button>';


            $cell_actions = '<button class="btn btn-success btn-sm" onclick="approve_req_topup(this.value,' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->user_finance . "'" . ',' . "'" . $term->nomor . "'" . ')"><i class="zmdi zmdi-check"></i> Finance Approve</button>
        <button class="btn btn-danger btn-sm" onclick="reject_req_topup(this.value,' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->user_finance . "'" . ')"><i class="zmdi zmdi-close-circle"></i> Finance Reject</button>';


            $this->table->add_row(
                $term->invoice_no,
                $term->package_selected,
                $term->user_request,
                $term->date_request,
                // $term->date_approved,

                // number_format($term->limit),
                // number_format($term->price),
                // number_format($term->fee),
                $term->status,
                // $cell_actions
                array('data' => $cell_actions, 'align' => 'center')
            );
        }
    }

    function get_table_app_package()
    {
        $data_where = array(
            'status'    => 'Approved By Finance',
        );
        $terms = $this->Ptpr_model->get_data_history_package('Approved By Finance');

        $tmpl = array(
            'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_app_package" width="100%">',
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
            'Attachment',
            'Actions',
            'Request No',
            'Package',
            'User Request',
            'Date Request',
            'User Finance',
            'Date Finance Approved',
            'Payment Date',
            'Status',
            
        );

        foreach ($terms as $term) {

            //   $cell_actions = '<button class="btn btn-primary btn-sm edit-list-package"><i class="zmdi zmdi-edit"></i></button>
            //   <button class="btn btn-danger btn-sm" onclick="modal_delete_list_package(this.value,'."'".$term->id."'".','."'".$term->limit."'".')"><i class="zmdi zmdi-delete"></i></button>';
            // $cell_actions = '<button class="btn btn-success btn-sm" onclick="approve_req_topup(this.value,' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->invoice_no . "'" . ')"><i class="zmdi zmdi-check"></i></button>
            // <button class="btn btn-primary btn-sm edit-terminal-access" ><i class="zmdi zmdi-edit"></i></button>
            // <button class="btn btn-danger btn-sm" onclick="reject_req_topup(this.value,' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->invoice_no . "'" . ')"><i class="zmdi zmdi-close-circle"></i></button>';

           
            $get_first_approved = $this->Ptpr_model->get_first_approved_rcs();
            
            // $get_first_approved = $term->nomor
            $cell_extends = array('class' => 'details-control', 'title' => $term->invoice_no, 'data-prefix' => $term->invoice_no);

            $cell_actions = '<button class="btn btn-success btn-sm" onclick="approve_req_topup(' . "" . "'RCS Approve'" . ',' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->user_finance . "'" .',' . "'" . $term->nomor . "'" .',' . "'" . $get_first_approved . "'" .',' . "'" . $term->user_request . "'" .',' . "'" . $term->date_request . "'" .',' . "'" . $term->package_selected . "'" . ')"><i class="zmdi zmdi-check"></i> RCS Approve</button>
        <button class="btn btn-danger btn-sm" onclick="reject_req_topup(this.value,' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->user_finance . "'" . ')"><i class="zmdi zmdi-close-circle"></i> RCS Reject</button>';


            $this->table->add_row(
                $cell_extends,
                array('data' => $cell_actions, 'align' => 'center'),
                $term->invoice_no,
                $term->package_selected,
                $term->user_request,
                $term->date_request,
                $term->user_finance,
                $term->date_fin_approved,
                $term->payment_date,

                // number_format($term->limit),
                // number_format($term->price),
                // number_format($term->fee),
                $term->status,
                // $cell_actions
                
            );
        }
    }

    function get_table_app_rcs_package()
    {
        $data_where = array(
            'status'    => 'Approved By RCS',
        );
        $terms = $this->Ptpr_model->get_data_history_package('Approved By RCS');

        $tmpl = array(
            'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_app_rcs_package" width="100%">',
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
            'Attachment',
            'Request No',
            'Package',
            'User Request',
            'Date Request',
            'User Finance',
            'Date Finance Approved',
            'Payment Date',
            'User RCS',
            'Date RCS Approved',
            'Status',
            'Transaction Status'
            // 'Actions',
        );

        foreach ($terms as $term) {

            //   $cell_actions = '<button class="btn btn-primary btn-sm edit-list-package"><i class="zmdi zmdi-edit"></i></button>
            //   <button class="btn btn-danger btn-sm" onclick="modal_delete_list_package(this.value,'."'".$term->id."'".','."'".$term->limit."'".')"><i class="zmdi zmdi-delete"></i></button>';
            // $cell_actions = '<button class="btn btn-success btn-sm" onclick="approve_req_topup(this.value,' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->invoice_no . "'" . ')"><i class="zmdi zmdi-check"></i></button>
            // <button class="btn btn-primary btn-sm edit-terminal-access" ><i class="zmdi zmdi-edit"></i></button>
            // <button class="btn btn-danger btn-sm" onclick="reject_req_topup(this.value,' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->invoice_no . "'" . ')"><i class="zmdi zmdi-close-circle"></i></button>';


            // $cell_actions = '<button class="btn btn-success btn-sm" onclick="approve_req_topup(this.value,' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->invoice_no . "'" . ')"><i class="zmdi zmdi-check"></i></button>
            // <button class="btn btn-danger btn-sm" onclick="reject_req_topup(this.value,' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->invoice_no . "'" . ')"><i class="zmdi zmdi-close-circle"></i></button>';


            $cell_extends = array('class' => 'details-control', 'title' => $term->invoice_no, 'data-prefix' => $term->invoice_no);

            $this->table->add_row(
                $cell_extends,
                $term->invoice_no,
                $term->package_selected,
                $term->user_request,
                $term->date_request,
                $term->user_finance,
                $term->date_fin_approved,
                $term->payment_date,
                $term->user_rcs,
                $term->date_rcs_approved,

                // number_format($term->limit),
                // number_format($term->price),
                // number_format($term->fee),
                $term->status,
                $term->status_log,
                // $cell_actions
                // array('data' => $cell_actions, 'align' => 'center')
            );
        }
    }

    function get_table_rej_package()
    {
        $data_where = array(
            'status'    => 'Rejected By Finance',
        );
        $terms = $this->Ptpr_model->get_data_history_package('Rejected By Finance');

        $tmpl = array(
            'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_rej_package" width="100%">',
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
            'Request No',
            'Package',
            'User Request',
            'Date Request',
            'User Finance',
            'Finance Rejected',
            'Status',
            // 'Actions',
        );

        foreach ($terms as $term) {

            $this->table->add_row(
                $term->invoice_no,
                $term->package_selected,
                $term->user_request,
                $term->date_request,
                $term->user_finance,
                $term->date_fin_rejected,
                $term->status,
            );
        }
    }

    function get_table_rej_rcs_package()
    {
        $data_where = array(
            'status'    => 'Rejected By RCS',
        );
        $terms = $this->Ptpr_model->get_data_history_package('Rejected By RCS');

        $tmpl = array(
            'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_rej_rcs_package" width="100%">',
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
            'Request No',
            'Package',
            'User Request',
            'Date Request',
            'User Finance',
            'Finance Approved',
            'User RCS',
            'RCS Rejected',
            'Status',
            // 'Actions',
        );

        foreach ($terms as $term) {

            //   $cell_actions = '<button class="btn btn-primary btn-sm edit-list-package"><i class="zmdi zmdi-edit"></i></button>
            //   <button class="btn btn-danger btn-sm" onclick="modal_delete_list_package(this.value,'."'".$term->id."'".','."'".$term->limit."'".')"><i class="zmdi zmdi-delete"></i></button>';
            // $cell_actions = '<button class="btn btn-success btn-sm" onclick="approve_req_topup(this.value,' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->invoice_no . "'" . ')"><i class="zmdi zmdi-check"></i></button>
            // <button class="btn btn-primary btn-sm edit-terminal-access" ><i class="zmdi zmdi-edit"></i></button>
            // <button class="btn btn-danger btn-sm" onclick="reject_req_topup(this.value,' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->invoice_no . "'" . ')"><i class="zmdi zmdi-close-circle"></i></button>';


            // $cell_actions = '<button class="btn btn-success btn-sm" onclick="approve_req_topup(this.value,' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->invoice_no . "'" . ')"><i class="zmdi zmdi-check"></i></button>
            // <button class="btn btn-danger btn-sm" onclick="reject_req_topup(this.value,' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->invoice_no . "'" . ')"><i class="zmdi zmdi-close-circle"></i></button>';


            $this->table->add_row(
                $term->invoice_no,
                $term->package_selected,
                $term->user_request,
                $term->date_request,
                $term->user_finance,
                $term->date_fin_approved,
                $term->user_rcs,
                $term->date_rcs_rejected,

                // number_format($term->limit),
                // number_format($term->price),
                // number_format($term->fee),
                $term->status,
                // $cell_actions
                // array('data' => $cell_actions, 'align' => 'center')
            );
        }
    }

    function get_table_completed_package()
    {
        $data_where = array(
            'status'        => 'Approved By RCS',
            'status_log'    => 'Completed',
        );
        $terms = $this->Ptpr_model->get_history_completed_package($data_where);

        $tmpl = array(
            'table_open'    => '<table class="table table-bordered table-striped table-hover nowrap" id="dt_completed_package" width="100%">',
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
            'Request No',
            'Package',
            'User Request',
            'Date Request',
            'User Finance',
            'Finance Approved',
            'User RCS',
            'RCS Approved',
            'Status Expired',
            'Status Transaksi',
            'Date Completed'
        );

        foreach ($terms as $term) {

            //   $cell_actions = '<button class="btn btn-primary btn-sm edit-list-package"><i class="zmdi zmdi-edit"></i></button>
            //   <button class="btn btn-danger btn-sm" onclick="modal_delete_list_package(this.value,'."'".$term->id."'".','."'".$term->limit."'".')"><i class="zmdi zmdi-delete"></i></button>';
            // $cell_actions = '<button class="btn btn-success btn-sm" onclick="approve_req_topup(this.value,' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->invoice_no . "'" . ')"><i class="zmdi zmdi-check"></i></button>
            // <button class="btn btn-primary btn-sm edit-terminal-access" ><i class="zmdi zmdi-edit"></i></button>
            // <button class="btn btn-danger btn-sm" onclick="reject_req_topup(this.value,' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->invoice_no . "'" . ')"><i class="zmdi zmdi-close-circle"></i></button>';


            // $cell_actions = '<button class="btn btn-success btn-sm" onclick="approve_req_topup(this.value,' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->invoice_no . "'" . ')"><i class="zmdi zmdi-check"></i></button>
            // <button class="btn btn-danger btn-sm" onclick="reject_req_topup(this.value,' . "'" . $term->invoice_no . "'" . ',' . "'" . $term->invoice_no . "'" . ')"><i class="zmdi zmdi-close-circle"></i></button>';


            $this->table->add_row(
                $term->invoice_no,
                $term->package_selected,
                $term->user_request,
                $term->date_request,
                $term->user_finance,
                $term->date_fin_approved,
                $term->user_rcs,
                $term->date_rcs_approved,

                // number_format($term->limit),
                // number_format($term->price),
                // number_format($term->fee),
                $term->expired_status,
                $term->status_log,
                $term->datetime_expired_trx,
                // $cell_actions
                // array('data' => $cell_actions, 'align' => 'center')
            );
        }
    }



    function index()
    {
        $data = array(
            'title'               => 'Topup Package',
            'header_view'         => 'header_view',
            'content_view'        => 'ptpr/topup',
            'sub_header_title'    => 'Topup Package',
            'header_title'        => 'Request Topup',
            'username'            => $this->session->userdata('logged_full_name'),
            'lastlogin'           => $this->session->userdata('logged_last_login'),
            'list_package'        => $this->Ptpr_model->get_list_package(),
            // 'table_req_package'   => $this->table->generate(),
            // 'table_app_package'   => $this->table->generate(),
            // 'table_rej_package'   => $this->table->generate()
        );

        // $this->generatexl->send_mail_request_topup(20220107);

        $this->get_table_req_package();
        $data['table_req_package'] = $this->table->generate();

        $this->get_table_app_package();
        $data['table_app_package'] = $this->table->generate();

        $this->get_table_app_rcs_package();
        $data['table_app_rcs_package'] = $this->table->generate();

        $this->get_table_rej_package();
        $data['table_rej_package'] = $this->table->generate();

        $this->get_table_rej_rcs_package();
        $data['table_rej_rcs_package'] = $this->table->generate();

        $this->get_table_completed_package();
        $data['table_completed_package'] = $this->table->generate();

        $this->load->view('template', $data);
    }

    function insert_req_package()
    {
        $now = new DateTime();
        //echo $now->format("Y-m-d H:i:s.v");

        $data = array(
            'invoice_no'        => '#BTN' . $now->format("YmdHisv"), //$this->input->post('txt_package_code'),
            'user_request'      => $this->session->userdata('logged_user_name'),
            'date_request'      => date('Y-m-d H:i:s'),
            'package_selected'  => $this->input->post('cmb_package_selected'),
            'status'            => 'Requested',
            // 'date_insert'       => date('Y-m-d H:i:s'),
        );
        // print_r($data);

        $data_email = array(
            'invoice_no'        => '#BTN' . $now->format("YmdHisv"), //$this->input->post('txt_package_code'),
            'user_request'      => $this->session->userdata('logged_user_name'),
            'date_request'      => date('Y-m-d H:i:s'),
            'package_selected'  => $this->input->post('cmb_package_selected'),
            'price'             => $this->input->post('cmb_package_selected'),
            'price'             => $this->input->post('cmb_package_selected'),
            'price'             => $this->input->post('cmb_package_selected'),
            // 'date_insert'       => date('Y-m-d H:i:s'),
        );

        if ($this->Ptpr_model->request_topup_package($data)) {
            $this->generatexl->send_mail_request_topup($data);
            $this->session->set_flashdata('messagesuccess', "Record has been inserted with request no : " . $data['invoice_no']);
        } else {
            $this->session->set_flashdata('messageerror', "Inserted record has failed");
        }




        redirect('ptpr/topup');
    }

    function upload_image_files()
    {
        $config = array(
            'upload_path'   => './topup',
            'allowed_types' => 'jpg|png',
        );

        $this->load->library('upload', $config);

        $images = array();
        $success_json = array();
        $failed_json = array();

        if (!empty($_FILES['file_image']['name'][0])) {
            $files = $_FILES['file_image'];
            $title = "";

            foreach ($files['name'] as $key => $image) {
                $_FILES['file_image[]']['name'] = $files['name'][$key];
                $_FILES['file_image[]']['type'] = $files['type'][$key];
                $_FILES['file_image[]']['tmp_name'] = $files['tmp_name'][$key];
                $_FILES['file_image[]']['error'] = $files['error'][$key];
                $_FILES['file_image[]']['size'] = $files['size'][$key];

                $fileName = $title . '_' . $image;

                $images[] = $fileName;

                $config['file_name'] = $fileName;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('file_image[]')) {
                    $upload_data =  $this->upload->data();
                    $file_name = $upload_data['file_name'];


                    $data = array(
                        'request_no'    => $file_name,
                        'file_name'     => $this->session->userdata('logged_user_name'),
                        'size_file'     => $upload_data['file_size'],
                        'payment_date'  => $this->input->post('v_payment_date'),
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
}
