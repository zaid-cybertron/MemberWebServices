<?php 

namespace MemberWebServices\ProfileOperations;
use MemberWebServices\Config;
use MemberWebServices\CallApi;

class Preferences
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

    public function __construct($apiAccessToken,$memberAccountNumber,$preferenceId,$preferenceOptin)
    {
        $this->headers = [
            "access_token" => $apiAccessToken,
            "content-type" => $this->CONTENTTYPE,
        ];
        $config = new Config();
        $this->programUdk = $config->getProgramId();
        
        $this->URLPARAMS = "member-connect.excentus.com/fuelrewards/public/rest/v2/" . $this->programUdk . "/members/preferences"; 

        $this->body = [
            "accountNumber" => $memberAccountNumber,
            "memberProgramUDK" => "",
            "preferences" => [
                [
                    "id" => $preferenceId,
                    "code" => "",
                    "type" => "",
                    "description" => "",
                    "optin" => $preferenceOptin
                ]
            ],
        ];

        $this->callApiObj = new CallApi($this->REQUESTTYPE,$this->URLPARAMS,$this->headers,$this->options,$this->body);
        $this->response = $this->callApiObj->requestApi();
    }
    public function getResponse(){
        return json_decode($this->response->getBody()->getContents());
    }


}

?>