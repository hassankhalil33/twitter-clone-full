<?php

include("connection.php");

$userName = $_POST["userName"];
$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$email = $_POST["email"];
$dateJoined = date("d M Y @ " . "H" . ":i");
$userType = 1;
$password = hash("sha256", $_POST["password"] . $dateJoined . "asd");

$query = $mysql -> prepare(
    "INSERT INTO users(user_type, f_name, l_name, username, password, email, date_of_join)
    VALUE ($userType, ?, ?, ?, $password, ?, $dateJoined)");
$query -> bind_param("ssss", $firstName, $lastName, $userName, $email);
$query -> execute();

echo json_encode($array);

?>
