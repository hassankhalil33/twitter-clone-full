<?php

include("connection.php");

function imageDecode($image) {
    return base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image)); //stackoverflow
};

function imageSave($image, $id, $type, $mysql) {
    $photoAddress = dirname(__FILE__). "../images/" . $type . $id . ".png";
    file_put_contents($photoAddress, $image);

    if($type == "profile") {
        $query = $mysql -> prepare(
            "UPDATE users SET profile_pic = '$photoAddress'
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

function imageRetrieve() {
    return;
};

?>
