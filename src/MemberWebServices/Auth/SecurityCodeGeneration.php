<?php 
namespace MemberWebServices\Auth;
use MemberWebServices\Config;
use MemberWebServices\CallApi;

class SecurityCodeGeneration{

    private $CONTENTTYPE = 'application/json';
    private $headers = [];
    private $response;
    private $REQUESTTYPE = "POST";
    private $options = [];


    public function __construct($apiAccessToken, $userId, $channel){
        $this->headers = [
            "access_token" => $apiAccessToken,
            "content-type" => $this->CONTENTTYPE,
        ];
        $config = new Config();
        $this->programUdk = $config->getProgramId();
        
        $this->URLPARAMS = "member-connect.excentus.com/fuelrewards/public/rest/v2/" . $this->programUdk . "/members/password/securitycode"; 

        $this->body = [
            "userId" => $userId,
            "channel" => $channel,
            "partnerAttributes" => [],
        ];
        $this->callApiObj = new CallApi($this->REQUESTTYPE,$this->URLPARAMS,$this->headers,$this->options,$this->body);
        $this->response = $this->callApiObj->requestApi();
    }

    public function getResponse(){
        return json_decode($this->response->getBody());
    }
}
?>