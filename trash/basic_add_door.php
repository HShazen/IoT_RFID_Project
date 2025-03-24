<style>
/* Info Box */
#infoBox {
    width: 500px;
    max-width: 90%;
    border: 1px solid #ddd;
    border-radius: 12px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    background-color: #ffffff;
    padding: 25px;
    text-align: center;
    transition: all 0.3s ease-in-out;
    margin: auto; /* Centering without affecting body */
}

/* Header */
#infoBox .card-header {
    background: linear-gradient(135deg, #2c3e50, #4b6584);
    color: white;
    font-size: 20px;
    font-weight: bold;
    padding: 15px;
    border-radius: 12px 12px 0 0;
}

/* Body */
#infoBox .card-body {
    padding: 20px;
}

/* Label-Value Alignment */
.info-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    font-size: 17px;
    color: #333;
}

.info-item strong {
    text-align: left;
    flex: 1;
    font-weight: bold;
}

.info-item span {
    text-align: right;
    flex: 1;
}

/* Separator Lines */
.info-item + .info-item {
    border-top: 1px solid #ddd;
    padding-top: 10px;
}

/* Buttons */
.info-buttons {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 15px;
}

.info-buttons button {
    background-color: #4b6584;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 15px;
    cursor: pointer;
    transition: 0.3s;
}

.info-buttons button:hover {
    background-color: #2c3e50;
}

.logout-btn {
    background-color: #c0392b;
}

.logout-btn:hover {
    background-color: #a93226;
}
/* Registration Box */
#registerBox {
    width: 500px;
    max-width: 90%;
    border: 1px solid #ddd;
    border-radius: 12px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    background-color: #ffffff;
    padding: 25px;
    transition: all 0.3s ease-in-out;
    margin: auto;
}

/* Header */
#registerBox .card-header {
    background: linear-gradient(135deg, #2c3e50, #4b6584);
    color: white;
    font-size: 20px;
    font-weight: bold;
    padding: 15px;
    border-radius: 12px 12px 0 0;
    text-align: center;
}

/* Form Styling */
.form-floating input {
    border-radius: 8px;
    border: 1px solid #ddd;
    padding: 12px;
    font-size: 16px;
}

/* Buttons */
.register-buttons {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 15px;
}

.register-buttons button {
    background-color: #4b6584;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 15px;
    cursor: pointer;
    transition: 0.3s;
}

.register-buttons button:hover {
    background-color: #2c3e50;
}

.left-btn {
    background-color: #c0392b;
}

.left-btn:hover {
    background-color: #a93226;
}

</style>
<div id="layoutSidenav_content">
    <main>
        <div id="registerBox" class="card">
            <div class="card-header">
                <i class="fas fa-user-plus me-1"></i> Add New Door
            </div>
            <div class="card-body">
            <form action="/config/updoor.php" method="POST">
                <div class="row g-2 mb-2">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="inputRoomNumber" type="number" name="room_number" placeholder="Enter Room Number" required />
                            <label for="inputRoomNumber">Room Number</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input class="form-control" id="inputAccessLevel" type="number" name="needed_access_level" value="0" min="0" />
                            <label for="inputAccessLevel">Needed Access Level</label>
                        </div>
                    </div>
                </div>

                <div class="register-buttons d-flex justify-content-between">
                    <button type="button" onclick="window.location.href='/index.php'" class="btn btn-secondary">Exit</button>
                    <button type="submit" class="btn btn-primary">Add Door</button>
                </div>

            </form>

            </div>
        </div>
    </main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/elements/foot.php'; ?>
</div>
