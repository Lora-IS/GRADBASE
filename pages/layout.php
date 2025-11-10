<?php
session_start();
$isLoggedIn = isset($_SESSION['user_name']);
$userName = $_SESSION['user_name'] ?? '';
?>

<div id="header-wrap">
  <!-- Top content -->
  <div class="top-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="right-element d-flex justify-content-end align-items-center gap-3">
            	<?php if ($isLoggedIn): ?>
                          <a href="profile.php" class="user-account for-buy">
                          <i class="icon icon-user"></i>
                           <span><?= htmlspecialchars($userName) ?></span>
                           </a>
                          <?php else: ?>
                         <a href="login.php" class="user-account for-buy">
                         <i class="icon icon-user"></i>
                          <span>Account</span>
                            </a>
                          <?php endif; ?>

            <div class="action-menu">
              <div class="search-bar">
                <a href="#" class="search-button search-toggle" data-selector="#header-wrap">
                  <i class="icon icon-search"></i>
                </a>
                <form role="search" method="get" class="search-box">
                  <input class="search-field text search-input" id="search-input" placeholder="Search" type="search">
                </form>
              </div>
            </div>

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
            <a href="index.html"><img src="../images/main-logo.png">
            </a>
          </div>
        </div>

        <div class="col-md-10">
          <nav id="navbar">
            <div class="main-menu stellarnav">
              <ul class="menu-list ms-0 me-auto">
                <li><a href="../index.html">Home</a></li>
                <li class="menu-item"><a href="projects.php">Graduation Projects</a></li>
                <li class="menu-item"><a href="Project_Template.html">Smart Report Guide</a></li>
                <li class="menu-item"><a href="templates/gradbot-access.php">GradBot</a></li>
               <li class="menu-item"><a href="submission.php">Upload Projects</a></li>
                <li class="menu-item"><a href="track_projects.php">Submission Tracker</a></li>
              </ul>

              <!-- زر الهامبرغر -->
              <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
              </div>
            </div>
          </nav>
        </div>


      </div>
    </div>
  </header>

</div><!--header-wrap-->


<footer id="footer">
  <div class="container">
    <div class="row">

      <div class="col-md-4">

        <div class="footer-item">
          <div class="company-brand">
            <img src="../images/main-logo.png" alt="logo" class="footer-logo">
            <p>GRADBASE is a digital archive for graduation projects,
								helping students explore, learn,
								and contribute to academic innovation.</p>
          </div>
        </div>

      </div>

      <div class="col-md-2">

        <div class="footer-menu">
          <h5>About Us</h5>
          <ul class="menu-list">
            <li class="menu-item">
              <a href="vision_Mission.html#vision">Vision</a>
            </li>
            <li class="menu-item">
              <a href="vision_Mission.html#mission">Mission</a>
            </li>
            <li class="menu-item">
              <a href="https://maps.app.goo.gl/3YP2PC8LhdHH8gUy5" target="_blank">Location</a>
            </li>
            <li class="menu-item">
              <a href="terms.html">service terms</a>
            </li>
          </ul>
        </div>

      </div>
      <div class="col-md-2">

        <div class="footer-menu">
          <h5>Discover</h5>
          <ul class="menu-list">
            <li class="menu-item">
              <a href="../index.html">Home</a>
            </li>
            <li class="menu-item">
              <a href="projects.html">Graduation Projects</a>
            </li>
            <li class="menu-item">
              <a href="saved.html">Saved Projects</a>
            </li>
            <li class="menu-item">
              <a href="assistant.html">GradBot</a>
            </li>
            <li class="menu-item">
              <a href="dashboard.html">Dashboard</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-2">

        <div class="footer-menu">
          <h5>My account</h5>
          <ul class="menu-list">
            <li class="menu-item">
              <a href="pages/login.html">Sign In</a>
            </li>
            <li class="menu-item">
              <a href="pages/saved.html">View saved</a>
            </li>
            <li class="menu-item">
              <a href="#">My Wishtlist</a>
            </li>
            <li class="menu-item">
              <a href="#">Track My Requast</a>
            </li>
          </ul>
        </div>

      </div>
      <div class="col-md-2">

        <div class="footer-menu">
          <h5>Help</h5>
          <ul class="menu-list">
            <li class="menu-item">
              <a href="help.html">Help center</a>
            </li>
            <li class="menu-item">
              <a href="report.html">Report a problem</a>
            </li>
            <li class="menu-item">
              <a href="suggest.html">Suggesting edits</a>
            </li>
            <li class="menu-item">
              <a href="contact.html">Contact us</a>
            </li>
          </ul>
        </div>

      </div>

    </div>
    <!-- / row -->

  </div>
</footer>

<div id="footer-bottom">
  <div class="container">
    <div class="row">
      <div class="col-md-12">

        <div class="copyright">
          <div class="row">

            <div class="col-md-6">
              <p>© 2025 All rights reserved. <a href="../index.html"
                  target="_blank">GRADBASE</a></p>
            </div>

            <div class="col-md-6">
              <div class="social-links align-right">
                <ul>
                  <li>
                    <a href="#"><i class="icon icon-facebook"></i></a>
                  </li>
                  <li>
                    <a href="#"><i class="icon icon-twitter"></i></a>
                  </li>
                  <li>
                    <a href="#"><i class="icon icon-youtube-play"></i></a>
                  </li>
                  <li>
                    <a href="#"><i class="icon icon-behance-square"></i></a>
                  </li>
                </ul>
              </div>
            </div>

          </div>
        </div><!--grid-->

      </div><!--footer-bottom-content-->
    </div>
  </div>
</div>




