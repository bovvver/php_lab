<?php
declare(strict_types=1);
include_once __DIR__ ."/redirect_to_main.php";
include_once __DIR__."/db_connection.php";
include_once __DIR__."/send_activation_mail.php";
session_start();

function sanitize_input(string $data): string {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function get_email_records_count(\mysqli $connection, string $email): int {
    $stmt = $connection->prepare("SELECT COUNT(id) FROM users WHERE email=?");

    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = (int) $row["COUNT(id)"];
    
    return $count;
}

function register_user(\mysqli $connection, string $email, string $password) {
    $stmt = $connection->prepare("INSERT INTO users (email, password, verification_token)
            VALUES (?, ?, ?)");

    $token = md5($email.time());
    $stmt->bind_param("sss", $email, password_hash($password, PASSWORD_BCRYPT), $token);
    $stmt->execute();
    send_activation_mail($email, $token);
}

$errors = [];

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $connection = connect_to_db();

    $email = sanitize_input($_POST["email"]);
    $email_rows = get_email_records_count($connection, $email);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Invalid email";
    } else if ($email_rows != 0) {
        $errors["email"] = "Account with this e-mail already exists";
    }

    $password = sanitize_input($_POST["password"]);
    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",$password)) {
        $errors["password"] = "Password isn't safe";
    }

    $repeat_password = sanitize_input($_POST["repeatPassword"]);
    if ($repeat_password !== $password) {
        $errors["repeat_password"] = "Passwords missmatch";
    }

    if(count($errors) !== 0){
        $_SESSION["errors"] = $errors;
        header("Location: registration.php");
        exit();
    }

    unset($_SESSION["errors"]);
    register_user($connection, $email, $password);
    $connection -> close();
    header("Location: login.php");
}
?>