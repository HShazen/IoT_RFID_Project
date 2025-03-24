<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="/index.php">
                        <div class="nav-link-icon" style="margin-right: 8px;"><i class="fas fa-home"></i></div>
                        Home
                    </a>
                    
                    <!-- 🔹 User Management Section -->
                    <div class="sb-sidenav-menu-heading">User Management</div>
                    <a class="nav-link" href="/users/all_logs.php">
                        <div class="nav-link-icon" style="margin-right: 8px;"><i class="fas fa-users"></i></div>
                        Users Statistics
                    </a>
                    <a class="nav-link" href="/users/user_list.php">
                        <div class="nav-link-icon" style="margin-right: 8px;"><i class="fas fa-list"></i></div>
                        Users List
                    </a>
                    <a class="nav-link" href="/users/add_user.php">
                        <div class="nav-link-icon" style="margin-right: 8px;"><i class="fas fa-user-plus"></i></div>
                        Add User
                    </a>

                    <!-- 🔹 Door Management Section -->
                    <!--div class="sb-sidenav-menu-heading">Door Management</div>
                    <a class="nav-link" href="/door_info.php">
                        <div class="nav-link-icon" style="margin-right: 8px;"><i class="fas fa-door-closed"></i></div>
                        Door Statistics
                    </a>
                    <a class="nav-link" href="/door_list.php">
                        <div class="nav-link-icon" style="margin-right: 8px;"><i class="fas fa-list"></i></div>
                        Doors List
                    </a>
                    <a class="nav-link" href="/door_allow.php">
                        <div class="nav-link-icon" style="margin-right: 8px;"><i class="fas fa-key"></i></div>
                        Door Access Control
                    </a-->
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                <?= $_SESSION['first_name'] . " " . $_SESSION['last_name']?>
            </div>
        </nav>
    </div>