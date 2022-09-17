<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include("connection.php");

$userName = $_POST["userName"];
$followed = $_POST["followed"];

function checkFollowed($user, $follow, $mysql) {
    $check = $mysql -> prepare(
        "SELECT COUNT(`user_id`) FROM follows
        WHERE `user_id` = ? AND followed_user_id = ?"
    );

    $check -> bind_param("ss", $user, $follow);
    $check -> execute();
    $array = $check -> get_result();

    $response = [];
    $response[] = $array -> fetch_assoc();

    if ($response[0]["COUNT(`user_id`)"] == 1) {
        return true;
    } else {
        return false;
    };
};

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

    // echo json_encode($response);

    return $response[0]["id"];
};

function followUser($user, $follow, $mysql) {
    $query = $mysql -> prepare(
        "INSERT INTO follows(`user_id`, followed_user_id)
        VALUE (?, ?)");

    if ($query === false) {
        die("error: " . $mysql -> error);
    };

    $query -> bind_param("ss", $user, $follow);
    $query -> execute();
};

function unfollowUser($user, $follow, $mysql) {
    $query = $mysql -> prepare(
        "DELETE FROM follows
        WHERE `user_id` = ? AND followed_user_id = ?");

    if ($query === false) {
        die("error: " . $mysql -> error);
    };

    $query -> bind_param("ss", $user, $follow);
    $query -> execute();
};

$userId = returnId($userName, $mysql);
$followedId = returnId($followed, $mysql);

echo json_encode($userId);
echo json_encode($followedId);

if (checkFollowed($userId, $followedId, $mysql)) {
    unfollowUser($userId, $followedId, $mysql);
    echo json_encode("unfollowed successfully");
} else {
    followUser($userId, $followedId, $mysql);
    echo json_encode("followed successfully");
};

?>
