<?php
/*php file order in the word doc: auth.php > book.php > db.php > doctors.php > history.php*/ 
session_start();
require 'db.php';

$message = '';

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}


if (isset($_POST['action']) && $_POST['action'] === 'register') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = md5($_POST['password']);

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        $message = '<div class="alert alert-error">This email is already registered. Please log in.</div>';
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $password]);
        $message = '<div class="alert alert-success">Account created! Please log in.</div>';
    }
}


if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $email    = trim($_POST['email']);
    $password = md5($_POST['password']);

    $stmt = $pdo->prepare("SELECT id, name FROM users WHERE email = ? AND password = ?");
    $stmt->execute([$email, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header('Location: index.php');
        exit;
    } else {
        $message = '<div class="alert alert-error">Invalid email or password.</div>';
    }
}


if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClinicCare - Login / Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


<nav>
    <div class="nav-logo">Clinic<span>Care</span></div>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="doctors.php">Doctors</a>
        <a href="auth.php" class="btn-nav active">Login / Register</a>
    </div>
</nav>

<div class="container">
    <?php echo $message; ?>

    <div class="auth-wrapper">
        <!-- Tabs -->
        <div class="auth-tabs">
            <button class="auth-tab active" id="login-tab" onclick="showTab('login')">Login</button>
            <button class="auth-tab" id="register-tab" onclick="showTab('register')">Register</button>
        </div>

        
        <div class="auth-form active" id="login-form">
            <h2 style="margin-bottom:20px; color:#023e8a;">Welcome Back</h2>
            <form method="POST" onsubmit="return validateLogin()">
                <input type="hidden" name="action" value="login">
                <div class="form-group">
                    <label for="login-email">Email Address</label>
                    <input type="email" id="login-email" name="email" placeholder="you@example.com" required>
                </div>
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-submit">Login</button>
            </form>
            <p style="text-align:center; margin-top:18px; font-size:0.9rem; color:#64748b;">
                No account? <a href="#" onclick="showTab('register')" style="color:#0077b6; font-weight:600;">Register here</a>
            </p>
        </div>

        
        <div class="auth-form" id="register-form">
            <h2 style="margin-bottom:20px; color:#023e8a;">Create Account</h2>
            <form method="POST" onsubmit="return validateRegister()">
                <input type="hidden" name="action" value="register">
                <div class="form-group">
                    <label for="reg-name">Full Name</label>
                    <input type="text" id="reg-name" name="name" placeholder="Your full name" required>
                </div>
                <div class="form-group">
                    <label for="reg-email">Email Address</label>
                    <input type="email" id="reg-email" name="email" placeholder="you@example.com" required>
                </div>
                <div class="form-group">
                    <label for="reg-password">Password</label>
                    <input type="password" id="reg-password" name="password" placeholder="Min 6 characters" required>
                </div>
                <div class="form-group">
                    <label for="reg-confirm">Confirm Password</label>
                    <input type="password" id="reg-confirm" name="confirm" placeholder="Repeat password" required>
                </div>
                <button type="submit" class="btn btn-submit">Create Account</button>
            </form>
        </div>
    </div>
</div>


<footer>
    <p>&copy; 2026 SeuClinic. All rights reserved.</p>
</footer>

<script src="script.js"></script>
</body>
</html>
