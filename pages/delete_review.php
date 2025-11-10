<?php
session_start();
header('Content-Type: application/json');
require_once '../backend/db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents("php://input"), true);
$reviewID = $data['reviewID'] ?? 0;
$userID   = $_SESSION['user_id'] ?? null;
$userType = $_SESSION['user_type'] ?? null;

if (!$reviewID || !$userID || !$userType) {
  echo json_encode(['success' => false, 'error' => 'Missing data']);
  exit();
}

switch ($userType) {
  case 'student':
    $stmt = $conn->prepare("DELETE FROM Review WHERE reviewID = ? AND studentID = ?");
    $stmt->bind_param("ii", $reviewID, $userID);
    break;

  case 'faculty':
    $stmt = $conn->prepare("DELETE FROM Review WHERE reviewID = ? AND facultyID = ?");
    $userID = strval($userID);
    $stmt->bind_param("is", $reviewID, $userID);
    break;

  case 'admin':
    $stmt = $conn->prepare("DELETE FROM Review WHERE reviewID = ? AND adminID = ?");
    $userID = strval($userID);
    $stmt->bind_param("is", $reviewID, $userID);
    break;

  default:
    echo json_encode(['success' => false, 'error' => 'Invalid user type']);
    exit();
}

$success = $stmt->execute();
echo json_encode(['success' => $success]);

$stmt->close();
$conn->close();
?>
