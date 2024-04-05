<?php
declare(strict_types=1);
include_once __DIR__ ."/redirect_to_main.php";
include_once __DIR__."/db_connection.php";

session_start();

function check_credentials(\mysqli $connection, string $email, string $password) {
    $stmt = $connection->prepare("SELECT password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) return false;

    $row = $result->fetch_assoc();
    $hashed_password = $row["password"];

    return password_verify($password, $hashed_password);
}

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $connection = connect_to_db();
    $email = $_POST["email"];
    $password = $_POST["password"];
        
    if(!check_credentials($connection, $email, $password)) {
        $_SESSION["login_error"] = "Invalid credentials";
        header("Location: login.php");
        exit();
    }

    $_SESSION["logged_in"] = true;
    $_SESSION["logged_email"] = $email;
    unset($_SESSION["login_error"]);

    $connection -> close();

    header("Location: success.php");
}