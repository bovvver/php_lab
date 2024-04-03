<?php 
    session_start();

    if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) header("Location: main.php");
    
    function showEmail() {
        if(isset($_SESSION["logged_user"])) 
            echo $_SESSION["logged_user"];
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
        <p>Logged as: <?php showEmail(); ?></p>
    </section>
</body>
</html>