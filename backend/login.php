<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

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
    die(json_encode("username not found!"));
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
    $tokenPayload = json_encode($myObj1);

    echo json_encode(tokenEncode($tokenHeader, $tokenPayload, $SECRETKEY));
} else {
    echo json_encode("incorrect password");
};

?>
