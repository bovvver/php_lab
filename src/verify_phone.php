<?php
include_once __DIR__."/activate.php";

session_start();

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION["phone_status"] = "Phone number not active";

    $key = "sms_code";
    $value = $_POST["code"];
    $status_table = "is_phone_verified";
    $redirect = "phone_number.php";

    $result = activate_account($key, $value, $status_table, $redirect);

    if($result) {
        $_SESSION["phone_status"] = "Phone number active";
        header("Location: $redirect");
    }
    exit();
} else {
    header("Location: main.php");
}