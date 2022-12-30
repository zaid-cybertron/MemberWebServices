<?php

namespace MemberWebServices;
use \MemberWebServices\CallApi;

class GenerateAccessToken
{
  private $callApiObj;
  private $clientId;
  private $clientSecret;
  private $authorization;
  private $body = [];
  private $REQUESTTYPE = "POST";
  private $URLPARAMS = "auth-connect.excentus.com/authservice/v2/accesstokens";
  private $CONTENTTYPE = "application/x-www-form-urlencoded";
  private $options = [
    'form_params' => [
      'grant_type' => 'client_credentials',
      'bizType' => 'B2C'
    ]];
  private $response;
  private $accessToken;
  private $refreshToken;
  private $headers = [];

  public function __construct($clientId, $clientSecret)
  {
    $this->clientId = $clientId;
    $this->clientSecret = $clientSecret;
    $this->authorization = "Basic " .  base64_encode($this->clientId.":".$this->clientSecret);
    $this->headers = [
      "content-type" => $this->CONTENTTYPE,
      "authorization" => $this->authorization,
    ];
    $this->callApiObj = new CallApi($this->REQUESTTYPE,$this->URLPARAMS,$this->headers,$this->options,$this->body);
    $this->response = $this->callApiObj->requestApi();
  }

  public function getResponse(){
    foreach(json_decode($this->response->getBody()->getContents(),true) as $key => $val){
      if ($key != null && $key == "accessToken"){
        $this->accessToken = $val;
      }
      else if($key != null && $key == "refreshToken"){
        $this->refreshToken = $val;
      }
    }
    return $this->accessToken;
  }
  public function getAccessToken(){
    return $this->accessToken;
  }
  public function setAccessToken($accessToken){
    $this->accessToken = $accessToken;
  }
  public function getRefreshToken(){
    return $this->refreshToken;
  }
  public function setRefreshToken($refreshToken){
    $this->refreshToken = $refreshToken;
  }

}



























?>
