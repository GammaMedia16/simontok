<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  

require_once APPPATH."third_party/PHPMailerAutoload.php";//Your problem was here

class CI_Phpmailer extends PHPMailerAutoload {

    public function __construct() {
        parent::__construct();
    }

    

}
?>