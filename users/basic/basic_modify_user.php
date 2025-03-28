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
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<div class='alert alert-danger'>❌ No valid user ID provided</div>");
}

// Sanitize user ID
$id_user = intval($_GET['id']); // Convert to integer for security

// ✅ 1️⃣ First SQL Query - Fetch User Details
$sql_user = "SELECT id_user, first_name, last_name, birth_date, rfid_code, access_level, created_date FROM user WHERE id_user = ?";
$stmt_user = $con->prepare($sql_user);

if (!$stmt_user) {
    die("<div class='alert alert-danger'>❌ Database error: " . $con->error . "</div>");
}

$stmt_user->bind_param("i", $id_user);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc(); // Fetch single user row

// Close statement
$stmt_user->close();

// Close database connection
$con->close();
?>


<div id="layoutSidenav_content">
    <main>
        <div id="infoBox" class="card">
            <div class="card-header">
                <i class="fas fa-user-edit me-1"></i> Edit User
            </div>
            <div class="card-body">
                <form action="/config/upuser.php" method="POST">
                    <input type="hidden" name="id_user" value="<?= htmlspecialchars($user['id_user']) ?>">

                    <div class="form-floating mb-2">
                        <input class="form-control" type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
                        <label>First Name</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input class="form-control" type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
                        <label>Last Name</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input class="form-control" type="date" name="birth_date" value="<?= htmlspecialchars($user['birth_date']) ?>">
                        <label>Birth Date</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input class="form-control" type="text" name="rfid_code" value="<?= htmlspecialchars($user['rfid_code']) ?>" required>
                        <label>UID (RFID Code)</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input class="form-control" type="number" name="access_level" value="<?= htmlspecialchars($user['access_level']) ?>" min="0">
                        <label>Access Level</label>
                    </div>
                    
                    <!-- Buttons (Unused for Now) -->
                    <div class="info-buttons">
                        <button type="button" onclick="window.location.href='/index.php'" class="modify-user-btn"> Cancel </button>
                        <button type="submit" class="delete-user-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
