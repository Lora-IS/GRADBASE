<?php
session_start();
require_once '../backend/db.php';
ini_set('display_errors', 0);
error_reporting(0);


header('Content-Type: application/json');


if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
  echo json_encode(['success' => false, 'error' => 'Not logged in']);
  exit();
}


$data = json_decode(file_get_contents("php://input"), true);
$projectID = $data['projectID'] ?? null;
$userType = $_SESSION['user_type'];
$userID = $_SESSION['user_id'];


if (!$projectID) {
  echo json_encode(['success' => false, 'error' => 'Missing project ID']);
  exit();
}

if ($userType === 'student') {
  $stmt = $conn->prepare("DELETE FROM BookMark WHERE projectID = ? AND studentID = ?");
  $stmt->bind_param("ii", $projectID, $userID);
} elseif ($userType === 'faculty') {
  $stmt = $conn->prepare("DELETE FROM BookMark WHERE projectID = ? AND facultyID = ?");
  $stmt->bind_param("is", $projectID, $userID);
} elseif ($userType === 'admin') {
  $stmt = $conn->prepare("DELETE FROM BookMark WHERE projectID = ? AND adminID = ?");
  $stmt->bind_param("is", $projectID, $userID);
} else {
  echo json_encode(['success' => false, 'error' => 'Invalid user type']);
  exit();
}


if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'error' => 'Failed to delete bookmark']);
}
?>
