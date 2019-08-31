<?php

require_once("SimpleRest.php");
require_once("Site.php");

/**
 * Class SiteRestHandler
 */
class SiteRestHandler extends SimpleRest
{

    function getAllSites(){

        $site = new Site();
        $rawData = $site->getAllSite();

        if(empty($rawData)){
            $statusCode = 404;
            $rawData = array("error"=>"No site found!");
        }else{
            $statusCode = 200;
        }

        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this->setHttpHeaders($requestContentType,$statusCode);

        if(strpos($requestContentType,'application/json') != false){
            $response = $this->encodeJson($rawData);
            echo $response;
        }elseif (strpos($requestContentType,'text/html') != false){
            $response = $this->encodeHtml($rawData);
            echo $response;
        }elseif (strpos($requestContentType,'application/xml') != false){
            $response = $this->encodeXml($rawData);
            echo $response;
        }
    }

    /**
     * @param $responseData
     * @return string
     */
    public function encodeHtml($responseData) {
        $htmlResponse = "<table border='1'>";

        foreach ($responseData as $key=>$value){
            $htmlResponse .= "<tr><td>".$key."</td><td>".$value."</td></tr>";
        }

        $htmlResponse .= "</table>";
        return $htmlResponse;
    }

    /**
     * @param $responseData
     * @return mixed
     */
    public function encodeXml($responseData){
        //创建SimpleXMLElement 对象
        $xml = new SimpleXMLElement('<?xml version="1.0"?><site></site>');

        foreach ($responseData as $key=>$value){
            $xml->addChild($key,$value);
        }
        return $xml->asXML();
    }


}