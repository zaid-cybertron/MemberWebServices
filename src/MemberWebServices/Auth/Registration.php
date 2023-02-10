<?php

namespace MemberWebServices\Auth;
use MemberWebServices\CallApi;
use MemberWebServices\Config;

class Registration{

    private $callApiObj;
    
    private $body = [];
    private $REQUESTTYPE = "POST";
    private $URLPARAMS;
    private $CONTENTTYPE = "application/json";
    private $options = [];
    private $response;
    private $headers = [];
    private $programUdk;
    
    public function __construct($apiAccessToken,$firstName, $lastName, $brithDate, $email, $primaryPhone, $zipCode, $password, $tcAction){

        $this->headers = [
            "access_token" => $apiAccessToken,
            "content-type" => $this->CONTENTTYPE,
        ];
        $config = new Config();
        $this->programUdk = $config->getProgramId();
        
        $this->URLPARAMS = "member-connect.excentus.com/fuelrewards/public/rest/v2/" . $this->programUdk . "/members"; 

        $this->body = [
            "userId" => $email,
            "password" => $password,
            "firstName" => $firstName,
            "lastName" => $lastName,
            "street1" => "",
            "street2" => "",
            "city" => "",
            "stateCode" => "",
            "zipCode" => $zipCode,
            "primaryPhone" => $primaryPhone,
            "primaryPhoneType" => "",
            "secondaryPhone" => "",
            "secondaryPhoneType" => "",
            "mobilePhone" => "",
            "homePhone" => "",
            "birthDate" => "",
            "gender" => "",
            "tcAction" => $tcAction,
            "marcomOptIn" => "true",
            "partnerSourceId" => "",
            "mode" => "",
            "smsOptIn" => "",
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
