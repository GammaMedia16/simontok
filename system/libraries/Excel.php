<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  

require_once APPPATH."third_party/PHPExcel.php";//Your problem was here

class CI_Excel extends PHPExcel {

    public function __construct() {
        parent::__construct();
    }

}
?>