<div id="layoutSidenav_content">
    <main>
        <div id="infoBox" class="card">
            <div class="card-header">
                <i class="fas fa-user-plus me-1"></i> Add New User
            </div>
            <div class="card-body">
                <form action="/config/upuser.php" method="POST">
                    <div class="form-floating mb-2">
                        <input class="form-control" type="text" name="first_name" placeholder="First Name" required>
                        <label>First Name</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input class="form-control" type="text" name="last_name" placeholder="Last Name" required>
                        <label>Last Name</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input class="form-control" type="date" name="birth_date">
                        <label>Birth Date</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input class="form-control" type="text" name="rfid_code" placeholder="RFID Code" required>
                        <label>UID (RFID Code)</label>
                    </div>

                    <div class="form-floating mb-2">
                        <input class="form-control" type="number" name="access_level" value="0" min="0">
                        <label>Access Level</label>
                    </div>

                    <!-- Buttons -->
                    <div class="info-buttons">
                        <button type="button" onclick="window.location.href='/index.php'" class="modify-user-btn">Exit</button>
                        <button type="submit" class="delete-user-btn">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </main>


    <!--main>
        <div id="registerBox" class="card">
            <div class="card-header">
                <i class="fas fa-user-plus me-1"></i> Add New User
            </div>
            <div class="card-body">
                <form action="/config/upuser.php" method="POST">
                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input class="form-control" id="inputFirstName" type="text" name="first_name" placeholder="Enter your first name" required />
                                <label for="inputFirstName">First Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input class="form-control" id="inputLastName" type="text" name="last_name" placeholder="Enter your last name" required />
                                <label for="inputLastName">Last Name</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-2">
                        <input class="form-control" id="inputBirthDate" type="date" name="birth_date" />
                        <label for="inputBirthDate">Birth Date</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputRFID" type="text" name="rfid_code" placeholder="Enter RFID Code" required />
                        <label for="inputRFID">RFID Code</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputAccessLevel" type="number" name="access_level" value="0" min="0" />
                        <label for="inputAccessLevel">Access Level</label>
                    </div>

                    <div class="register-buttons d-flex justify-content-between">
                        <button type="button" onclick="window.location.href='/index.php'" class="left-btn">Exit</button>
                        <button type="submit" class="right-btn">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </main-->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/elements/foot.php'; ?>
</div>
