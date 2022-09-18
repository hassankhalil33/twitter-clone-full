<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include("connection.php");

$userName = $_POST["userName"];
$searchQuery = $_POST["searchQuery"];
$regEx = ".*(" . $searchQuery . ").*";
$i = 0;

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

function searchFor($search, $mysql) {
    $query = $mysql -> prepare(
        "SELECT id, username, f_name, l_name FROM users
        WHERE `username` REGEXP ? OR f_name REGEXP ? OR l_name REGEXP ?"
    );

    $query -> bind_param("sss", $search, $search, $search);
    $query -> execute();
    $array = $query -> get_result();

    $response = [];

    while($i = $array -> fetch_assoc()){
        $response[] = $i;
    };

    return $response;
};

function checkBlocked($id, $mysql) {
    $query = $mysql -> prepare(
        "SELECT `user_id` FROM blocks
        WHERE blocked_user_id = '$id'"
    );

    $query -> execute();
    $array = $query -> get_result();

    $response = [];

    while($i = $array -> fetch_assoc()){
        $response[] = $i;
    };

    return $response;
};

$userId = returnId($userName, $mysql);
$blockedBy = checkBlocked($userId, $mysql);
$allData = searchFor($regEx, $mysql);

foreach($allData as $data) {
    foreach($blockedBy as $id){
        if($data["id"] == $id["user_id"]) {
            unset($allData[$i]);
        };
    };
    $i++;
};

$array = [];
foreach($allData as $data) {
    $array[] = $data;
};

echo json_encode($array);

?>
