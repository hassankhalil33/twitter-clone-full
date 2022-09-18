<?php

include("connection.php");

$image = $_POST["image"];

function imageDecode($image) {
    return base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image)); //stackoverflow
};

function imageSave($image, $id, $type) {
    //file_put_contents("C:/xampp/htdocs/fswo5/twitter-clone/images/" . $type . $id . ".png", $image);
    file_put_contents(dirname(__FILE__). "../images/" . $type . $id . ".png", $image);
};

?>
