<?php

include("connection.php");

$image = $_POST["image"];

function imageDecode($image) {
    return base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image)); //stackoverflow
};

function imageSave($image, $id, $type) {
    $photoAddress = dirname(__FILE__). "../images/" . $type . $id . ".png", $image;
    file_put_contents($photoAddress);

    if($type == "profile") {
        $query = $mysql -> prepare(
            "UPDATE users SET profile_picture = '$photoAddress'
            WHERE id = '$id'");
    } else {
        $query = $mysql -> prepare(
            "INSERT INTO tweets(tweet_id, `image`)
            VALUE ('$id', '$photoAddress')");
    };

    if ($query === false) {
        die("error: " . $mysql -> error);
    };

    $query -> execute();
};

function imageRetrieve()

?>
