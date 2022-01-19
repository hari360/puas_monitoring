<?php

class Reporting_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        // $this->db_iso = $this->load->database('iso_office', TRUE);
    }

    function print_report()
    {
        $this->db_iso->select('ROW_NUMBER() OVER (
            PARTITION BY 
                terminal_id 
            ORDER BY 
                terminal_id
                ,datetime_tran_local 
        ) row_num,
        sum(amount_req) OVER (
            PARTITION BY 
                terminal_id 
        ) as jml_amount_req
        ,CONVERT(varchar,datetime_tran_local,106) as tgl
        ,\'coba,ah\' as test1
        ,CONVERT(varchar,datetime_tran_local,24) as waktu,*');
        // $this->db_iso->order_by('terminal_id asc, datetime_tran_local DESC');
        return $this->db_iso->get_where('iso_trans', array('batch_nr' => 20210706), 10)->result();
        // $this->db_iso->get_where('iso_trans',array('batch_nr' => 20210706),10);
        // die($this->db_iso->last_query());

        // print_r($this->db_iso->get_where('iso_trans',array('batch_nr' => 20210706),10)->result_array());
    }

    // function detail_report_xlsx($bsn_date, $type, $other_param){
    //     $category = ($type=='approved' ? 'get_detail_transaction_approved' : 'get_detail_transaction_rejected');
    //     $query = $this->db_iso->query(sprintf("exec ".$category." '%s'", $bsn_date));
    //     return $query;
    // }

    function detail_report_xlsx_atmi_ptpr($bsn_date, $type, $selected_term, $tran_type, $from_datetime, $to_datetime)
    {
        $this->db->select('ROW_NUMBER() OVER (
            PARTITION BY 
                terminal_id 
            ORDER BY 
                terminal_id
                ,datetime_tran_local 
        ) row_num,
        sum(amount_req) OVER (
            PARTITION BY 
                terminal_id 
        ) as jml_amount_req
		,count(*) OVER () as jml_record,*');

        $this->db->where('left(terminal_id,3)', '042');

        if ($bsn_date != '') {
            $this->db->where('batch_nr', $bsn_date);
        }

        if ($selected_term != '') {
            $string = $selected_term;
            $array = explode(',', $string);
            $this->db->where_in('terminal_id', $array);
        }
        if ($tran_type != '') {
            $this->db->where('tran_type_name', $tran_type);
        }

        if ($from_datetime != '' && $to_datetime != '') {
            $this->db->where('datetime_tran_local >=', $from_datetime);
            $this->db->where('datetime_tran_local <=', $to_datetime);
        }

        
        $this->db->order_by("terminal_id", "asc");
        $this->db->order_by("datetime_tran_local", "asc"); 

        // return $this->db_iso->get(($type=='approved' ? 'v_get_detail_trx' : 'v_test_detail_trx_rejected'));
        //$this->db->limit(17);
        return $this->db->get('iso_output_detail');
        // die($this->db_iso->last_query());   
    }

    function detail_report_xlsx_ptpr($bsn_date, $type, $selected_term, $tran_type, $from_datetime, $to_datetime)
    {
        $this->db->select('ROW_NUMBER() OVER (
            PARTITION BY 
                terminal_id 
            ORDER BY 
                terminal_id
                ,datetime_tran_local 
        ) row_num,
        sum(amount_req) OVER (
            PARTITION BY 
                terminal_id 
        ) as jml_amount_req
		,count(*) OVER () as jml_record,*');

        $this->db->where('left(terminal_id,3)', '042');
        if ($bsn_date != '') {
            $this->db->where('batch_nr', $bsn_date);
        }

        if ($selected_term != '') {
            $string = $selected_term;
            $array = explode(',', $string);
            $this->db->where_in('terminal_id', $array);
        }
        if ($tran_type != '') {
            $this->db->where('tran_type_name', $tran_type);
        }

        if ($from_datetime != '' && $to_datetime != '') {
            $this->db->where('datetime_tran_local >=', $from_datetime);
            $this->db->where('datetime_tran_local <=', $to_datetime);
        }

        $this->db->order_by("terminal_id", "asc");
        $this->db->order_by("datetime_tran_local", "asc"); 
        // return $this->db_iso->get(($type=='approved' ? 'v_get_detail_trx' : 'v_test_detail_trx_rejected'));
        //$this->db->limit(17);
        return $this->db->get('iso_output_detail');
        // die($this->db_iso->last_query());   
    }

    function detail_report_xlsx($bsn_date, $type, $selected_term, $tran_type, $from_datetime, $to_datetime)
    {
        $this->db->select('ROW_NUMBER() OVER (
            PARTITION BY 
                terminal_id 
            ORDER BY 
                terminal_id
                ,datetime_tran_local 
        ) row_num,
        sum(amount_req) OVER (
            PARTITION BY 
                terminal_id 
        ) as jml_amount_req
		,count(*) OVER () as jml_record,*');

        $this->db->where('left(terminal_id,3)', '010');
        if ($bsn_date != '') {
            $this->db->where('batch_nr', $bsn_date);
        }

        if ($selected_term != '') {
            $string = $selected_term;
            $array = explode(',', $string);
            $this->db->where_in('terminal_id', $array);
        }
        if ($tran_type != '') {
            $this->db->where('tran_type_name', $tran_type);
        }

        if ($from_datetime != '' && $to_datetime != '') {
            $this->db->where('datetime_tran_local >=', $from_datetime);
            $this->db->where('datetime_tran_local <=', $to_datetime);
        }

        $this->db->order_by("terminal_id", "asc");
        $this->db->order_by("datetime_tran_local", "asc"); 
        // return $this->db_iso->get(($type=='approved' ? 'v_get_detail_trx' : 'v_test_detail_trx_rejected'));
        // $this->db->limit(15000);
        return $this->db->get('iso_output_detail');
        // die($this->db_iso->last_query());   
    }

    function detail_report_xlsx_crm($bsn_date, $type, $selected_term, $tran_type, $from_datetime, $to_datetime)
    {
        $this->db->select('ROW_NUMBER() OVER (
            PARTITION BY 
                terminal_id 
            ORDER BY 
                terminal_id
                ,datetime_tran_local 
        ) row_num,
        sum(amount_req) OVER (
            PARTITION BY 
                terminal_id 
        ) as jml_amount_req
		,count(*) OVER () as jml_record,*');

        $this->db->like('tran_type_name', 'cardless','both');
        // $this->db->where('left(terminal_id,3)', '041');
        if ($bsn_date != '') {
            $this->db->where('batch_nr', $bsn_date);
        }

        if ($selected_term != '') {
            $string = $selected_term;
            $array = explode(',', $string);
            $this->db->where_in('terminal_id', $array);
        }
        if ($tran_type != '') {
            $this->db->where('tran_type_name', $tran_type);
        }

        if ($from_datetime != '' && $to_datetime != '') {
            $this->db->where('datetime_tran_local >=', $from_datetime);
            $this->db->where('datetime_tran_local <=', $to_datetime);
        }

        $this->db->order_by("terminal_id", "asc");
        $this->db->order_by("datetime_tran_local", "asc"); 
        // return $this->db_iso->get(($type=='approved' ? 'v_get_detail_trx' : 'v_test_detail_trx_rejected'));
        // $this->db->limit(15000);
        return $this->db->get('iso_output_detail_crm');
        // die($this->db_iso->last_query());   
    }

    function detail_report_reject_xlsx($bsn_date, $type, $selected_term, $tran_type, $from_datetime, $to_datetime)
    {
        $this->db->select('ROW_NUMBER() OVER (
            PARTITION BY 
                issuer_name 
            ORDER BY 
                 issuer_name
                ,datetime_tran_local 
        ) row_num,
        sum(amount_req) OVER (
            PARTITION BY 
                    issuer_name 
        ) as jml_amount_req
		,count(*) OVER () as jml_record,*');

        $this->db->where('left(terminal_id,3)', '010');

        if ($bsn_date != '') {
            $this->db->where('batch_nr', $bsn_date);
        }

        if ($selected_term != '') {
            $string = $selected_term;
            $array = explode(',', $string);
            $this->db->where_in('terminal_id', $array);
        }
        if ($tran_type != '') {
            $this->db->where('tran_type_name', $tran_type);
        }

        if ($from_datetime != '' && $to_datetime != '') {
            $this->db->where('datetime_tran_local >=', $from_datetime);
            $this->db->where('datetime_tran_local <=', $to_datetime);
        }

        $this->db->order_by('issuer,datetime_tran_local', 'asc');
        return $this->db->get('iso_output_detail_reject');
        // die($this->db_iso->last_query());   
    }

    function detail_report_reject_xlsx_crm($bsn_date, $type, $selected_term, $tran_type, $from_datetime, $to_datetime)
    {
        $this->db->select('ROW_NUMBER() OVER (
            PARTITION BY 
                issuer_name 
            ORDER BY 
                 issuer_name
                ,datetime_tran_local 
        ) row_num,
        sum(amount_req) OVER (
            PARTITION BY 
                    issuer_name 
        ) as jml_amount_req
		,count(*) OVER () as jml_record,*');

        $this->db->like('tran_type_name', 'cardless','both');

        if ($bsn_date != '') {
            $this->db->where('batch_nr', $bsn_date);
        }

        if ($selected_term != '') {
            $string = $selected_term;
            $array = explode(',', $string);
            $this->db->where_in('terminal_id', $array);
        }
        if ($tran_type != '') {
            $this->db->where('tran_type_name', $tran_type);
        }

        if ($from_datetime != '' && $to_datetime != '') {
            $this->db->where('datetime_tran_local >=', $from_datetime);
            $this->db->where('datetime_tran_local <=', $to_datetime);
        }

        $this->db->order_by('issuer,datetime_tran_local', 'asc');
        return $this->db->get('iso_output_detail_reject_crm');
        // die($this->db_iso->last_query());   
    }


    function detail_report_reject_xlsx_atmi_ptpr($bsn_date, $type, $selected_term, $tran_type, $from_datetime, $to_datetime)
    {
        $this->db->select('ROW_NUMBER() OVER (
            PARTITION BY 
                issuer_name 
            ORDER BY 
                 issuer_name
                ,datetime_tran_local 
        ) row_num,
        sum(amount_req) OVER (
            PARTITION BY 
                    issuer_name 
        ) as jml_amount_req
		,count(*) OVER () as jml_record,*');

        $this->db->where('left(terminal_id,3)', '042');

        if ($bsn_date != '') {
            $this->db->where('batch_nr', $bsn_date);
        }

        if ($selected_term != '') {
            $string = $selected_term;
            $array = explode(',', $string);
            $this->db->where_in('terminal_id', $array);
        }
        if ($tran_type != '') {
            $this->db->where('tran_type_name', $tran_type);
        }

        if ($from_datetime != '' && $to_datetime != '') {
            $this->db->where('datetime_tran_local >=', $from_datetime);
            $this->db->where('datetime_tran_local <=', $to_datetime);
        }

        $this->db->order_by('issuer,datetime_tran_local', 'asc');
        return $this->db->get('iso_output_detail_reject');
        // die($this->db_iso->last_query());   
    }
    
    function detail_report_reject_xlsx_ptpr($bsn_date, $type, $selected_term, $tran_type, $from_datetime, $to_datetime)
    {
        $this->db->select('ROW_NUMBER() OVER (
            PARTITION BY 
                issuer_name 
            ORDER BY 
                 issuer_name
                ,datetime_tran_local 
        ) row_num,
        sum(amount_req) OVER (
            PARTITION BY 
                    issuer_name 
        ) as jml_amount_req
		,count(*) OVER () as jml_record,*');

        $this->db->where('left(terminal_id,3)', '042');

        if ($bsn_date != '') {
            $this->db->where('batch_nr', $bsn_date);
        }

        if ($selected_term != '') {
            $string = $selected_term;
            $array = explode(',', $string);
            $this->db->where_in('terminal_id', $array);
        }
        if ($tran_type != '') {
            $this->db->where('tran_type_name', $tran_type);
        }

        if ($from_datetime != '' && $to_datetime != '') {
            $this->db->where('datetime_tran_local >=', $from_datetime);
            $this->db->where('datetime_tran_local <=', $to_datetime);
        }

        $this->db->order_by('issuer,datetime_tran_local', 'asc');
        return $this->db->get('iso_output_detail_reject');
        // die($this->db_iso->last_query());   
    }

    function vault_settlement_xlsx($bsndate)
    {
        // return $this->db_iso->get_where('tbl_settlement_fee_acq',array('bsn_date' => $bsn_date))->row();

        // $query = $this->db->query(sprintf("exec iso_vault_settlement '%s','%s'", $bsndate,'010'));
        // $this->db->db_debug = false;

        // if(!$this->db->query(sprintf("exec iso_vault_settlement '%s','%s'", $bsndate,'010')))
        // {
        //     $error = $this->db->error();
        //     // do something in error case
        // }else{
        //     // do something in success case
        // }
        // $last_query = $this->db->last_query();
        // die($this->db->last_query());

        // return $query->row();
        return $this->db->get_where('iso_tbl_settlement',array(
            'bsn_date'          => $bsndate,
            'report'            => '010',
            'vault_description' => 'Settlement_BTNPen',
            ))->row();
    }

    function vault_settlement_xlsx_ptpr($bsndate)
    {
        // return $this->db_iso->get_where('tbl_settlement_fee_acq',array('bsn_date' => $bsn_date))->row();

        // $query = $this->db->query(sprintf("exec iso_vault_settlement '%s','%s'", $bsndate,'042'));
        // return $query->row();
        return $this->db->get_where('iso_tbl_settlement',array(
            'bsn_date'          => $bsndate,
            'report'            => '042',
            'vault_description' => 'Settlement_PTPR',
            ))->row();
    }

    function fee_settlement_xlsx($bsndate)
    {
        // return $this->db_iso->get_where('tbl_settlement_fee_acq',array('bsn_date' => $bsn_date))->row();

        // $query = $this->db->query(sprintf("exec iso_settlement_fee '%s','%s'", $bsndate,'010'));
        return $this->db->get_where('iso_tbl_settlement',array(
            'bsn_date'          => $bsndate,
            'report'            => '010',
            'vault_description' => 'Settlement FEE_Acquire_ATMi',
            ))->row();
        //return $this->db->get()->row();
    }

    function fee_settlement_xlsx_ptpr($bsndate)
    {
        // return $this->db_iso->get_where('tbl_settlement_fee_acq',array('bsn_date' => $bsn_date))->row();

        // $query = $this->db->query(sprintf("exec iso_settlement_fee '%s','%s'", $bsndate,'042'));
        // return $query->row();
        return $this->db->get_where('iso_tbl_settlement',array(
            'bsn_date'          => $bsndate,
            'report'            => '042',
            'vault_description' => 'Settlement_FEE_PTPR',
            ))->row();
    }

    function summary_xlsx($bsndate)
    {
        $query = $this->db->query(sprintf("exec iso_get_summary_transaction '%s','%s'", '010',$bsndate));
        return $query->result();
    }

    function summary_xlsx_crm($bsndate)
    {
        $query = $this->db->query(sprintf("exec iso_get_summary_transaction_crm '%s','%s'", '041',$bsndate));
        return $query->result();
    }

    function summary_xlsx_ptpr($bsndate)
    {
        // $query = $this->db_iso->query(sprintf("exec get_summary_tran_type '%s','%s','%s'", $from_date, $to_date, $tran_type));
        // return $query->result();

        $query = $this->db->query(sprintf("exec iso_get_summary_transaction '%s','%s'", '042',$bsndate));
        return $query->result();
    }

    function get_batch_xls_crm($bsndate)
    {
        // return $this->db_iso->get_where('tbl_settlement_fee_acq',array('bsn_date' => $bsn_date))->row();

        $this->db->select('batch_nr');
        $this->db->where('bsn_date', $bsndate);
        return $this->db->get('iso_batch_crm')->row()->batch_nr;
    }

    function insert_log_generate($data)
    {
        $this->db->insert('iso_log_generate', $data);
        return $this->db->insert_id();
    }
}
