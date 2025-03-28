<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php'; // Include database connection

// Function to sanitize input
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Retrieve and sanitize form inputs
    $id_user = isset($_POST['id_user']) ? filter_var($_POST['id_user'], FILTER_VALIDATE_INT) : null;
    $first_name = sanitize_input($_POST['first_name'] ?? '');
    $last_name = sanitize_input($_POST['last_name'] ?? '');
    $birth_date = sanitize_input($_POST['birth_date'] ?? '');
    $rfid_code = sanitize_input($_POST['rfid_code'] ?? '');
    $access_level = filter_var($_POST['access_level'] ?? 0, FILTER_VALIDATE_INT);

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($rfid_code)) {
        echo "<script>
                alert('❌ Error: First Name, Last Name, and RFID Code are required.');
                window.history.back();
              </script>";
        exit();
    }

    // Check if RFID code already exists for a different user (avoid duplicate RFID codes)
    $check_sql = "SELECT id_user FROM user WHERE rfid_code = ? AND id_user != ?";
    if ($stmt = $con->prepare($check_sql)) {
        $stmt->bind_param("si", $rfid_code, $id_user);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>
                    alert('❌ Error: RFID Code already exists for another user.');
                    window.history.back();
                  </script>";
            exit();
        }
        $stmt->close();
    }

    if ($id_user) {
        // Update existing user
        $sql = "UPDATE user SET first_name = ?, last_name = ?, birth_date = ?, rfid_code = ?, access_level = ? WHERE id_user = ?";
        if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param("ssssii", $first_name, $last_name, $birth_date, $rfid_code, $access_level, $id_user);
        }
    } else {
        // Insert new user
        $sql = "INSERT INTO user (first_name, last_name, birth_date, rfid_code, access_level) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param("ssssi", $first_name, $last_name, $birth_date, $rfid_code, $access_level);
        }
    }

    if (isset($stmt) && $stmt->execute()) {
        echo "<script>
                alert('✅ User successfully " . ($id_user ? "updated" : "added") . ".');
                window.location.href = '/index.php';
              </script>";
    } else {
        echo "<script>
                alert('❌ Error: " . ($stmt->error ?? $con->error) . "');
                window.history.back();
              </script>";
    }
    $stmt->close();
    $con->close();
} else {
    echo "<script>
            alert('❌ Invalid Request.');
            window.history.back();
          </script>";
}

/*
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php'; // Include database connection

// Function to sanitize input
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Retrieve and sanitize form inputs
    $first_name = sanitize_input($_POST['first_name'] ?? '');
    $last_name = sanitize_input($_POST['last_name'] ?? '');
    $birth_date = sanitize_input($_POST['birth_date'] ?? '');
    $rfid_code = sanitize_input($_POST['rfid_code'] ?? '');
    $access_level = filter_var($_POST['access_level'] ?? 0, FILTER_VALIDATE_INT);

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($rfid_code)) {
        echo "<script>
                alert('❌ Error: First Name, Last Name, and RFID Code are required.');
                window.history.back();
              </script>";
        exit();
    }

    // Check if RFID code already exists
    $check_sql = "SELECT id_user FROM user WHERE rfid_code = ?";
    if ($stmt = $con->prepare($check_sql)) {
        $stmt->bind_param("s", $rfid_code);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>
                    alert('❌ Error: RFID Code already exists.');
                    window.history.back();
                  </script>";
            exit();
        }
        $stmt->close();
    }

    // Prepare SQL statement to insert user data
    $sql = "INSERT INTO user (first_name, last_name, birth_date, rfid_code, access_level) 
            VALUES (?, ?, ?, ?, ?)";
    
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("ssssi", $first_name, $last_name, $birth_date, $rfid_code, $access_level);
        
        if ($stmt->execute()) {
            echo "<script>
                    alert('✅ User added successfully.');
                    window.location.href = '/index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('❌ Error: " . $stmt->error . "');
                    window.history.back();
                  </script>";
        }
        $stmt->close();
    } else {
        echo "<script>
                alert('❌ SQL Prepare Error: " . $con->error . "');
                window.history.back();
              </script>";
    }

    $con->close();
} else {
    echo "<script>
            alert('❌ Invalid Request.');
            window.history.back();
          </script>";
}*/
?>
