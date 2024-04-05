<?php
session_start();

include_once __DIR__."/db_connection.php";

if(isset($_GET["id"])) {
    $connection = connect_to_db();

    $env = parse_ini_file(".env");

    $stmt = $connection->prepare("SELECT phone_number, sms_code FROM users WHERE email=?");
    $stmt->bind_param("s", $_GET["id"]);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();
    $phone_number = $row["phone_number"];
    $sms_code = $row["sms_code"];

    $data = array(
        "jsonrpc" => $env["JSON_RPC"],
        "method" => "SendSMS",
        "params" => array(
            "SMSId" => -1,
            "SMSContent" => "Your code is: $sms_code",
            "PhoneNumber" => array($phone_number),
            "SMSTime" => date('Y-m-d H:i:s')
        ),
        "id" => $env["SMS_ID"],
    );

    $postData = json_encode($data);

    $curlOptions = array(
        CURLOPT_URL => $env["SMS_URL"],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_HTTPHEADER => array(
            "Accept: text/plain, */*; q=0.01",
            "Content-Type: application/x-www-form-urlencoded;   charset=UTF-8"
        )
    );

    $ch = curl_init();
    curl_setopt_array($ch, $curlOptions);
    curl_setopt($ch, CURLOPT_HTTP09_ALLOWED, true);

    $response = curl_exec($ch);

    if ($response === false) echo "Failed: " . curl_error($ch);

    curl_close($ch);
} else {
    header("Location: success.php");
}