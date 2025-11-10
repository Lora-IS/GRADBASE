<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../pages/login.php");
    exit();
}

require_once '../backend/db.php';


$whereProject = "WHERE 1";
$wherePending = "WHERE status = 'approved'";
$paramsProject = [];
$paramsPending = [];
$typesProject = "";
$typesPending = "";


if (!empty($_GET['departmentID'])) {
    $whereProject .= " AND departmentID = ?";
    $wherePending .= " AND departmentID = ?";
    $paramsProject[] = intval($_GET['departmentID']);
    $paramsPending[] = intval($_GET['departmentID']);
    $typesProject .= "i";
    $typesPending .= "i";
}

// نوع المستخدم (ينطبق فقط على PendingProject)
if (!empty($_GET['user_type'])) {
    if ($_GET['user_type'] === 'student') {
        $wherePending .= " AND studentID IS NOT NULL";
    } elseif ($_GET['user_type'] === 'faculty') {
        $wherePending .= " AND facultyID IS NOT NULL";
    }
}

// تاريخ الرفع
if (!empty($_GET['uploadDate'])) {
    $whereProject .= " AND uploadDate = ?";
    $wherePending .= " AND uploadDate = ?";
    $paramsProject[] = $_GET['uploadDate'];
    $paramsPending[] = $_GET['uploadDate'];
    $typesProject .= "s";
    $typesPending .= "s";
}


$sqlProject = "SELECT projectID, title, description, departmentID, uploadDate, 'admin' AS source FROM Project $whereProject";
$stmtProject = $conn->prepare($sqlProject);
if (!empty($paramsProject)) {
    $stmtProject->bind_param($typesProject, ...$paramsProject);
}
$stmtProject->execute();
$resultProject = $stmtProject->get_result();


$sqlPending = "SELECT pendingID AS projectID, title, description, departmentID, uploadDate, 'user' AS source FROM PendingProject $wherePending";
$stmtPending = $conn->prepare($sqlPending);
if (!empty($paramsPending)) {
    $stmtPending->bind_param($typesPending, ...$paramsPending);
}
$stmtPending->execute();
$resultPending = $stmtPending->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Filtered Projects</title>

    	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

	<link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="../css/dark-mode.css">
	<link rel="stylesheet" href="../css/admin-dark-mode.css">
  <style>
    body {
      font-family: var(--font-family);
      color: var(--text-color);
      padding: 30px;
    }

    h2 {
      text-align: center;
      color: var(--primary-color);
      margin-bottom: 30px;
    }

    .project-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
    }

    .project-card {
      background-color: white;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      padding: 20px;
      border-left: 6px solid var(--primary-color);
      transition: transform 0.3s ease;
    }

    .project-card:hover {
      transform: translateY(-5px);
    }

    .project-card h4 {
      margin: 0 0 10px;
      color: #8e7a3f;
      font-size: 18px;
    }

    .project-card p {
      font-size: 15px;
      color: var(--text-color);
      margin-bottom: 15px;
    }

    .project-card .meta {
      display: flex;
      justify-content: space-between;
      font-size: 13px;
      color: #666;
    }

    .btn-back {
      display: inline-block;
      margin-top: 40px;
      padding: 10px 20px;
      background-color: var(--primary-color);
      color: #fff;
      text-decoration: none;
      border-radius: var(--border-radius);
      transition: background-color 0.3s ease;
    }

    .btn-back:hover {
      background-color: #8e7a3f;
    }

    .no-results {
      text-align: center;
      margin-top: 40px;
      font-size: 16px;
      color: #999;
      font-style: italic;
    }
  </style>
</head>
<body>
  <h2> Filtered Projects</h2>

  <?php if ($resultProject->num_rows === 0 && $resultPending->num_rows === 0): ?>
    <div class="no-results">There are no projects that match the selected filters.</div>
  <?php else: ?>
    <div class="project-grid">
      <?php while ($row = $resultProject->fetch_assoc()): ?>
        <div class="project-card">
          <h4><?= htmlspecialchars($row['title']) ?></h4>
          <p><?= htmlspecialchars($row['description']) ?></p>
          <div class="meta">
            <span>Dept: <?= $row['departmentID'] ?></span>
            <span> <?= $row['uploadDate'] ?></span>
            <span>🧑‍💼 Admin</span>
          </div>
        </div>
      <?php endwhile; ?>

      <?php while ($row = $resultPending->fetch_assoc()): ?>
        <div class="project-card">
          <h4><?= htmlspecialchars($row['title']) ?></h4>
          <p><?= htmlspecialchars($row['description']) ?></p>
          <div class="meta">
            <span>📁 Dept: <?= $row['departmentID'] ?></span>
            <span>📅 <?= $row['uploadDate'] ?></span>
            <span>👨‍🎓 User</span>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endif; ?>

  <a href="admin_dashboard.php" class="btn-back">Back</a>
</body>
</html>
