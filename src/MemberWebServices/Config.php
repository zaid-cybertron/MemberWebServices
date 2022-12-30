<?php

namespace MemberWebServices;

class Config{

    private $baseUrl = "https://staging-";
    private $clientUserIdDev = "2b4084a2-8367-444a-a57b-86013b89a42c";
    private $clientUserSecreteDev = "da23ec9a-b57f-4dfb-aaac-fb4a33255727";
    private $clientUserIdProd;
    private $clientUserSceretProd;
    private $participantId = "ONI15122";
    private $programId = "ONI15122";
    private $psid = "coenweb";

    public function getBaseUrl(){
        return $this->baseUrl;
    }
    
    public function getParticipantId(){
        return $this->participantId;
    }
    
    public function getProgramId(){
        return $this->programId;
    }
    
    public function getPsid(){
        return $this->psid;
    }

    public function getUserIdCredentialsDev(){
        if (!empty($this->clientUserIdDev)){
            return $this->clientUserIdDev;
        }
    }

    public function setUserIdCredentialsDev($clientUserIdDev){
        return $this->clientUserIdDev = $clientUserIdDev;
    }

    public function getUserSecretCredentialsDev(){
        if (!empty($this->clientUserSecreteDev)){
            return $this->clientUserSecreteDev;
        }
    }

    public function setUserSecretCredentialsDev($clientUserSecreteDev){
        return $this->clientUserSecreteDev = $clientUserSecreteDev;
    }

    public function getUserIdCredentialsProd(){
        if (!empty($this->clientUserIdProd)){
            return $this->clientUserIdProd;
        }
    }

    public function setUserIdCredentialsProd($clientUserIdProd){
        return $this->clientUserIdProd = $clientUserIdProd;
    }

    public function getUserSecretCredentialsProd(){
        if (!empty($this->clientUserSceretProd)){
            return $this->clientUserSecretProd;
        }
    }

    public function setUserSecretCredentialsProd($clientUserSceretProd){
        return $this->clientUserSceretProd = $clientUserSceretProd;
    }
}


?>