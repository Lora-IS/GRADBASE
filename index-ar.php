<?php
session_start();
$isLoggedIn = isset($_SESSION['user_name']);
$userName = $_SESSION['user_name'] ?? '';
?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
	<title>E-library</title>
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
                                    <span>الحساب</span>
                                </a>
                            <?php endif; ?>

                            <div class="action-menu">
                                <div class="search-bar">
                                    <a href="#" class="search-button search-toggle" data-selector="#header-wrap">
                                        <i class="icon icon-search"></i>
                                    </a>
                                    <form role="search" method="get" class="search-box">
                                        <input class="search-field text search-input" placeholder="بحث" type="search">
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
        <div class="row flex-row-reverse">

            <div class="col-md-2">
                <div class="main-logo text-end">
                    <a href="index.php"><img src="images/main-logo.png" alt="الشعار"></a>
                </div>
            </div>

            <div class="col-md-10">
                <nav id="navbar">
                    <div class="main-menu stellarnav">
                     <ul class="menu-list-ar">
                            <li class="menu-item active"><a href="index-ar.php">الرئيسية</a></li>
                            <li class="menu-item"><a href="pages/projects.php">مشاريع التخرج</a></li>
                            <li class="menu-item"><a href="pages/Project_Template.html">نموذج مشروع التخرج</a></li>
                            <li class="menu-item"><a href="pages/templates/gradbot-access.php">جراد بوت</a></li>
                            <li class="menu-item"><a href="pages/submission.php">رفع المشاريع</a></li>
                            <li class="menu-item"><a href="pages/track_projects.php">متابعة الرفع</a></li>
                        </ul>

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
                                <p>منصة مكتبة رقمية مصممة لجامعة نجران لحفظ وإدارة ومشاركة مشاريع التخرج.
                                    يدعم النظام الوصول الثنائي اللغة (العربية/الإنجليزية)، والمساعدة المدعومة بالذكاء الاصطناعي، وإضافة العلامات، والتعليقات، وتقييم المشاريع.
                                    يهدف إلى حفظ الأعمال الأكاديمية، وتعزيز التعاون بين الطلاب وأعضاء هيئة التدريس، وتحسين الوصول لجميع المستخدمين بما فيهم ذوي الاحتياجات الخاصة.
                                </p>
                                <div class="btn-wrap">
                                    <a href="#" class="btn btn-outline-accent btn-accent-arrow" onclick="goToDetail('gradbase')">اقرأ المزيد<i class="icon icon-ns-arrow-right"></i></a>
                                </div>
                            </div>
                            <img src="images/main-banner1.png" alt="راية" class="banner-image">
                        </div>

                        <div class="slider-item">
                            <div class="banner-content">
                                <h2 class="banner-title">GCTS</h2>
                                <p>منصة إلكترونية تهدف إلى متابعة الخريجين وربطهم بفرص العمل.
                                    يسهل النظام التواصل بين الخريجين والجامعة والشركات من خلال مشاركة بيانات التوظيف ذات الصلة.
                                    يساعد الخريجين في العثور على وظائف مناسبة، ويدعم الجامعة في متابعة نتائج المسار المهني، ويمكّن الشركات من توظيف المرشحين المؤهلين بكفاءة.
                                </p>
                                <div class="btn-wrap">
                                    <a href="#" class="btn btn-outline-accent btn-accent-arrow" onclick="goToDetail('gcts')">اقرأ المزيد<i class="icon icon-ns-arrow-right"></i></a>
                                </div>
                            </div>
                            <img src="images/main-banner3.jpg" alt="راية" class="banner-image">
                        </div>

                    </div>

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
                            <a href="#"><img src="images/client-image1.png" alt="عميل"></a>
                            <a href="#"><img src="images/client-image2.png" alt="عميل"></a>
                            <a href="#"><img src="images/client-image3.png" alt="عميل"></a>
                            <a href="#"><img src="images/client-image4.png" alt="عميل"></a>
                            <a href="#"><img src="images/client-image5.png" alt="عميل"></a>
                        </div>
                    </div>
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
                            <span>بعض المشاريع المميزة</span>
                        </div>
                        <h2 class="section-title">مشاريع مختارة</h2>
                    </div>

                    <div class="product-list" data-aos="fade-up">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="product-item">
                                    <figure class="product-style">
                                        <img src="images/product-item1.png" alt="مشروع" class="product-item">
                                        <button type="button" class="add-to-cart" data-product-tile="add-to-cart" onclick="goToDetails('greenlife')">اقرأ المزيد</button>
                                    </figure>
                                    <figcaption>
                                        <h3>Greenlife</h3>
                                        <span>نظم المعلومات</span>
                                    </figcaption>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="product-item">
                                    <figure class="product-style">
                                        <img src="images/product-item2.png" alt="مشروع" class="product-item">
                                        <button type="button" class="add-to-cart" data-product-tile="add-to-cart" onclick="goToDetails('makkin')">اقرأ المزيد</button>
                                    </figure>
                                    <figcaption>
                                        <h3>Makkin</h3>
                                        <span>نظم المعلومات</span>
                                    </figcaption>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="product-item">
                                    <figure class="product-style">
                                        <img src="images/product-item3.png" alt="مشروع" class="product-item">
                                        <button type="button" class="add-to-cart" data-product-tile="add-to-cart" onclick="goToDetails('newsclassification')">اقرأ المزيد</button>
                                    </figure>
                                    <figcaption>
                                        <h3>News Classification</h3>
                                        <span>نظم المعلومات</span>
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
										<span>نظم المعلومات</span>

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
						<a href="pages/projects.php" class="btn-accent-arrow">عرض جميع المشاريع <i
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
                            <img src="images/main-banner1.png" alt="مشروع" class="single-image">
                        </figure>
                    </div>

                    <div class="col-md-6">
    <div class="product-entry">
        <h2 class="section-title divider">أفضل المشاريع</h2>

        <div class="products-content">
            <div class="author-name">بواسطة 1003</div>
            <h3 class="item-title">GRADBASE</h3>
            <p>منصة مكتبة رقمية ثنائية اللغة لجامعة نجران تقوم بحفظ وإدارة ومشاركة مشاريع التخرج — وتتميز بمساعدة الذكاء الاصطناعي، وإضافة العلامات، والتعليقات، وأدوات التقييم لتعزيز التعاون وضمان الوصول لجميع المستخدمين، بما فيهم ذوي الاحتياجات الخاصة.</p>

            <div class="btn-wrap">
                <a href="#" class="btn-accent-arrow" onclick="goToDetail('gradbase')">اقرأ الآن <i class="icon icon-ns-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>
