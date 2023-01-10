<?php

namespace MemberWebServices;
use \MemberWebServices\CallApi;
use \MemberWebServices\GenerateAccessToken;
use \GuzzleHttp\Exception\ClientException as ClientException;

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
    ]
  ];
  private $response;
  private $headers = [];
  


  public function __construct($clientId,$clientSecret,$refreshToken)
  {
    $this->clientId = $clientId;
    $this->clientSecret = $clientSecret;
    $this->authorization = "";
    $this->headers = [
      "content-type" => $this->CONTENTTYPE,
      "refresh_token" => $refreshToken,
    ];
    $this->callApiObj = new CallApi($this->REQUESTTYPE,$this->URLPARAMS,$this->headers,$this->options,$this->body);
    try
    {
      $response = $this->callApiObj->requestApi();
      $this->response = json_decode($response->getBody()->getContents());
    }
    catch (ClientException $e) {
      $response = $e->getResponse();
      $this->response = json_decode($response->getBody()->getContents());
    }
  }
  public function getResponseData(){  
    return $this->response;
  }
}

