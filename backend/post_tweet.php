<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include("connection.php");

$userName = $_POST["userName"];
$text = $_POST["text"];
$datePosted = date("d M Y @ " . "H" . ":i");
//$images = $_POST["images"];

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

function postTweet($id, $text, $date, $mysql) {
    $query = $mysql -> prepare(
        "INSERT INTO tweets(`user_id`, `text`, `time`)
        VALUE (?, ?, ?)");

    if ($query === false) {
        die("error: " . $mysql -> error);
    };

    $query -> bind_param("sss", $id, $text, $date);
    $query -> execute();
};

$userId = returnId($userName, $mysql);
postTweet($userId, $text, $datePosted, $mysql);

echo json_encode("success");

?>
