<?php
// pages/subscribe.php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php?subscribed=invalid'); exit;
}

$email    = trim($_POST['email'] ?? '');
$honeypot = trim($_POST['company'] ?? '');


if ($honeypot !== '') {
    header('Location: ../index.php?subscribed=bot'); exit;
}


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../index.php?subscribed=bad_email'); exit;
}


require_once __DIR__ . '/../backend/db.php'; // يجب أن يوفّر $conn (mysqli)

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn->set_charset('utf8mb4');


$stmt = $conn->prepare("INSERT IGNORE INTO newsletter_subscribers (email) VALUES (?)");
$stmt->bind_param('s', $email);
$stmt->execute();


if ($stmt->affected_rows === 1) {
    header('Location: ../index.php?subscribed=ok'); 
} else {
    header('Location: ../index.php?subscribed=exists');
}
exit;
