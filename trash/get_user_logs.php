<?php
// Database connection
include $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// Check if the admin is logged in
if (!isset($_SESSION['id_admin'])) {
    die("<script>alert('❌ Access denied! Please log in as an admin.'); window.location.href='/login.php';</script>");
}

// Check if 'id' is provided in the URL
if (!isset($_GET['id'])) {
    die("<div class='alert alert-danger'>❌ No user ID provided</div>");
}

// Sanitize user ID
$id_user = intval($_GET['id']); // Convert to integer for security

// ✅ 1️⃣ First SQL Query - Fetch User Details
$sql_user = "SELECT id_user, first_name, last_name, birth_date, rfid_code, access_level, created_date FROM user WHERE id_user = ?";
$stmt_user = $con->prepare($sql_user);
$stmt_user->bind_param("i", $id_user);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc(); // Fetch single user row

// ✅ 2️⃣ Second SQL Query - Fetch User Logs
$sql_logs = "SELECT 
            access_logs.log_number, 
            access_logs.user_id_log, 
            access_logs.log_date, 
            access_logs.status, 
            user.first_name,
            user.last_name      
        FROM access_logs
        JOIN user ON user.id_user = access_logs.user_id_log
        WHERE access_logs.user_id_log = ?";  // 🔥 Filter by user ID";
$stmt_logs = $con->prepare($sql_logs);
$stmt_logs->bind_param("i", $id_user);
$stmt_logs->execute();
$result_logs = $stmt_logs->get_result();
$logs = $result_logs->fetch_all(MYSQLI_ASSOC); // Fetch multiple rows as an array

// Close statements and database connection
$stmt_user->close();
$stmt_logs->close();
$con->close();
?>