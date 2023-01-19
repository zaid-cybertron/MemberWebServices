<?php

namespace MemberWebServices\BalanceAndTransactionsOperation;
use MemberWebServices\Config;
use MemberWebServices\CallApi;

class Balances
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
    private $memberAccountNumber;

    public function __construct($memberAccountNumber,$memberAccessToken)
    {
        $this->headers = [
            "content-type" => $this->CONTENTTYPE,
            "memberAccessToken" => $memberAccessToken,
        ];
        $config = new Config();
        $this->programUdk = $config->getProgramId();
        $this->retailerId =  $config->getParticipantId();
        $this->memberAccountNumber = $memberAccountNumber;
        
    }
    public function getResponse(){
        return json_decode($this->response->getBody()->getContents());
    }
    public function getBalance($param){

        $this->URLPARAMS = "member-connect.excentus.com/fuelrewards/public/rest/v2/" . $this->programUdk . "/members/" . $this->memberAccountNumber . "/balances?rewardType=" . $param  ; 

        $this->callApiObj = new CallApi($this->REQUESTTYPE,$this->URLPARAMS,$this->headers,$this->options,$this->body);
        $this->response = $this->callApiObj->requestApi();

        return json_decode($this->response->getBody()->getContents());
    }

    public function getCpgAmount(){
        $response = $this->getBalance("CPG");
        return $response->rewardDetails->totalRewards;
    }
 
    public function getPointsAmount(){
        $response = $this->getBalance("POINTS");
        return $response->rewardDetails->totalRewards;
    }
    
}
?>