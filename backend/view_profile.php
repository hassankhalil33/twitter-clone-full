<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include("connection.php");
include("image_handler.php");

// Init Variables

$userName = $_GET["userName"];

function returnId($user, $mysql) {
    $check = $mysql -> prepare(
        "SELECT id FROM users
        WHERE username = ?"
    );

    $check -> bind_param("s", $user);
    $check -> execute();
    $array = $check -> get_result();

    $response = [];
    $response[] = $array -> fetch_assoc();

    return $response[0]["id"];
};

function getData($user, $mysql) {
    $query = $mysql -> prepare(
        "SELECT username, f_name, l_name, `description`, date_of_joining 
        FROM users WHERE username = '$user'"
    );
    
    $query -> execute();
    $array = $query -> get_result();
    
    $response = [];
    
    while($i = $array -> fetch_assoc()) {
        $response[] = $i;
    };

    return $response;
};

function getFollows($user, $mysql) {
    $query = $mysql -> prepare(
        "SELECT COUNT(f.followed_user_id) FROM follows f, users u 
        WHERE u.username = '$user' AND u.id = f.user_id"
    );

    $query -> execute();
    $array = $query -> get_result();
    
    $response = [];
    
    while($i = $array -> fetch_assoc()) {
        $response[] = $i;
    };

    $query = $mysql -> prepare(
        "SELECT COUNT(f.user_id) FROM follows f, users u 
        WHERE u.username = '$user' AND u.id = f.followed_user_id"
    );

    $query -> execute();
    $array = $query -> get_result();

    while($i = $array -> fetch_assoc()) {
        $response[] = $i;
    };

    $response[0]["following"] = $response[0]["COUNT(f.followed_user_id)"];
    unset($response[0]["COUNT(f.followed_user_id)"]);

    $response[0]["followers"] = $response[1]["COUNT(f.user_id)"];
    unset($response[1]);

    return $response;
};

$data = getData($userName, $mysql);
$follows = getFollows($userName, $mysql);
$allData = array_merge($data, $follows);

$allData[0]["following"] = $allData[1]["following"];
$allData[0]["followers"] = $allData[1]["followers"];
unset($allData[1]);
$id = returnId($userName, $mysql);
$image = imageRetrieve($id, "profile", $mysql);

$allData[0]["profile_pic"] = $image;

echo json_encode($allData);

?>
