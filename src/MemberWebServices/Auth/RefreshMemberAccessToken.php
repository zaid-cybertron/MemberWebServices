<?php

namespace MemberWebServices\Auth;
use MemberWebServices\CallApi;
use MemberWebServices\Config;

class RefreshMemberAccessToken{

    private $callApiObj;
    
    private $body = [];
    private $REQUESTTYPE = "POST";
    private $URLPARAMS;
    private $CONTENTTYPE = "application/json";
    private $options = [];
    private $response;
    private $headers = [];
    private $programUdk;
    
    public function __construct($apiAccessToken,$accountNumber,$memberRefreshToken){

        $this->headers = [
            "access_token" => $apiAccessToken,
            "content-type" => $this->CONTENTTYPE,
        ];
        $config = new Config();
        $this->programUdk = $config->getProgramId();
        
        $this->URLPARAMS = "member-connect.excentus.com/fuelrewards/public/rest/v2/" . $this->programUdk . "/members/" . $accountNumber . "/token"; 

        $this->body = [
            "memberRefreshToken" => $memberRefreshToken,
        ];

        $this->callApiObj = new CallApi($this->REQUESTTYPE,$this->URLPARAMS,$this->headers,$this->options,$this->body);
        $this->response = $this->callApiObj->requestApi();
    }

    public function getResponse(){
        
        return json_decode($this->response->getBody()->getContents());
    }   
}


