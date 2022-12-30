<?php

namespace MemberWebServices;
use \MemberWebServices\CallApi;

class RevokeAccessToken
{
  private $callApiObj;
  private $authorization;
  private $REQUESTTYPE = "PUT";
  private $URLPARAMS = "/authservice/v2/accesstokens";
  private $options = [[]];
  private $response;
  private $headers = [];
  private $body = [];

  public function __construct($clientId, $clientSecret,$generateToken)
  {
    $this->authorization = "Basic " .  base64_encode($clientId.":".$clientSecret);
    $this->headers = [
      "authorization" => $this->authorization,
      "accessToken" => $generateToken->getAccessToken(),
      "refreshToken" => $generateToken->getRefreshToken(),
    ];
    $this->callApiObj = new CallApi($this->REQUESTTYPE,$this->URLPARAMS,$this->headers,$this->options,$this->body);
    $this->response = $this->callApiObj->requestApi();
  }

  public function getResponse(){
    return (string)$this->response->getBody();
  }
}



























?>
