<?php

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
    die("logged in successfully");
} else {
    die("incorrect password");
};

?>
