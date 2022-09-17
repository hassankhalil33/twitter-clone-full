<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include("connection.php");

$userName = $_POST["userName"];

function getUserData($user, $mysql) {
    $query = $mysql -> prepare(
        "SELECT f_name, l_name FROM users
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

function getFollowing($user, $mysql) {
    $query = $mysql -> prepare(
        "SELECT followed_user_id FROM follows
        WHERE `user_id` = '$user'"
    );

    $query -> execute();
    $array = $query -> get_result();

    $response = [];

    while($i = $array -> fetch_assoc()){
        $response[] = $i;
    };

    return $response;
};

?>
