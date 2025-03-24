<div id="layoutSidenav_content">
    <!-- Information Box -->
    <main>
        <div id="infoBox" class="card">
            <div class="card-header">
                <i class="fas fa-info-circle me-1"></i> Information Panel
            </div>
            <div class="card-body">
                <div class="info-item">
                    <strong>Admin Name:</strong> <span><?= $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></span>
                </div>
                <div class="info-item">
                    <strong>Birth Date:</strong> <span><?= $_SESSION['birth_date'] ?></span>
                </div>
                <div class="info-item">
                    <strong>Email:</strong> <span><?= $_SESSION['email'] ?></span>
                </div>

                <!-- Buttons (Unused for Now) -->
                <div class="info-buttons">
                    <button class="modify-btn">Modify</button>
                    <button class="logout-btn">Logout</button>
                </div>
            </div>
        </div>
    </main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/elements/foot.php'; ?>
</div>
