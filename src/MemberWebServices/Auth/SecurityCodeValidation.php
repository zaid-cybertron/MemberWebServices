<?php 
namespace MemberWebServices\Auth;
use MemberWebServices\Config;
use MemberWebServices\CallApi;

class SecurityCodeValidation{

    private $CONTENTTYPE = 'application/json';
    private $headers = [];
    private $response;


    public function __construct($apiAccessToken, $userId, $uniqueCode){
        $this->headers = [
            "access_token" => $apiAccessToken,
            "content-type" => $this->CONTENTTYPE,
        ];
        $config = new Config();
        $this->programUdk = $config->getProgramId();
        
        $this->URLPARAMS = "member-connect.excentus.com/fuelrewards/public/rest/v2/" . $this->programUdk . "/members/password/uniquecode/validate"; 

        $this->body = [
            "userId" => $userId,
            "uniqueCode" => $uniqueCode,
        ];
        $this->callApiObj = new CallApi($this->REQUESTTYPE,$this->URLPARAMS,$this->headers,$this->options,$this->body);
        $this->response = $this->callApiObj->requestApi();
    }

    public function getResponse(){
        return $this->response->getBody();
    }
}
?>