<style>
/* Box Style (Shared) */
.box {
    width: 500px;
    max-width: 90%;
    border: 1px solid #ddd;
    border-radius: 12px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    background-color: #ffffff;
    padding: 25px;
    text-align: center;
    transition: all 0.3s ease-in-out;
    margin: auto;
}

/* Header */
.box .card-header {
    background: linear-gradient(135deg, #2c3e50, #4b6584);
    color: white;
    font-size: 20px;
    font-weight: bold;
    padding: 15px;
    border-radius: 12px 12px 0 0;
}

/* Body */
.box .card-body {
    padding: 20px;
}

/* Label-Value Alignment (For Info Box) */
.info-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    font-size: 17px;
    color: #333;
}

.info-item strong {
    flex: 1;
    font-weight: bold;
}

.info-item span {
    flex: 1;
    text-align: right;
}

/* Separator */
.info-item + .info-item {
    border-top: 1px solid #ddd;
    padding-top: 10px;
}

/* Buttons */
.box-buttons {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 15px;
}

.box-buttons button {
    background-color: #4b6584;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 15px;
    cursor: pointer;
    transition: 0.3s;
}

.box-buttons button:hover {
    background-color: #2c3e50;
}

.logout-btn {
    background-color: #c0392b;
}

.logout-btn:hover {
    background-color: #a93226;
}

/* Form Fields */
.form-group {
    margin-bottom: 15px;
    text-align: left;
}

.form-group label {
    font-weight: bold;
    display: block;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 16px;
}

</style>

<div id="layoutSidenav_content">
    <!-- Registration Box -->
    <main>
        <div id="registerBox" class="card">
            <div class="card-header">
                <i class="fas fa-user-plus me-1"></i> Add New User
            </div>
            <div class="card-body">
            <form action="register_process.php" method="POST">
                <div class="row g-2 mb-2"> <!-- Reduced margin-bottom and added smaller gap -->
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

                <div class="form-floating mb-2"> <!-- Reduced margin-bottom -->
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

                <div class="register-buttons">
                    <button type="button" onclick="window.location.href='index.php'" class="left-btn">Exit</button>
                    <button type="submit" class="right-btn">Add User</button>
                </div>
            </form>


            </div>
        </div>
    </main>
    <?php include 'elements/foot.php'; ?>
</div>
