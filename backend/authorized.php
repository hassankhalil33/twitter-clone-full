<?php

include("token.php");

// Init Variables

$userName = $_POST["userName"];
$userToken = $_POST["token"];

// Main

echo isAuthorized($userName, $userToken, $SECRETKEY);

?>
