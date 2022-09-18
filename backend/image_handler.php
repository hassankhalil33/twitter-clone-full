<?php

include("connection.php");

function imageDecode($image) {
    return base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image)); //stackoverflow
};

function imageDirectory($image, $id, $type) {
    return dirname(__FILE__). "../images/" . $type . $id . ".png", $image;
};

function imageSave($image, $id, $type, $dir) {
    file_put_contents($dir);

    if($type == "profile") {
        $query = $mysql -> prepare(
            "UPDATE users SET profile_picture = '$dir'
            WHERE id = '$id'");
    } else {
        $query = $mysql -> prepare(
            "INSERT INTO tweets(tweet_id, `image`)
            VALUE ('$id', '$dir')");
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
