<?php

namespace MemberWebServices;
use Dotenv\Dotenv;


class Config{
    
    
    private $baseUrl;
    private $clientUserIdDev;
    private $clientUserSecreteDev;
    private $clientUserIdProd;
    private $clientUserSceretProd;
    private $participantId;
    private $programId;
    private $psid;

    public function __construct(){
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->safeLoad();
        $this->baseUrl = $_ENV['BASE_URL'];
        $this->clientUserIdDev = $_ENV['CLIENT_USER_ID_DEV'];
        $this->clientUserIdProd = $_ENV['CLINET_USER_ID_PROD'];
        $this->clientUserSecreteDev = $_ENV['CLIENT_USER_SECRET_DEV'];
        $this->clientUserSceretProd = $_ENV['CLIENT_USER_SECRET_PROD'];
        $this->participantId = $_ENV['PARTICIPANT_ID'];
        $this->programId = $_ENV['PROGRAM_ID'];
        $this->psid = $_ENV['PSID'];

    }
    

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
            return $this->clientUserSceretProd;
        }
    }

    public function setUserSecretCredentialsProd($clientUserSceretProd){
        return $this->clientUserSceretProd = $clientUserSceretProd;
    }
}


?>