<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include("connection.php");
include("image_handler.php");

// Init Variables

$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$photo = $_POST["photo"];
$description = $_POST["description"];
$userName = $_POST["userName"];

// Functions

//Get User Data
function getData($user, $mysql) {
    $query = $mysql -> prepare(
        "SELECT id, f_name, l_name, `description`, profile_pic FROM users
        WHERE username = '$user'"
    );
    
    $query -> execute();
    $array = $query -> get_result();
    
    $response = [];
    
    while($i = $array -> fetch_assoc()) {
        $response[] = $i;
    };

    return $response;
};

// Update Data
function updateData($user, $mysql, $name, $last, $desc) {
    $query = $mysql -> prepare(
        "UPDATE users SET f_name = '$name', l_name = '$last',
        `description` = '$desc'
        WHERE username = '$user'"
    );
    
    $query -> execute();
    return true;
};

// Main

$json = getData($userName, $mysql);
$id = $json[0]["id"];
$dbName = $json[0]["f_name"];
$dbLast = $json[0]["l_name"];
$dbPhoto = $json[0]["profile_pic"];
$dbDesc = $json[0]["description"];

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
    $decodedImage = imageDecode($photo);
    imageSave($decodedImage, $id, "profile", $mysql);
};

if (isset($description)) {
    $updateDesc = $description;
} else {
    $updateDesc = $dbDesc;
};

updateData($userName, $mysql, $updateName, $updateLast, $updateDesc);

?>
