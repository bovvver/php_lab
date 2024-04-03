<?php
include_once __DIR__."/redirect_to_main.php";

function connect_to_db(): ?mysqli {
    $env = parse_ini_file(".env");

    $servername = $env["DB_SERVER"] ?? null;
    $username = $env["DB_USERNAME"] ?? null;
    $password = $env["DB_PASSWORD"] ?? null;
    $db_name = $env["DB_NAME"] ?? null;

    if (!$servername || !$username || !$password || !$db_name) return null;

    $connection = mysqli_connect($servername, $username, $password, $db_name);

    if (!$connection) die("Connection failed: ".mysqli_connect_error());

    return $connection;
}
?>
