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

// Get admin ID from session
$id_admin = $_SESSION['id_admin'];

// ✅ Fetch Admin Details
$sql_admin = "SELECT first_name, last_name, birth_date, email FROM admin WHERE id_admin = ?";
$stmt_admin = $con->prepare($sql_admin);

if (!$stmt_admin) {
    die("<div class='alert alert-danger'>❌ Database error: " . $con->error . "</div>");
}

$stmt_admin->bind_param("i", $id_admin);
$stmt_admin->execute();
$result_admin = $stmt_admin->get_result();
$admin = $result_admin->fetch_assoc(); // Fetch single admin row

$stmt_admin->close();
$con->close();
?>

<div id="layoutSidenav_content">
    <main>
        <div id="infoBox" class="card">
            <div class="card-header">
                <i class="fas fa-user-edit me-1"></i> Edit Admin Profile
            </div>
            <div class="card-body">
                <form action="/config/upadmin.php" method="POST">
                    <input type="hidden" name="id_admin" value="<?= htmlspecialchars($id_admin) ?>">

                    <div class="form-floating mb-2">
                        <input class="form-control" type="text" name="first_name" value="<?= htmlspecialchars($admin['first_name']) ?>" required>
                        <label>First Name</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input class="form-control" type="text" name="last_name" value="<?= htmlspecialchars($admin['last_name']) ?>" required>
                        <label>Last Name</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input class="form-control" type="date" name="birth_date" value="<?= htmlspecialchars($admin['birth_date']) ?>">
                        <label>Birth Date</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input class="form-control" type="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required>
                        <label>Email</label>
                    </div>
                    
                    <!-- Buttons -->
                    <div class="info-buttons">
                        <button type="button" onclick="window.location.href='/index.php'" class="modify-user-btn"> Cancel </button>
                        <button type="submit" class="delete-user-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>