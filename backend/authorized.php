<?php

include("token.php");

// Init Variables

$userName = $_POST["userName"];
$userToken = $_POST["token"];

echo isAuthorized($userName, $userToken, $SECRETKEY);

?>