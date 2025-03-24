<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/config/config.php";

header('Content-Type: application/json');

// ✅ Enable Error Reporting for Debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ Ensure database connection exists
if (!$con) {
    echo json_encode(["error" => "❌ Erreur de connexion à la base de données!"]);
    exit();
}

// ✅ Prepare SQL query
$sql = "SELECT id_user, first_name, last_name, birth_date, rfid_code, access_level, created_date FROM user";
$result = $con->query($sql);

if (!$result) {
    echo json_encode(["error" => "❌ SQL Error: " . $con->error]);
    exit();
}

$users = [];

// ✅ Fetch user data
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

// ✅ Ensure JSON is valid
$jsonOutput = json_encode($users);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["error" => "❌ JSON Encoding Error: " . json_last_error_msg()]);
    exit();
}

// ✅ Return JSON response
echo $jsonOutput;
$con->close();
?>
