<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SeuClinic - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <div class="nav-logo">Seu<span>Clinic</span></div>
    <div class="nav-links">
        <a href="index.php" class="active">Home</a>
        <a href="doctors.php">Doctors</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="book.php">Book</a>
            <a href="history.php">My Appointments</a>
            <a href="auth.php?logout=1" class="btn-nav">Logout</a>
        <?php else: ?>
            <a href="auth.php" class="btn-nav">Login / Register</a>
        <?php endif; ?>
    </div>
</nav>


<section class="hero">
    <h1>Your Health, Our Priority</h1>
    <p>Book appointments with our experienced doctors quickly and easily, from the comfort of your home.</p>
    <a href="doctors.php" class="btn btn-primary">View Doctors</a>
    <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="auth.php" class="btn btn-secondary">Get Started</a>
    <?php else: ?>
        <a href="book.php" class="btn btn-secondary">Book Appointment</a>
    <?php endif; ?>
</section>


<section class="features">
    <h2>Why Choose SeuClinic?</h2>
    <div class="cards-grid" style="max-width:1000px; margin:0 auto;">
        <div class="card">
            <div class="card-icon">🩺</div>
            <h3>Expert Doctors</h3>
            <p>Certified specialists across multiple medical disciplines available for you.</p>
        </div>
        <div class="card">
            <div class="card-icon">📅</div>
            <h3>Easy Booking</h3>
            <p>Schedule your appointment online in minutes, no waiting on hold.</p>
        </div>
        <div class="card">
            <div class="card-icon">🔔</div>
            <h3>Track Appointments</h3>
            <p>View, manage, and update all your appointments from one place.</p>
        </div>
        <div class="card">
            <div class="card-icon">🔒</div>
            <h3>Secure & Private</h3>
            <p>Your personal health data is protected with secure authentication.</p>
            <!--abdullah: this is not necessary but we can leave it-->
        </div>
    </div>
</section>


<footer>
    <p>&copy; 2026 SeuClinic. All rights reserved. | web project.</p>
</footer>

<script src="script.js"></script>
</body>
</html>
