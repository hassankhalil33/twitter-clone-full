<?php

include("connection.php");

$userName = $_POST["userName"];
$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$email = $_POST["email"];
$dateJoined = date("d M Y @ " . "H" . ":i");
$userType = 1;
$passwordSS = hash("sha256", $_POST["password"] . $dateJoined . "asd");

$query = $mysql

echo json_encode($array);

?>
