<?php

namespace MemberWebServices;
use Dotenv\Dotenv;
use App\Models\Configuration;

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
        $configuration = Configuration::findOrFail(1);
        $dotenv = Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']."/../");
        $dotenv->safeLoad();
        $appEnv = $configuration->app_mode;
        $this->baseUrl = $appEnv == 0 ? $configuration->stage_url : $configuration->prod_url;
        $this->clientUserIdDev = $configuration->user_id_dev;
        $this->clientUserIdProd = $configuration->user_id_prod;
        $this->clientUserSecreteDev = $configuration->user_secret_dev;
        $this->clientUserSceretProd = $configuration->user_secret_prod;
        $this->participantId = $configuration->participant_id;
        $this->programId = $configuration->program_id;
        $this->psid = $configuration->psid;

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