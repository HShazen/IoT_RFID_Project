<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php'; // Include database connection

// Function to sanitize input
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];

    // SQL Query to verify the existence of the uid in db (rfid_code) - Using prepared statements
    $sql = "SELECT * FROM user WHERE rfid_code = ?";
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("s", $uid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0 && $user['access_level'] == 0) {
            $user = $result->fetch_assoc(); // Fetch user data from the database
            $id_user = $user['id_user'];

            // Insert log
            $log = "INSERT INTO access_logs (user_id_log, status) VALUES (?, ?)";
            if ($stmt = $con->prepare($log)) {
                $status = "Access Granted"; // Define status separately
                $stmt->bind_param("is", $id_user, $status);

                if ($stmt->execute()) {
                    echo "<script>
                            alert('✅ Log added successfully.');
                            window.location.href = '/index.php';
                          </script>";
                } else {
                    echo "<script>
                            alert('❌ Error: " . $stmt->error . "');
                            window.history.back();
                          </script>";
                }
                $stmt->close();
            }
        } else {
            echo "<script>
                    alert('❌ Access Denied.');
                    window.history.back();
                </script>";
        }
    }
}

$con->close();
?>
