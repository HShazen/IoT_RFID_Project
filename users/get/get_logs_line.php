<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/config/config.php";

header('Content-Type: application/json');

// ✅ Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Ensure database connection
if (!$con) {
    echo json_encode(["error" => "❌ Database connection error!"]);
    exit();
}

// ✅ Query: Count logs per minute
$sql = "SELECT DATE_FORMAT(log_date, '%H:%i') AS log_minute, COUNT(*) AS log_count 
        FROM access_logs 
        WHERE access_logs.log_date >= CURDATE()
        GROUP BY log_minute 
        ORDER BY log_minute";

$result = $con->query($sql);

if (!$result) {
    echo json_encode(["error" => "❌ SQL Error: " . $con->error]);
    exit();
}

$logs = [];

// ✅ Fetch data
while ($row = $result->fetch_assoc()) {
    $logs[] = $row;
}

// ✅ Ensure valid JSON output
$jsonOutput = json_encode($logs);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => "❌ JSON Encoding Error: " . json_last_error_msg()]);
    exit();
}

echo $jsonOutput;
$con->close();
?>
