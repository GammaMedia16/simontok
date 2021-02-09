<?php
    
    if (!function_exists('load_controller'))
    {
        function load_controller($controller, $method = 'index', $var1 = NULL, $var2 = NULL, $folder = '')
        {
            require_once(APPPATH . 'controllers/' . $folder . $controller . '.php');

            $controller = new $controller();

            return $controller->$method($var1,$var2);
        }
    }
    if(!function_exists("Now")){
        function Now(){
            return date("Y-m-d H:i:s");
        }
    }

    if(!function_exists("CheckProfile")){
        function CheckProfile($ProfileId){
            $profile = explode(',', $ProfileId);
            $return = false;
            foreach ($profile as $p) {
                $return = $return || ($_SESSION['users']['ProfileId'] == trim($p));
            }
            return $return;
        }
    }
    
    if(!function_exists("IgnoredMethod")){
        function IgnoredMethod(){
            $CI = &get_instance();
            $lastUri = $CI->uri->segment($CI->uri->total_segments());
            $method = $CI->router->fetch_method();
            if($lastUri == $method) 
                // MyRedirect();
                show_404();
        }
    }

    if(!function_exists("CheckThenRedirect")){
        function CheckThenRedirect($var,$redirect){
            if($var){
                MyRedirect($redirect);
            }
        }
    }

    if(!function_exists("MyRedirect")){
        function MyRedirect($redirect_to){
            $redirect_to = $redirect_to ?: base_url();
            if(isAjax()) {
                header("Location: $redirect_to", true, 401); 
                exit;
            }
            header("Location: $redirect_to", true);
            exit;
        }
    }

    if(!function_exists("isAjax")){
        function isAjax() {
            return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
        }
    }
    
    if(!function_exists("CompName")){
        function division($a, $b) {
            return $b === 0 || $b === null || !is_numeric($b) ? "-" : $a/$b;
        }
    }

    if(!function_exists("CompName")){
        function CompName(){
            return GetHostByAddr($_SERVER["REMOTE_ADDR"]);
        }
    }

    if(!function_exists("ListMonth")){
        function ListMonth(){
            return array("1"=>"Januari",
                         "2"=>"Februari",
                         "3"=>"Maret",
                         "4"=>"April",
                         "5"=>"Mei",
                         "6"=>"Juni",
                         "7"=>"Juli",
                         "8"=>"Agustus",
                         "9"=>"Sepetember",
                         "10"=>"Oktober",
                         "11"=>"November",
                         "12"=>"Desember",);
        }
    }

    if(!function_exists("ListDay")){
        function ListDay(){
            return array("Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu",);
        }
    }
    
    if(!function_exists("isNull")){
        function isNull($string, $replacement="") {
            if ($string === NULL) {
                return $replacement;
            } else {
                return $string;
            }
        }    
    }

    if(!function_exists("CheckVal")) {
        function CheckVal($string, $check="DEFAULT", $replacement="") {
            if (strtoupper($string) == $check) {
                return $replacement;
            } else {
                return $string;
            }
        }
    }

    if(!function_exists("ToNull")){
        function ToNull($string) {
            if (strtoupper($string) == "DEFAULT" || $string == "" || $string == " ") {
                return NULL;
            // } else if(is_numeric($string)){
            //     if ($string == "") {
            //         return NULL;
            //     } else {
            //         return $string;   
            //     }
            // } else {
            //     return "'".$string."'";
            } else {
                return $string;
            }
        }
    }

    if(!function_exists("Date_Add")){
        function Date_Add($date, $add) {
            $date1 = str_replace('-', '/', $date);
            $date2 = date('Y-m-d H:i:s', strtotime($date1 . " $add"));
            return $date2;
        }    
    }

    if(!function_exists("ifExists")){
        function ifExists($varname){
            return(isset($varname) ? $varname:null);
        }   
    }


    if(!function_exists("Get_Date")) {
        function Get_Date(){
            // return date("Y-m-d H:i:s". substr((string)microtime(), 1, 4)); /*dgn microsecond*/
            return date("Y-m-d H:i:s");
            // return "'+GETDATE()+'";            
        }
    }

    if(!function_exists("s2d")){
        function s2d($kata) {
            return str_replace("'", "''", trim($kata));
        }
    }

    if(!function_exists('format_date')){
        function format_date($date, $format="Y/m/d"){
            if($date != null){
                return date($format,strtotime($date));
            } else {
                return null;
            }
        }
    }

    if(!function_exists('format_dec')){
        function format_dec($number, $pct='0', $decimal='0'){
            if(empty($number) || $number == "" || !is_numeric($number)){
                return $number;
            }
            $number = $pct ? $number*100 : $number;
            $return = number_format($number, $decimal, ",", ".");
            return $pct ? $return."%" : $return;
        }
    }

    if(!function_exists('unformat_dec')){
        function unformat_dec($number, $decimal=2){
            if(empty($number) || $number == ""){
                return $number;
            }
            $number = str_replace(".", "", $number);
            $number = str_replace(",", ".", $number);
            return number_format($number, $decimal, ".", "");
        }
    }

    if(!function_exists('minutesToTime')){
        function minutesToTime($minutes){
            $seconds = $minutes * 60;
            $days = floor ($seconds / 86400);
            if($days > 0){
                return $days . ' hari ' . gmdate ('H:i:s', $seconds);
            } else {
                return gmdate ('H:i:s', $seconds);
            }
        }
    }

    if(!function_exists('secondsToTime')){
        function secondsToTime($sec,$f=':'){
            $hours = floor($sec / 3600);
            $minutes = floor(($sec / 60) % 60);
            $seconds = $sec % 60;
    
            return sprintf("%02d%s%02d%s%02d", $hours, $f, $minutes, $f, $seconds);
        }
    }

    if(!function_exists('timeToSeconds')){
        function timeToSeconds($time){
            $time = explode(':', $time);
            return ($time[0]*3600) + ($time[1]*60) + $time[2];
        }
    }

    if(!function_exists('MAXTime')){
        function MAXTime($time, $max=TRUE){
            // $time = array('54:50:24','60:08:17','75:10:25','01:38:58','72:19:43','105:20:57');
            $return = $time[0];
            if($max){
                for ($i=0; $i < count($time); $i++) { 
                    $return = str_replace(':','',$time[$i]) > str_replace(':','',$return) ? $time[$i] : $return;
                }
            } else {
                for ($i=0; $i < count($time); $i++) { 
                    $return = str_replace(':','',$time[$i]) < str_replace(':','',$return) ? $time[$i] : $return;
                }
            }
            return $return;
        }
    }

    if(!function_exists('MAXValue')){
        function MAXValue($array, $max=TRUE){
            // $array = array('1','2','3','4','5');
            $return = $array[0];
            if($max){
                for ($i=0; $i < count($array); $i++) { 
                    $return = $array[$i] > $return ? $array[$i] : $return;
                }
            } else {
                for ($i=0; $i < count($array); $i++) { 
                    $return = $array[$i] < $return ? $array[$i] : $return;
                }
            }
            return $return;
        }
    }

    if(!function_exists("ExtractArray")){
        function ExtractArray($array){
            $re = '';
            foreach (array_keys($array) as $key) {
                $re .= $key."=>".$array[$key]." |";
            }
            return substr($re, 0, -2);
        }
    }    

    //This function is used to encrypt data.
    if(!function_exists("MyEncrypt")){
        function MyEncrypt($text, $salt = "5imPl3S4lT"){
            return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
        }   
    }

    // This function will be used to decrypt data.
    if(!function_exists("MyDecrypt")){
        function MyDecrypt($text, $salt = "5imPl3S4lT"){
            return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
        }
    }

?>