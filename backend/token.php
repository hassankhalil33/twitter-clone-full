<?php

// Init Variables

$secretKey = "CDr9tr&Rk1c50ealZRrxcX#4";

$tokenHeader = {
    "alg": "HS256",
    "typ": "JWT"
};

// Functions

function tokenEncode($tokenHeader, $tokenPayload, $secretKey) {
    $encodedHeader = base64_encode($tokenHeader);
    $encodedPayload = base64_encode($tokenPayload);
    $encodedSignature = hash_hmac("sha256", "$encodedHeader" . "." . "$encodedPayload", $secretKey);
    return ("$encodedHeader" . "$encodedPayload" . "$encodedSignature");
};

function tokenDecode() {

};

function verifySignature() {

};

?>
