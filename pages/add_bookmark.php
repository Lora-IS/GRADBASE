<?php
session_start();
require_once '../backend/db.php';

// Display errors during development
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Set JSON response header
header('Content-Type: application/json');

// Check if user session is active
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

// Receive data from frontend (JSON format)
$data = json_decode(file_get_contents("php://input"), true);
$content   = $data['content'] ?? '';
$projectID = (int) ($data['projectID'] ?? 0);

// Validate received data
if (empty($content) || empty($projectID)) {
    echo json_encode(['success' => false, 'error' => 'Missing content or project ID']);
    exit();
}

$userID   = $_SESSION['user_id'];
$userType = $_SESSION['user_type'];

// Check if the bookmark already exists
switch ($userType) {
    case 'student':
        $check = $conn->prepare("SELECT bookmarkID FROM BookMark WHERE projectID = ? AND studentID = ?");
        $check->bind_param("ii", $projectID, $userID);
        break;

    case 'faculty':
        $userID = (string) $userID;
        $check = $conn->prepare("SELECT bookmarkID FROM BookMark WHERE projectID = ? AND facultyID = ?");
        $check->bind_param("is", $projectID, $userID);
        break;

    case 'admin':
        $userID = (string) $userID;
        $check = $conn->prepare("SELECT bookmarkID FROM BookMark WHERE projectID = ? AND adminID = ?");
        $check->bind_param("is", $projectID, $userID);
        break;

    default:
        echo json_encode(['success' => false, 'error' => 'Invalid user type']);
        exit();
}

$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'error' => 'Already bookmarked']);
    exit();
}

// Verify user existence in their respective table before inserting
switch ($userType) {
    case 'faculty':
        $verify = $conn->prepare("SELECT 1 FROM FacultyMember WHERE facultyID = ?");
        $verify->bind_param("s", $userID);
        break;

    case 'admin':
        $verify = $conn->prepare("SELECT 1 FROM Admin WHERE adminID = ?");
        $verify->bind_param("s", $userID);
        break;

    case 'student':
        $verify = $conn->prepare("SELECT 1 FROM Student WHERE studentID = ?");
        $verify->bind_param("i", $userID);
        break;
}

$verify->execute();
$verifyResult = $verify->get_result();
if ($verifyResult->num_rows === 0) {
    echo json_encode(['success' => false, 'error' => 'User ID not found in corresponding table']);
    exit();
}

// Insert the bookmark depending on user type
switch ($userType) {
    case 'student':
        $stmt = $conn->prepare("
            INSERT INTO BookMark (content, dateAdded, projectID, studentID, facultyID, adminID)
            VALUES (?, CURDATE(), ?, ?, NULL, NULL)
        ");
        $stmt->bind_param("sii", $content, $projectID, $userID);
        break;

    case 'faculty':
        $stmt = $conn->prepare("
            INSERT INTO BookMark (content, dateAdded, projectID, studentID, facultyID, adminID)
            VALUES (?, CURDATE(), ?, NULL, ?, NULL)
        ");
        $stmt->bind_param("sis", $content, $projectID, $userID);
        break;

    case 'admin':
        $stmt = $conn->prepare("
            INSERT INTO BookMark (content, dateAdded, projectID, studentID, facultyID, adminID)
            VALUES (?, CURDATE(), ?, NULL, NULL, ?)
        ");
        $stmt->bind_param("sis", $content, $projectID, $userID);
        break;
}

// Execute insert query
if (!$stmt) {
    echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
    exit();
}

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Execution failed: ' . $stmt->error]);
}

// Debug logging
error_log("Bookmark error: " . $stmt->error);
error_log("Prepared statement: content=$content, projectID=$projectID, userID=$userID, userType=$userType");

// Close connection
$stmt->close();
$conn->close();
?>
