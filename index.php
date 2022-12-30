<?php

require_once (__DIR__ . '/vendor/autoload.php');

use \MemberWebServices\GenerateAccessToken;
use \MemberWebServices\GenerateRefreshToken;
use \MemberWebServices\Config;
use MemberWebServices\RevokeAccessToken;
use MemberWebServices\Auth\Registration;
use MemberWebServices\Auth\Login;
use MemberWebServices\Auth\PasswordChangeViaSecurityCode;
use MemberWebServices\Auth\RefreshMemberAccessToken;
use MemberWebServices\Auth\SecurityCodeGeneration;
use MemberWebServices\Auth\SecurityCodeValidation;

use MemberWebServices\CardOperations\LoyaltyCardLink;

$config = new Config();
$clientId = $config->getUserIdCredentialsDev();
$clientSecret = $config->getUserSecretCredentialsDev();

$generateToken = new GenerateAccessToken($clientId,$clientSecret);
// print_r("Old access token = " . $generateToken->getResponse());
// print_r("\n Old refresh token = " . $generateToken->getRefreshToken());


// $refreshToken = new GenerateRefreshToken($clientId,$clientSecret,$generateToken);
// print_r("\n New access token 2 = " . $generateToken->getAccessToken());
// print_r("\n New refresh token = " . $generateToken->getRefreshToken());

$apiAccessToken = $generateToken->getResponse();
print_r($apiAccessToken);
// $revokeToken = new RevokeAccessToken($clientId,$clientSecret,$generateToken);
// print_r($revokeToken->getResponse());
// print_r($apiAccessToken . " ");
// $register = new Registration($apiAccessToken,"arshdeep","singh","wipam93995@khaxan.com","123-123-1234","14562","123544444","test@1234",true);
// print_r($register->getResponse());

// $login = new Login($apiAccessToken, "wipam93995@khaxan.com","test@1234");
// print_r($login->getResponse());

// $securityCodeGenerate = new SecurityCodeGeneration($apiAccessToken,"wipam93995@khaxan.com","email");
// print_r($securityCodeGenerate->getResponse());
// $linkCard = new LoyaltyCardLink("3a19dc69-f367-4af1-b5ff-a99f69755f6d","3121865","1234567891234567","12345");
// print_r($linkCard->getResponse());

$refreshToken = new RefreshMemberAccessToken($apiAccessToken,"3121865","v1.MbfV8gsZ9JuOVvvVbBiul8X-kY46M1zS_6kAcMw7g0avnjt11DyBbw0GQR9HdE3feVRYxMBhZ8A_JTgkjL4nIgo");
print_r($refreshToken->getResponse());


?>
