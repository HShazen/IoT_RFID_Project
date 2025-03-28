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
    $id_admin = isset($_POST['id_admin']) ? filter_var($_POST['id_admin'], FILTER_VALIDATE_INT) : null;
    $first_name = sanitize_input($_POST['first_name'] ?? '');
    $last_name = sanitize_input($_POST['last_name'] ?? '');
    $birth_date = sanitize_input($_POST['birth_date'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($email)) {
        echo "<script>
                alert('❌ Error: First Name, Last Name, and Email are required.');
                window.history.back();
              </script>";
        exit();
    }

    // Check if email already exists for a different admin
    $check_sql = "SELECT id_admin FROM admin WHERE email = ? AND id_admin != ?";
    if ($stmt = $con->prepare($check_sql)) {
        $stmt->bind_param("si", $email, $id_admin);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>
                    alert('❌ Error: Email already exists for another admin.');
                    window.history.back();
                  </script>";
            exit();
        }
        $stmt->close();
    }

    // Update admin data
    $sql = "UPDATE admin SET first_name = ?, last_name = ?, birth_date = ?, email = ? WHERE id_admin = ?";
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("ssssi", $first_name, $last_name, $birth_date, $email, $id_admin);
    }

    if (isset($stmt) && $stmt->execute()) {
        // Update session values
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['birth_date'] = $birth_date;
        $_SESSION['email'] = $email;

        echo "<script>
                alert('✅ Admin profile updated successfully.');
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
