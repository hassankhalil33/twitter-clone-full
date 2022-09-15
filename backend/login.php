<?php

include("token.php");
include("connection.php");

$userName = $_POST["userName"];

$check = $mysql -> prepare(
    "SELECT date_of_joining, `password` FROM users
    WHERE username = '$userName'"
);

$check -> execute();
$array = $check -> get_result();

$response = [];

while($i = $array -> fetch_assoc()) {
    $response[] = $i;
};

if (! $response) {
    die ("username not found!");
};

$dateJoined = $response[0]["date_of_joining"];
$passwordStored = $response[0]["password"];

$password = hash("sha256", $_POST["password"] . $dateJoined . "asd");

if ($password === $passwordStored) {
    $currentTime = time();
    $myObj1 = new stdClass();
    $myObj1 -> username = "$userName";
    $myObj1 -> iat = "$currentTime";
    $myObj1 -> exp = "$currentTime" + 10800; //3 hours expiration
    $tokenHPayload = json_encode($myObj1);

    echo json_encode(tokenEncode($tokenHeader, $tokenHPayload, $secretKey));
} else {
    echo "incorrect password";
};

?>
