<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

class M_api extends CI_Model {

    var $linkAPI="https://sidak.ksdae.com/api/";

	function requesttoken()
    {
        $token = "";
        $params= array(
           "username" => "simpulkk",
           "password" => "restfulapikk"
        );
        $url = $this->linkAPI.'user/request_token';

        $output = $this->postCURL($url, $params);
        if ($output['status'] == 1) {
            $token = $output['data']['token'];
        }
        return $token;
    }

    function postCURL($_url, $_param){

        $postData = '';
        //create name value pairs seperated by &
        foreach($_param as $k => $v) 
        { 
          $postData .= $k . '='.$v.'&'; 
        }
        rtrim($postData, '&');

        //header('Content-Type: application/x-www-form-urlencoded');
        //header('X-Api-Key: S1MPULKK3A96D96CVED6NFC22D435F6');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                            'Accept: application/json',
                                            'Content-Type: application/x-www-form-urlencoded',
                                            'X-Api-Key: S1MPULKK3A96D96CVED6NFC22D435F6'
                                            ));
        curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    

        $result=curl_exec($ch);
        

        curl_close($ch);

        return json_decode($result, true);
    }
}
/* eof admin/models/M_user.php */
?>