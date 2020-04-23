<?php
/**
 * Created by PhpStorm.
 * User: KFUEIT
 * Date: 18/08/2019
 * Time: 12:00 PM
 */

class Telenor_api_model extends CI_Model
{
    private $userName = "";
    private $password = '';
    private $planetbeyondApiUrl = "https://telenorcsms.com.pk:27677/corporate_sms2/api/auth.jsp?";
    private $planetbeyondApiSendSmsUrl="https://telenorcsms.com.pk:27677/corporate_sms2/api/sendsms.jsp?";

    function __construct()
    {
        parent::__construct();
    }


    function getSessionId()
    {
        $response = $this->sendApiCall($this->planetbeyondApiUrl.http_build_query(array('msisdn'=>$this->userName, 'password'=>$this->password)));
        //print_r($response);
        if ($response && substr($response->response, 0, 5) !== "Error") {
            return $response->data;
        }
        return -1;
    }

    function sendApiCall($url)
    {
        $response = file_get_contents($url);
        $xml = simplexml_load_string($response) or die("Error: Cannot create object");
        if ($xml && ! empty($xml->response)) {
            return $xml;
        }
        return "";
    }

    function sendSmsMessage($messageText, $toNumbersCsv, $mask)
    {
        $fromNumber = "";
        $sessionKey = $this->getSessionId();
        $keys=array(
            "session_id"=>(string)$sessionKey,
            "to"=>$toNumbersCsv,
            "text"=>$messageText
        );
        if ($mask != null) {
            $keys=$keys+array("mask"=>$mask);
        }
        print_r($keys);
        //echo $this->planetbeyondApiSendSmsUrl.http_build_query($keys);exit;
        $xml = $this->sendApiCall($this->planetbeyondApiSendSmsUrl.http_build_query($keys));
        print_r($xml);
        return $xml->response;
    }

}