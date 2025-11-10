<?php
session_start();


// تحقق من حالة الدخول ونوع المستخدم
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: ../pages/login.php"); // ← تأكدي من المسار الصحيح
    exit();
}

require_once '../backend/db.php';

$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? 'User';

// إحصائيات المكتبة
$deptCount      = $conn->query("SELECT COUNT(*) FROM Department")->fetch_row()[0];
$projectCount   = $conn->query("SELECT 
  (SELECT COUNT(*) FROM Project)")->fetch_row()[0];
$approvedCount  = $conn->query("SELECT COUNT(*) FROM PendingProject WHERE status = 'approved'")->fetch_row()[0];
$rejectedCount  = $conn->query("SELECT COUNT(*) FROM PendingProject WHERE status = 'rejected'")->fetch_row()[0];
$studentCount   = $conn->query("SELECT COUNT(*) FROM Student")->fetch_row()[0];
$facultyCount = $conn->query("SELECT COUNT(*) FROM FacultyMember")->fetch_row()[0];
$commentCount    = $conn->query("SELECT COUNT(*) FROM review WHERE comments IS NOT NULL AND comments != ''")->fetch_row()[0];
$ratingCount     = $conn->query("SELECT COUNT(*) FROM review WHERE rating IS NOT NULL")->fetch_row()[0];
$favoriteCount   = $conn->query("SELECT COUNT(*) FROM bookmark")->fetch_row()[0];
$averageRating   = $conn->query("SELECT AVG(rating) FROM review WHERE rating IS NOT NULL")->fetch_row()[0];



// فلترة ذكية
$where = "WHERE status = 'pending'";
$params = [];
$types = "";

if (!empty($_GET['departmentID'])) {
    $where .= " AND departmentID = ?";
    $params[] = intval($_GET['departmentID']);
    $types .= "i";
}

if (!empty($_GET['user_type'])) {
    if ($_GET['user_type'] === 'student') {
        $where .= " AND studentID IS NOT NULL";
    } elseif ($_GET['user_type'] === 'faculty') {
        $where .= " AND facultyID IS NOT NULL";
    }
}

if (!empty($_GET['uploadDate'])) {
    $where .= " AND uploadDate = ?";
    $params[] = $_GET['uploadDate'];
    $types .= "s";
}

$sql = "SELECT * FROM PendingProject $where";
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link rel="stylesheet" href="../css/normalize.css">
	<link rel="stylesheet" href="../icomoon/icomoon.css">
	<link rel="stylesheet" href="../css/vendor.css">
	<link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" href="../css/dark-mode.css">
	<link rel="stylesheet" href="../css/admin-dark-mode.css">
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

/* Titles */
h1, h2 {
  color: var(--primary-color);
  text-align: center;
  margin-bottom: 20px;
}

/* Statistics Section */
.stats ul {
  list-style: none;
  padding: 0;
  background-color: var(--card-bg);
  border-radius: var(--border-radius);
  box-shadow: var(--shadow);
  padding: 20px;
  margin-bottom: 30px;
}

.stats li {
  margin: 10px 0;
  font-weight: bold;
  font-size: 16px;
  color: var(--text-color);
}

/* Filter Form */
.filter-form {
  background-color: var(--card-bg);
  padding: 20px;
  border-radius: var(--border-radius);
  box-shadow: var(--shadow);
  margin-bottom: 30px;
  display: flex;
  gap: 15px;
  align-items: center;
  flex-wrap: wrap;
}

.filter-form label {
  font-weight: bold;
  color: var(--primary-color);
}

.filter-form select,
.filter-form input[type="date"] {
  padding: 10px;
  border-radius: var(--border-radius);
  border: 1px solid #ccc;
  font-size: 15px;
  background-color: #fff;
  color: var(--text-color);
}

/* Table */
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

/* Status Colors */
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

/* Buttons */
button {
  background-color: #fff;
  color: var(--primary-color);
  border: 2px solid var(--primary-color);
  padding: 8px 16px;
  border-radius: var(--border-radius);
  font-size: 14px;
  cursor: pointer;
  transition: all 0.3s ease;
}

button:hover {
  background-color: var(--primary-color);
  color: #fff;
}
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 20px;
  margin-bottom: 40px;
}

.stat-card {
  background-color: var(--card-bg);
  border-radius: var(--border-radius);
  box-shadow: var(--shadow);
  padding: 20px;
  text-align: center;
  border-left: 6px solid var(--primary-color);
  transition: transform 0.3s ease;
}

.stat-card:hover {
  transform: translateY(-5px);
}

.stat-card h3 {
  margin: 0;
  font-size: 18px;
  color: var(--primary-color);
}

.stat-card p {
  font-size: 24px;
  font-weight: bold;
  margin-top: 10px;
  color: var(--text-color);
}
.filter-section {
  background-color: #f3f2ec;
  padding: 30px;
  border-radius: var(--border-radius);
  box-shadow: var(--shadow);
  margin-bottom: 40px;
}

.filter-section h2 {
  color: var(--primary-color);
  margin-bottom: 20px;
  text-align: center;
}

.filter-form {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 20px;
}

.filter-form label {
  font-weight: bold;
  color: var(--primary-color);
  margin-bottom: 8px;
  display: block;
}

.filter-form select,
.filter-form input[type="date"] {
  padding: 10px;
  border-radius: var(--border-radius);
  border: 1px solid #ccc;
  font-size: 15px;
  background-color: #fff;
  color: var(--text-color);
  width: 100%;
}

