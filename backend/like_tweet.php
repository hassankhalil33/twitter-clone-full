<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include("connection.php");

$userName = $_POST["userName"];
$tweetId = $_POST["tweetId"];

function checkLiked($user, $tweet, $mysql) {
    $check = $mysql -> prepare(
        "SELECT COUNT(`user_id`) FROM likes
        WHERE `user_id` = ? AND tweet_id = ?"
    );

    $check -> bind_param("ss", $user, $tweet);
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

    return $response[0]["id"];
};

function likeTweet($user, $tweet, $mysql) {
    $query = $mysql -> prepare(
        "INSERT INTO likes(`user_id`, tweet_id)
        VALUE (?, ?)");

    if ($query === false) {
        die("error: " . $mysql -> error);
    };

    $query -> bind_param("ss", $user, $tweet);
    $query -> execute();
};

function unlikeTweet($user, $tweet, $mysql) {
    $query = $mysql -> prepare(
        "DELETE FROM likes
        WHERE `user_id` = ? AND tweet_id = ?");

    if ($query === false) {
        die("error: " . $mysql -> error);
    };

    $query -> bind_param("ss", $user, $tweet);
    $query -> execute();
};

$userId = returnId($userName, $mysql);

if (checkLiked($userId, $tweetId, $mysql)) {
    unlikeTweet($userId, $tweetId, $mysql);
    echo json_encode("unliked successfully");
} else {
    likeTweet($userId, $tweetId, $mysql);
    echo json_encode("liked successfully");
};

?>
