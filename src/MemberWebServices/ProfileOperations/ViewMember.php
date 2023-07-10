<?php
namespace MemberWebServices\ProfileOperations;
use MemberWebServices\Config;
use MemberWebServices\CallApi;

class ViewMember 
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


    public function __construct($memberAccessToken, $memberAccountNumber)
    {
        $this->headers = [
            "Content-Type" => $this->CONTENTTYPE,
            "memberAccessToken" => $memberAccessToken,
        ];
        
        $config = new Config();
        $this->programUdk = $config->getProgramId();
        
        $this->body = [];
        
        $this->URLPARAMS = "member-connect.excentus.com/fuelrewards/public/rest/v2/" . $this->programUdk . "/members/" . $memberAccountNumber . "?memberAttributes=Y"; 

        $this->callApiObj = new CallApi($this->REQUESTTYPE  ,$this->URLPARAMS,$this->headers,$this->options,$this->body);
        $this->response = $this->callApiObj->requestApi();

    }
    public function getResponse()
    {
        if (isset($this->response->errors))
        {

            return json_decode($this->response->errors);
        }
        
        return json_decode($this->response->getBody()->getContents()); 
    }


}


?>