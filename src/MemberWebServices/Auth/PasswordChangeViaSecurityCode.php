<?php 
namespace MemberWebServices\Auth;
use MemberWebServices\Config;
use MemberWebServices\CallApi;

class PasswordChangeViaSecurityCode{

    private $CONTENTTYPE = 'application/json';
    private $headers = [];
    private $response;


    public function __construct($apiAccessToken, $userId, $newPassword, $securityCode){
        $this->headers = [
            "access_token" => $apiAccessToken,
            "content-type" => $this->CONTENTTYPE,
        ];
        $config = new Config();
        $this->programUdk = $config->getProgramId();
        
        $this->URLPARAMS = "member-connect.excentus.com/fuelrewards/public/rest/v2/" . $this->programUdk . "/members/password"; 

        $this->body = [
            "userId" => $userId,
            "password" => $newPassword,
            "securityCode" => $securityCode,
            "tcAction" => "true",
            "authorizationCode" => "",
            "marcomOptIn" => "",
            "partnerAttribute" => "",
        ];
        $this->callApiObj = new CallApi($this->REQUESTTYPE,$this->URLPARAMS,$this->headers,$this->options,$this->body);
        $this->response = $this->callApiObj->requestApi();
    }

    public function getResponse(){
        return $this->response->getBody();
    }
}
?>