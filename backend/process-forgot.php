<?php
session_start();
include 'db.php';

$type    = $_POST['type'] ?? '';
$new     = $_POST['new_password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

function renderMessage($message, $color = 'red') {
  echo "
  <!DOCTYPE html>
  <html lang='en'>
  <head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Password Reset Result</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css' rel='stylesheet'>
    <style>
      body {
         background-color: var(--light-color);
         font-family: 'Segoe UI', sans-serif;
      }
      .card {
        max-width: 500px;
        margin: 5rem auto;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        text-align: center;
      }
      .card h3 {
        font-size: 1.6rem;
        font-weight: 600;
        color: $color;
        margin-bottom: 1rem;
      }
      .btn-login {
        background-color: rgb(154, 136, 76);
        color: white;
        padding: 10px 25px;
        border: none;
        border-radius: 30px;
        font-weight: bold;
        font-size: 1rem;
        margin-top: 1.5rem;
        text-decoration: none;
        display: inline-block;
      }
      .btn-login:hover {
        background-color: #a48f56;
      }
    </style>
  </head>
  <body>
    <div class='card'>
      <h3>$message</h3>
      <a href='../pages/login.php' class='btn-login'>Back to Login</a>
    </div>
  </body>
  </html>
  ";
  exit();
}

// التحقق من تطابق كلمة المرور
if ($new !== $confirm) {
  renderMessage("Passwords do not match.");
}

// التحقق من قوة كلمة المرور
if (
  strlen($new) < 8 ||
  !preg_match('/[A-Z]/', $new) ||
  !preg_match('/[a-z]/', $new) ||
  !preg_match('/[0-9]/', $new) ||
  !preg_match('/[\W]/', $new)
) {
  renderMessage("Password must be at least 8 characters and include uppercase, lowercase, number, and special character.");
}

$hashed = password_hash($new, PASSWORD_DEFAULT);

// تحديد نوع المستخدم
if ($type === 'student' && isset($_POST['student_id'])) {
  $id = $_POST['student_id'];
  $check = $conn->prepare("SELECT studentID FROM Student WHERE studentID = ?");
  $check->bind_param("i", $id);
  $check->execute();
  $result = $check->get_result();
  if ($result->num_rows === 0) renderMessage("Student not found.");
  $stmt = $conn->prepare("UPDATE Student SET spassword = ? WHERE studentID = ?");
  $stmt->bind_param("si", $hashed, $id);

} elseif ($type === 'faculty' && isset($_POST['faculty_email'])) {
  $email = $_POST['faculty_email'];
  $check = $conn->prepare("SELECT facultyID FROM FacultyMember WHERE femail = ?");
  $check->bind_param("s", $email);
  $check->execute();
  $result = $check->get_result();
  if ($result->num_rows === 0) renderMessage("Faculty member not found.");
  $stmt = $conn->prepare("UPDATE FacultyMember SET password = ? WHERE femail = ?");
  $stmt->bind_param("ss", $hashed, $email);

} elseif ($type === 'admin' && isset($_POST['admin_user'])) {
  $username = $_POST['admin_user'];
  $check = $conn->prepare("SELECT adminID FROM Admin WHERE adminID = ?");
  $check->bind_param("s", $username);
  $check->execute();
  $result = $check->get_result();
  if ($result->num_rows === 0) renderMessage("Admin not found.");
  $stmt = $conn->prepare("UPDATE Admin SET password = ? WHERE adminID = ?");
  $stmt->bind_param("ss", $hashed, $username);

} else {
  renderMessage("Missing or invalid input.");
}

// تنفيذ التحديث
if ($stmt->execute()) {
  renderMessage("Password reset successfully", "green");
} else {
  renderMessage("Update failed. Please try again later.");
}
?>
