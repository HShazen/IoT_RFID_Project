<?php
// Ensure session_start() is called before any output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/elements/head.php' ?>
    </head>
    <body class="sb-nav-fixed">
        <?php
        if (isset($_SESSION['id_admin'])) {
            include $_SERVER['DOCUMENT_ROOT'] . '/elements/nav.php';
            include $_SERVER['DOCUMENT_ROOT'] . '/elements/sidebar.php';
            include $_SERVER['DOCUMENT_ROOT'] . '/users/basic/basic_add_user.php';
        } else {
            include $_SERVER['DOCUMENT_ROOT'] . '/elements/authentification.php';
        }
        ?>
         <?php include $_SERVER['DOCUMENT_ROOT'] . '/elements/scripts.php'; ?>
    </body>
</html>