<?php
session_start();
header('Content-Type: application/json');
require_once '../backend/db.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);


$data = json_decode(file_get_contents("php://input"), true);
$projectID = $data['projectID'] ?? 0;
$userID    = $_SESSION['user_id'] ?? null;
$userType  = $_SESSION['user_type'] ?? null;

if (!$projectID || !$userID || !$userType) {
  echo json_encode(['reviews' => [], 'error' => 'Missing data']);
  exit();
}


$stmt = $conn->prepare("
  SELECT R.reviewID, R.rating, R.comments, R.reviewDate,
         CASE 
           WHEN R.studentID IS NOT NULL THEN S.sfname
           WHEN R.facultyID IS NOT NULL THEN F.mfname
           WHEN R.adminID IS NOT NULL THEN A.fname
         END AS reviewerName,
         CASE 
           WHEN (R.studentID = ? AND ? = 'student') OR
                (R.facultyID = ? AND ? = 'faculty') OR
                (R.adminID   = ? AND ? = 'admin')
           THEN 1 ELSE 0
         END AS canDelete
  FROM Review R
  LEFT JOIN Student S ON R.studentID = S.studentID
  LEFT JOIN FacultyMember F ON R.facultyID = F.facultyID
  LEFT JOIN Admin A ON R.adminID = A.adminID
  WHERE R.projectID = ?
  ORDER BY R.reviewDate DESC
");


$userID_str = strval($userID);
$stmt->bind_param("ssssssi", $userID_str, $userType, $userID_str, $userType, $userID_str, $userType, $projectID);


$stmt->execute();
$result = $stmt->get_result();


$reviews = [];
while ($row = $result->fetch_assoc()) {
  $reviews[] = $row;
}

echo json_encode(['reviews' => $reviews]);

$stmt->close();
$conn->close();
?>
