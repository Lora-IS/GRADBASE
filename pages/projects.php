<?php
require_once '../backend/db.php';

$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

if ($searchQuery !== '') {
    $query = "SELECT projectID, title, category, posterPath 
              FROM Project 
              WHERE title LIKE '%$searchQuery%' OR category LIKE '%$searchQuery%' 
              ORDER BY uploadDate DESC";
} else {
    $query = "SELECT projectID, title, category, posterPath 
              FROM Project 
              ORDER BY uploadDate DESC";
}

$result = $conn->query($query); // تنفيذ الاستعلام بعد تحديده
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Graduation Projects - E-Library</title>

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link rel="stylesheet" href="../css/normalize.css">
	<link rel="stylesheet" href="../icomoon/icomoon.css">
	<link rel="stylesheet" href="../css/vendor.css">
	<link rel="stylesheet" href="../style.css">
	<link rel="stylesheet" type="text/css" href="../css/dark-mode.css">

</head>

<body data-bs-spy="scroll" data-bs-target="#header" tabindex="0">


	<div id="header-placeholder"></div>


	<!-- Main Content -->
	<main class="container mt-5">
		<section id="popular-books" class="bookshelf py-5 my-5">
			<div class="container">
				<div class="section-header align-center">
					<h2 class="section-title">Graduation Projects</h2>
				</div>


				<ul class="tabs">
					<li data-category="all" class="active tab">All Genre</li>
					<li data-category="information-system" class="tab">Information System</li>
					<li data-category="computer-science" class="tab">Computer Science</li>
					<li data-category="network" class="tab">Network and Communications</li>

				</ul>

	
				<div class="tab-content mt-4">
						<div class="row" id="projects-list">
                      <?php while ($row = $result->fetch_assoc()): ?>
                      <?php
                        $categorySlug = strtolower(str_replace(' ', '-', $row['category']));
                        $projectKey = strtolower(str_replace(' ', '', $row['title']));
                           ?>
                          <div class="col-md-3 project" data-category="<?= $categorySlug ?>">
                            <div class="product-item">
                           <figure class="product-style">
                           <img src="../<?= htmlspecialchars($row['posterPath']) ?>" alt="Project Poster" class="product-item">
                           <button class="add-to-cart" onclick="goToDetails('<?= $projectKey ?>')">Read More</button>
                           </figure>
                           <figcaption>
                          <h3><?= htmlspecialchars($row['title']) ?></h3>
                          <span><?= htmlspecialchars($row['category']) ?></span>
                         </figcaption>
                          </div>
                           </div>
                         <?php endwhile; ?>
                            </div>
					</div>
				</div>
		</section>
	</main>




	<div id="footer-placeholder"></div>

	<!-- JS Files -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>




	<!-- Custom JS -->
	<script src="../js/main.js"></script>
	<script src="../js/loadLayout.js"></script>
	<script src="../js/filterProjects.js"></script>
    <script src="../js/dark-mode.js"></script>



</body>

</html>