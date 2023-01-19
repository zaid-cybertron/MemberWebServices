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
        $this->response = $this->callApiObj->requestApi();
        
    }
    public function getResponse(){
        return json_decode($this->response->getBody()->getContents());
    }


    public function getUpcomingOffers(){
        $response = json_decode($this->response->getBody()->getContents());
        $upcomingOffers = [];
    
        if (!isset($response->errors))
        {
            foreach($response->offerRewardDetails as $offerDetails)
            {
                $offer = [];
                if ($offerDetails->rewardType == "POINTS" || $offerDetails->rewardType == "CPG"){
                    array_push($upcomingOffers, [
                        "currentBalance" => $offerDetails->curPurchaseBalance,
                        "requiredBalance" => $offerDetails->offerRequirement,
                        "pendingBalance" => $offerDetails->offerRequirement - $offerDetails->curPurchaseBalance,
                        "offerId" => $offerDetails->offerId,
                        "offerDescription" => $offerDetails->offerDescription,
                    ]);
                }
                
                array_push($upcomingOffers,[$offer]);
            }
            return $upcomingOffers;
        }
        
        return $response;
    }
}
?>