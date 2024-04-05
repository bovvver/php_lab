<?php 
    session_start();

    if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) header("Location: main.php");
    
    function show_email() {
        if(isset($_SESSION["logged_email"])) 
            echo $_SESSION["logged_email"];
    }

    function show_phone_number_status() {
        if(isset($_SESSION["phone_status"])) 
            echo $_SESSION["phone_status"];
        else echo "";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/success.css">
    <title>Logged In!</title>
</head>
<body>
    <section class="wrapper">
        <h2>Logged In!</h2>
        <p>Logged as: <?php show_email(); ?></p>
        <a href="phone_number.php">Confirm your phone number</a>
        <p><?php show_phone_number_status(); ?></p>
    </section>
</body>
</html>