<?php
include_once __DIR__."/db_connection.php";

function activate_account($key, $value, $status_table, $redirect = "main.php"): bool {
    $connection = connect_to_db();

    $select_stmt = $connection->prepare("SELECT $key FROM users WHERE $key=?");
    $select_stmt->bind_param("s", $value);

    $select_stmt->execute();
    $result = $select_stmt->get_result();

    if ($result->num_rows === 0) {
        header("Location: $redirect");
        $connection -> close();
        return false;
    } else {
        $result->fetch_assoc();
    
        $update_stmt = $connection->prepare("UPDATE users SET $status_table = 1 WHERE $key = ?");
        $update_stmt->bind_param("s", $value);
        $update_stmt->execute();
    
        $connection -> close();
        return true;
    }
}