<?php

include("token.php");

//Get Key from token.php
$key = $secretKey;

// Functions

function tokenDecode($userToken) {
    $payload = explode(".", $userToken);
    return base64_decode($payload[1]);
};

function tokenAlive($userToken, $key){
    if(! verifySignature($userToken, $key)) {
        die("error: incorrect token.");
    };

    $userData = tokenDecode($userToken);
    $result = json_decode($userData, true);
    $expTime = $result["exp"];

    if ($expTime < time()) {
        die("session expired");
    };

    return true;
};

?>
