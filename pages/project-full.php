<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
  $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
  header("Location: login.php");
  exit();
}


require_once '../backend/db.php';

$projectKey = strtolower(str_replace(' ', '', $_GET['project'] ?? ''));

$stmt = $conn->prepare("SELECT projectID, title, description, posterPath, projectPath, uploadDate FROM Project WHERE LOWER(REPLACE(title, ' ', '')) = ?");


$stmt->bind_param("s", $projectKey);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Project Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../icomoon/icomoon.css">
  <link rel="stylesheet" href="../css/vendor.css">
  <link rel="stylesheet" href="../style.css">
  <link rel="stylesheet" type="text/css" href="../css/dark-mode.css">
  <style>
      :root { --accent-color: rgb(154, 136, 76); }
    body {
      padding: 2rem;
      font-family: 'Segoe UI', sans-serif;
      background-color: #EAE8DF;
    }
    .project-container {
      max-width: 900px;
      margin: auto;
      background-color: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.05);
      position: relative;
    }
    .project-title {
      font-size: 2rem;
      font-weight: 600;
      color: var(--accent-color);
      border-bottom: 2px solid var(--accent-color);
      padding-bottom: 6px;
      margin-bottom: 1rem;
      text-align: center;
    }
    .project-image {
      max-width: 100%;
      max-height: 300px;
      object-fit: contain;
      background-color: #EFEEE8;
      border: 1px solid #EAE8DF;
      padding: 1rem;
      border-radius: 12px;
      margin-bottom: 1rem;
    }
    .project-description {
      font-size: 1rem;
      color: #555;
      line-height: 1.6;
      margin-bottom: 1rem;
      padding: 1rem;
    }
    #download-link {
      position: absolute;
      top: 20px;
      right: 20px;
      background: none;
      color: var(--accent-color);
      font-weight: 600;
      text-decoration: none;
      border: none;
      padding: 0;
      cursor: pointer;
      z-index: 10;
    }
    #download-link:hover {
      text-decoration: underline;
    }
    #back-button {
      background: none;
      border: none;
      position: absolute;
      top: 20px;
      left: 20px;
      cursor: pointer;
      z-index: 10;
      padding: 0;
    }
    #back-button img {
      transition: transform 0.2s ease;
    }
    #back-button:hover img {
      transform: scale(1.1);
    }
    .rating-stars span {
      font-size: 1.5rem;
      cursor: pointer;
      color: #ccc;
      transition: color 0.3s ease;
    }
    .rating-stars span.active {
      color: gold;
    }
    .btn-outline-secondary {
      border: none;
      color: var(--accent-color);
      font-weight: 500;
      border-radius: 0;
      transition: all 0.3s ease;
    }
    .btn-outline-secondary:hover {
      background-color: var(--accent-color);
      color: white;
    }
    textarea.form-control {
      border-radius: 8px;
      resize: vertical;
    }
    #comment-section {
      margin-top: 1rem;
      display: none;
    }
    #bookmark-status {
      font-size: 0.9rem;
      color: var(--accent-color);
      background-color: #fdf8e7;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      margin-top: 1rem;
      display: inline-block;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .review-box {
      position: relative;
      background-color: #fdfdfd;
      border: 1px solid #ddd;
      padding: 1rem;
      border-radius: 8px;
      margin-bottom: 1rem;
    }
    .review-box strong {
      color: var(--accent-color);
    }
    .review-box small {
      color: #888;
    }
    .delete-icon {
      position: absolute;
      bottom: 10px;
      right: 10px;
      cursor: pointer;
      transition: transform 0.2s ease;
    }
    .delete-icon:hover {
      transform: scale(1.2);
    }
    #submit-comment {
      background-color: var(--accent-color);
      color: white;
      font-weight: 600;
      border: none;
      padding: 0.6rem 1.5rem;
      border-radius: 8px;
      transition: background-color 0.3s ease;
    }
    #submit-comment:hover {
      background-color: #a08c4c;
    }
    #share-link {
      border-radius: 6px;
      padding: 0.5rem;
      font-size: 0.9rem;
      color: #333;
    }
  </style>
