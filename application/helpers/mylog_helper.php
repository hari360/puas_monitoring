<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function wh_log($log_msg)
        {
                $v_dir = "E:\\Temporary\\Report ISO\\Temp\\";
                $log_filename = "Logs";

                if (!file_exists($v_dir . $log_filename)) {
                        // create directory/folder uploads.
                        mkdir($v_dir . $log_filename, 0777, true);
                }
                $log_file_data = $v_dir . $log_filename . '/log_' . date('d-M-Y') . '.log';
                // if you don't add `FILE_APPEND`, the file will be erased each time you add a log
                file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
        }