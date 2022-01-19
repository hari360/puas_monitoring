<?php

class Statistic_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->db_iso = $this->load->database('iso_office', TRUE);
    }

    function get_top5_crm_7days($bsn_date)
    {

        // $this->db_iso->select('a.user_name');
        // $this->db_iso->from('iso_summary_transactios a');
        // $this->db_iso->join('iso_terminal b', 'a.terminal_id = b.terminal_id');


        // return $this->db_iso->get_where(
        //     'iso_summary_transactios',
        //     array(
        //         'bsn_date' => $bsn_date, 'terminal_id' => '04200013'
        //     )
        // )->result();

        $query = $this->db_iso
            ->select(
                'max(b.terminal_city) as city,
              max(b.location) as location,
                        sum(a.count_trx) as jml_trx'
            )
            ->from('iso_summary_transactios a')
            ->where('a.bsn_date >', 'replace(DATEADD(dd, -70, cast(GETDATE() as date)),\'-\',\'\')', false)
            ->join('iso_terminal b', 'a.terminal_id = b.terminal_id')
            ->group_by(array('a.bsn_date', 'a.terminal_id'))
            ->order_by('jml_trx', 'asc')
            ->limit(5)
            ->get();
        // print_r($query->result());
        return $query->result();
    }

    function get_bottom5_crm_7days($bsn_date)
    {
        $query = $this->db_iso
            ->select(
                'max(b.terminal_city) as city,
              max(b.location) as location,
                        sum(a.count_trx) as jml_trx'
            )
            ->from('iso_summary_transactios a')
            ->where('a.bsn_date >', 'replace(DATEADD(dd, -70, cast(GETDATE() as date)),\'-\',\'\')', false)
            ->join('iso_terminal b', 'a.terminal_id = b.terminal_id')
            ->group_by(array('a.bsn_date', 'a.terminal_id'))
            ->order_by('jml_trx', 'desc')
            ->limit(5)
            ->get();
        // print_r($query->result());
        //die($this->db_iso->last_query());
        return $query->result();

        // return $this->db_iso->get_where(
        //     'iso_summary_transactios',
        //     array(
        //         'bsn_date' => $bsn_date, 'terminal_id' => '04200013'
        //     )
        // )->result();
    }
}
