<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . "/config/config.php";

// ✅ Ensure database connection exists
if (!$con) {
    die("<script>alert('❌ Erreur de connexion à la base de données!'); window.location.href='/login.php';</script>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // ✅ Check if fields are empty
    if (empty($email) || empty($password)) {
        echo "<script>alert('❌ Veuillez remplir tous les champs!'); window.location.href='/login.php';</script>";
        exit();
    }

    // ✅ Prepare SQL query
    $sql = "SELECT id_admin, first_name, last_name, email, birth_date, password FROM admin WHERE email = ?";
    $stmt = $con->prepare($sql);

    if (!$stmt) {
        die("<script>alert('❌ Erreur SQL: " . $con->error . "'); window.location.href='/login.php';</script>");
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // ✅ Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // ✅ Verify password
        if (password_verify($password, $user['password'])) {
            // ✅ Store session variables
            $_SESSION['id_admin'] = $user['id_admin'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['birth_date'] = $user['birth_date'];

            // ✅ Handle "Remember Me" option
            if (!empty($_POST['remember'])) {
                setcookie("remember_email", $email, time() + (86400 * 30), "/"); // 30 days
            } else {
                setcookie("remember_email", "", time() - 3600, "/"); // Clear cookie
            }

            // ✅ Success alert and redirect
            echo "<script>alert('✅ Connexion réussie!'); window.location.href='/index.php';</script>";
            exit();
        }
    }

    // ❌ If login fails, show alert and redirect
    echo "<script>alert('❌ Email ou mot de passe incorrect!'); window.location.href='/login.php';</script>";
    exit();
}
?>
