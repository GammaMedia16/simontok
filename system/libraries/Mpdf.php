<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  

require_once APPPATH."third_party/mpdf60/mpdf.php";//Your problem was here

class CI_Mpdf extends mpdf {

    public function __construct() {
        parent::__construct();
    }

    

}
?>