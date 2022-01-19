<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Csvparser {

    // var $fields;            /** columns names retrieved after parsing */ 
    var $separator = '|';    /** separator used to explode each line */
    // var $enclosure = '"';    /** enclosure used to decorate each field */

    // var $max_row_size = 4096;    /** maximum row size to be used for decoding */

    // function parse_file($p_Filepath) {

    //     $file = fopen($p_Filepath, 'r');
    //     $this->fields = fgetcsv($file, $this->max_row_size, $this->separator, $this->enclosure);
    //     $keys_values = explode(',',$this->fields[0]);

    //     $content    =   array();
    //     $keys   =   $this->escape_string($keys_values);

    //     $i  =   1;
    //     while( ($row = fgetcsv($file, $this->max_row_size, $this->separator, $this->enclosure)) != false ) {            
    //         if( $row != null ) { // skip empty lines
    //             $values =   explode(',',$row[0]);
    //             if(count($keys) == count($values)){
    //                 $arr    =   array();
    //                 $new_values =   array();
    //                 $new_values =   $this->escape_string($values);
    //                 for($j=0;$j<count($keys);$j++){
    //                     if($keys[$j] != ""){
    //                         $arr[$keys[$j]] =   $new_values[$j];
    //                     }
    //                 }

    //                 $content[$i]=   $arr;
    //                 $i++;
    //             }
    //         }
    //     }
    //     fclose($file);
    //     return $content;
    // }

    // function escape_string($data){
    //     $result =   array();
    //     foreach($data as $row){
    //         $result[]   =   str_replace('"', '',$row);
    //     }
    //     return $result;
    // }   


    function parse_file($Filepath)
{
    //Get csv file content
    $csvData = file_get_contents($Filepath);

    //Remove empty lines
    $csvData = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\r\n", $csvData);

    //String convert in array formate and remove double quote(")
    $array = array();
    $array = $this->escape_string(preg_split('/\r\n|\r|\n/', $csvData));
    $new_content_in_array = array();
    if($array)
    {
        //Get array key
        $array_keys = array();
        $array_keys = array_filter(array_map('trim', explode($this->separator,$array[0])));

        //Get array value
        $array_values = array();
        for ($i=1;$i<count($array);$i++)
        {
            if($array[$i])
            {
                $array_values[] = array_filter(array_map('trim', explode($this->separator,$array[$i])));
            }
        }

        //Convert in associative array
        if($array_keys && $array_values)
        {
            $assoc_array = array();
            foreach ($array_values as $ky => $val)
            {           
                for($j=0;$j<count($array_keys);$j++){
                    if($array_keys[$j] != "" && $val[$j] != "" && (count($array_keys) == count($val)))
                    {
                        $assoc_array[$array_keys[$j]] = $val[$j];
                    }
                }
                $new_content_in_array[] = $assoc_array;
            }
        }
    }
    return $new_content_in_array;
}

function escape_string($data){
    $result =   array();
    foreach($data as $row){
        $result[]   = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "", str_replace('"', '',$row));
    }
    return $result;
}   



}
?> 