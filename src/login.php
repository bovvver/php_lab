<?php 
    include_once __DIR__ ."/redirect_to_success.php";

    function show_login_error() {
        if(isset($_SESSION["login_error"]))
            echo $_SESSION["login_error"];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/form.css">
    <title>PHP Login</title>
</head>
<body>
    <section class="wrapper">
        <h1 class="title">Login</h1>
        <form action="validate_login.php" method="POST">
            <div class="inputWrapper">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email"/>
            </div>
            <div class="inputWrapper">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"/>
            </div>
            <span><?php show_login_error(); ?></span>
            <button class="submit" type="submit">Submit</button>
        </form>
    </section>
</body>
</html>