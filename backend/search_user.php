<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include("connection.php");

$searchQuery = $_POST["searchQuery"];

function searchFor($search, $mysql) {
    $query = $mysql -> prepare(
        "SELECT username, f_name, l_name FROM users
        WHERE `username` = ? OR f_name = ? OR l_name = ?"
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

echo json_encode(searchFor($searchQuery, $mysql));

?>
