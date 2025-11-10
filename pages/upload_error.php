<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$error_message = $_GET['msg'] ?? 'Unknown error occurred.';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Error</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo&family=Poppins&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/dark-mode.css">
  <style>
    :root {
      --primary-color: rgb(154, 136, 76);
      --background-color: #f3f2ec;
      --text-color: #2C2C2C;
      --card-bg: #ffffff;
      --border-radius: 10px;
      --shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      --font-family: 'Cairo', 'Poppins', sans-serif;
    }

    body {
      background-color: var(--background-color);
      color: var(--text-color);
      font-family: var(--font-family);
      margin: 0;
      padding: 0;
    }

    .container {
      background-color: var(--card-bg);
      padding: 40px;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      max-width: 700px;
      margin: 40px auto;
      text-align: center;
    }

    h2 {
      color: var(--primary-color);
      margin-bottom: 20px;
    }

    .error-box {
      background-color: #fff3f3;
      border: 1px solid #ffcccc;
      padding: 20px;
      border-radius: var(--border-radius);
      color: #990000;
      font-size: 16px;
      margin-bottom: 20px;
    }

    .back-btn {
      background-color: #fff;
      color: var(--primary-color);
      border: 2px solid var(--primary-color);
      padding: 10px 20px;
      border-radius: var(--border-radius);
      font-size: 16px;
      text-decoration: none;
      transition: all 0.3s ease;
      display: inline-block;
      position: absolute;
      top: 20px;
      left: 20px;
    }

    .back-btn:hover {
      background-color: var(--primary-color);
      color: #fff;
    }

    .back-btn img {
      width: 24px;
      height: 24px;
      vertical-align: middle;
      margin-right: 8px;
    }
  </style>
</head>
<body>

<a href="submission.php" class="back-btn">
  <img src="../icomoon/left-arrow.svg" alt="Back">
</a>

<div class="container">
  <h2>Upload Error</h2>
  <div class="error-box">
    <?= htmlspecialchars($error_message) ?>
  </div>
</div>

<script src="../js/dark-mode.js"></script>
</body>
</html>
