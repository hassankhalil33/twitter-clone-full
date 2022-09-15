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

function tokenDecode($exp, $token) {
    $payload = explode(".", $token);
    return $payload[1];
};

function verifySignature() {

};

$myObj2 -> username = "LambdaTiger";
$myObj2 -> iat = "151623902";
$tokenPayload = json_encode($myObj2);

$output = tokenEncode($tokenHeader, $tokenPayload, $secretKey);
echo tokenDecode($regExp, $output);

?>
