<?php

include 'phpsqlsearch_dbinfo.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	class restApi {
		public $_content_type = "application/json";
		public $_request = array();		
		private $_code = 200;
		public function __construct(){
			$this->inputs();
		}
		// returning response with HTTP status code and headers
		public function response($data,$statusCode){
			$this->_code = ($statusCode)?$statusCode:200;
			$this->setHeaders();
			echo $data;
			exit;
		}
		// HTTP messages with status code
		private function getStatusMessage(){
			$status = array(
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
				505 => 'HTTP Version Not Supported',
				506	=> 'invalid length',
				507	=> 'Invalid search Code');
				
			return ($status[$this->_code])?$status[$this->_code]:$status[500];
		}
		// receiving inputs in json and decoding the input
		public function inputs(){
			$json = file_get_contents('php://input');
			$this->_request = json_decode($json);
		}		
		// set HTTP headers
		private function setHeaders(){
			header("HTTP/1.1 ".$this->_code." ".$this->getStatusMessage());
			header("Content-Type:".$this->_content_type);
		}
		//Encode array into JSON
		public function json($data,$message,$statusCode,$status)
		{
			if(is_array($data)){
				$response = array();
				//$response['status'] = $status;
				$response['overallStatusCode'] = $statusCode;
				$response['message'] = $message;
				$response['result'] = $data;
				return json_encode($response);
			}
		}
		// Function for authenticating the api request
		public function checkAuth(){
			$headers = getallheaders();
			$token='';
			foreach ($headers as $header => $value) {
				if($header == "Accesstoken"){
						$token=$value;
						break;		 
				}		
			} 
			 // here you can check access token of perticular user as well from db
			if(!empty($token) && $token=='VJbldi9KMCBeeNRxatK/XVYUNgy'){
				return true;
			}else{
				$this->response($this->json([],'Unauthorized request',401,0), 401);
			}
		}
	}	
	

?>
