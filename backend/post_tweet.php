<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include("connection.php");

$userName = $_POST["userName"];
$text = $_POST["text"];
$datePosted = date("d M Y @ " . "H" . ":i");
$images = $_POST["images"];

function returnId($user, $mysql) {
    $check = $mysql -> prepare(
        "SELECT id FROM users
        WHERE username = ?"
    );

    $check -> bind_param("s", $user);
    $check -> execute();
    $array = $check -> get_result();

    $response = [];
    $response[] = $array -> fetch_assoc();

    return $response[0]["id"];
};

echo returnId($userName, $mysql);

?>