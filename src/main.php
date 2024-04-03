<?php 
    include_once __DIR__ ."/redirect_to_success.php";

    $_SESSION["logged_in"] = false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/welcome.css">
    <title>Main Page</title>
</head>
<body>
    <section class="wrapper">
        <h1>PHP Lab Site</h1>
        <div class="buttonWrapper">
            <a href="login.php">Login</a>
            <a href="registration.php">Register</a>
        </div>
    </section>
</body>
</html>