<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class AcqRejected
{

    var $CI = NULL;
    var $_valid = NULL;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->database();
        $this->CI->load->library('session');
        $this->CI->load->library('insertlog');
        $this->CI->load->model('reporting/Withdrawal_model', 'wdl_model', TRUE);
    }

    function page_header($fi_acq, $fi_issuer, $acquirer_name, $issuer_name)
    {
        $header =
            "PAGE:   1                                             PT. ALTO NETWORK                                   DATE: 08/05/20
REPORT ID: DNLD05A                                    REJECTED TRANSACTION LISTING AS ACQUIRER                   TIME: 00:22:42

SETTLEMENT DATE   : 07/05/20
ISSUER F.I. NO.   : (" . $fi_issuer . ") " . $issuer_name . "
ACQUIRER F.I. NO. : (" . $fi_acq . ") " . $acquirer_name . "
            
   TERM      TRACE NUMBER     CARD ACCOUNT         RCPT  RCPT      RECEIPT   TRANS   AMOUNT            INTERCHANGE       RESP  REJC  DESCRIPT                REJC   RJ FEE
   NO.       ACQ / SWT        NUMBER               NBR   DATE      TIME      TYPE    REQUESTED         FEE DUE FROM      CODE  CODE  CODE                    CLASS  DUE TO
   --------  ---------------  -------------------  ----  --------  --------  ------  ----------------  ----------------  ----  ----  ----------------------  -----  ------" . "\n";
        return $header;
    }

    function page_footer($count, $amount, $fee, $prev, $next)
    {
        $footer =
            "   --------  ---------------  -------------------  ----  --------  --------  ------  ----------------  ----------------  ----  ----  ----------------------  -----  ------
" . str_pad($count, 58, " ", STR_PAD_LEFT) .
            str_pad(" ", 1, " ", STR_PAD_RIGHT) .
            "TRANSACTIONS, PAGE TOTAL" .
            str_pad(number_format($amount), 16, " ", STR_PAD_LEFT) .
            str_pad(number_format($fee), 18, " ", STR_PAD_LEFT) .
            "\n";

        if ($prev != $next) {
            $footer .=
                str_pad($count, 58, " ", STR_PAD_LEFT) .
                str_pad(" ", 1, " ", STR_PAD_RIGHT) .
                "TRANSACTIONS, BANK TOTAL" .
                str_pad(number_format($amount), 16, " ", STR_PAD_LEFT) .
                str_pad(number_format($fee), 18, " ", STR_PAD_LEFT) .
                "\n" .
                "   ---------------------------------------------------------------------------------------------------------------------------------------
   BANK TOTAL REJECTED TXN CLASS   CUST :    8   PROC :     0   TECH :     0   CUST-CAPT :     0   PROC-CAPT : 0
   ---------------------------------------------------------------------------------------------------------------------------------------" .
                "\n" .
                "\n";
        }
        return $footer;
    }

    function bank_footer($count, $amount, $fee)
    {
        $footer =
            str_pad($count, 73, " ", STR_PAD_LEFT) .
            str_pad(" ", 1, " ", STR_PAD_RIGHT) .
            "TRANSACTIONS, BANK TOTAL" .
            str_pad(number_format($amount), 16, " ", STR_PAD_LEFT) .
            str_pad(number_format($fee), 18, " ", STR_PAD_LEFT) .
            "\n";
        return $footer;
    }

    function grand_footer($count, $amount, $fee)
    {
        $footer =
            str_pad($count, 58, " ", STR_PAD_LEFT) .
            str_pad(" ", 1, " ", STR_PAD_RIGHT) .
            "TRANSACTIONS, GRAND TOTAL" .
            str_pad(number_format($amount), 15, " ", STR_PAD_LEFT) .
            str_pad(number_format($fee), 18, " ", STR_PAD_LEFT) .
            "\n" .
            "   ---------------------------------------------------------------------------------------------------------------------------------------
GRAND TOTAL REJECTED TXN CLASS  CUST :  140   PROC :     0   TECH :    25   CUST-CAPT :     0   PROC-CAPT : 1
---------------------------------------------------------------------------------------------------------------------------------------
Note :   The number of CUST-CAPT (Customer Captured Card) is included in the number of CUST (Customer Rejected).
        The number of PROC-CAPT (Procedural Captured Card) is included in the number of PROC (Procedural Rejected).


                ** ** ** ** ** END OF REJECTED TRANSACTION LISTING AS ACQUIRER REPORT FOR PERMATA ** ** ** ** **
         ";
        return $footer;
    }



    function page_detail()
    {
        $detail_transactions = $this->CI->wdl_model->detail_acq_rejected()->result();
        $total_transactions = $this->CI->wdl_model->detail_acq_rejected()->num_rows();
        $detail = "";
        $i = 0;
        $x = 0;
        $total_amount = 0;
        $total_fee = 0;
        $prev_issuer = "";
        $grand_count = 0;
        $grand_amount = 0;
        $grand_fee = 0;

        foreach ($detail_transactions as $data_detail) {
            if ($x == 0) {
                $detail .= $this->page_header(
                    $data_detail->fi_acquirer,
                    $data_detail->fi_issuer,
                    $data_detail->acq_name,
                    $data_detail->iss_name,
                );
                $prev_issuer = $data_detail->fi_issuer;
            }

            if ($prev_issuer != $data_detail->fi_issuer) {
                $detail .= $this->page_footer($i, $total_amount, $total_fee, $prev_issuer, $data_detail->fi_issuer);

                $detail .= $this->page_header(
                    $data_detail->fi_acquirer,
                    $data_detail->fi_issuer,
                    $data_detail->acq_name,
                    $data_detail->iss_name,
                );
                $i = $total_amount = $total_fee = 0;

                $prev_issuer = $data_detail->fi_issuer;
            }

            $detail .= "   " . str_pad(trim($data_detail->term_id), 8, " ", STR_PAD_RIGHT) .
                str_pad(" ", 2) .
                str_pad($data_detail->trace, 15, " ", STR_PAD_RIGHT) .
                str_pad(" ", 2) .
                str_pad($data_detail->pan, 19, "0", STR_PAD_LEFT) .
                str_pad(" ", 2) .
                str_pad($data_detail->rrn, 4, " ", STR_PAD_RIGHT) .
                str_pad(" ", 2) .
                str_pad($data_detail->date, 8, " ", STR_PAD_RIGHT) .
                str_pad(" ", 2) .
                str_pad($data_detail->time, 8, " ", STR_PAD_RIGHT) .
                str_pad(" ", 2) .
                str_pad($data_detail->tran_type, 6, " ", STR_PAD_RIGHT) .
                str_pad(" ", 2) .
                str_pad(number_format($data_detail->amount), 16, " ", STR_PAD_LEFT) .
                str_pad(" ", 2) .
                str_pad(number_format($data_detail->fee), 16, " ", STR_PAD_LEFT) .
                str_pad(" ", 2) .
                str_pad(" ", 2) .
                str_pad($data_detail->resp_code, 4, " ", STR_PAD_LEFT) .
                str_pad(" ", 2) .
                str_pad($data_detail->reject_code, 4, " ", STR_PAD_LEFT) .
                str_pad(" ", 2) .
                str_pad($data_detail->desc_code, 22, " ", STR_PAD_RIGHT) .
                str_pad(" ", 2) .
                str_pad($data_detail->reject_class, 5, " ", STR_PAD_RIGHT) .
                str_pad(" ", 2) .
                str_pad($data_detail->reject_fee, 6, " ", STR_PAD_RIGHT) .
                str_pad(" ", 2) .
                "\n";
            $i++;
            $x++;
            $total_amount = $total_amount + $data_detail->amount;
            $total_fee = $total_fee + $data_detail->fee;
            $grand_amount = $grand_amount + $data_detail->amount;
            $grand_fee = $grand_fee + $data_detail->fee;



            if ($i % 48 == 0 && $x != 0) {
                $detail .= $this->page_footer($i, $total_amount, $total_fee, $prev_issuer, $data_detail->fi_issuer);
                $detail .= $this->page_header(
                    $data_detail->fi_acquirer,
                    $data_detail->fi_issuer,
                    $data_detail->acq_name,
                    $data_detail->iss_name,
                );
                $i = $total_amount = $total_fee = 0;
            }

            if ($data_detail->fi_issuer) {
            }

            if ($x == $total_transactions) {
                $prev_issuer = "";
                $detail .= $this->page_footer($i, $total_amount, $total_fee, $prev_issuer, $data_detail->fi_issuer);
                // $detail .= $this->bank_footer($i, $total_amount, $total_fee);
                $detail .= $this->grand_footer($x, $grand_amount, $grand_fee);
            }
        }
        return $detail;
    }

    function wdl_detail_approved($member)
    {

        $v_dir = $this->CI->config->item('global_dir_rpt') . '20211224' . '\\';
        if (!file_exists($v_dir)) {
            mkdir($v_dir, 0777, true);
        }

        $filename = $member . "_acq_reject." . '20211224' . ".rpt";
        $fd = fopen($v_dir . $filename, "w");


        fwrite(
            $fd,
            //$this->page_header()
            $this->page_detail()
            //. $this->page_footer()
            // . $this->page_footer_end()
        );

        fclose($fd);
    }
}
