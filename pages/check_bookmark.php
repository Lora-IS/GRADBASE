<?php
session_start();
require_once '../backend/db.php';
ini_set('display_errors', 0);
error_reporting(0);


// Set the header before any output
header('Content-Type: application/json');
// Check if the user session exists
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
  echo json_encode(['bookmarked' => false]);
  exit();
}
// Receive the JSON data from the frontend
$data = json_decode(file_get_contents("php://input"), true);
$projectID = $data['projectID'] ?? null;
// Validate project ID
if (!$projectID) {
  echo json_encode(['bookmarked' => false]);
  exit();
}

$userID = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];
// Check bookmark existence based on user type
if ($userType === 'student') {
  $stmt = $conn->prepare("SELECT bookmarkID FROM BookMark WHERE projectID = ? AND studentID = ?");
  $stmt->bind_param("ii", $projectID, $userID);
} elseif ($userType === 'faculty') {
  $stmt = $conn->prepare("SELECT bookmarkID FROM BookMark WHERE projectID = ? AND facultyID = ?");
  $stmt->bind_param("is", $projectID, $userID);
} elseif ($userType === 'admin') {
  $stmt = $conn->prepare("SELECT bookmarkID FROM BookMark WHERE projectID = ? AND adminID = ?");
  $stmt->bind_param("is", $projectID, $userID);
} else {
  echo json_encode(['bookmarked' => false]);
  exit();
}
// Execute the query
$stmt->execute();
$result = $stmt->get_result();
// Return JSON response (true if bookmarked, false otherwise)
echo json_encode(['bookmarked' => $result->num_rows > 0]);
?>
