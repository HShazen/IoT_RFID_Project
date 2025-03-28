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
                <button type="button" 
                            onclick="window.location.href='/elements/modify_admin.php?id=<?= $_SESSION['id_admin'] ?>'" 
                            class="modify-user-btn">
                        Modify
                    </button>
                    <button type="button" class="logout-btn" onclick="window.location.href='/config/logout.php'" onmouseover="this.style.backgroundColor='red'; this.style.color='white';" 
                    onmouseout="this.style.backgroundColor='black'; this.style.color='white';">Logout</button>
                </div>
            </div>
        </div>
    </main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/elements/foot.php'; ?>
</div>
