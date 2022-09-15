<?php

include("token.php");

$userToken = $_POST["token"];

if(! verifySignature($userToken, $secretKey)) {
    die("error: incorrect token.");
};

$userData = tokenDecode($userToken);
$result = json_decode($userData, true);
$expTime = $result["exp"];

if ($expTime < time()) {
    die("session expired");
};

echo true;

?>
