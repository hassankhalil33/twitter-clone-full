<?php

// Init Variables

$secretKey = "CDr9tr&Rk1c50ealZRrxcX#4";

$myObj -> alg = "HS256";
$myObj -> typ = "JWT";
$tokenHeader = json_encode($myObj);

// Functions

function tokenEncode($header, $payload, $key) {
    $encodedHeader = base64_encode($header);
    $encodedPayload = base64_encode($payload);
    $encodedSignature = hash_hmac("sha256", "$encodedHeader" . "." . "$encodedPayload", $key);
    return ("$encodedHeader" . "." . "$encodedPayload" . "." . "$encodedSignature");
};

function tokenDecode($token) {
    $payload = explode(".", $token);
    return base64_decode($payload[1]);
};

function verifySignature($token, $key) {
    $explodedArray = explode(".", $token);
    $encodedSignature = hash_hmac("sha256", "$explodedArray[0]" . "." . "$explodedArray[1]", $key);
    return ($explodedArray[2] === $encodedSignature);
};

?>