</div><!-- / row -->
</div>
</div>
</div>
</section>

<section id="ai-assistant-promo" class="bookshelf pb-5 mb-5">
    <div class="section-header align-center">
        <div class="title">
            <span>رفيقك في مشروع التخرج</span>
        </div>
        <h2 class="section-title">جرّب مساعد الذكاء الاصطناعي</h2>
    </div>

    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="images/Gradbase.png" alt="مساعد الذكاء الاصطناعي" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <p class="lead">تواجه صعوبة في مشروع التخرج؟ دع مساعد الذكاء الاصطناعي يرشدك عبر:</p>
                <ul>
                    <li> توليد أفكار للمشروع</li>
                    <li> تنظيم هيكل التقرير</li>
                    <li> تحسين الكتابة والوضوح</li>
                    <li> اقتراح تحسينات</li>
                </ul>
                <div class="btn-wrap">
                    <a href="pages/templates/gradbot-access.php" class="btn btn-outline-accent btn-accent-arrow">ابدأ الآن<i class="icon icon-ns-arrow-right"></i></a>
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
                            <h2 class="section-title divider">اشترك في النشرة البريدية</h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="subscribe-content" data-aos="fade-up">
                            <p>احصل على إشعارات عند إضافة مشاريع تخرج جديدة، وتلقَّ أدوات ونصائح حصرية تساعدك في بناء مشروعك الخاص.</p>
                            <form id="form">
                                <input type="text" name="email" placeholder="أدخل بريدك الإلكتروني هنا">
                                <button class="btn-subscribe">
                                    <span>إرسال</span>
                                    <i class="icon icon-send"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="quotation" class="align-center pb-5 mb-5">
    <div class="inner-content">
        <h2 class="section-title divider">اقتباس اليوم</h2>
        <blockquote data-aos="fade-up">
            <q>“كلما قرأت أكثر، عرفت أكثر. كلما تعلمت أكثر، ذهبت إلى أماكن أكثر.”</q>
            <div class="author-name">د. سوس</div>
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
                            <img src="images/device.png" alt="هاتف" class="single-image">
                        </figure>
                    </div>
                    <div class="col-md-7">
                        <div class="app-info">
                            <h2 class="section-title divider">قريبًا!</h2>
                            <p>الوصول إلى مئات مشاريع التخرج والقوالب والأدوات — كلها في تطبيق واحد.
                                سواء كنت تبحث عن الإلهام أو تبني مشروعك الخاص،
                                تجربتنا على الجوال تجعل الأمر أسهل من أي وقت مضى.</p>
                            <div class="google-app">
                                <img src="images/google-play.jpg" alt="جوجل بلاي">
                                <img src="images/app-store.jpg" alt="آب ستور">
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
                        <img src="../images/main-logo.png" alt="الشعار" class="footer-logo">
                        <p>GRADBASE هو أرشيف رقمي لمشاريع التخرج، يساعد الطلاب على الاستكشاف والتعلم والمساهمة في الابتكار الأكاديمي.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="footer-menu">
                    <h5>من نحن</h5>
                    <ul class="menu-list">
                        <li class="menu-item"><a href="pages/vision_Mission-ar.html#vision">الرؤية</a></li>
                        <li class="menu-item"><a href="pages/vision_Mission-ar.html#mission">الرسالة</a></li>
                        <li class="menu-item"><a href="https://maps.app.goo.gl/3YP2PC8LhdHH8gUy5" target="_blank">الموقع</a></li>
                        <li class="menu-item"><a href="pages/terms-ar.html">شروط الخدمة</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-2">
                <div class="footer-menu">
                    <h5>استكشاف</h5>
                    <ul class="menu-list">
                        <li class="menu-item"><a href="index.php">الرئيسية</a></li>
                        <li class="menu-item"><a href="pages/projects.html">مشاريع التخرج</a></li>
                        <li class="menu-item"><a href="pages/saved.html">المشاريع المحفوظة</a></li>
                        <li class="menu-item"><a href="pages/assistant.html">جراد بوت</a></li>
                        <li class="menu-item"><a href="pages/dashboard.html">لوحة التحكم</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-2">
                <div class="footer-menu">
                    <h5>حسابي</h5>
                    <ul class="menu-list">
                        <li class="menu-item"><a href="pages/login.html">تسجيل الدخول</a></li>
                        <li class="menu-item"><a href="pages/saved.html">عرض المحفوظات</a></li>
                        <li class="menu-item"><a href="#">قائمة الأمنيات</a></li>
                        <li class="menu-item"><a href="#">تتبع الطلب</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-2">
                <div class="footer-menu">
                    <h5>المساعدة</h5>
                    <ul class="menu-list">
                        <li class="menu-item"><a href="pages/help-ar.html">مركز المساعدة</a></li>
                        <li class="menu-item"><a href="pages/report-ar.html">الإبلاغ عن مشكلة</a></li>
                        <li class="menu-item"><a href="pages/suggest-ar.html">اقتراح تعديل</a></li>
                        <li class="menu-item"><a href="pages/contact-ar.html">اتصل بنا</a></li>
                    </ul>
                </div>
            </div>

        </div><!-- / row -->
    </div>
</footer>

<div id="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="copyright">
                    <div class="row">

                        <div class="col-md-6">
                            <p>© 2025 جميع الحقوق محفوظة. <a href="index.html" target="_blank">GRADBASE</a></p>
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
    <img src="../icomoon/accessibility_new.svg" alt="أدوات الوصول">
</div>

<!-- لوحة أدوات الوصول -->
<div id="accessibility-panel" class="accessibility-panel">
    <button onclick="startSpeech()">بدء القراءة</button>
    <button onclick="stopSpeech()">إيقاف القراءة</button>
    <button onclick="toggleDarkMode()">تباين فاتح/داكن</button>
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
		const menuLinks = document.querySelectorAll(".menu-list-ar a");

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
	</script>

</body>

</html>

