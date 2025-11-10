<?php
session_start();
require_once '../backend/db.php';
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);


if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
  echo json_encode(['success' => false, 'error' => 'Not logged in']);
  exit();
}


$data = json_decode(file_get_contents("php://input"), true);
$rating    = $data['rating'] ?? null;
$comment   = $data['comment'] ?? '';
$projectID = $data['projectID'] ?? 0;

if ($rating === null || empty($projectID)) {
  echo json_encode(['success' => false, 'error' => 'Missing rating or project ID']);
  exit();
}


$studentID = $facultyID = $adminID = null;
$userID = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];

switch ($userType) {
  case 'student':
    $studentID = intval($userID);
    $stmt = $conn->prepare("INSERT INTO Review (rating, comments, reviewDate, projectID, studentID, facultyID, adminID)
                            VALUES (?, ?, CURDATE(), ?, ?, NULL, NULL)");
    $stmt->bind_param("isii", $rating, $comment, $projectID, $studentID);
    break;

  case 'faculty':
    $facultyID = strval($userID);
    $stmt = $conn->prepare("INSERT INTO Review (rating, comments, reviewDate, projectID, studentID, facultyID, adminID)
                            VALUES (?, ?, CURDATE(), ?, NULL, ?, NULL)");
    $stmt->bind_param("isis", $rating, $comment, $projectID, $facultyID);
    break;

  case 'admin':
    $adminID = strval($userID);
    $stmt = $conn->prepare("INSERT INTO Review (rating, comments, reviewDate, projectID, studentID, facultyID, adminID)
                            VALUES (?, ?, CURDATE(), ?, NULL, NULL, ?)");
    $stmt->bind_param("isis", $rating, $comment, $projectID, $adminID);
    break;

  default:
    echo json_encode(['success' => false, 'error' => 'Invalid user type']);
    exit();
}

// تنفيذ الإدخال
if (!$stmt) {
  echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
  exit();
}

if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'error' => 'Execution failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
