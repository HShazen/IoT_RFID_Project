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
                                <input class="form-control" id="inputRoomNum" type="number" name="room_number" placeholder="Enter your first name" required />
                                <label for="inputRoomNum">Room Number</label>
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
                        <button type="button" onclick="window.location.href='/index.php'" class="left-btn">Exit</button>
                        <button type="submit" class="right-btn">Add Door</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/elements/foot.php'; ?>
</div>
