<?php

include("connection.php");

// Init Variables

$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$photo = $_POST["photo"];
$description = $_POST["description"];

// Functions

//Get User Data
function getData ($user, $mysql) {
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

    return json_encode($response);
};

// Main

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

echo getData ("LambdaTiger", $mysql);

?>
