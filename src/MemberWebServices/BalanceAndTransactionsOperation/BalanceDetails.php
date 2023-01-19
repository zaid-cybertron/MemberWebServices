<?php

namespace MemberWebServices\BalanceAndTransactionsOperation;
use MemberWebServices\Config;
use MemberWebServices\CallApi;

class BalanceDetails 
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

    public function __construct($memberAccountNumber,$memberAccessToken)
    {
        $this->headers = [
            "content-type" => $this->CONTENTTYPE,
            "memberAccessToken" => $memberAccessToken,
        ];
        $config = new Config();
        $this->programUdk = $config->getProgramId();
        $this->retailerId =  $config->getParticipantId();
        
        $this->URLPARAMS = "member-connect.excentus.com/fuelrewards/public/rest/v2/" . $this->programUdk . "/members/" . $memberAccountNumber . "/balance/details"; 

        $this->callApiObj = new CallApi($this->REQUESTTYPE,$this->URLPARAMS,$this->headers,$this->options,$this->body);
        $this->response = $this->callApiObj->requestApi();
    }
    public function getResponse(){
        return json_decode($this->response->getBody()->getContents());
    }

    public function getCPGAmount(){
        $response = json_decode($this->response->getBody()->getContents());
        $balanceDetials = json_decode($response->balanceDetails);
        $cpgAmount = 0;
        if (!empty($balanceDetails))
        {
            foreach ($balanceDetails as $balanceDetail){
                if ($balanceDetail->rewardType == "CPG"){
                    foreach($balanceDetails->participantRewards as $participantReward){
                        $cpgAmount += $participantReward->rewardAmount;
                    }
                }
            }
            return $cpgAmount;
        }
        return $cpgAmount;
    }
 
    public function getPointsAmount(){
        $response = json_decode($this->response->getBody()->getContents());
        $balanceDetials = json_decode($response->balanceDetails);
        $pointsAmount = 0;
        if (!empty($balanceDetails))
        {
            foreach ($balanceDetails as $balanceDetail){
                if ($balanceDetail->rewardType == "CPG"){
                    foreach($balanceDetails->participantRewards as $participantReward){
                        $pointsAmount += $participantReward->rewardAmount;
                    }
                }
            }
            return $pointsAmount;
        }
        return $pointsAmount;
    }
    
}































































?>