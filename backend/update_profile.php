<?php

include("connection");

// Init Variables

$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$photo = $_POST["photo"];
$description = $_POST["description"];

if (isset($firstName)) {
    $updateName = $firstName;
} else {
    $updateName = $dbName;
};

if (isset($lastName)) {
    $updateLast = $lastName;
} else {
    $updateLast = $dbLast;
};

if (isset($photo)) {
    $updatePhoto = $photo;
} else {
    $updatePhoto = $dbPhoto;
};

if (isset($description)) {
    $updateDesc = $description;
} else {
    $updateDesc = $dbDesc;
};

?>
