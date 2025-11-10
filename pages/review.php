<?php
require_once '../backend/db.php';

if (!isset($_POST['pendingID'], $_POST['action'])) {
    die("❌ Missing data.");
}

$pendingID = intval($_POST['pendingID']);
$action    = $_POST['action'];

// Determine project status based on admin action
if ($action === 'approve') {
    $status = 'approved';
} elseif ($action === 'reject') {
    $status = 'rejected';
} else {
    die("❌ Invalid action.");
}

// Update project status in PendingProject table
$stmt = $conn->prepare("UPDATE PendingProject SET status = ? WHERE pendingID = ?");
$stmt->bind_param("si", $status, $pendingID);
$stmt->execute();
$stmt->close();

// If approved, move the project to the main Project table
if ($status === 'approved') {

    // Fetch project details from PendingProject
    $fetch = $conn->prepare("SELECT title, description, departmentID, uploadDate, studentID, facultyID, category, projectPath, posterPath 
                             FROM PendingProject 
                             WHERE pendingID = ?");
    $fetch->bind_param("i", $pendingID);
    $fetch->execute();
    $result  = $fetch->get_result();
    $project = $result->fetch_assoc();
    $fetch->close();

    if ($project) {
        // Insert the approved project into the main Project table
        $insert = $conn->prepare("INSERT INTO Project 
            (title, description, departmentID, uploadDate, studentID, facultyID, category, projectPath, posterPath) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param(
            "ssissssss",
            $project['title'],
            $project['description'],
            $project['departmentID'],
            $project['uploadDate'],
            $project['studentID'],
            $project['facultyID'],
            $project['category'],
            $project['projectPath'],   
            $project['posterPath']     
        );
        $insert->execute();
        $insert->close();

        // Mark project as finalized in PendingProject
        $markFinal = $conn->prepare("UPDATE PendingProject SET finalized = TRUE WHERE pendingID = ?");
        $markFinal->bind_param("i", $pendingID);
        $markFinal->execute();
        $markFinal->close();
    }
}

$conn->close();

// Redirect to admin dashboard with status parameter
if ($status === 'approved') {
    header("Location: admin_dashboard.php?status=approved");
} elseif ($status === 'rejected') {
    header("Location: admin_dashboard.php?status=rejected");
}
exit();