.filter-form .button-row {
  grid-column: span 2;
  text-align: center;
  margin-top: 10px;
}

.filter-form button {
  background-color: #fff;
  color: var(--primary-color);
  border: 2px solid var(--primary-color);
  padding: 10px 20px;
  border-radius: var(--border-radius);
  font-size: 16px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.filter-form button:hover {
  background-color: var(--primary-color);
  color: #fff;
}
.custom-alert {
  background-color: #fff;
  color: var(--primary-color);
  border: 2px solid var(--primary-color);
  border-radius: 12px;
  padding: 15px 25px;
  margin: 20px auto;
  width: fit-content;
  text-align: center;
  font-weight: 600;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  transition: all 0.5s ease;
  animation: fadeInDown 0.5s ease;
}

@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-15px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
 </style>
</head>
<body>
  <header>
    <h1> GradBase Dashboard</h1>

<?php if (isset($_GET['status'])): ?>
    <?php
        $message = '';
        $icon = '';
        $alertClass = '';

        if ($_GET['status'] === 'approved') {
            $message = 'Project approved successfully!';
            $icon = '✅';
        } elseif ($_GET['status'] === 'rejected') {
            $message = 'Project rejected successfully!';
            $icon = '❌';
        }
    ?>
    <div class="custom-alert">
        <?= $icon ?> <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

     <div class="right-element d-flex justify-content-end align-items-center gap-3" >
      	<?php if ($isLoggedIn): ?>
                          <a href="profile.php" class="user-account for-buy">
                          <i class="icon icon-user"></i>
                           <span><?= htmlspecialchars($userName) ?></span>
                           </a>
                          <?php else: ?>
                         <a href="pages/login.php" class="user-account for-buy">
                         <i class="icon icon-user"></i>
                          <span>Account</span>
                            </a>
                          <?php endif; ?>
     </div>
  </header>

  <div class="container">
    <!-- Library Statistics -->
   <h2 class="center-title">Library Statistics</h2>
<div class="stats-grid">
  <div class="stat-card">
    <h3>Departments</h3>
    <p><?= $deptCount ?></p>
  </div>
  <div class="stat-card">
    <h3>Total Projects</h3>
    <p><?= $projectCount ?></p>
  </div>
  <div class="stat-card">
    <h3>Approved Projects</h3>
    <p><?= $approvedCount ?></p>
  </div>
  <div class="stat-card">
    <h3>Rejected Projects</h3>
    <p><?= $rejectedCount ?></p>
  </div>
  <div class="stat-card">
    <h3>Faculty Members</h3>
    <p><?= $facultyCount ?></p>
  </div>
   <div class="stat-card">
    <h3>Students</h3>
    <p><?= $studentCount ?></p>
  </div>
    <div class="stat-card">
    <h3>Comments</h3>
    <p><?= $commentCount ?></p>
  </div>
    <div class="stat-card">
    <h3>Ratings</h3>
    <p><?= $ratingCount ?></p>
  </div>
   <div class="stat-card">
    <h3>Favorites</h3>
    <p><?= $favoriteCount ?></p>
  </div>
   <div class="stat-card">
    <h3>Average Rating</h3>
    <p><?= number_format($averageRating, 2) ?></p>
  </div>
</div>


    <!-- Filter Form -->
    <div class="filter-section">
  <h2>Filter Projects</h2>
 <form method="GET" action="filter.php" class="filter-form">
    <div>
      <label for="departmentID">Department</label>
      <select name="departmentID" id="departmentID">
        <option value="">All</option>
        <option value="101">Information System</option>
        <option value="102">Computer Science</option>
        <option value="103">Network & Communications</option>
      </select>
    </div>

    <div>
      <label for="user_type">User Type</label>
      <select name="user_type" id="user_type">
        <option value="">All</option>
        <option value="student">Student</option>
        <option value="faculty">Faculty</option>
      </select>
    </div>

    <div>
      <label for="uploadDate">Upload Date</label>
      <input type="date" name="uploadDate" id="uploadDate">
    </div>

    <div class="button-row">
      <button type="submit">FILTER</button>
    </div>
  </form>
</div>


    <!-- Pending Projects -->
    <h2 class="center-title">Pending Projects</h2>
    <table>
      <thead>
        <tr>
          <th>Title</th>
          <th>Description</th>
          <th>Department</th>
          <th>Submitted By</th>
          <th>Status</th>
          <th>Files</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['title'] ?></td>
            <td><?= $row['description'] ?></td>
            <td><?= $row['category'] ?></td>
            <td><?= $row['submittedBy'] ?></td>
            <td><span class="status pending">Pending</span></td>
            <td>
              <a href="../<?= $row['projectPath'] ?>" target="_blank">Project</a><br>
              <a href="../<?= $row['posterPath'] ?>" target="_blank">Poster</a>
            </td>
            <td>
              <form method="post" action="review.php">
                <input type="hidden" name="pendingID" value="<?= $row['pendingID'] ?>">
                <button name="action" value="approve">Approve</button>
                <button name="action" value="reject">Reject</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <script src="../js/dark-mode.js"></script>
    <script>
      // Auto-hide the alert after 10 seconds
      setTimeout(() => {
        const alertBox = document.querySelector('.custom-alert');
        if (alertBox) {
          alertBox.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
          alertBox.style.opacity = '0';
          alertBox.style.transform = 'translateY(-10px)';
          setTimeout(() => alertBox.remove(), 600);
        }
      }, 10000);
    </script>

</body>
</html>
