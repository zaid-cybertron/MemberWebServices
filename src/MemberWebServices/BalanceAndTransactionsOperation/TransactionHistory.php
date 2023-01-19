<?php

namespace MemberWebServices\BalanceAndTransactionsOperation;
use MemberWebServices\Config;
use MemberWebServices\CallApi;

class TransactionHistory
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

    public function __construct($apiAccessToken,$memberAccountNumber,$memberAccessToken)
    {
        $this->headers = [
            "content-type" => $this->CONTENTTYPE,
            "memberAccessToken" => $memberAccessToken,
            "access_token" => $apiAccessToken,
        ];
        $config = new Config();
        $this->programUdk = $config->getProgramId();
        $this->retailerId =  $config->getParticipantId();
        $this->memberAccountNumber = $memberAccountNumber;

            $this->URLPARAMS = "member-connect.excentus.com/fuelrewards/public/rest/v2/" . $this->programUdk . "/members/" . $this->memberAccountNumber . "/txnhistory"; 

        $this->callApiObj = new CallApi($this->REQUESTTYPE,$this->URLPARAMS,$this->headers,$this->options,$this->body);
        $this->response = $this->callApiObj->requestApi();
        
    }
    public function getResponse(){
        return json_decode($this->response->getBody()->getContents());
    }


    public function getRecentActivity(){
        $response = json_decode($this->response->getBody()->getContents());
        $recentActivities = [];
        
        if (isset($response->errors) && $response->errors[0]->errorCode == 1061){
            return $recentActivities;
        }

        if (!isset($response->errors) && $response->transactionCount > 0)
        {
            foreach($response->transactions as $transaction)
            {
                $activity = [
                    "transactionDate" => $transaction->transactionDateTime,
                    "storeName" => $transaction->storeName,
                    "transactionType" => $transaction->transactionType,
                ];
                if ($transaction->transactionType == "Issuance" && $transaction->rewards->offers->rewardType == "POINTS"){
                    array_push($activity, ["points" => $transaction->rewards->offers->rewardAmount]);
                }
                else if($transaction->transactionType == "Redemption" && $transaction->rewards->offers->rewardType == "POINTS"){
                    array_push($activity, ["points" => $transaction->rewards->offers->rewardAmount]);
                }
                array_push($recentActivities,[$activity]);
            }
            return $recentActivities;
        }
        
        return $response;
    }
}
?>