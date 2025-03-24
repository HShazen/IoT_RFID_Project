<div id="layoutAuthentication">
    <div id="layoutSidenav_content">
        <main>
            <div id="registerBox" class="card">
                <div class="card-header">
                    <i class="fas fa-sign-in-alt me-1"></i> Login
                </div>
                <div class="card-body">
                    <form action="/config/login.php" method="POST">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="inputEmail" name="email" type="email" placeholder="name@example.com" required />
                            <label for="inputEmail">Email Address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" required />
                            <label for="inputPassword">Password</label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" id="inputRememberPassword" name="remember" type="checkbox" />
                            <label class="form-check-label" for="inputRememberPassword">Remember Me</label>
                        </div>
                        <div class="register-buttons d-flex justify-content-between">
                            <button type="button" onclick="window.location.href='password.html'" class="btn btn-secondary">Forgot Password?</button>
                            <button class="btn btn-primary" type="submit">Login</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
                </div>
            </div>
        </main>
        
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/elements/foot.php';?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
