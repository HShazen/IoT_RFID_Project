<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php'; // Database connection

if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    echo "<script>
            alert('❌ Error: Invalid user ID.');
            window.history.back();
          </script>";
    exit();
}

$id_user = $_GET['id'];

// Prepare DELETE SQL query
$sql = "DELETE FROM user WHERE id_user = ?";
if ($stmt = $con->prepare($sql)) {
    $stmt->bind_param("i", $id_user);

    if ($stmt->execute()) {
        echo "<script>
                alert('✅ User deleted successfully.');
                window.location.href = '/index.php';
              </script>";
    } else {
        echo "<script>
                alert('❌ Error: Unable to delete user.');
                window.history.back();
              </script>";
    }

    $stmt->close();
}

$con->close();
?>
