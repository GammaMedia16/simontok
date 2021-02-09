<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  

require_once APPPATH."third_party/image/Compress.php";//Your problem was here

class CI_Compress extends Compress {

    public function __construct() {
        parent::__construct();
    }

}
?>