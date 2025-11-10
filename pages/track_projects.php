<?php
session_start();
require_once '../backend/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's submitted projects
$stmt = $conn->prepare("
    SELECT title, category, uploadDate, status, projectPath, posterPath
    FROM PendingProject
    WHERE submittedBy = ?
    ORDER BY uploadDate DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Submission Tracker</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo&family=Poppins&display=swap" rel="stylesheet">
    	<link rel="stylesheet" type="text/css" href="../css/dark-mode.css">
    <style>
        :root {
            --primary-color: rgb(154, 136, 76);
            --accent-color: rgb(225, 217, 190);
            --background-color: #f3f2ec;
            --text-color: #2C2C2C;
            --card-bg: #ffffff;
            --border-radius: 10px;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            --font-family: 'Cairo', 'Poppins', sans-serif;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--background-color);
            color: var(--text-color);
            padding: 20px;
            margin: 0;
        }

        h1, h2 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 20px;
        }

        .top-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 20px;
        }

        .top-buttons a {
            text-decoration: none;
            background-color: #fff;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 8px 16px;
            border-radius: var(--border-radius);
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .top-buttons a:hover {
            background-color: var(--primary-color);
            color: #fff;
        }

        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: var(--border-radius);
            font-size: 15px;
            text-align: center;
        }

        .alert-success {
            background-color: #dff0d8;
            border: 1px solid #3c763d;
            color: #3c763d;
        }

        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #a94442;
            color: #a94442;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: var(--card-bg);
            box-shadow: var(--shadow);
            border-radius: var(--border-radius);
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 15px;
        }

        th {
            background-color: var(--accent-color);
            color: var(--text-color);
        }

        .status.pending {
            color: orange;
            font-weight: bold;
        }

        .status.approved {
            color: green;
            font-weight: bold;
        }

        .status.rejected {
            color: red;
            font-weight: bold;
        }
   .top-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.back-btn, .home-btn {
  text-decoration: none;
  background-color: #fff;
  color: var(--primary-color);
  border: 2px solid var(--primary-color);
  padding: 8px 16px;
  border-radius: var(--border-radius);
  font-size: 14px;
  transition: all 0.3s ease;
}

.back-btn:hover, .home-btn:hover {
  background-color: var(--primary-color);
  color: #fff;
}
.back-btn img,
.home-btn img {
  width: 20px;
  height: 20px;
  vertical-align: middle;
}


    </style>
</head>
<body>
   <div class="top-bar">
  <a href="javascript:history.back()" class="back-btn">
    <img src="../icomoon/left-arrow.svg" alt="back-button">
  </a>
  <a href="../index.php" class="home-btn">
    <img src="../icomoon/home.svg" alt="home-button">
  </a>
</div>

 


    <?php if (isset($_GET['status_changed'])): ?>
  <div id="status-alert" class="alert <?= $_GET['status_changed'] === 'success' ? 'alert-success' : 'alert-error' ?>">
    <?= $_GET['status_changed'] === 'success'
        ? '✅ Your project has been submitted successfully and is pending admin approval.'
        : '❌ Failed to submit your project. Please try again.' ?>
  </div>
<?php endif; ?>


    <h2>Your Submitted Projects</h2>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Upload Date</th>
                <th>Status</th>
                <th>Project File</th>
                <th>Poster</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['category']) ?></td>
                    <td><?= htmlspecialchars($row['uploadDate']) ?></td>
                    <td class="status <?= $row['status'] ?>">
                        <?= match($row['status']) {
                            'pending' => 'Pending Review',
                            'approved' => 'Approved',
                            'rejected' => 'Rejected',
                            default => 'Unknown'
                        } ?>
                    </td>
                    <td><a href="../<?= htmlspecialchars($row['projectPath']) ?>" target="_blank">📄 Download</a></td>
                    <td><a href="../<?= htmlspecialchars($row['posterPath']) ?>" target="_blank">🖼️ View</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script>
  setTimeout(() => {
    const alertBox = document.getElementById('status-alert');
    if (alertBox) alertBox.style.display = 'none';
  }, 5000); // 5 seconds
</script>
<script src="../js/dark-mode.js"></script>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
