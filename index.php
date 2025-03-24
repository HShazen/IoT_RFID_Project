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
                include $_SERVER['DOCUMENT_ROOT'] . '/elements/welcome.php'; // Show accueil only if the user is logged in
            } else {
                include $_SERVER['DOCUMENT_ROOT'] . '/elements/authentification.php'; // Show authentication only if the user is NOT logged in
            }
        ?>
         <!--button onclick="addAdmin()" class="btn btn-primary">Add Admin</button>
        -->
         <?php include $_SERVER['DOCUMENT_ROOT'] . '/elements/scripts.php'; ?>
    </body>
</html>
<script>
function addAdmin() {
    if (confirm("Are you sure you want to add the admin?")) {
        window.location.href = "/config/add_admin.php";
    }
}
</script>


<!--
<!DOCTYPE html>
<html lang="en">
    <head>
    < ?php include "elements/head.php"?>
    </head>
    <body class="sb-nav-fixed">
        < ?php include "elements/nav.php"?>
        
        <div id="layoutSidenav">
            < ?php include "elements/sidebar.php"?>
            <div id="layoutSidenav_content">
                <main>

                </main>
                < ?php include 'elements/foot.php'; ?>
            </div>
        </div>
        < ?php include 'elements/scripts.php'; ?>
    </body>
</html>

-->