</head>
<body>
  <div class="project-container">
    <button id="back-button" onclick="window.location.href='projects.php'">
      <img src="../icomoon/left-arrow.svg" alt="Back" width="20" height="20">
    </button>

    <?php if ($project): ?>
      <a id="download-link" href="view.php?file=<?= htmlspecialchars($project['projectPath']) ?>" target="_blank">
      <img src="../icomoon/download.svg" alt="View PDF" width="20" height="20">
      </a>

      <h2 class="project-title"><?= htmlspecialchars($project['title']) ?></h2>

      <div class="text-center">
        <img class="project-image" src="../<?= htmlspecialchars($project['posterPath']) ?>" alt="<?= htmlspecialchars($project['title']) ?> Poster">
      </div>

      <p class="project-description"><?= htmlspecialchars($project['description']) ?></p>
      <?php if (!empty($project['uploadDate'])): ?>
      <p class="project-description"><strong>uploadDate:</strong> <?= date('d-m-Y', strtotime($project['uploadDate'])) ?></p>
      <?php endif; ?>

      <input type="hidden" id="project-id" value="<?= $project['projectID'] ?>">
      <div id="bookmark-status" class="text-muted small mt-2" style="opacity: 0; visibility: hidden;"></div>
      <div class="d-flex justify-content-center gap-3 flex-wrap my-4">
  <div class="rating-stars">
    <span onclick="rate(1)">★</span>
    <span onclick="rate(2)">★</span>
    <span onclick="rate(3)">★</span>
    <span onclick="rate(4)">★</span>
    <span onclick="rate(5)">★</span>
  </div>

  <button onclick="toggleShareTools()" class="btn btn-outline-secondary">
    <img src="../icomoon/share.svg" alt="Share" width="20" height="20">
  </button>

  <button onclick="toggleBookmark()" class="btn btn-outline-secondary">
    <img id="bookmark-icon" src="../icomoon/bookmark.svg" alt="Bookmark" width="20" height="20">
  </button>

  <button onclick="toggleCommentSection()" class="btn btn-outline-secondary">
    <img src="../icomoon/comment.svg" alt="Comment" width="20" height="20">
  </button>
</div>
<div id="share-tools" style="display: none; margin-top: 10px;">
  <input type="text" id="share-link" class="form-control mb-2" readonly>
  <div class="d-flex gap-2">
    <button onclick="copyLink()" class="btn btn-sm btn-outline-secondary">
      <img src="../icomoon/link.svg" alt="Copy" width="16" height="16"> Copy Link
    </button>
    <button onclick="nativeShare()" class="btn btn-sm btn-outline-secondary">
      <img src="../icomoon/share.svg" alt="Share" width="16" height="16"> Native Share
    </button>
  </div>
</div>
<div id="comment-section" style="display: none;">
  <textarea id="comment-text" class="form-control mb-2" placeholder="Write your comment..."></textarea>
  <button onclick="submitComment()" class="btn btn-success" id="submit-comment">Submit</button>
</div>
<div id="reviews-section" class="mt-4">
  <h4>Users Reviews</h4>
  <!-- Reviews will appear here -->
</div>

    <?php else: ?>
      <h2 class="project-title">Project Not Found</h2>
      <p class="project-description">Sorry, we couldn't find details for this project.</p>
    <?php endif; ?>
  </div>

  <script src="../js/projects.js"></script>
  <script src="../js/dark-mode.js"></script>
  <script>
    document.addEventListener('contextmenu', event => event.preventDefault());
  document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && ['c', 'x', 's'].includes(e.key.toLowerCase())) {
      e.preventDefault();
    }
  });
</script>

</body>
</html>
