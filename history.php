<?php

session_start();
require 'db.php';

// Must be logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: auth.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';

if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = (int) $_POST['appointment_id'];
    $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
    $message = '<div class="alert alert-success">Appointment deleted successfully.</div>';
}


if (isset($_POST['action']) && $_POST['action'] === 'update') {
    $id     = (int) $_POST['appointment_id'];
    $status = $_POST['status'];
    $stmt = $pdo->prepare("UPDATE appointments SET status = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$status, $id, $user_id]);
    $message = '<div class="alert alert-success">Appointment status updated.</div>';
}


$stmt = $pdo->prepare(
    "SELECT id, doctor, specialty, date, time, status, created_at
     FROM appointments
     WHERE user_id = ?
     ORDER BY date DESC, time DESC"
);
$stmt->execute([$user_id]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClinicCare - My Appointments</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


<nav>
    <div class="nav-logo">Clinic<span>Care</span></div>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="doctors.php">Doctors</a>
        <a href="book.php">Book</a>
        <a href="history.php" class="active">My Appointments</a>
        <a href="auth.php?logout=1" class="btn-nav">Logout</a>
    </div>
</nav>

<div class="container">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; flex-wrap:wrap; gap:12px;">
        <h2 class="page-title" style="margin-bottom:0;">My Appointments</h2>
        <a href="book.php" class="btn btn-secondary" style="font-size:0.9rem; padding:10px 22px;">+ New Appointment</a>
    </div>

    <?php echo $message; ?>

    <?php if (count($appointments) === 0): ?>
        <div class="empty-state">
            <div style="font-size:3rem;">📋</div>
            <p>No appointments found. <a href="book.php" style="color:#0077b6; font-weight:600;">Book one now →</a></p>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Doctor</th>
                        <th>Specialty</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $i => $appt): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><strong><?= htmlspecialchars($appt['doctor']) ?></strong></td>
                        <td><?= htmlspecialchars($appt['specialty']) ?></td>
                        <td><?= date('d M Y', strtotime($appt['date'])) ?></td>
                        <td><?= date('h:i A', strtotime($appt['time'])) ?></td>
                        <td>
                            <?php
                            $cls = 'status-pending';
                            if ($appt['status'] === 'Confirmed') $cls = 'status-confirmed';
                            if ($appt['status'] === 'Cancelled') $cls = 'status-cancelled';
                            ?>
                            <span class="status <?= $cls ?>"><?= $appt['status'] ?></span>
                        </td>
                        <td>
                            
                            <form method="POST" class="inline-form">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="appointment_id" value="<?= $appt['id'] ?>">
                                <select name="status">
                                    <option value="Pending"   <?= $appt['status']==='Pending'   ? 'selected':'' ?>>Pending</option>
                                    <option value="Confirmed" <?= $appt['status']==='Confirmed' ? 'selected':'' ?>>Confirmed</option>
                                    <option value="Cancelled" <?= $appt['status']==='Cancelled' ? 'selected':'' ?>>Cancelled</option>
                                </select>
                                <button type="submit" class="btn-update">Update</button>
                            </form>

                            
                            <form method="POST" class="inline-form" onsubmit="return confirmDelete(this)">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="appointment_id" value="<?= $appt['id'] ?>">
                                <button type="submit" class="btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>


<footer>
    <p>&copy; 2026 SeuClinic. All rights reserved.</p>
</footer>

<script src="script.js"></script>
</body>
</html>
