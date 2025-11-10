<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  http_response_code(403);
  exit('Unauthorized');
}

$file = $_GET['file'] ?? '';
$path = realpath('../secure-pdfs/' . $file);


$allowedDir = realpath('../secure-pdfs/');
if (strpos($path, $allowedDir) !== 0 || !file_exists($path)) {
  http_response_code(403);
  exit('Access denied');
}


header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="view.pdf"'); // inline = عرض فقط
header('X-Content-Type-Options: nosniff');
readfile($path);
