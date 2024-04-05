<?php 
    include_once __DIR__ ."/redirect_to_success.php";
    
    function showError($fieldName) {
        if(isset($_SESSION["errors"][$fieldName]))
            echo $_SESSION["errors"][$fieldName];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/form.css">
    <title>PHP Registration</title>
</head>
<body>
    <section class="wrapper">
        <h1 class="title">Registration</h1>
        <form action="validate_registration.php" method="POST">
            <div class="inputWrapper">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email"/>
                <span class="error">
                    <?php showError("email"); ?>
                </span>
            </div>
            <div class="inputWrapper">
                <label for="phoneNumber">Phone number</label>
                <input id="phoneNumber" name="phoneNumber"/>
                <span class="error">
                    <?php showError("phone_number"); ?>
                </span>
            </div>
            <div class="inputWrapper">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"/>
                <span class="error">
                    <?php showError("password"); ?>
                </span>
            </div>
            <div class="inputWrapper">
                <label for="repeatPassword">Repeat password</label>
                <input type="password" id="repeatPassword" name="repeatPassword"/>
                <span class="error">
                    <?php showError("repeat_password"); ?>
                </span>
            </div>
            <button class="submit" type="submit">Submit</button>
        </form>
    </section>
</body>
</html>