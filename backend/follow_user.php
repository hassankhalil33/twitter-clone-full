<?php

$userName = $_POST["userName"];
$followed = $_POST["followed"];

function returnId($user) {
    $check = $mysql -> prepare(
        "SELECT id FROM users
        WHERE username = '$user'"
    );

    $check -> execute();
    $array = $check -> get_result();

    $response = [];
    $response[] = $array -> fetch_assoc();

    return $response;
};

$userId = returnId($userName);
$followedId = returnId($followed);

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
