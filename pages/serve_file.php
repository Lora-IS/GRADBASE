<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit('Unauthorized');
}


$file = $_GET['file'] ?? '';
if ($file === '') {
    http_response_code(400);
    exit('Bad Request: No file specified');
}


$filename = basename($file);


$uploadsDir = realpath(__DIR__ . '/../files');
if ($uploadsDir === false) {
    http_response_code(500);
    exit('Server configuration error: Uploads folder not found');
}


$fullPath = realpath($uploadsDir . DIRECTORY_SEPARATOR . $filename);


if ($fullPath === false || strpos($fullPath, $uploadsDir) !== 0) {
    http_response_code(403);
    exit('Access denied');
}


if (!is_file($fullPath) || !is_readable($fullPath)) {
    http_response_code(404);
    exit('File not accessible');
}


header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . basename($fullPath) . '"');
header('Content-Length: ' . filesize($fullPath));
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
header('X-Content-Type-Options: nosniff');


$fp = fopen($fullPath, 'rb');
if ($fp) {
    while (!feof($fp)) {
        echo fread($fp, 8192);
        flush();
    }
    fclose($fp);
}
exit();
