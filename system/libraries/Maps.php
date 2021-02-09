<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  

require_once APPPATH."third_party/maps/Googlemaps.php";//Your problem was here

class CI_Maps extends Googlemaps {

    public function __construct() {
        parent::__construct();
    }

}
?>