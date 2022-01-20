<?php

class Postilion_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
        //$this->db_temp = $this->load->database('old_posti', TRUE);
        //$this->db_iso = $this->load->database('iso_office', TRUE);
        //$this->db_postilion_office = $this->load->database('postilion_office', TRUE);
    }

    function term_monitor_offset($username) {
        $query = $this->db->query("exec iso_get_terminal_monitor ?", $username);

        // $this->db->db_debug = false;

        // if(!$query)
        // {
        //     $error = $this->db->error();
        //     // do something in error case
        // }else{
        //     // do something in success case
        // }

        return $query->result();
    }

    function term_monitor_offset_temp($username) {
        $query = $this->db_temp->query("exec atm.get_terminal_monitor_temp ?", $username);
        return $query->result();
    }

    function get_terminal_offline_front($id){
        $query = $this->db->query("exec get_mode_terminal '".$id."'");
        return $query;
    }

    function all_terminal() {
        $query = $this->db->query("exec get_dashboard_all_terminal");
        return $query->num_rows();
    }

    function save_parameterize($data)
    {
        $this->db->insert('tbl_parameterize', $data);
        return $this->db->insert_id();
    }

    function update_terminal_access($data)
    {
        // return $this->db->insert_batch('iso_user_terminal', $data);
        // return $this->db->insert_id();

        if ($this->db->insert_batch('iso_user_terminal', $data))
        {
            return TRUE;
        }
        else
        {
            $error_query = $this->db->error(); 
            return FALSE;
        }
    }

    public function save($data,$tbl)
    {
        $this->db->insert('tbl_flm', $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->update('tbl_flm', $data, $where);
        return $this->db->affected_rows();
    }

    function update_data_parameterize($data, $where)
    {
        $this->db->update('tbl_parameterize', $data, $where);
        return $this->db->affected_rows();
    }

    function update_status_flm($term_id)
    {
        $data = array(
                'status_flm' => 'OK',  
                'date_time_ok' => date('Y-m-d H:i:s'),
            );
        $this->db->update('tbl_flm', $data, array('terminal_id' => $term_id));
    }

    function update_status_slm($where, $status_flm_slm)
    {
        $data = array(
                $status_flm_slm => 'OK',  
                'date_time_ok' => date('Y-m-d H:i:s'),
            );
        $this->db->update('tbl_slm', $data, array('terminal_id' => $where));
    }

    function term_monitor_crm($user_term) {
        $query = $this->db->query("exec iso_get_terminal_crm ?", $user_term);
        return $query->result();
    }

    function get_data_flm_slm($term_id,$table){
        // $query = $this->db->query("exec get_data_flm_slm ?", $term_id);
        $sp = "exec get_data_flm_slm '".$term_id[0]."','".$table."'";
        $query = $this->db->query($sp);
        return $query->result();
    }

    function get_data_parameterize($term_id){
        return $this->db->get_where('tbl_parameterize',array('terminal_id' => $term_id))->result();
    }

    function get_status_flm_slm($value_id,$status) {
        $this->db->select('status_'.$status);
        $this->db->select('date_insert');
        $this->db->from('iso_'.$status);
        $this->db->where('terminal_id', $value_id);
        $this->db->order_by("date_insert", "asc");
        return $this->db->get()->result();
    }

    function get_card_retain(){
        return $this->db->get_where('iso_card_retain',array(
            'user_id' => $this->session->userdata('logged_user_name'),
            //'user_id' => $this->session->userdata('logged_user_name'),
            ))->result();
        // return $this->db->get('v_card_retain')->result();
    }

    function get_summarized_generate(){
        $this->db->order_by("bsn_date", "desc");
        $this->db->limit(20);
        return $this->db->get('iso_log_generate')->result();
        // return $this->db->get('v_card_retain')->result();
    }

    function get_summarized_settlement(){
        $this->db->order_by("date_insert", "desc");
        $this->db->limit(20);
        return $this->db->get('iso_tbl_settlement')->result();
        // return $this->db->get('v_card_retain')->result();
    }

    function get_offline_term(){
        return $this->db->get('iso_terminal_offline')->result();
    }

    function get_data_bar_atm($terminal_id){
        $query = $this->db->query('select 100000000 as max_bar, 50000000 as current_bar');
        return $query->result();
        // return $this->db->get_where('tbl_terminal',array('terminal_id' => $terminal_id))->result();
    }

    function get_closed_term(){
        return $this->db->get('iso_terminal_closed')->result();
    }

    function get_inservice_term(){
        return $this->db->get('iso_terminal_inservice')->result();
    }

    function get_faulty_term(){
        return $this->db->get('iso_terminal_faulty')->result();
    }

    function get_faulty_term_temp(){
        return $this->db->get('iso_terminal_faulty')->result();
    }

    function get_terminal_saldo_detail(){
        return $this->db->get('iso_terminal_saldo_min')->result();
    }

    //function get_data_summary_trx($first_date=20210601,$second_date=20210620){
    function get_data_summary_trx($first_date,$second_date){
        $this->db->order_by("tgl", "asc");
        $this->db->where('tgl >=', ($first_date=="" ? 20210601 : $first_date));
        $this->db->where('tgl <=', ($second_date=="" ? 20210620 : $second_date));
        return $this->db->get('v_summary_trx')->result();
    }

    function get_data_summary_trx_weekly(){
        $this->db->order_by("tgl", "asc");
        return $this->db->get('v_summary_trx_weekly')->result();
    }

    function get_list_bsndate(){
        $this->db->order_by("batch_nr", "desc");
        return $this->db->get('iso_batch')->result();
    }

    function get_list_interchange(){
        $this->db->where('business_entity_name is NOT NULL', NULL, FALSE);
        $this->db->order_by("interchange", "asc");
        return $this->db->get('iso_interchange')->result();
    }

    function get_data_interchange($data){
        // $this->db->db_debug = false;

        // if(!$this->db->get_where('iso_interchange',$data))
        // {
        //     $error = $this->db->error();
        //     // do something in error case
        // }else{
        //     // do something in success case
        // }
        // $last_query = $this->db->last_query();
        //die($this->db->last_query());

        return $this->db->get_where('iso_interchange',$data)->result_array();
    }

    function get_list_sink_node(){
        $this->db->order_by("settle_entity_id", "asc");
        return $this->db->get('postilion_office..post_settle_entity')->result();
    }

    function get_list_batch_nr(){
        $this->db->select('batch_nr');
        $this->db->select('cast(settle_date as date) as settle_date');
        $this->db->where('settle_entity_id', 0);
        $this->db->order_by("batch_nr", "desc");
        return $this->db->get('postilion_office..post_batch')->result();
    }

    function get_list_cbc_bank(){
        $this->db->order_by("cbc,bank", "asc");
        return $this->db->get('iso_cbc')->result();
    }

    function get_list_resp_code(){
        $this->db->order_by("resp_code", "asc");
        return $this->db->get('iso_alto_resp_code')->result();
    }

    function get_time_saldo() {
        $query = $this->db->query("exec iso_history_saldo_gettime");
        return $query->row();
    }

    function get_terminal_saldo() {
        $query = $this->db->query("exec iso_history_saldo_getall");
        return $query->result();
    }

    function insert_from_csv($data)
    {
        $this->db->insert_batch('tbl_terminal_upload', $data);
        return $this->db->insert_id();
    }

    function insert_from_excel($data)
    {
        $this->db->empty_table('tbl_parameterize'); 
        $this->db->insert_batch('tbl_parameterize', $data);
        return $this->db->insert_id();
    }

    function get_data_upload($id_upload){
        return $this->db->get_where('tbl_terminal_upload',array('id_upload' => $id_upload))->result();
    }

    function get_terminal_atm(){
        $this->db->select('terminal_id');
        $this->db->select('terminal_name');
        $bind = array('010', '041', '042');
        $this->db->where_in('left(terminal_id,3)', $bind);
        return $this->db->get('iso_terminal')->result();
        // return $this->db->get_where_in('tbl_terminal',array('left(terminal_id,3)' => '010,041,042'))->result();
    }

    function get_users_not_access_term(){
        $this->db->select('a.user_name');
        $this->db->from('iso_users a');
        $this->db->join('iso_user_terminal b', "a.user_name = b.user_id",'left');
        $this->db->where('b.user_id is null'); 
        $this->db->order_by('a.user_name', 'asc'); 
        return  $this->db->get()->result();
    }

    function get_users_term($user_id){
        return $this->db->get_where('iso_user_terminal',array('user_id' => $user_id))->result();
    }


    function get_user_access_term($user_id){
        $this->db->select('ROW_NUMBER()over(partition by LEFT(a.terminal_id,3) order by LEFT(a.terminal_id,3)) as cat,b.user_id
                            ,LEFT(a.terminal_id,3) as prefix
                            ,a.terminal_id
                            ,a.terminal_name');
        $this->db->from('iso_terminal a');
        $this->db->join('iso_user_terminal b', "a.terminal_id = b.terminal_id and b.user_id = '".$user_id."'",'left');
        $bind = array('010', '041', '042');
        $this->db->where_in('left(a.terminal_id,3)', $bind); 
        $this->db->order_by('prefix', 'asc'); 
        return  $this->db->get()->result();

        // $this->db->get()->result();
        // die($this->db->last_query());

        // $this->db->join('tbl_permission_page b', "a.no = b.page_controller and b.user_name = '".$user_id."'", 'left');
    }

    function get_data_summary_tran_type(){
        //  $query = $this->db->query('SELECT *
        //  FROM
        //  (
        //      select case 
        //              when tran_type = \'01\' then \'withdrawal\'
        //              when tran_type = \'31\' then \'balance_inquiry\'
        //              when tran_type = \'50\' then \'transfer\'
        //              end as tran_type
        //          ,sum(count_trx) as count_trx
        //      from iso_office..iso_summary_transactios
        //      where bsn_date = 20210701
        //      group by tran_type
        //  ) AS SourceTable PIVOT(AVG(count_trx) FOR tran_type IN([withdrawal],[balance_inquiry],[transfer])) AS PivotTable;');
        // $query = $this->db->get('tbl_terminal',1);
        $query = $this->db->query('select * from atm_monitoring..tbl_summary_trx_ptpr');
        return $query->result();
    }

    function term_batch_viewer($terminal){
        return $this->db->get_where('tbl_terminal',array('terminal_name' => $terminal))->result();
    }

    function get_detail_summary_crm(){
        $this->db->select('*');
        $this->db->from('pan_office..v_get_summary_trx_crm');
        $this->db->where('issuer_name !=', NULL); 
        $this->db->order_by('issuer_name');
        return  $this->db->get()->result();
    }

    function get_detail_summary_crm_bank($batch_nr){
        $this->db->select('issuer_name,sum(count_txn) as count_txn');
        $this->db->from('pan_office..v_get_summary_issuer_crm');
        $this->db->where('issuer_name !=', NULL); 
        $this->db->group_by('issuer_name');
        $this->db->order_by('count_txn desc');
        return  $this->db->get()->result();
    }

    function get_detail_trx_crm($batch_nr=""){
        // $array_where = array(//'batch_nr' => $batch_nr, 
        //                         'left(terminal_id,3)' => '042'
        //                 );
        // $this->db->select('terminal_id');
        // $this->db->select('terminal_name');
        // $this->db->select('terminal_city');
        // $this->db->select('tran_type');
        // $this->db->select('pan');
        // $this->db->select('issuer_name');
        // // $this->db->select('benef_name');
        // $this->db->select('datetime_tran_local');
        // $this->db->select('settle_amount_req');
        // $this->db->from('pan_office..tbl_details_wdl_approve');
        // $this->db->where($array_where); 
        // $this->db->order_by('post_tran_id desc');
        // $this->db->limit(100);

        // return  $this->db->get()->result();

        
        $this->db->order_by('post_tran_id','asc');
        $this->db->limit(100);

        return  $this->db->get_where('iso_get_active_detail_trx_topup',
            array('post_tran_id >=' => 55517402
                    ,'rsp_code_rsp' =>'00'
            ))->result();
    }

    function get_top_5_tran_type($from_date, $to_date, $tran_type){
        $query = $this->db_iso->query(sprintf("exec get_summary_tran_type '%s','%s','%s'", $from_date, $to_date, $tran_type));
        return $query->result();
    }

    // function get_summary_query_trx($from_date,$to_date,$tran_type,$issuer,$benef,$prefix_term,$pan,$rrn,$sink_node_name){
    //     if($from_date!='' and $to_date!=''){
    //         $this->db->where('datetime_tran_local >=', $from_date);
    //         $this->db->where('datetime_tran_local <=', $to_date);
    //         //$this->db_iso->where('datetime_tran_local between '.$from_date.' and '.$to_date);
    //     }
    //     if($prefix_term!=''){
    //         $this->db->where('left(terminal_id,3) = '.$prefix_term);
    //     }
    //     if($tran_type!=''){
    //         $this->db->where('tran_type', $tran_type);
    //     }
    //     if($issuer!=''){
    //         $this->db->where('issuer_name', $issuer);
    //     }
    //     if($benef!=''){
    //         $this->db->where('cbc_ben', $benef);
    //     }
    //     if($pan!=''){
    //         //$this->db->where('pan', $pan);
    //         $this->db->like('pan', $pan);
    //     }
    //     if($rrn!=''){
    //         $this->db->where('retrieval_reference_nr', $rrn);
    //     }
    //     if($sink_node_name!=''){
    //         $this->db->where('sink_node_name', $sink_node_name);
    //     }

    //     $this->db->where('batch_nr', 2366);
    //     $this->db->order_by("rate", "desc");
    //     //$this->db->limit(1000);
    //     return $this->db->get('iso_sum_query_transactions')->result();
        
    // }

    function get_real_transactions($datefrom, $dateto, $batch_nr, $tran_type,$sink_node_name,$pan,$rrn,$prefix_term,$terminal_id,$response_code,$show_records){
        $query = $this->db->query(sprintf("exec iso_get_query_transactions '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s'", $datefrom, $dateto, $batch_nr, $tran_type,$sink_node_name,$pan,$rrn,$prefix_term,$terminal_id,$response_code,$show_records));

        $test = $this->db->last_query();
        // die();
        // $this->db->db_debug = false;

        // if(!$query)
        // {
        //     $error = $this->db->error();
        //     // do something in error case
        // }else{
        //     // do something in success case
        // }

        // die();
        return $query->result();
    }

    function get_summary_query_trx($datefrom, $dateto, $batch_nr, $tran_type,$issuer_name,$benef_name,$sink_node_name,$pan,$rrn,$prefix_term,$terminal_id,$response_code,$show_records){
        $query = $this->db->query(sprintf("exec iso_get_sum_query_transactions '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s'", $datefrom, $dateto, $batch_nr, $tran_type,$sink_node_name,$pan,$rrn,$prefix_term,$terminal_id,$response_code,$show_records));

        $test = $this->db->last_query();
        // die();
        // $this->db->db_debug = false;

        // if(!$query)
        // {
        //     $error = $this->db->error();
        //     // do something in error case
        // }else{
        //     // do something in success case
        // }

        // die();
        return $query->result();
    }

    // function get_real_transactions($from_date,$to_date,$tran_type,$issuer,$benef,$prefix_term,$pan,$rrn,$sink_node_name){
    //     if($from_date!='' and $to_date!=''){
    //         $this->db->where('datetime_tran_local >=', $from_date);
    //         $this->db->where('datetime_tran_local <=', $to_date);
    //         //$this->db_iso->where('datetime_tran_local between '.$from_date.' and '.$to_date);
    //     }
    //     if($prefix_term!=''){
    //         $this->db->where('left(terminal_id,3) = '.$prefix_term);
    //     }
    //     if($tran_type!=''){
    //         $this->db->where('tran_type', $tran_type);
    //     }
    //     if($issuer!=''){
    //         $this->db->where('issuer_name', $issuer);
    //     }
    //     if($benef!=''){
    //         $this->db->where('cbc_ben', $benef);
    //     }
    //     if($pan!=''){
    //         //$this->db->where('pan', $pan);
    //         $this->db->like('pan', $pan);
    //     }
    //     if($rrn!=''){
    //         $this->db->where('retrieval_reference_nr', $rrn);
    //     }
    //     if($sink_node_name!=''){
    //         $this->db->where('sink_node_name', $sink_node_name);
    //     }

    //     $this->db->where('duplicate', 1);
    //     $this->db->order_by("datetime_tran_local", "desc");
    //     $this->db->limit(1000);
    //     return $this->db->get('iso_query_transactions')->result();

    //     // $this->db->db_debug = false;

    //     // if(!$this->db->get('iso_query_transactions'))
    //     // {
    //     //     $error = $this->db->error();
    //     //     // do something in error case
    //     // }else{
    //     //     // do something in success case
    //     // }
    //     // $last_query = $this->db->last_query();
    //     // die($this->db->last_query());
    // }

    function date_cut_off_saldo(){
        $this->db->select('CONVERT(DATE, CAST(batch_nr AS VARCHAR(8)), 112) as settle_date');
        $this->db->where('batch_nr > 20191231');
        // $this->db->order_by('bsn_date DESC, name ASC');
        $this->db->order_by('batch_nr DESC');
        // $this->db->get('alto_history');
        // die($this->db->last_query());
        return $this->db->get('iso_batch')->result();
    }

    function get_parameterize_saldo() {
        $query = $this->db->query("exec iso_get_parameterize_atmi");
        return $query->result();
    }

    function get_terminal_detail($terminal_id) {
        return $this->db->get_where('iso_term_monitor_detail',array('id' => $terminal_id))->result();
    }

    function get_menu($user_id) {
        // $this->db->select('a.menu');
        // $this->db->select('b.user_name');
        // $this->db->from('tbl_menu a');
        // $this->db->join('tbl_permission_page b', "a.menu = b.page_controller and b.user_name = '".$user_id."'",'left');
        // return $this->db->get()->result();
        //die($this->db->last_query());   
        // return $this->db->get('tbl_menu')->result();


        // $this->db->select('a.user_name');
        // $this->db->select('b.menu');
        // $this->db->select('b.category');
        // $this->db->from('tbl_permission_page a');
        // $this->db->join('tbl_menu b', 'a.page_controller = b.no');
        // $this->db->where('a.user_name', $user_id);
        // $this->db->order_by('b.no', 'asc');
        // return $this->db->get()->result();

        $this->db->select('ROW_NUMBER()over(partition by category order by category) as cat,*');
        $this->db->from('iso_menu a');
        $this->db->join('iso_permission_page b', "a.no = b.page_controller and b.user_name = '".$user_id."'", 'left');
        $this->db->order_by('a.category', 'asc');
        return $this->db->get()->result();
    }


    function get_iso_terminal($prefix) {
        $this->db->select('id,short_name');
        $this->db->where('left(id,3) = \''.$prefix.'\'');
        $this->db->order_by("id", "asc");
        return $this->db->get('realtime_term')->result();
    }

    function get_terminal_staus_fields($terminal_id) {
        return $this->db->get_where('v_term_monitor_detail',array('id' => $terminal_id))->result();
    }

    function get_terminal_events($terminal_id) {
        return $this->db->get_where('v_term_monitor_detail',array('id' => $terminal_id))->result();
    }

    function get_batch_viewer($date,$user,$terminal){
        // $sql = sprintf("exec sp_getreplenish '%s','%s','%s'", $date,$user,$terminal);
        //$query = $this->db->query("exec sp_getreplenish ?,?,?", $date,$user,$terminal);
        $query = $this->db->query(sprintf("exec iso_sp_getreplenish '%s','%s','%s'", $date,$user,$terminal));
        return $query->result();
    }

    function get_saldo($datecutoff){
        $query = $this->db->query(sprintf("exec iso_terminal_saldo '%s'", $datecutoff));
        return $query->result();
    }

    function search_terminal_card($date_from,$date_end,$terminal){
        $query = $this->db->query(sprintf("exec iso_cardholder_not_take '%s','%s','%s'", $date_from,$date_end,$terminal));
        return $query->result();
    }

    function get_status_fields($term_pos,$term_type,$term_status){
        $query = $this->db->query(sprintf("exec iso_get_status_fields '%s','%s','%s'", $term_pos,$term_type,$term_status));
        return $query->result();
    }

    function get_events_detail($term_id){
        $query = $this->db->query(sprintf("exec iso_get_events_detail '%s'", $term_id));
        return $query->result();
    }

    function get_history_flm_slm() {
        $this->db->order_by("date_time_problem", "desc");
        return $this->db->get('v_get_history_flm_slm')->result();

        // $this->db->from('v_get_history_flm_slm');
        // $this->db->order_by("date_time_problem", "desc");
        
        // $this->db->get('v_get_history_flm_slm');
        // die($this->db->last_query());   
        
        // return $this->db->get()->result();

    }

    function delete_parameterize_id($data)
    {
        $this->db->delete('tbl_parameterize', $data);       
        return $this->db->affected_rows();
    }

    function insert_from_rpt($data)
    {
        $this->db->insert_batch('iso_output_rpt', $data);
        return $this->db->insert_id();
    }
}
