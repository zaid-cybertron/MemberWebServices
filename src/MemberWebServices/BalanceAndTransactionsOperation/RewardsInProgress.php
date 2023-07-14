<?php 

namespace MemberWebServices\BalanceAndTransactionsOperation;
use MemberWebServices\Config;
use MemberWebServices\CallApi;

class RewardsInProgress
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

            $this->URLPARAMS = "member-connect.excentus.com/fuelrewards/public/rest/v2/" . $this->programUdk . "/members/" . $this->memberAccountNumber . "/rewardsInProgress"; 

        $this->callApiObj = new CallApi($this->REQUESTTYPE,$this->URLPARAMS,$this->headers,$this->options,$this->body);
        $this->response = $this->callApiObj->requestApi()->getBody()->getContents();
        
    }
    public function getResponse(){
        return json_decode($this->response);
    }


    public function getUpcomingOffers(){
        $response = $this->getResponse();
        $upcomingOffers = [];
    
        if ($response !== null) {
            if (isset($response->errors)) {
                // Handle errors
                // ...
            } else {
                foreach ($response->offerRewardDetails as $offerDetails) {
                    if ($offerDetails->rewardType == "POINTS" || $offerDetails->rewardType == "CPG" || $offerDetails->rewardType == "PERCNT_OFF") {
                        $offer = [
                            "currentBalance" => $offerDetails->curPurchaseBal,
                            "requiredBalance" => $offerDetails->offerRequirement,
                            "pendingBalance" => $offerDetails->offerRequirement - $offerDetails->curPurchaseBal,
                            "offerId" => $offerDetails->offerId,
                            "offerDescription" => $offerDetails->offerDescription,
                            "longDescription" => $offerDetails->longDescription,
                        ];

                        $upcomingOffers[] = $offer;
                    }
                }

                return $upcomingOffers;
            }
        }
        return $response;
    }
}
?>