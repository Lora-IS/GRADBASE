<?php
session_start();
include '../backend/db.php';

if (!isset($_SESSION['user_type']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userType = $_SESSION['user_type'];
$userID = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];

$idColumn = $userType === 'student' ? 'studentID' : 'facultyID';

// Get email from database
$email = '';
if ($userType === 'student') {
    $stmt = $conn->prepare("SELECT semail FROM Student WHERE studentID = ?");
} elseif ($userType === 'faculty') {
    $stmt = $conn->prepare("SELECT femail FROM FacultyMember WHERE facultyID = ?");
} else {
    $stmt = $conn->prepare("SELECT email FROM Admin WHERE adminID = ?");
}

$stmt->bind_param("s", $userID);
$stmt->execute();
$stmt->bind_result($email);
$stmt->fetch();
$stmt->close();

// Prepare data arrays
$bookmarks = [];
$ratings = [];
$comments = [];
$published = [];

// Bookmarked Projects
$bmQuery = $conn->prepare("
    SELECT Project.projectID, Project.title 
    FROM BookMark 
    JOIN Project ON BookMark.projectID = Project.projectID 
    WHERE BookMark.$idColumn = ?
");
$bmQuery->bind_param("s", $userID);
$bmQuery->execute();
$bmResult = $bmQuery->get_result();
while ($row = $bmResult->fetch_assoc()) {
    $bookmarks[] = $row;
}

// Rated Projects
$rateQuery = $conn->prepare("
    SELECT Project.projectID, Project.title, Review.rating 
    FROM Review 
    JOIN Project ON Review.projectID = Project.projectID 
    WHERE Review.rating > 0 AND Review.$idColumn = ?
");
$rateQuery->bind_param("s", $userID);
$rateQuery->execute();
$rateResult = $rateQuery->get_result();
while ($row = $rateResult->fetch_assoc()) {
    $ratings[] = $row;
}

// Comments
$commentQuery = $conn->prepare("
    SELECT Project.projectID, Project.title, Review.comments 
    FROM Review 
    JOIN Project ON Review.projectID = Project.projectID 
    WHERE Review.comments IS NOT NULL AND Review.$idColumn = ?
");
$commentQuery->bind_param("s", $userID);
$commentQuery->execute();
$commentResult = $commentQuery->get_result();
while ($row = $commentResult->fetch_assoc()) {
    $comments[] = $row;
}

// Published Projects
$publishQuery = $conn->prepare("
    SELECT projectID, title, uploadDate 
    FROM Project 
    WHERE $idColumn = ?
");
$publishQuery->bind_param("s", $userID);
$publishQuery->execute();
$publishResult = $publishQuery->get_result();
while ($row = $publishResult->fetch_assoc()) {
    $published[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../icomoon/icomoon.css">
  <link rel="stylesheet" href="../css/vendor.css">
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="../css/dark-mode.css">
  <link rel="stylesheet" href="../css/profile-dark-mode.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      padding: 2rem;
    }
    .profile-box {
      background-color: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.05);
      max-width: 900px;
      margin: auto;
      margin-bottom: 1rem;
    }
    .profile-box ul {
      margin: 0;
      padding-left: 1rem;
      list-style-type: disc;
    }
    .page-title {
      font-size: 2rem;
      font-weight: 600;
      color: #333;
      border-bottom: 2px solid rgb(154, 136, 76);
      padding-bottom: 6px;
      margin-bottom: 2rem;
      display: inline-block;
    }
    .section-title {
      font-size: 1.2rem;
      margin-top: 1rem;
      margin-bottom: 0.5rem;
      font-weight: 500;
      color: rgb(154, 136, 76);
    }
    .btn-logout {
      background-color: #dc3545;
      color: white;
      border: none;
      padding: 0.5rem 1.2rem;
      border-radius: 6px;
      float: right;
    }
    .btn-logout:hover {
      background-color: #c82333;
    }
    .section-block {
      border-top: 1px solid #eee;
      padding-top: 1rem;
    }
    a.project-link {
      color: #5a4d1f;
      text-decoration: none;
      font-weight: 500;
    }
    a.project-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="profile-box">
  <h2 class="page-title">👤 Welcome, <?= htmlspecialchars($userName) ?></h2>
  <a href="logout.php" class="btn btn-logout">
    <img src="../icomoon/logout.svg" alt="logout">
  </a>
  <p>User Type: <?= ucfirst($userType) ?></p>
  <p>User ID: <?= htmlspecialchars($userID) ?></p>
  <p>Email: <?= htmlspecialchars($email) ?></p>

  <hr>

  <h4 class="section-title">Rated Projects</h4>
  <?php if ($ratings): ?>
    <ul>
      <?php foreach ($ratings as $project): ?>
        <li>
          <a class="project-link" href="project-full.php?project=<?= urlencode($project['title']) ?>">
            <?= htmlspecialchars($project['title']) ?>
          </a> — <?= str_repeat("★", $project['rating']) ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="text-muted">You haven't rated any projects yet.</p>
  <?php endif; ?>

  <h4 class="section-title">Comments</h4>
  <?php if ($comments): ?>
    <ul>
      <?php foreach ($comments as $project): ?>
        <li>
          <a class="project-link" href="project-full.php?project=<?= urlencode($project['title']) ?>">
            <strong><?= htmlspecialchars($project['title']) ?>:</strong>
          </a> <?= htmlspecialchars($project['comments']) ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="text-muted">No comments submitted yet.</p>
  <?php endif; ?>

  <h4 class="section-title">Bookmarked Projects</h4>
  <?php if ($bookmarks): ?>
    <ul>
      <?php foreach ($bookmarks as $project): ?>
        <li>
          <a class="project-link" href="project-full.php?project=<?= urlencode($project['title']) ?>">
            <?= htmlspecialchars($project['title']) ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="text-muted">No bookmarks saved yet.</p>
  <?php endif; ?>

  <h4 class="section-title">Published Projects</h4>
  <?php if ($published): ?>
    <ul>
      <?php foreach ($published as $project): ?>
        <li>
         <a class="project-link" href="project-full.php?project=<?= urlencode($project['title']) ?>">
            <?= htmlspecialchars($project['title']) ?>
          </a> — <?= htmlspecialchars($project['uploadDate']) ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="text-muted">No projects published under your name.</p>
  <?php endif; ?>
</div>

<script src="../js/dark-mode.js"></script>
</body>
</html>
