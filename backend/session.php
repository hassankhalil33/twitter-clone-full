<?php

include("token.php");

$userToken = $_POST["token"];

if(! verifySignature($userToken, $secretKey)) {
    die("error: incorrect token.");
};

$userData = tokenDecode($userToken);
echo $userData;

?>