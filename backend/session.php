<?php

include("token.php");

$key = $secretKey;

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
