<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Submit Project</title>
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
      background-color: var(--background-color);
      color: var(--text-color);
      font-family: var(--font-family);
      margin: 0;
      padding: 0;
    }

    .container {
      background-color: var(--card-bg);
      padding: 40px;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
      max-width: 700px;
      margin: 40px auto;
    }

    h2 {
      text-align: center;
      color: var(--primary-color);
      margin-bottom: 30px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: rgb(167, 151, 99);
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 10px;
      border-radius: var(--border-radius);
      border: 1px solid #ccc;
      font-size: 16px;
      background-color: #fff;
      color: var(--text-color);
      box-sizing: border-box;
    }

    .form-group small {
      color: gray;
      display: block;
      margin-top: 5px;
    }

    .button-row {
      text-align: center;
      margin-top: 30px;
    }

    .button-row button {
      background-color: #fff;
      color: var(--primary-color);
      border: 2px solid var(--primary-color);
      padding: 12px 24px;
      border-radius: var(--border-radius);
      font-size: 16px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .button-row button:hover {
      background-color: var(--primary-color);
      color: #fff;
    }

    #posterPreview {
      max-width: 100%;
      margin-top: 10px;
      display: none;
      border-radius: var(--border-radius);
      box-shadow: var(--shadow);
    }
    .back-btn {
  color: white;
  text-decoration: none;
  font-weight: bold;
  font-size: 16px;
  background-color: transparent;
 
  padding: 8px 16px;
  border-radius: var(--border-radius);
  transition: all 0.3s ease;
  display: inline-block;
}

.back-btn:hover {
  background-color: var(--primary-color);
  color: white ;
}
.back-btn img {
  width: 24px;
  height: 24px;
  vertical-align: middle;
}


  </style>
</head>
<body>


<div class="container">
  <a href="../index.php" class="back-btn"> 
  <img src="../icomoon/left-arrow.svg" alt="back-button">
</a>
  <h2>Submit a New Project</h2>

  <form action="upload_project.php" method="POST" enctype="multipart/form-data">
    <div class="form-group">
      <label>Project Title:</label>
      <input type="text" name="title" required>
    </div>

    <div class="form-group">
      <label>Short Description:</label>
      <textarea name="description" rows="4" required></textarea>
    </div>

    <div class="form-group">
      <label>Academic Category:</label>
      <select name="departmentID" required>
        <option value="">-- Select Category --</option>
        <option value="101">Information System</option>
        <option value="102">Computer Science</option>
        <option value="103">Network and Communications</option>
      </select>
    </div>

    <div class="form-group">
      <label>Project File (PDF or ZIP):</label>
      <input type="file" name="project_file" accept=".pdf,.zip" required>
      <small>Max size: 15MB</small>
    </div>

    <div class="form-group">
      <label>Project Poster (Image):</label>
      <input type="file" name="poster_image" accept="image/*" required onchange="previewPoster(event)">
      <small>Max size: 15MB</small>
      <img id="posterPreview" />
    </div>

    <div class="button-row">
      <button type="submit">Submit Project</button>
    </div>
  </form>
</div>

<script>
  function previewPoster(e) {
    const reader = new FileReader();
    reader.onload = function(event) {
      const img = document.getElementById('posterPreview');
      img.src = event.target.result;
      img.style.display = 'block';
    };
    reader.readAsDataURL(e.target.files[0]);
  }

  document.querySelector("form").addEventListener("submit", function(e) {
    if (!confirm("Are you sure you want to submit this project?")) {
      e.preventDefault();
    }
  });
</script>
<script src="../js/dark-mode.js"></script>

</body>
</html>
