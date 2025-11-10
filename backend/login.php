<?php
session_start();
include 'db.php'; // الاتصال بقاعدة البيانات

if (!isset($_POST['type'])) {
    $_SESSION['login_error'] = " Login type is missing.";
    header("Location: ../pages/login.php");
    exit();
}

$type = $_POST['type'];
$password = '';
$userID = '';
$query = '';
$bindType = '';
$bindValue = '';

if ($type === 'student') {
    if (!isset($_POST['student_id'], $_POST['student_pass'])) {
        $_SESSION['login_error'] = " Please enter your Academic ID and password.";
        header("Location: ../pages/login.php");
        exit();
    }

    $userID = $_POST['student_id'];
    $password = $_POST['student_pass'];
    $query = "SELECT studentID, sfname, spassword FROM Student WHERE studentID = ?";
    $bindType = "i";
    $bindValue = $userID;

} elseif ($type === 'faculty') {
    if (!isset($_POST['faculty_email'], $_POST['faculty_pass'])) {
        $_SESSION['login_error'] = " Please enter your University Email and password.";
        header("Location: ../pages/login.php");
        exit();
    }

    $userEmail = $_POST['faculty_email'];
    $password = $_POST['faculty_pass'];
    $query = "SELECT facultyID, mfname, password FROM FacultyMember WHERE femail = ?";
    $bindType = "s";
    $bindValue = $userEmail;

} elseif ($type === 'admin') {
    if (!isset($_POST['admin_user'], $_POST['admin_pass'])) {
        $_SESSION['login_error'] = "Please enter your admin username and password.";
        header("Location: ../pages/login.php");
        exit();
    }

    $userID = $_POST['admin_user'];
    $password = $_POST['admin_pass'];
    $query = "SELECT adminID, fname, lname, password FROM Admin WHERE adminID = ?";
    $bindType = "s";
    $bindValue = $userID;

} else {
    $_SESSION['login_error'] = "Invalid user type.";
    header("Location: ../pages/login.php");
    exit();
}

// تنفيذ الاستعلام
$stmt = $conn->prepare($query);
$stmt->bind_param($bindType, $bindValue);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $storedPassword = $row['spassword'] ?? $row['password'];
    $name = $row['sfname'] ?? $row['mfname'] ?? ($row['fname'] . ' ' . $row['lname']);
    $actualID = $row['studentID'] ?? $row['facultyID'] ?? $row['adminID'];

    if (password_verify($password, $storedPassword)) {
        $_SESSION['user_type'] = $type;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_id']   = $actualID;
        $_SESSION['user_email'] = $userEmail ?? null;

        $redirect = $_SESSION['redirect_after_login'] ?? ($type === 'admin' ? '../pages/admin_dashboard.php' : '../index.php');
        unset($_SESSION['redirect_after_login']); 
        header("Location: $redirect"); 
        exit();
    } else {
        $_SESSION['login_error'] = " Incorrect password.";
        header("Location: ../pages/login.php");
        exit();
    }

} else {
    $_SESSION['login_error'] = " User not found.";
    header("Location: ../pages/login.php");
    exit();
}

?>
