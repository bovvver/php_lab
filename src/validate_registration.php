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

function get_records_count(\mysqli $connection, string $key, string $value): int {
    $stmt = $connection->prepare("SELECT COUNT(id) FROM users WHERE $key=?");

    $stmt->bind_param("s", $value);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = (int) $row["COUNT(id)"];
    
    return $count;
}

function generate_sms_code(int $length): string {
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $randomString = "";
    
    for ($i = 0; $i < $length; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    
    return $randomString;
}

function register_user(\mysqli $connection, string $email, string $phone_number, string $password) {
    $stmt = $connection->prepare("INSERT INTO users (email, phone_number, password, verification_token, sms_code)
            VALUES (?, ?, ?, ?, ?)");

    $token = md5($email.time());
    $sms_code = generate_sms_code(5);
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt->bind_param("sssss", $email, $phone_number, $hashed_password, $token, $sms_code);
    $stmt->execute();
    send_activation_mail($email, $token);
}

$errors = [];

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $connection = connect_to_db();

    $email = sanitize_input($_POST["email"]);
    $email_rows = get_records_count($connection, "email", $email);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Invalid email";
    } else if ($email_rows != 0) {
        $errors["email"] = "Account with this e-mail already exists";
    }

    $phone_number = sanitize_input($_POST["phoneNumber"]);
    $phone_rows = get_records_count($connection, "phone_number", $phone_number);

    if (!preg_match("/^\+?[1-9][0-9]{7,14}$/", $phone_number)) {
        $errors["phone_number"] = "Wrong phone number format";
    } else if ($phone_rows != 0) {
        $errors["phone_number"] = "Account with this phone number already exists";
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
    register_user($connection, $email, $phone_number, $password);
    $connection -> close();
    header("Location: login.php");
}