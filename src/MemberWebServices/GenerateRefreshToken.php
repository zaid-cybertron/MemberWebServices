<?php

namespace MemberWebServices;
use \MemberWebServices\CallApi;
use \MemberWebServices\GenerateAccessToken;

class GenerateRefreshToken
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
      'grant_type' => 'refresh_token',
    ]];
  private $response;
  private $headers = [];
  


  public function __construct($clientId,$clientSecret,$generateToken)
  {
    $this->clientId = $clientId;
    $this->clientSecret = $clientSecret;
    $this->authorization = "";
    $this->headers = [
      "content-type" => $this->CONTENTTYPE,
      "refresh_token" => $generateToken->getRefreshToken(),
    ];
    $this->callApiObj = new CallApi($this->REQUESTTYPE,$this->URLPARAMS,$this->headers,$this->options,$this->body);
    $this->response = $this->callApiObj->requestApi();

    foreach(json_decode($this->response->getBody()->getContents(),true) as $key => $val){
      if ($key != null && $key == "accessToken"){
        $generateToken->setAccessToken($val);
      }
      else if($key != null && $key == "refreshToken"){
        $generateToken->setRefreshToken($val);
      }
    }
  }

  public function getResponse(){
    print_r($this->response->getBody()->getContents());
  }
}

