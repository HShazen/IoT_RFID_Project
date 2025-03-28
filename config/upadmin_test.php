<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

function showAlertAndRedirect($message, $redirect) {
    echo "<script>
            alert('$message');
            window.location.href = '$redirect';
          </script>";
    exit();
}
// The add of admins is restricted so it is done only by using this code!

// Define admin details
$first_name = "Admin";
$last_name = "User";
$birth_date = "1990-01-01";
$email = "admin@gmail.com"; 
$password = "admin123";

// Check if admin already exists by email
$check_sql = "SELECT id_admin FROM admin WHERE email = ?";
$stmt = $con->prepare($check_sql);

// ✅ Check if prepare() failed
if (!$stmt) {
    die("❌ SQL Prepare Error: " . $con->error); // Shows exact SQL error
}

$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    showAlertAndRedirect("❌ Error: Admin already exists.", "/index.php");
}
$stmt->close();

// Hash password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Insert into database
$sql = "INSERT INTO admin (first_name, last_name, birth_date, email, password) VALUES (?, ?, ?, ?, ?)";
$stmt = $con->prepare($sql);

// ✅ Check if prepare() failed again
if (!$stmt) {
    die("❌ SQL Prepare Error (Insert): " . $con->error); // Shows exact SQL error
}

$stmt->bind_param("sssss", $first_name, $last_name, $birth_date, $email, $hashed_password);

if ($stmt->execute()) {
    showAlertAndRedirect("✅ Admin added successfully.", "/index.php");
} else {
    showAlertAndRedirect("❌ Error: " . $stmt->error, "/index.php");
}

$stmt->close();
?>
