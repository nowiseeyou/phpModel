## RESTful ##

RESET(Representational State Transfer ,简称REST),指的是一组架构约束条件和原则。

符合REST设计风格的Web Api称为RESTful API,他从以下三个方面资源进行定义：

- 直观简短的资源地址：URL,例：http://example.com/resources/。
- 传输资源：Web服务接收与返回的互联网媒体类型，例：JSON,XML,YAM等。
- 对资源的操作：Web服务在该资源上所支持的一系列请求方法（POST，GET，PUT，DELETE）。

创建一个RESTful web service

- 创建一个RESTful Web service。
- 使用原生PHP，不依赖任何框架。
- URL模型需要遵循REST规则。
- RESTful service 接收与返回的格式可以是 JSON， XML。
- 根据不同情况相应对应的HTTP状态码。
- 演示请求头的使用。
- 使用REST 客户端来测试RESTful web service

## RESTful Webservice实例 ##

    <?php
	//RESTful 演示实例
	Class Site {
		private $sites = array(
			1=>"taobao",
			2=>"google",
			3=>"baidu",
			4=>"jd",
			5=>"sina"
		);

		public function getAllSite(){
			return $this->sites;
		}

		public function getSite(){
			$site = isset($this->sites[$id]) ? $this->sites[$id] : $this->sites[1];
        	return $site;
		}
	}

	
## RESTful Services URI映射 ##

RESTful Services URI应该设置为一个直观简短的资源地址，Apache服务器的.htaccess 应该设置好对应的Rewrite规则。

1、获取所有站点列表

    http://localhost/restexample/site/list/

2、使用ID获取对应站点地址

    http://localhost/restexample/site/list/3/

项目的.htaccess文件配置规则如下所示

    #开启 rewrite 功能
	Options +FollowSymlinks
	RewriteEngine on

	#重写规则
	RewriteRule ^site/list/$ RestController.php?view=all[nc,qsa]
	RewriteRule ^site/list/([0-9]+)/$ RestController.php?view=single&id=$1 [nc,qsa]

## RESTful Web Service 控制器##

在 .htaccess 文件中，我们通过设置参数 'view' 来获取RestController.php文件中的对应请求，通过获取'view'不同参数来分到不同的方法上，RestController.php 文件代码如下：

实例：

    <?php 
	require_once('siteRestHandler.php')
	
	$view = "";
	if(isset($_GET['view'])) $view = $_GET['view'];

	//RESTful service 控制器  URL 映射
	
	switch($view){
		case  "all":
			//处理 REST Url /site/list/
			$siteRestHandler = new SiteRestHandler();
			$siteRestHandler->getAllSites();
			break;

		case "single":
			//处理 REST Url /site/show/<id>/
			$siteRestHandler = new SiteRestHandler();
			$siteRestHandler->getSite($_GET['id']);
			break;
		case "":
			//404 - not found;
			break;
		
	}

## 简单的 RESTful 基础类 ##
以下提供了RESTful 的一个基础类，用于处理响应请求的HTTP状态码，SimpleRest.php 文件代码如下：

    <?php
/**
 * Class SimpleRest
 * 一个简单的 RESTful web services 基类
 * 我们可以基于这个类来扩展需求
 */

	class SimpleRest
	{
	    private $httpVersion = "HTTP/1.1";
	
	    /**
	     * @param $contentType
	     * @param $statusCode
	     */
	    public function setHttpHeaders($contentType,$statusCode){
	
	        $statusMessage = $this -> getHttpStatusMessage($statusCode);
	
	        header($this->httpVersion . "" . $statusCode. "" .$statusMessage);
	        header("Content-Type".$contentType);
	
	    }
	
	    /**
	     * @param $statusCode
	     * @return mixed
	     */
	    public function getHttpStatusMessage($statusCode){
	
	        $httpStatus = array(
	            100 => 'Continue',
	            101 => 'Switching Protocols',
	            200 => 'OK',
	            201 => 'Created',
	            202 => 'Accepted',
	            203 => 'Non-Authoritative Information',
	            204 => 'No Content',
	            205 => 'Reset Content',
	            206 => 'Partial Content',
	            300 => 'Multiple Choices',
	            301 => 'Moved Permanently',
	            302 => 'Found',
	            303 => 'See Other',
	            304 => 'Not Modified',
	            305 => 'Use Proxy',
	            306 => '(Unused)',
	            307 => 'Temporary Redirect',
	            400 => 'Bad Request',
	            401 => 'Unauthorized',
	            402 => 'Payment Required',
	            403 => 'Forbidden',
	            404 => 'Not Found',
	            405 => 'Method Not Allowed',
	            406 => 'Not Acceptable',
	            407 => 'Proxy Authentication Required',
	            408 => 'Request Timeout',
	            409 => 'Conflict',
	            410 => 'Gone',
	            411 => 'Length Required',
	            412 => 'Precondition Failed',
	            413 => 'Request Entity Too Large',
	            414 => 'Request-URI Too Long',
	            415 => 'Unsupported Media Type',
	            416 => 'Requested Range Not Satisfiable',
	            417 => 'Expectation Failed',
	            500 => 'Internal Server Error',
	            501 => 'Not Implemented',
	            502 => 'Bad Gateway',
	            503 => 'Service Unavailable',
	            504 => 'Gateway Timeout',
	            505 => 'HTTP Version Not Supported'
	        );
	        return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $httpStatus[500];
	    }
	}

## RESTful Web Service 处理类 ##

以下是一个RESTful Web Service处理类 SiteRestHandler.php ,继承了上面我们提供的Restful 基类，类中通过判断请求的参数来决定返回的HTTP 状态码以及数据格式，实例中我们提供了三种数据格式 "application/json"，"application/xml"，"text/html":


**SiteRestHandler.php 文件代码如下：**

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
	
	    /**
	     * @param $responseData
	     * @return false|string
	     */
	    public function encodeJson($responseData){
	        $jsonResponse = json_encode($responseData);
	        return $jsonResponse;
	    }
	
	    public function getSite($id){
	        $site = new Site();
	        $rawData = $site->getSite($id);
	
	        if(empty($rawData)){
	            $statusCode = 404;
	            $rawData = array('error'=> 'No sites found!');
	        }else{
	            $statusCode = 200;
	        }
	
	        $requestContentType = $_SERVER['HTTP_ACCEPT'];
	        $this->setHttpHeaders($requestContentType,$statusCode);
	
	        if(strpos($requestContentType,'application/json') != false){
	            $response = $this->encodeJson($rawData);
	            echo $response;
	        }elseif(strpos($requestContentType,'text/html') != false){
	            $response = $this->encodeHtml($rawData);
	            echo $response;
	        }elseif(strpos($requestContentType,'application/xml') != false){
	            $response = $this->encodeXml($rawData);
	            echo $response;
	        }
	    }
	}