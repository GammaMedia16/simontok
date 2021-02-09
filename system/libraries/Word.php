<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  

/*include_once(APPPATH."third_party/PhpWord/Autoloader.php");


class CI_Word extends Autoloader {

    public function __construct() {
        parent::__construct();
        Autoloader::register();
		Settings::loadConfig();
    }*/
    require_once  APPPATH.'/third_party/PhpWord/Autoloader.php';
    use PhpOffice\PhpWord\Autoloader as Autoloader;
    Autoloader::register();

    class CI_Word extends Autoloader {

    }

//}

?>
