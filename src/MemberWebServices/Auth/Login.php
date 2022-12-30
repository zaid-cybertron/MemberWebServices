<?php

namespace MemberWebServices\Auth;
use MemberWebServices\CallApi;
use MemberWebServices\Config;

class Login{

    private $callApiObj;
    
    private $body = [];
    private $REQUESTTYPE = "POST";
    private $URLPARAMS;
    private $CONTENTTYPE = "application/json";
    private $options = [];
    private $response;
    private $headers = [];
    private $programUdk;
    private $memberAccessToken;
    private $memberRefreshToken;
    
    public function __construct($apiAccessToken,$userId, $password){

        $this->headers = [
            "access_token" => $apiAccessToken,
            "content-type" => $this->CONTENTTYPE,
        ];
        $config = new Config();
        $this->programUdk = $config->getProgramId();
        
        $this->URLPARAMS = "member-connect.excentus.com/fuelrewards/public/rest/v2/" . $this->programUdk . "/login"; 

        $this->body = [
            "userId" => $userId,
            "password" => $password,
             "partnerAttributes" => [
               [
                  "participantId" => "",
                  "partnerAssociation" => "",
                  "<partner-defined attribute>" => "",
                  "name" => "",
                  "value" => ""
             ]
            ]
        ];
        $this->callApiObj = new CallApi($this->REQUESTTYPE,$this->URLPARAMS,$this->headers,$this->options,$this->body);
        $this->response = $this->callApiObj->requestApi();
    }

    public function getResponse(){
         
        return json_decode($this->response->getBody()->getContents());
    }   
}


















?>