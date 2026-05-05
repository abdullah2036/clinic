<?php
session_start();
require 'db.php';

// Must be logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: auth.php');
    exit;
}

$message = '';


$doctors = [
    ['name' => 'Dr. Khaled Nasser',  'specialty' => 'General Medicine'],
    ['name' => 'Dr. Layla Omar',     'specialty' => 'Cardiology'],
    ['name' => 'Dr. Tariq Saleh',    'specialty' => 'Dermatology'],
    ['name' => 'Dr. Hana Al-Rashid', 'specialty' => 'Pediatrics'],
    ['name' => 'Dr. Fares Qasim',    'specialty' => 'Orthopedics'],
    ['name' => 'Dr. Nora Ibrahim',   'specialty' => 'Neurology'],
];

// doctors.php "Book" button
$selected_doctor = isset($_GET['doctor']) ? $_GET['doctor'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctor    = $_POST['doctor'];
    $date      = $_POST['date'];
    $time      = $_POST['time'];
    $user_id   = $_SESSION['user_id'];

    //specialty
    $specialty = '';
    foreach ($doctors as $d) {
        if ($d['name'] === $doctor) {
            $specialty = $d['specialty'];
            break;
        }
    }

    $stmt = $pdo->prepare(
        "INSERT INTO appointments (user_id, doctor, specialty, date, time) VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->execute([$user_id, $doctor, $specialty, $date, $time]);

    $message = '<div class="alert alert-success">✅ Appointment booked successfully! <a href="history.php" style="color:#065f46; font-weight:700;">View My Appointments →</a></div>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClinicCare - Book Appointment</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


<nav>
    <div class="nav-logo">Clinic<span>Care</span></div>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="doctors.php">Doctors</a>
        <a href="book.php" class="active">Book</a>
        <a href="history.php">My Appointments</a>
        <a href="auth.php?logout=1" class="btn-nav">Logout</a>
    </div>
</nav>

<div class="container">
    <h2 class="page-title">Book an Appointment</h2>

    <?php echo $message; ?>

    <div class="form-card">
        <p style="color:#64748b; margin-bottom:24px;">Fill in the details below to schedule your visit.</p>

        <form method="POST" onsubmit="return validateBooking()">
            <div class="form-group">
                <label for="doctor">Select Doctor</label>
                <select id="doctor" name="doctor" required>
                    <option value="">-- Choose a Doctor --</option>
                    <?php foreach ($doctors as $d): ?>
                        <option value="<?= htmlspecialchars($d['name']) ?>"
                            <?= ($selected_doctor === $d['name']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($d['name']) ?> — <?= htmlspecialchars($d['specialty']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="date">Appointment Date</label>
                    <input type="date" id="date" name="date" min="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="form-group">
                    <label for="time">Preferred Time</label>
                    <input type="time" id="time" name="time" min="08:00" max="17:00" required>
                </div>
            </div>

            <div class="form-group">
                <label>Patient Name</label>
                <input type="text" value="<?= htmlspecialchars($_SESSION['user_name']) ?>" disabled style="background:#e2e8f0;">
            </div>

            <button type="submit" class="btn btn-submit">Confirm Appointment</button>
        </form>
    </div>
</div>


<footer>
    <p>&copy; 2026 SeuClinic. All rights reserved.</p>
</footer>

<script src="script.js"></script>
</body>
</html>
