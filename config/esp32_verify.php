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

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc(); // Fetch user data from the database
            $id_user = $user['id_user'];
            $status = ($user['access_level'] == 0) ? "Granted" : "Denied"; // Define status

            // Insert log
            $log = "INSERT INTO access_logs (user_id_log, used_rfid_code, status) VALUES (?, ?, ?)";
            if ($stmt = $con->prepare($log)) {
                $stmt->bind_param("iss", $id_user, $uid, $status);
                
                if ($stmt->execute()) {
                    echo ($status == "Granted") ? "✅ Access Granted" : "❌ Access Denied";
                } else {
                    echo "<script>
                            alert('❌ Error: " . $stmt->error . "');
                            window.history.back();
                        </script>";
                }
                $stmt->close();
            }
            /*$user = $result->fetch_assoc(); // Fetch user data from the database
            if ($user['access_level'] == 0) { // Now, check access level after fetching
                // Insert log
                $log = "INSERT INTO access_logs (user_id_log, used_rfid_code, status) VALUES (?, ?, ?)";
                if ($stmt = $con->prepare($log)) {
                    $id_user = $user['id_user'];
                    $status = "Granted"; // Define status separately
                    $stmt->bind_param("iss", $id_user, $uid, $status);

                    if ($stmt->execute()) {
                        echo "✅ Access Granted";
                    } else {
                        echo "<script>
                                alert('❌ Error: " . $stmt->error . "');
                                window.history.back();
                            </script>";
                    }
                    $stmt->close();
                }
            } else {
                $id_user = $user['id_user'];
                $status = "Denied"; // Define status separately
                $stmt->bind_param("iss", $id_user, $uid, $status);

                if ($stmt->execute()) {
                    echo "❌ Access Denied";
                } else {
                    echo "<script>
                            alert('❌ Error: " . $stmt->error . "');
                            window.history.back();
                        </script>";
                }
                $stmt->close();
            }*/

        } else {
            $log = "INSERT INTO access_logs (user_id_log, used_rfid_code, status) VALUES (?, ?, ?)";
            if ($stmt = $con->prepare($log)) {
                $status = "Denied"; // Define status separately
                $id_user = 4;
                $stmt->bind_param("iss", $id_user, $uid, $status);

                if ($stmt->execute()) {
                    echo "❌ Access Denied";
                } else {
                    echo "<script>
                            alert('❌ Error: " . $stmt->error . "');
                            window.history.back();
                        </script>";
                }
                $stmt->close();
            }
        }
    }
}

$con->close();
?>
