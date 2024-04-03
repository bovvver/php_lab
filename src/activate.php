<?php
    include_once __DIR__."/db_connection.php";

    if(isset($_GET['token'])) {
        $connection = connect_to_db();

        $token = $_GET['token'];
        $select_stmt = $connection->prepare("SELECT verification_token FROM users WHERE verification_token=?");
        $select_stmt->bind_param("s", $token);

        $select_stmt->execute();
        $result = $select_stmt->get_result();

        if ($result->num_rows === 0) {
            header("Location: main.php");
            $connection -> close();
            exit();
        } else {
            $row = $result->fetch_assoc();
    
            $update_stmt = $connection->prepare("UPDATE users SET is_verified = 1 WHERE verification_token = ?");
            $update_stmt->bind_param("s", $token);
            $update_stmt->execute();
    
            $connection -> close();
            header("Location: account_activated.php");
            exit();
        }
    } else {
        header("Location: main.php");
    }
?>