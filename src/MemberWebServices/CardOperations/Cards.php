<?php 

namespace MemberWebServices\CardOperations;
use MemberWebServices\Config;
use MemberWebServices\CallApi;

class Cards
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
        
        $this->URLPARAMS = "member-connect.excentus.com/fuelrewards/public/rest/v2/" . $this->programUdk . "/members/" . $memberAccountNumber . "/cards"; 

        $this->callApiObj = new CallApi($this->REQUESTTYPE,$this->URLPARAMS,$this->headers,$this->options,$this->body);
        $this->response = $this->callApiObj->requestApi();
    }
    public function getResponse(){
        return json_decode($this->response->getBody()->getContents());
    }
    public function getCards(){
        
        if (!isset($this->response->errors)){
            $cardsData = json_decode($this->response->getBody()->getContents());
            $cards = [];
            foreach($cardsData->retailerCards as $card){
                array_push($cards,$card);
            }
            return $cards;
        }
        return $this->response;        
    }
}













































?> 