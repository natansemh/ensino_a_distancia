<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "escola_ead";

    $mysqli = new mysqli($host, $user, $password, $database);

    if($mysqli->connect_errno) {
        echo "Falha na conexao" . $mysqli->connect_error;
        exit();
    }
?>