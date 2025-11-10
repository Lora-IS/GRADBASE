<?php
require_once '../backend/db.php';

$projectKey = strtolower(str_replace(' ', '', $_GET['project'] ?? ''));

$stmt = $conn->prepare("SELECT title, description, posterPath FROM Project WHERE LOWER(REPLACE(title, ' ', '')) = ?");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details</title>

    <!-- CSS Links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../icomoon/icomoon.css">
    <link rel="stylesheet" href="../css/vendor.css">
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/dark-mode.css">
    

    <style>
        body {
            padding: 2rem;
            font-family: 'Segoe UI', sans-serif;
        }

        .abstract {
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .page-title {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid rgb(154, 136, 76);
            padding-bottom: 6px;
            margin-bottom: 1rem;
            display: inline-block;
        }

        .project-image {
            max-width: 100%;
            max-height: 300px;
            object-fit: contain;
            background-color: #EFEEE8;
            border: 1px solid #EAE8DF;
            padding: 1rem;
            border-radius: 12px;
        }

        .product-style {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .card-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid rgb(154, 136, 76);
            padding-bottom: 6px;
            margin-bottom: 1rem;
            display: inline-block;
        }

        .card-text {
            font-size: 1rem;
            color: #555;
            line-height: 1.6;
        }

        .container {
            background-color: #EAE8DF;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            max-width: 900px;
        }

        :root {
            --accent-color: rgb(154, 136, 76);
        }
        .custom-btn {
  background-color: white;
  border: 2px solid var(--accent-color);
  color: var(--accent-color);
  padding: 0.5rem 1.5rem;
  font-size: 1rem;
  font-weight: 500;
  border-radius: 0;
  cursor: pointer;
  transition: all 0.3s ease;
  width: 200px; /* ← توحيد العرض */
  text-align: center;
  box-shadow: 0 4px 6px rgba(154, 136, 76, 0.2);
  white-space: nowrap; /* يمنع كسر السطر */
  height: 60px;
  margin: 5px;
}
.btn-back:hover {
  transform: translateX(-10px);
  background-color: var(--accent-color);
  color: white;
}

.btn-details:hover {
  transform: translateX(10px);
  background-color: var(--accent-color);
  color: white;
}
.home-btn {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 999;
  text-decoration: none;
  border: 2px solid rgb(154, 136, 76);
  padding: 8px 12px;
  border-radius: 50px;
  background-color: white;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 6px rgba(154, 136, 76, 0.2);
}

.home-btn img {
  width: 24px;
  height: 24px;
  transition: filter 0.3s ease;
}

.home-btn:hover {
  background-color: rgb(154, 136, 76);
}

.home-btn:hover img {
  filter: brightness(0) invert(1); 
}
      
    </style>
</head>

<body>
    <a href="../index.php" class="home-btn" aria-label="Go to Home">
  <img src="../icomoon/home.svg" alt="Home">
</a>
   <div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="container">
        <div class="row d-flex align-items-stretch">

            <div class="col-md-6 d-flex flex-column h-100">
                <div class="card flex-fill">
                    <div class="card-body" data-aos="fade-up">
                        <?php if ($project): ?>
                            <h1 class="card-title"><?= htmlspecialchars($project['title']) ?></h1>
                            <h5 class="mb-3 text-muted">Abstract</h5>
                            <p class="card-text"><?= htmlspecialchars($project['description']) ?></p>
                            <div class="button-wrapper d-flex gap-3">
                                <button onclick="history.back()" class="custom-btn btn-back">← Back</button>
                                <a href="project-full.php?project=<?= urlencode($projectKey) ?>" class="custom-btn btn-details">MORE DETAILS →</a>

                            </div>
                        <?php else: ?>
                            <h1 class="card-title">Project Not Found</h1>
                            <p class="card-text">Sorry, we couldn't find details for this project.</p>
                            <button onclick="history.back()" class="btn-back">← Back</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>


            <div class="col-md-6 d-flex align-items-center justify-content-center h-100">
                <div class="product-style" data-aos="fade-left">
                    <?php if ($project): ?>
                        <img class="project-image" src="../<?= htmlspecialchars($project['posterPath']) ?>" alt="<?= htmlspecialchars($project['title']) ?> Image">
                    <?php else: ?>
                        <img class="project-image" src="../images/default.png" alt="Default Image">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800, 
            once: true     
        });
    </script>
    <script src="../js/dark-mode.js"></script>
</body>

</html>