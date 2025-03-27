<?php
// Ensure session_start() is called before any output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
            access_logs.used_rfid_code, -- ✅ Added used_rfid_code

            user.first_name,
            user.last_name      
        FROM access_logs
        JOIN user ON user.id_user = access_logs.user_id_log
        WHERE access_logs.user_id_log = ?";  // 🔥 Filter by user ID

$stmt_logs = $con->prepare($sql_logs);
$stmt_logs->bind_param("i", $id_user);
$stmt_logs->execute();
$result_logs = $stmt_logs->get_result();
$logs = $result_logs->fetch_all(MYSQLI_ASSOC); // Fetch multiple rows as an array

// ✅ SQL Query for Line Chart - Logs per Minute
$sql_logsline = "
    SELECT 
        DATE_FORMAT(access_logs.log_date, '%H:%i') AS log_minute,  
        COUNT(*) AS log_count
    FROM access_logs
    WHERE access_logs.user_id_log = ? 
        AND access_logs.log_date >= CURDATE()
    GROUP BY log_minute
    ORDER BY log_minute ASC
";

$stmt_logsline = $con->prepare($sql_logsline);
$stmt_logsline->bind_param("i", $id_user);
$stmt_logsline->execute();
$result_logsline = $stmt_logsline->get_result();
$logsLine = $result_logsline->fetch_all(MYSQLI_ASSOC);
$stmt_logsline->close();

// ✅ SQL Query for Bar Chart - Logs per Day (Last 7 Days)
$sql_logsbar = "
    SELECT 
        DATE_FORMAT(access_logs.log_date, '%Y-%m-%d') AS log_day,
        COUNT(*) AS log_count_bar
    FROM access_logs
    WHERE access_logs.user_id_log = ?
        AND access_logs.log_date >= CURDATE() - INTERVAL 6 DAY
    GROUP BY log_day
    ORDER BY log_day ASC
";

$stmt_logsbar = $con->prepare($sql_logsbar);
$stmt_logsbar->bind_param("i", $id_user);
$stmt_logsbar->execute();
$result_logsbar = $stmt_logsbar->get_result();
$logsBar = $result_logsbar->fetch_all(MYSQLI_ASSOC);
$stmt_logsbar->close();

// Close statements and database connection
$stmt_user->close();
$stmt_logs->close();
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/elements/head.php'; ?>
</head>
<body class="sb-nav-fixed">
    <?php
        if (isset($_SESSION['id_admin'])) {
            include $_SERVER['DOCUMENT_ROOT'] . '/elements/nav.php';
            include $_SERVER['DOCUMENT_ROOT'] . '/elements/sidebar.php';
            include $_SERVER['DOCUMENT_ROOT'] . '/users/basic/basic_user_details.php';
        } else {
            include $_SERVER['DOCUMENT_ROOT'] . '/elements/authentification.php';
        }
    ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/elements/scripts.php'; ?>
</body>
</html>
