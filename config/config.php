<?php
// ✅ Avoid multiple includes
if (!isset($con)) {
    // Database Configuration
    $localhost_mysqli = "db";
    $user_mysqli = "myuser"; 
    $password_mysqli = "mypassword"; 
    $name_mysqli = "mydatabase"; 

    // ✅ Open the Connection
    $con = new mysqli($localhost_mysqli, $user_mysqli, $password_mysqli, $name_mysqli);

    // ✅ Check Connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
}
?>