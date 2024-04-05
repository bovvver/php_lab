<?php
    session_start();
    if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) header("Location: main.php");

    function show_logged_email() {
        if(isset($_SESSION["logged_email"]))
            echo "?id=".$_SESSION["logged_email"];
        else echo "";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activate phone number</title>
</head>
<body>
    <section class="wrapper">
        <a href="send_sms_code.php<?php show_logged_email(); ?>">Send code</a>
        <form action="verify_phone.php" method="POST">
            <label for="code">Verification code</label>
            <input id="code" name="code" />
            <button type="submit">Verify</button>
        </form>
    </section>
</body>
</html>