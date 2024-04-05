<?php
include_once __DIR__."/activate.php";

if(isset($_GET["token"])) {
    $key = "verification_token";
    $value = $_GET["token"];
    $status_table = "is_email_verified";

    $result = activate_account($key, $value, $status_table);

    if($result) header("Location: account_activated.php");
    exit();
} else {
    header("Location: main.php");
}