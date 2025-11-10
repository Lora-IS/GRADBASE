<?php
require_once 'db.php'; 

// Single student data
$student = [
  'studentID' => 443302077,
  'sfname' => 'Fatimah',
  'slname' => 'Al Mehthel',
  'semail' => '443302077@gradbase.edu.sa',
  'spassword' => 'Sara123456@',
  'adminID' => 'admin001',
  'departmentID' => 101
];

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO Student (
  studentID, sfname, slname, semail, sesstionID, spassword, adminID, departmentID, aiID
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

$sesstionID = null;
$aiID = null;
$hashedPassword = password_hash($student['spassword'], PASSWORD_DEFAULT);

// Bind the parameters
$stmt->bind_param(
  "isssisssi",
  $student['studentID'],
  $student['sfname'],
  $student['slname'],
  $student['semail'],
  $sesstionID,
  $hashedPassword,
  $student['adminID'],
  $student['departmentID'],
  $aiID
);

// Execute the query
if ($stmt->execute()) {
  echo "✅ Student {$student['sfname']} {$student['slname']} has been inserted successfully.";
} else {
  echo "⚠️ Failed to insert student: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
