<?php

$userName = $_POST["userName"];
$followed = $_POST["followed"];



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
