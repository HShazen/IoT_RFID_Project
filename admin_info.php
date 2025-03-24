<?php
// Ensure session_start() is called before any output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/elements/head.php'?>
    </head>
    <body class="sb-nav-fixed">
        <?php

            // Check if the user is logged in
            if (isset($_SESSION['id_admin'])) {
                include $_SERVER['DOCUMENT_ROOT'] . '/elements/nav.php';
                include $_SERVER['DOCUMENT_ROOT'] . '/elements/sidebar.php';
                include $_SERVER['DOCUMENT_ROOT'] . '/elements/information.php'; // Show accueil only if the user is logged in
            } else {
                include $_SERVER['DOCUMENT_ROOT'] . '/authentification.php'; // Show authentication only if the user is NOT logged in
            }
        ?>
         <!--button onclick="addAdmin()" class="btn btn-primary">Add Admin</button>
        -->
         <?php include $_SERVER['DOCUMENT_ROOT'] . '/elements/scripts.php'; ?>
    </body>
</html>