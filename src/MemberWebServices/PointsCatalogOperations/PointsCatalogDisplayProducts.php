<?php
namespace MemberWebServices\PointsCatalogOperations;
use MemberWebServices\Config;
use MemberWebServices\CallApi;

class PointsCatalogDisplayProducts   
{
    private $callApiObj;
    private $body = [];
    private $REQUESTTYPE = "GET";
    private $URLPARAMS;
    private $CONTENTTYPE = "application/json";
    private $options = [];
    private $response;
    private $headers = [];
    private $programUdk;
    private $retailerId;


    public function __construct($memberAccessToken, $memberAccountNumber, $onlyRedeemable = false)
    {
        $this->headers = [
            "Content-Type" => $this->CONTENTTYPE,
            "memberAccessToken" => $memberAccessToken,
        ];
        
        $config = new Config();
        $this->programUdk = $config->getProgramId();
        $this->retailerId =  $config->getParticipantId();
        
        // $this->body = [
        //     "participantUdk" => $config->getParticipantId(),
        //     "offerUdk" => $offerUdk,
        //     "timestamp" => $timestamp,
        //     "timezone" => $timezone,
        // ];
        
        $this->URLPARAMS = "member-connect.excentus.com/fuelrewards/public/rest/v2/" . $this->programUdk . "/members/" . $memberAccountNumber . "/retailers/". $this->programUdk . "/catalog?" . $onlyRedeemable; 

        $this->callApiObj = new CallApi($this->REQUESTTYPE  ,$this->URLPARAMS,$this->headers,$this->options,$this->body);
        $this->response = $this->callApiObj->requestApi();

    }
    public function getResponse()
    {
        if (isset($this->response->errors))
        {

            return $this->response->errors;
        }
        
        return $this->response->getBody()->getContents(); 
    }


}


?>