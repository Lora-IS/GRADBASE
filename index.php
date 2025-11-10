<?php
session_start();
$isLoggedIn = isset($_SESSION['user_name']);
$userName = $_SESSION['user_name'] ?? '';
?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
	<title>GRADBASE</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="author" content="">
	<meta name="keywords" content="">
	<meta name="description" content="">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="icomoon/icomoon.css">
	<link rel="stylesheet" type="text/css" href="css/vendor.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="css/dark-mode.css">

</head>

<body data-bs-spy="scroll" data-bs-target="#header" tabindex="0">

	<div id="header-wrap">
		<div class="top-content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="right-element d-flex justify-content-end align-items-center gap-3">
							<?php if ($isLoggedIn): ?>
                          <a href="pages/profile.php" class="user-account for-buy">
                          <i class="icon icon-user"></i>
                           <span><?= htmlspecialchars($userName) ?></span>
                           </a>
                          <?php else: ?>
                         <a href="pages/login.php" class="user-account for-buy">
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
										<input class="search-field text search-input" id="search-input" placeholder="Search"
											type="search">
									</form>
								</div>
							</div>

						</div><!--right-element-->
					</div>
				</div>
			</div>
		</div><!--top-content-->


		<header id="header">
			<div class="container-fluid">
				<div class="row">

					<div class="col-md-2">
						<div class="main-logo">
							<a href="index.php"><img src="images/main-logo.png" alt="logo"></a>
						</div>

					</div>

					<div class="col-md-10">
						<nav id="navbar">
							<div class="main-menu stellarnav">
								<ul class="menu-list ms-0 me-auto">
									<li class="menu-item active"><a href="index.php">Home</a></li>
									<li class="menu-item"><a href="pages/projects.php">Graduation Projects</a></li>
									<li class="menu-item"><a href="pages/Project_Template.html">Smart Report Guide</a></li>
									<li class="menu-item"><a href="pages/templates/gradbot-access.php">GradBot</a></li>
									<li class="menu-item"><a href="pages/submission.php">Upload Projects</a></li>
									<li class="menu-item"><a href="pages/track_projects.php">Submission Tracker</a></li>
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

	<section id="billboard">

		<div class="container">
			<div class="row">
				<div class="col-md-12">

					<button class="prev slick-arrow">
						<i class="icon icon-arrow-left"></i>
					</button>

					<div class="main-slider pattern-overlay">
						<div class="slider-item">
							<div class="banner-content">
								<h2 class="banner-title">GRADBASE</h2>
								<p>A digital library platform designed for Najran University to store, manage, and share
									graduation projects.
									The system supports bilingual access (Arabic/English), AI-powered assistance,
									bookmarking, commenting, and project evaluation.
									It aims to preserve academic work, enhance collaboration among students and faculty,
									and improve accessibility for all users, including those with special needs.</p>
								<div class="btn-wrap">
									<a href="#" class="btn btn-outline-accent btn-accent-arrow" onclick="goToDetail('gradbase')">Read More<i
											class="icon icon-ns-arrow-right"></i></a>
								</div>
							</div><!--banner-content-->
							<img src="images/main-banner1.png" alt="banner" class="banner-image">
						</div><!--slider-item-->

						<div class="slider-item">
							<div class="banner-content">
								<h2 class="banner-title">GCTS</h2>
								<p>A web-based platform designed to track graduates and connect them with job
									opportunities.
									The system facilitates communication between graduates, the university,
									and companies by sharing relevant employment data. It helps graduates find suitable
									jobs,
									supports the university in monitoring career outcomes,
									and enables companies to recruit qualified candidates effectively.</p>
								<div class="btn-wrap">
									<a href="#" class="btn btn-outline-accent btn-accent-arrow"onclick="goToDetail('gcts')">Read More<i
											class="icon icon-ns-arrow-right"></i></a>
								</div>
							</div><!--banner-content-->
							<img src="images/main-banner3.jpg" alt="banner" class="banner-image">
						</div><!--slider-item-->

					</div><!--slider-->

					<button class="next slick-arrow">
						<i class="icon icon-arrow-right"></i>
					</button>

				</div>
			</div>
		</div>

	</section>

	<section id="client-holder" data-aos="fade-up">
		<div class="container">
			<div class="row">
				<div class="inner-content">
					<div class="logo-wrap">
						<div class="grid">
							<a href="#"><img src="images/client-image1.png" alt="client"></a>
							<a href="#"><img src="images/client-image2.png" alt="client"></a>
							<a href="#"><img src="images/client-image3.png" alt="client"></a>
							<a href="#"><img src="images/client-image4.png" alt="client"></a>
							<a href="#"><img src="images/client-image5.png" alt="client"></a>
						</div>
					</div><!--image-holder-->
				</div>
			</div>
		</div>
	</section>

	<section id="featured-books" class="py-5 my-5">
		<div class="container">
			<div class="row">
				<div class="col-md-12">

					<div class="section-header align-center">
						<div class="title">
							<span>Some quality Projects</span>
						</div>
						<h2 class="section-title">Featured Projects</h2>
					</div>

					<div class="product-list" data-aos="fade-up">
						<div class="row">

							<div class="col-md-3">
								<div class="product-item">
									<figure class="product-style">
										<img src="images/product-item1.png" alt="Projects" class="product-item">
										<button type="button" class="add-to-cart" data-product-tile="add-to-cart" onclick="goToDetails('greenlife')">Read
											More
										</button>
									</figure>
									<figcaption>
										<h3>Greenlife</h3>
										<span>Information System</span>

									</figcaption>
								</div>
							</div>

							<div class="col-md-3">
								<div class="product-item">
									<figure class="product-style">
										<img src="images/product-item2.png" alt="Books" class="product-item">
										<button type="button" class="add-to-cart" data-product-tile="add-to-cart" onclick="goToDetails('makkin')">Read
											More
										</button>
									</figure>
									<figcaption>
										<h3>Makkin</h3>
										<span>Information System</span>

									</figcaption>
								</div>
							</div>

							<div class="col-md-3">
								<div class="product-item">
									<figure class="product-style">
										<img src="images/product-item3.png" alt="Books" class="product-item">
										<button type="button" class="add-to-cart" data-product-tile="add-to-cart"  onclick="goToDetails('newsclassification')">Read
											More
										</button>
									</figure>
									<figcaption>
										<h3>News classIfication</h3>
										<span>Information System</span>

									</figcaption>
								</div>
							</div>

							<div class="col-md-3">
								<div class="product-item">
									<figure class="product-style">
										<img src="images/product-item4.png" alt="Books" class="product-item">
										<button type="button" class="add-to-cart" data-product-tile="add-to-cart"  onclick="goToDetails('hewarsamet')">Read
											More
										</button>
									</figure>
									<figcaption>
										<h3>Hewar Samet</h3>
										<span>Information System</span>

									</figcaption>
								</div>
							</div>

						</div><!--ft-books-slider-->
					</div><!--grid-->


				</div><!--inner-content-->
			</div>

			<div class="row">
				<div class="col-md-12">

					<div class="btn-wrap align-right">
						<a href="pages/projects.php" class="btn-accent-arrow">View all Projects <i
								class="icon icon-ns-arrow-right"></i></a>
					</div>

				</div>
			</div>
		</div>
	</section>

	<section id="best-selling" class="leaf-pattern-overlay">
		<div class="corner-pattern-overlay"></div>
		<div class="container">
			<div class="row justify-content-center">

				<div class="col-md-8">

					<div class="row">

						<div class="col-md-6">
							<figure class="products-thumb">
								<img src="images/main-banner1.png" alt="project" class="single-image">
							</figure>
						</div>

						<div class="col-md-6">
							<div class="product-entry">
								<h2 class="section-title divider">Best Projects</h2>

								<div class="products-content">
									<div class="author-name">By 1003</div>
									<h3 class="item-title">GRADBASE</h3>
									<p>A bilingual digital library platform for Najran University that stores, manages,
										and shares graduation
										projects—featuring AI assistance, bookmarking, commenting, and evaluation tools
										to foster
										collaboration and ensure accessibility for all users, including those with
										special needs.</p>

									<div class="btn-wrap">
										<a href="#" class="btn-accent-arrow" onclick="goToDetail('gradbase')">read it now <i
												class="icon icon-ns-arrow-right"></i></a>
									</div>
								</div>

							</div>
						</div>

					</div>
					<!-- / row -->

				</div>

			</div>
		</div>
	</section>

	<section id="ai-assistant-promo" class="bookshelf pb-5 mb-5">
		<div class="section-header align-center">
			<div class="title">
				<span>Your Graduation Companion</span>
			</div>
			<h2 class="section-title">Try the AI Assistant</h2>
		</div>

		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6">
					<img src="images/Gradbase.png" alt="AI Assistant" class="img-fluid rounded">
				</div>
				<div class="col-md-6">
					<p class="lead">Struggling with your graduation project? Let our AI assistant guide you through:</p>
					<ul>
						<li> Brainstorming project ideas</li>
						<li> Structuring your report</li>
						<li> Improving writing and clarity</li>
						<li> Suggesting enhancements</li>
					</ul>
					<!--<a href="login.html" class="btn btn-primary mt-3"></a> -->
					<div class="btn-wrap">
						<a href= "pages/templates/gradbot-access.php" class="btn btn-outline-accent btn-accent-arrow">get started<i
								class="icon icon-ns-arrow-right"></i></a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="subscribe">
		<div class="container">
			<div class="row justify-content-center">

				<div class="col-md-8">
					<div class="row">

						<div class="col-md-6">

							<div class="title-element">
								<h2 class="section-title divider">Subscribe to our newsletter</h2>
							</div>

						</div>
						<div class="col-md-6">

							<div class="subscribe-content" data-aos="fade-up">
								<p>Get notified when new graduation projects are added, and receive exclusive
									tools and tips to help you build your own.</p>
								<form id="form" action="pages/subscribe.php" method="post" novalidate>
  <input
    type="text"
    name="email"
    placeholder="Enter your email addresss here"
    inputmode="email"
    pattern="^[^@\s]+@[^@\s]+\.[^@\s]+$"
    required
    aria-label="Email"
  >

  <!-- Honeypot -->
  <input
    type="text"
    name="company"
    autocomplete="off"
    tabindex="-1"
    aria-hidden="true"
    style="position:absolute;left:-9999px;"
  >

  <button type="submit" class="btn-subscribe">
    <span>send</span>
    <i class="icon icon-send"></i>
  </button>
