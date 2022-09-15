<?php

include("connection.php");
include("session.php");

// Init Variables

$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$photo = $_POST["photo"];
$description = $_POST["description"];
$userToken = $_POST["token"];
$userName = $_POST["userName"];

// Functions

//Get User Data
function getData($user, $mysql) {
    $query = $mysql -> prepare(
        "SELECT f_name, l_name, `description`, profile_pic FROM users
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
function updateData($user, $mysql, $name, $last, $desc, $pic) {
    $query = $mysql -> prepare(
        "UPDATE users SET f_name = '$name', l_name = '$last',
        `description` = '$desc', profile_pic = '$pic'
        WHERE username = '$user'"
    );
    
    $query -> execute();
    return true;
};

// Main

if (! isAuthorized($userName, $userToken, $secretKey)) {
    die("not authorized");
};

$json = getData($userName, $mysql);
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
    $updatePhoto = $photo;
} else {
    $updatePhoto = $dbPhoto;
};

if (isset($description)) {
    $updateDesc = $description;
} else {
    $updateDesc = $dbDesc;
};

//Check Token Then Update
if (tokenAlive($userToken, $key)) {
    updateData($userName, $mysql, $updateName, $updateLast, $updatePhoto, $updateDesc);
    die("updated successfully");
};

?>
