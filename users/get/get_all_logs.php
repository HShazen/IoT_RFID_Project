<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/config/config.php";

header('Content-Type: application/json');

// ✅ Enable Error Reporting for Debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

function sendError($message) {
    echo json_encode(["error" => "❌ $message"]);
    exit();
}

// ✅ Ensure database connection
if (!$con) {
    sendError("Database connection error!");
}

// ✅ Prepare SQL query to get logs for ALL users
$sql = "SELECT 
            access_logs.log_number, 
            access_logs.user_id_log, 
            access_logs.log_date, 
            access_logs.status, 
            access_logs.used_rfid_code,
            user.first_name,
            user.last_name      
        FROM access_logs
        JOIN user ON user.id_user = access_logs.user_id_log";

$stmt = $con->prepare($sql);

if (!$stmt) {
    sendError("SQL Prepare Error: " . $con->error);
}

// ✅ Execute the query
if (!$stmt->execute()) {
    sendError("SQL Execute Error: " . $stmt->error);
}

$result = $stmt->get_result();
$logs = [];

// ✅ Fetch user data
while ($row = $result->fetch_assoc()) {
    $logs[] = $row;
}

// ✅ Ensure JSON is valid
$jsonOutput = json_encode($logs, JSON_PRETTY_PRINT);

if (json_last_error() !== JSON_ERROR_NONE) {
    sendError("JSON Encoding Error: " . json_last_error_msg());
}

// ✅ Return JSON response
echo $jsonOutput;

$stmt->close();
$con->close();
?>
