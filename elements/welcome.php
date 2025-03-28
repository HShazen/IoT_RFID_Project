<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 text-center">Welcome to Your Doors Access Control System</h1>
            <ol class="breadcrumb mb-4 justify-content-center">
                <li class="breadcrumb-item active">Home</li>
            </ol>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h2 class="card-title">Hello, <?= $_SESSION['first_name'] . " " . $_SESSION['last_name']?>!</h2>
                            <p class="card-text">
                                Welcome back! Manage your users and doors efficiently using the sections below.
                                Click on the appropriate section to continue.
                            </p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="/users/all_logs.php" class="btn btn-primary">
                                    <i class="fas fa-users me-1"></i> User Access Statistics
                                </a>
                                <br>
                                <!--form action="/config/esp32_verify.php" method="get">
                                    <div class="input-group">
                                        <input type="text" name="uid" class="form-control" placeholder="Enter UID" required>
                                        <button type="submit" class="btn btn-secondary">
                                            <i class="fas fa-door-open me-1"></i> Temp test the script used by ESP32
                                        </button>
                                    </div>
                                </form-->

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include 'elements/foot.php'; ?>
</div>
