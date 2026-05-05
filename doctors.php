<?php

session_start();


$doctors = [
    ['name' => 'Dr. Khaled Nasser',  'specialty' => 'General Medicine', 'experience' => '12 years', 'icon' => '🩺'],
    ['name' => 'Dr. Layla Omar',     'specialty' => 'Cardiology',        'experience' => '9 years',  'icon' => '❤️'],
    ['name' => 'Dr. Tariq Saleh',    'specialty' => 'Dermatology',       'experience' => '7 years',  'icon' => '🔬'],
    ['name' => 'Dr. Hana Al-Rashid', 'specialty' => 'Pediatrics',        'experience' => '11 years', 'icon' => '👶'],
    ['name' => 'Dr. Fares Qasim',    'specialty' => 'Orthopedics',       'experience' => '15 years', 'icon' => '🦴'],
    ['name' => 'Dr. Nora Ibrahim',   'specialty' => 'Neurology',         'experience' => '10 years', 'icon' => '🧠'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClinicCare - Our Doctors</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


<nav>
    <div class="nav-logo">Clinic<span>Care</span></div>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="doctors.php" class="active">Doctors</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="book.php">Book</a>
            <a href="history.php">My Appointments</a>
            <a href="auth.php?logout=1" class="btn-nav">Logout</a>
        <?php else: ?>
            <a href="auth.php" class="btn-nav">Login / Register</a>
        <?php endif; ?>
    </div>
</nav>


<div class="container">
    <h2 class="page-title">Our Medical Team</h2>
    <p style="color:#64748b; margin-bottom:28px;">Meet our certified specialists dedicated to your well-being.</p>

    <div class="cards-grid">
        <?php foreach ($doctors as $doc): ?>
        <div class="card">
            <div class="card-icon"><?= $doc['icon'] ?></div>
            <h3><?= htmlspecialchars($doc['name']) ?></h3>
            <p><?= htmlspecialchars($doc['specialty']) ?></p>
            <div class="badge">⏱ <?= $doc['experience'] ?></div>
            <br><br>
            <a href="book.php?doctor=<?= urlencode($doc['name']) ?>" class="btn btn-secondary" style="font-size:0.85rem; padding:8px 18px;">Book Appointment</a>
        </div>
        <?php endforeach; ?>
    </div>
</div>


<footer>
    <p>&copy; 2026 SeuClinic. All rights reserved.</p>
</footer>

<script src="script.js"></script>
</body>
</html>
