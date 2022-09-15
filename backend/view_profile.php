<?php

include("connection.php");

// Init Variables

$userName = $_GET["userName"];

// if (decodeToken($userToken) != $userName) {
    
// }

// Functions

function getData($user, $mysql) {
    $query = $mysql -> prepare(
        "SELECT username, f_name, l_name, `description`,
        profile_pic, date_of_joining, 
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

function getFollowed($user, $mysql) {
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

    return json_encode($response);
};

function getFollowers($user, $mysql) {
    $query = $mysql -> prepare(
        "SELECT COUNT(f.user_id) FROM follows f, users u 
        WHERE u.username = '$user' AND u.id = f.followed_user_id"
    );

    $query -> execute();
    $array = $query -> get_result();
    
    $response = [];
    
    while($i = $array -> fetch_assoc()) {
        $response[] = $i;
    };

    return json_encode($response);
};

echo getFollowed($userName, $mysql);
echo getFollowers($userName, $mysql);

?>
