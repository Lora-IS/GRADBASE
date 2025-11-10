<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
  $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
  header("Location: http://localhost:8000/pages/login.php");

  exit();
}


$isLoggedIn = true;
$userName = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" href="../../icomoon/icomoon.css">
    <link rel="stylesheet" href="../../css/vendor.css">
    <link rel="stylesheet" href="../../style.css">
    <link rel="stylesheet" href="../static/style.css">
</head>
<body>

         <div id="header-wrap">
  <!-- Top content -->
  <div class="top-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="right-element d-flex justify-content-end align-items-center gap-3">
            	<?php if ($isLoggedIn): ?>
                          <a href="../profile.php" class="user-account for-buy">
                          <i class="icon icon-user"></i>
                           <span><?= htmlspecialchars($userName) ?></span>
                           </a>
                          <?php else: ?>
                         <a href="pages/login.php" class="user-account for-buy">
                         <i class="icon icon-user"></i>
                          <span>Account</span>
                            </a>
                          <?php endif; ?>
          </div><!--right-element-->
        </div>
      </div>
    </div>
  </div><!--top-content-->
      <!-- Main header -->
  <header id="header">
    <div class="container-fluid">
      <div class="row">

        <div class="col-md-2">
          <div class="main-logo">
            <a href="../../index.php"><img src="../../images/Gradbase.png">
            </a>
          </div>
        </div>

        <div class="col-md-10">
          <nav id="navbar">
            <div class="main-menu stellarnav">
              <ul class="menu-list ms-0 me-auto">
                <li><a href="../../index.php">Home</a></li>
                <li class="menu-item"><a href="#suggest-section">Suggestions</a></li>
                <li class="menu-item"><a href="#develop-section">Chatbot</a></li>

              </ul>

            </div>
          </nav>
        </div>


      </div>
    </div>
                          </header>

    <section id="suggest-section" class="suggest-wrapper">
    <div class="suggest-container">
     <!-- نافذة اختيار اللغة -->
<div id="languageModal" class="modal d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4">
      <h5 class="mb-3">🌐 Please select your language</h5>
      <button class="custom-lang-btn mb-2" onclick="selectLang('ar')">العربية</button>
      <button class="custom-lang-btn" onclick="selectLang('en')">English</button>
        <input type="hidden" id="lang-input" value="">
    </div>
  </div> 
</div>
    <h2 class="mb-4">💡 Suggest Project Ideas</h2>

    <div class="form-group mb-4">
      <label for="category" class="form-label fw-bold">Choose the domain:</label>
      <select id="category" name="category" class="form-select">
      <!-- الخيارات راح تنضاف تلقائيًا -->
      </select>

    </div>

    <button id="generate-btn" onclick="generate()">
       Generate Ideas
    </button>

    <div id="result" class="mt-4 p-3 border rounded bg-light"></div>
  </div>
</section>





    <!-- القسم: تطوير المشروع -->
    <section id="develop-section" style="display: none;">
        <div class="container">

            <!-- العنوان -->
            <h2 style="text-align: center;"> Develop your ideas </h2>

            <!-- صندوق المحادثة -->
            <div id="chatBox" class="chat-box">
                <!-- الرسائل تظهر هنا -->
            </div>

            <!-- الإدخال + زر الإرسال -->
            <div class="input-row">
                <input type="text" id="userMessage" placeholder="write your message here..." />
                <button onclick="chat()" class="send-btn">
                    <img src="../static/icons/send.svg" alt="Send" width="24" height="24">
                </button>

            </div>
        </div>
    </section>

    <!-- ربط ملف الجافا سكربت -->
   <script src="../static/script.js"></script>

</body>
</html>