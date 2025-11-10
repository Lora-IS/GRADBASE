<?php
require_once 'db.php'; // Make sure the database connection is correct

// Single faculty member data
$faculty = [
  'facultyID' => 'FAC011',
  'mfname' => 'Dr.Samer ',
  'mlname' => 'Al-Qahtani',
  'femail' => 'Smalqahtani@gradbase.edu.sa',
  'password' => 'SA123456@',
  'adminID' => 'admin001'
];

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO Facultymember (
  facultyID, mfname, mlname, femail, password, sesstionID, adminID, aiID
) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

$sesstionID = null;
$aiID = null;
$hashedPassword = password_hash($faculty['password'], PASSWORD_DEFAULT);

// Bind parameters
$stmt->bind_param(
  "ssssssss",
  $faculty['facultyID'],
  $faculty['mfname'],
  $faculty['mlname'],
  $faculty['femail'],
  $hashedPassword,
  $sesstionID,
  $faculty['adminID'],
  $aiID
);

// Execute the query
if ($stmt->execute()) {
  echo "✅ Faculty member {$faculty['mfname']} {$faculty['mlname']} has been inserted successfully.";
} else {
  echo "⚠️ Failed to insert faculty member: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
