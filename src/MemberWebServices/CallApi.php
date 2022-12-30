<?php 

namespace MemberWebServices;
use \MemberWebServices\Config;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class CallApi{
    
    private $client;
    private $config;
    private $response;
    private $requestType;
    private $urlParam;
    private $headers = [];
    private $body = [];
    private $req;
    private $options = [[

    ]];
    
    public function __construct($requestType,$urlParam,$headers,$options,$body)
    {
        $this->config = new Config;
        $this->client = new Client();
        $this->requestType =  $requestType;
        $this->headers = $headers;
        $this->urlParam = $this->config->getBaseUrl() . $urlParam;
        $this->body = json_encode($body);
        $this->options = $options;
        // print_r(($this->body));

    }

    public function requestApi(){
        $this->req =  new Request($this->requestType,$this->urlParam,$this->headers,$this->body);
        $this->response = $this->client->sendAsync($this->req,$this->options)->wait();
        return $this->response;
    }
}

?>