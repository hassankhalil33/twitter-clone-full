<?php

include("connection.php");

$userName = $_POST["userName"];
$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$email = $_POST["email"];
$dateJoined = date("d M Y @ " . "H" . ":i");
$userType = 1;
$password = hash("sha256", $_POST["password"] . $dateJoined . "asd");

$check = $mysql -> prepare(
    "SELECT username, email FROM users
    WHERE username = '$userName' OR email = '$email'"
);

$check -> execute();
$array = $check -> get_result();

echo json_encode($array);

$query = $mysql -> prepare(
    "INSERT INTO users(user_type, f_name, l_name, username, `password`, email, date_of_joining)
    VALUE ('$userType', ?, ?, ?, '$password', ?, '$dateJoined')");

if ($query === FALSE) {
    die ("Error: " . $mysql -> error);
}

$query -> bind_param("ssss", $firstName, $lastName, $userName, $email);
$query -> execute();

echo json_encode("success");

?>
