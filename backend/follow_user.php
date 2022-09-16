<?php

include("connection.php");

$userName = $_POST["userName"];
$followed = $_POST["followed"];

//NEED TO ADD IF EXISTS TO UNFOLLOW

function returnId($user, $mysql) {
    $check = $mysql -> prepare(
        "SELECT id FROM users
        WHERE username = '$user'"
    );

    $check -> execute();
    $array = $check -> get_result();

    $response = [];
    $response[] = $array -> fetch_assoc();

    // echo json_encode($response);

    return $response[0]["id"];
};

$userId = returnId($userName, $mysql);
$followedId = returnId($followed, $mysql);

echo json_encode($userId);
echo json_encode($followedId);

$query = $mysql -> prepare(
    "INSERT INTO follows(`user_id`, followed_user_id)
    VALUE (?, ?)");

if ($query === false) {
    die ("error: " . $mysql -> error);
};

$query -> bind_param("ss", $userId, $followedId);
$query -> execute();

echo json_encode("success");

?>
