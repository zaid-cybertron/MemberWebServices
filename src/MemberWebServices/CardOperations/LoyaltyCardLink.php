<?php

namespace MemberWebServices\CardOperations;
use MemberWebServices\Config;
use MemberWebServices\CallApi;

class LoyaltyCardLink
{
    private $callApiObj;
    private $body = [];
    private $REQUESTTYPE = "POST";
    private $URLPARAMS;
    private $CONTENTTYPE = "application/json";
    private $options = [];
    private $response;
    private $headers = [];
    private $programUdk;
    private $retailerId;

    public function __construct($apiAccessToken,$memberAccountNumber,$cardNumber,$zipCode)
    {
        $this->headers = [
            "access_token" => $apiAccessToken,
            "content-type" => $this->CONTENTTYPE,
        ];
        $config = new Config();
        $this->programUdk = $config->getProgramId();
        $this->retailerId =  $config->getParticipantId();
        
        $this->URLPARAMS = "member-connect.excentus.com/fuelrewards/public/rest/v2/" . $this->programUdk . "/members/cardlink"; 

        $this->body = [
            "accountNumber" => $memberAccountNumber,
            "retailerId" => $this->retailerId,
            "cardNumber" => $cardNumber, 
            "zipCode" => $zipCode,
        ];

        $this->callApiObj = new CallApi($this->REQUESTTYPE,$this->URLPARAMS,$this->headers,$this->options,$this->body);
        $this->response = $this->callApiObj->requestApi();
    }
    public function getResponse(){
        return json_decode($this->response->getBody()->getContents());
    }


}



















?>