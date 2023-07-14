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
        $this->response = $this->callApiObj->requestApi()->getBody()->getContents();
        
    }
    public function getResponse(){
        return json_decode($this->response);
    }


    public function getRewardHistory(){
        $response = $this->getResponse();
        $recentActivities = [];

        if (isset($response->errors)) {
            return $recentActivities;
        } else {
            $recentActivities = [];
            foreach ($response->transactions as $transaction) {
                if ($transaction->transactionType == "Issuance" && !empty($transaction->rewards)) {
                    foreach ($transaction->rewards as $reward) {
                        if ($reward->issuanceType == "POINTS") {
                            $transactionDate = date("Y-m-d", strtotime($transaction->transactionDateTime));
                            $activity = [
                                "transactionDate" => $transactionDate,
                                "storeName" => $transaction->siteName,
                                "transactionType" => $transaction->transactionType,
                                "earned" => $reward->earned
                            ];
                            $recentActivities[] = $activity;
                        }
                    }
                }
                else if ($transaction->transactionType == "Redemption" && !empty($transaction->rewards)) {
                    foreach ($transaction->rewards as $reward) {
                        if ($reward->redemptionType == "POINTS") {
                            $transactionDate = date("Y-m-d", strtotime($transaction->transactionDateTime));
                            $activity = [
                                "transactionDate" => $transactionDate,
                                "storeName" => $transaction->siteName,
                                "transactionType" => $transaction->transactionType,
                                "redeemed" => $reward->redeemed
                            ];
                            $recentActivities[] = $activity;
                        }
                    }
                }
            }
        
            return $recentActivities;
        }
        
        
        
        return $response;
    }
    public function getRecentActivity(){
        $response = $this->getResponse();
        $allTransactions = [];
        
        if (isset($response->errors) && $response->errors[0]->errorCode == 1061){
            return $allTransactions;
        }

        if (!isset($response->errors))
        {
            foreach($response->transactions as $transaction)
            {
                $trans = [
                    "transactionDate" => date("Y-m-d", strtotime($transaction->transactionDateTime)),
                    "retailerName"  => $transaction->retailerName,
                    "transactionType" => $transaction->transactionType,
                    "transactionAmount" => $transaction->transactionAmount,
                    "siteName" => $transaction->siteName,
                    "rewards" => $transaction->rewards,
                    "cardNumber" => $transaction->cardNumber
                ];
                array_push($allTransactions,$trans);
            }
            return $allTransactions;
        }
        
        return $response;
    }
}
?>