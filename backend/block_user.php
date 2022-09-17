<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include("connection.php");

$userName = $_POST["userName"];
$blocked = $_POST["blocked"];

function checkBlocked($user, $block, $mysql) {
    $check = $mysql -> prepare(
        "SELECT COUNT(`user_id`) FROM blocks
        WHERE `user_id` = ? AND blocked_user_id = ?"
    );

    $check -> bind_param("ss", $user, $block);
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

function blockUser($user, $block, $mysql) {
    $query = $mysql -> prepare(
        "INSERT INTO blocks(`user_id`, blocked_user_id)
        VALUE (?, ?)");

    if ($query === false) {
        die("error: " . $mysql -> error);
    };

    $query -> bind_param("ss", $user, $block);
    $query -> execute();
};

function unblockUser($user, $block, $mysql) {
    $query = $mysql -> prepare(
        "DELETE FROM blocks
        WHERE `user_id` = ? AND blocked_user_id = ?");

    if ($query === false) {
        die("error: " . $mysql -> error);
    };

    $query -> bind_param("ss", $user, $block);
    $query -> execute();
};

$userId = returnId($userName, $mysql);
$blockedId = returnId($blocked, $mysql);

if (checkBlocked($userId, $blockedId, $mysql)) {
    unblockUser($userId, $blockedId, $mysql);
    echo json_encode("unblocked successfully");
} else {
    blockUser($userId, $blockedId, $mysql);
    echo json_encode("blocked successfully");
};

?>
