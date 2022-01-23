<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class IssApproved
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

    function page_header($fi_acq,$fi_issuer,$acquirer_name,$issuer_name)
    {
        $header =
            "PAGE:   1                                             PT. PURWANTARA                                   DATE: 08/05/20
REPORT ID: DNLD03A                                    DAILY TRANSACTION LISTING AS ISSUER                      TIME: 00:21:12

SETTLEMENT DATE   : 07/05/20
ISSUER F.I. NO.   : (".$fi_issuer.") ".$issuer_name."
ACQUIRER F.I. NO. : (".$fi_acq.") ".$acquirer_name."

   TERMINAL  TRACE NUMBER     CARD ACCOUNT         RCPT  RCPT      RCPT      TRAN    ACCOUNT        AMOUNT DUE        INTERCHANGE       SWITCH FEE
   NO.       ACQ / SWT        NUMBER               NBR   DATE      TIME      TYPE    NUMBER         FROM ISSUER       FEE DUE FROM      DUE TO PURWANTARA
   --------  ---------------  -------------------  ----  --------  --------  ------  -------------  ----------------  ----------------  ----------------" . "\n";
        return $header;
    }

    function page_footer($count,$amount,$fee,$prev,$next,$swt_fee)
    {
        $footer =
            "      --------  ---------------  -------------------  ----  --------  --------  ------  -------------  ----------------  ----------------  ----------------
" . str_pad($count, 73, " ", STR_PAD_LEFT) . 
    str_pad(" ", 1, " ", STR_PAD_RIGHT) . 
    "TRANSACTIONS, PAGE TOTAL".
    str_pad(number_format($amount), 16, " ", STR_PAD_LEFT).
    str_pad(number_format($fee), 18, " ", STR_PAD_LEFT).
    str_pad(number_format($swt_fee), 18, " ", STR_PAD_LEFT).
    "\n";

    if ($prev != $next){
        $footer .= 
        str_pad($count, 73, " ", STR_PAD_LEFT) . 
        str_pad(" ", 1, " ", STR_PAD_RIGHT) . 
        "TRANSACTIONS, BANK TOTAL".
        str_pad(number_format($amount), 16, " ", STR_PAD_LEFT).
        str_pad(number_format($fee), 18, " ", STR_PAD_LEFT).
        str_pad(number_format($swt_fee), 18, " ", STR_PAD_LEFT).
        "\n".
        "\n";
    }
        return $footer;
    }

    function bank_footer($count,$amount,$fee,$swt_fee)
    {
        $footer = 
    str_pad($count, 73, " ", STR_PAD_LEFT) . 
    str_pad(" ", 1, " ", STR_PAD_RIGHT) . 
    "TRANSACTIONS, BANK TOTAL".
    str_pad(number_format($amount), 16, " ", STR_PAD_LEFT).
    str_pad(number_format($fee), 18, " ", STR_PAD_LEFT).
    str_pad(number_format($swt_fee), 18, " ", STR_PAD_LEFT).
    "\n";
        return $footer;
    }

    function grand_footer($count,$amount,$fee,$swt_fee)
    {
        $footer = 
    str_pad($count, 73, " ", STR_PAD_LEFT) . 
    str_pad(" ", 1, " ", STR_PAD_RIGHT) . 
    "TRANSACTIONS, GRAND TOTAL".
    str_pad(number_format($amount), 15, " ", STR_PAD_LEFT).
    str_pad(number_format($fee), 18, " ", STR_PAD_LEFT).
    str_pad(number_format($swt_fee), 18, " ", STR_PAD_LEFT).
    "\n".
    "
NOTE: TRANSACTIONS MARKED WITH A '*' ARE COUNTED, BUT THEIR AMOUNTS ARE NOT ADDED TO THE PAGE, BANK OR GRAND TOTALS.


                  ** ** ** ** ** END OF DAILY TRANSFER TRANSACTION LISTING AS ACQUIRER REPORT FOR PERMATA ** ** ** ** ** "
    ;
        return $footer;
    }

    

    function page_detail()
    {
        $detail_transactions = $this->CI->wdl_model->detail_iss_approved()->result();
        $total_transactions = $this->CI->wdl_model->detail_iss_approved()->num_rows();
        $detail = "";
        $i=0;
        $x=0;
        $total_amount = 0;
        $total_fee = 0;
        $total_swt_fee = 0;
        $prev_acquirer = "";
        $grand_count = 0;
        $grand_amount = 0;
        $grand_fee = 0;
        $grand_swt_fee = 0;

        foreach ($detail_transactions as $data_detail) {
            if($x==0){
                $detail .= $this->page_header(
                    $data_detail->fi_acquirer,
                    $data_detail->fi_issuer,
                    $data_detail->acq_name,
                    $data_detail->iss_name,
                );
                $prev_acquirer = $data_detail->fi_acquirer;
            }

            if($prev_acquirer != $data_detail->fi_acquirer){
                $detail .= $this->page_footer($i,$total_amount,$total_fee,$prev_acquirer,$data_detail->fi_acquirer,$total_swt_fee);
                
                $detail .= $this->page_header(
                    $data_detail->fi_acquirer,
                    $data_detail->fi_issuer,
                    $data_detail->acq_name,
                    $data_detail->iss_name,);
                    $i = $total_amount = $total_fee = $total_swt_fee = 0;

                    $prev_acquirer = $data_detail->fi_acquirer;
                
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
                str_pad($data_detail->from_acc_number,13, " ", STR_PAD_LEFT) .
                str_pad(" ", 2) .
                str_pad(number_format($data_detail->amount), 14, " ", STR_PAD_LEFT) .
                str_pad(" ", 2) .
                str_pad(" ", 2) .
                str_pad(number_format($data_detail->fee), 14, " ", STR_PAD_LEFT) .
                str_pad(number_format($data_detail->swt_fee), 18, " ", STR_PAD_LEFT) .
                str_pad(" ", 2)
                . "\n";
                $i++;
                $x++;
                $total_amount = $total_amount + $data_detail->amount;
                $total_fee = $total_fee + $data_detail->fee;
                $total_swt_fee = $total_swt_fee + $data_detail->swt_fee;
                $grand_amount = $grand_amount + $data_detail->amount;
                $grand_fee = $grand_fee + $data_detail->fee;
                $grand_swt_fee = $grand_swt_fee + $data_detail->swt_fee;
                
                
                

                if ($i%48==0 && $x != 0) {
                    $detail .= $this->page_footer($i,$total_amount,$total_fee,$prev_acquirer,$data_detail->fi_acquirer,$total_swt_fee);
                    $detail .= $this->page_header(
                    $data_detail->fi_acquirer,
                    $data_detail->fi_issuer,
                    $data_detail->acq_name,
                    $data_detail->iss_name,);
                    $i = $total_amount = $total_fee = 0;
                }

                if($data_detail->fi_issuer){

                }

                if ($x==$total_transactions){
                    $detail .= $this->page_footer($i,$total_amount,$total_fee,$prev_acquirer,$data_detail->fi_acquirer,$total_swt_fee);
                    $detail .= $this->bank_footer($i,$total_amount,$total_fee,$total_swt_fee);
                    $detail .= $this->grand_footer($x,$grand_amount,$grand_fee,$grand_swt_fee);
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

        $filename = $member . "_iss_transaction." . '20211224' . ".rpt";
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