</form>

<div id="subscribe-msg" role="status" aria-live="polite"></div>

							</div>

						</div>

					</div>
				</div>

			</div>
		</div>
	</section>


	<section id="quotation" class="align-center pb-5 mb-5">
		<div class="inner-content">
			<h2 class="section-title divider">Quote of the day</h2>
			<blockquote data-aos="fade-up">
				<q>“The more that you read, the more things you will know. The more that you learn, the more places
					you’ll go.”</q>
				<div class="author-name">Dr. Seuss</div>
			</blockquote>
		</div>
	</section>

	<section id="download-app" class="leaf-pattern-overlay">
		<div class="corner-pattern-overlay"></div>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8">
					<div class="row">

						<div class="col-md-5">
							<figure>
								<img src="images/device.png" alt="phone" class="single-image">
							</figure>
						</div>

						<div class="col-md-7">
							<div class="app-info">
								<h2 class="section-title divider">Coming Soon!</h2>
								<p>Access hundreds of graduation projects, templates, and tools—all in one app.
									Whether you're browsing for inspiration or building your own masterpiece,
									our mobile experience makes it easier than ever.</p>
								<div class="google-app">
									<img src="images/google-play.jpg" alt="google play">
									<img src="images/app-store.jpg" alt="app store">
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>

	<footer id="footer">
		<div class="container">
			<div class="row">

				<div class="col-md-4">

					<div class="footer-item">
						<div class="company-brand">
							<img src="images/main-logo.png" alt="logo" class="footer-logo">
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
								<a href="pages/vision_Mission.html#vision">Vision</a>
							</li>
							<li class="menu-item">
								<a href="pages/vision_Mission.html#mission">Mission</a>
							</li>
							<li class="menu-item">
								<a href="https://maps.app.goo.gl/3YP2PC8LhdHH8gUy5" target="_blank">Location</a>
							</li>
							<li class="menu-item">
								<a href="pages/terms.html">service terms</a>
							</li>
						</ul>
					</div>

				</div>
				<div class="col-md-2">

					<div class="footer-menu">
						<h5>Discover</h5>
						<ul class="menu-list">
							<li class="menu-item">
								<a href="index.php">Home</a>
							</li>
							<li class="menu-item">
								<a href="pages/projects.php">Graduation Projects</a>
							</li>
							<li class="menu-item">
								<a href="pages/submission.php">Upload Projects</a>
							</li>
							<li class="menu-item">
								<a href="pages/templates/gradbot-access.php">GradBot</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-md-2">

					<div class="footer-menu">
						<h5>My account</h5>
						<ul class="menu-list">
							<li class="menu-item">
								<a href="pages/login.php">Sign In</a>
							</li>
							<li class="menu-item">
								<a href="pages/track_projects.php">Submission Tracker</a>
							</li>
							<li class="menu-item">
								<a href="pages/Project_Template.html">Smart Report Guide</a>
							</li>

						</ul>
					</div>
				</div>
				<div class="col-md-2">

					<div class="footer-menu">
						<h5>Help</h5>
						<ul class="menu-list">
							<li class="menu-item">
								<a href="pages/help.html">Help center</a>
							</li>
							<li class="menu-item">
								<a href="pages/report.html">Report a problem</a>
							</li>
							<li class="menu-item">
								<a href="pages/suggest.html">Suggesting edits</a>
							</li>
							<li class="menu-item">
								<a href="pages/contact.html">Contact us</a>
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
								<p>© 2025 All rights reserved. <a href="index.php" target="_blank">GRADBASE</a></p>
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
	<!-- زر الوصول الثابت -->
	<div class="accessibility-toggle" onclick="toggleAccessibilityPanel()">
		<img src="../icomoon/accessibility_new.svg" alt="">
	</div>

	<!-- لوحة أدوات الوصول -->
	<div id="accessibility-panel" class="accessibility-panel">
		<button onclick="startSpeech()">Start Reading</button>
        <button onclick="stopSpeech()">Stop Reading</button>
		<button onclick="toggleDarkMode()">Light Contrast/Dark Contrast</button>
		<button onclick="changeFontSize(1)">A+</button>
		<button onclick="changeFontSize(-1)">A−</button>
		<button onclick="window.location.href='index-ar.php'">العربية</button>
		<button onclick="window.location.href='index.php'">English</button>
	</div>

	<script src="js/jquery-1.11.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
		crossorigin="anonymous"></script>
	<script src="js/plugins.js"></script>
	<script src="js/script.js"></script>
    <script src="js/acess.js"></script>
    <script src="js/dark-mode.js"></script>
	<script>
		const currentPage = window.location.pathname.split("/").pop();
		const menuLinks = document.querySelectorAll(".menu-list a");

		menuLinks.forEach(link => {
			const href = link.getAttribute("href").split("/").pop();
			if (href === currentPage) {
				link.classList.add("active");
			}
		});
		 function goToDetails(projectKey) {
         window.location.href = `pages/project-details.php?project=${projectKey}`;
         }
		  function goToDetail(projectKey) {
         window.location.href = `pages/project-full.php?project=${projectKey}`;
         }
	</script>
		<script src="js/language-preference.js"></script>
	   <script>
  // Set English preference when index page loads
  if (window.LanguagePreference) {
    window.LanguagePreference.set('en');
  }

  // زر البحث
  document.querySelector('.search-button').addEventListener('click', function(e) {
    e.preventDefault(); // يمنع الانتقال للرابط #

    const queryInput = document.querySelector('#search-input');
    const query = queryInput ? queryInput.value.trim() : '';

    if (query) {
      window.location.href = `pages/projects.php?query=${encodeURIComponent(query)}`;
    } else {
      alert('Please enter a search term.');
    }
  });

  // الضغط على Enter داخل حقل البحث
  document.querySelector('#search-input').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
      e.preventDefault();
      document.querySelector('.search-button').click();
    }
  });
</script>
<script>
(function () {
  const params = new URLSearchParams(location.search);
  const status = params.get('subscribed');
  if (!status) return;
  const box = document.getElementById('subscribe-msg');
  const map = {
    ok: 'Subscribed! Check your inbox soon.',
    bad_email: '❌ Please enter a valid email.',
    bot: '❌ Submission blocked.',
    invalid: '❌ Invalid request.',
  };
  box.textContent = map[status] || '';
})();
</script>

</body>

</html>


