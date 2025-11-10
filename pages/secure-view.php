<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
  header("Location: login.php");
  exit();
}

$file = $_GET['file'] ?? '';
$cleanPath = trim($file);


if (!preg_match('/\.pdf$/i', $cleanPath)) {
  echo "<h2 style='text-align:center; margin-top:2rem;'>Invalid file format.</h2>";
  exit();
}


$fullPath = realpath(__DIR__ . '/../' . $cleanPath);
if (!$fullPath || !file_exists($fullPath)) {
  echo "<h2 style='text-align:center; margin-top:2rem;'>File not found.</h2>";
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Secure PDF Viewer</title>
  <style>
    body {
      margin: 0;
      background-color: #f4f4f4;
      overflow: hidden;
    }
    iframe {
      width: 100vw;
      height: 100vh;
      border: none;
    }
  </style>
</head>
<body>
  <iframe src="../pdfjs/web/viewer.html?file=<?= rawurlencode('../' . $cleanPath) ?>"></iframe>

  <script>
    document.addEventListener('contextmenu', e => e.preventDefault());
    document.addEventListener('keydown', function(e) {
      if ((e.ctrlKey || e.metaKey) && ['s', 'p', 'c'].includes(e.key.toLowerCase())) {
        e.preventDefault();
      }
    });
  </script>
</body>
</html>
