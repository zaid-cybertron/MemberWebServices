<?php 

namespace MemberWebServices\ProfileOperations;
use MemberWebServices\Config;
use MemberWebServices\CallApi;

class UpdateProfile
{
    private $callApiObj;
    private $body = [];
    private $REQUESTTYPE = "PUT";
    private $URLPARAMS;
    private $CONTENTTYPE = "application/json";
    private $options = [];
    private $response;
    private $headers = [];
    private $programUdk;
    private $bodyParameters = [];

    public function __construct($memberAccessToken,$memberAccountNumber,$bodyParams)
    {
        $this->headers = [
            "content-type" => $this->CONTENTTYPE,
            "memberAccessToken" => $memberAccessToken,
        ];
        $config = new Config();
        $this->programUdk = $config->getProgramId();
        
        $this->URLPARAMS = "member-connect.excentus.com/fuelrewards/public/rest/v2/" . $this->programUdk . "/members/$memberAccountNumber"; 
    
        $this->body = [
            $this->bodyParameters,
        ];

        $this->callApiObj = new CallApi($this->REQUESTTYPE,$this->URLPARAMS,$this->headers,$this->options,$bodyParams);
        $this->response = $this->callApiObj->requestApi();
    }
    public function getResponse(){
        return json_decode($this->response->getBody()->getContents());
    }

}

?>
