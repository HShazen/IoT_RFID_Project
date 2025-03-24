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
    $room_number = sanitize_input($_POST['room_number'] ?? '');
    $needed_access_level = filter_var($_POST['needed_access_level'] ?? 0, FILTER_VALIDATE_INT);

    // Validate required fields
    if (empty($room_number) || !isset($needed_access_level)) {
        echo "<script>
                alert('❌ Error: Room Number and access level are required.');
                window.history.back();
              </script>";
        exit();
    }

    // Prepare SQL statement to insert door data
    $sql = "INSERT INTO door (room_number, needed_access_level) 
            VALUES (?, ?)";
    
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param("ii", $room_number, $needed_access_level);
        
        if ($stmt->execute()) {
            echo "<script>
                    alert('✅ Door added successfully.');
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
}
?>
