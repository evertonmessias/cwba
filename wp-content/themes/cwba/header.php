<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title><?php bloginfo() ?></title>
	<meta content="" name="description">
	<meta content="" name="keywords">

	<!-- Favicons -->
	<link href="<?php echo get_option('home_input_2'); ?>" rel="icon">

	<!-- Vendor CSS Files -->
	<link href="<?php echo SITEPATH; ?>assets/vendor/animate.css/animate.min.css" rel="stylesheet">
	<link href="<?php echo SITEPATH; ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo SITEPATH; ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="<?php echo SITEPATH; ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
	<link href="<?php echo SITEPATH; ?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
	<link href="<?php echo SITEPATH; ?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">	
	<link href="<?php echo SITEPATH; ?>assets/vendor/icofont/icofont.min.css" rel="stylesheet">
	<link href="<?php echo SITEPATH; ?>assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
	<link href="<?php echo SITEPATH; ?>assets/vendor/venobox/venobox.css" rel="stylesheet">
	<link href="<?php echo SITEPATH; ?>assets/vendor/aos/aos.css" rel="stylesheet">

	<!-- Template Main CSS File -->
	<link href="<?php echo SITEPATH; ?>assets/css/style.css" rel="stylesheet">
	<link href="<?php echo SITEPATH; ?>assets/css/cwba.css" rel="stylesheet">

	<?php wp_head(); ?>

</head>

<body>

	<!-- ======= Top Bar ======= -->
	<div id="topbar" class="d-none d-lg-flex align-items-center fixed-top <?php hide_admin_bar(); ?>">
		<div class="container d-flex">
			<div class="contact-info mr-auto">
				<a target="_blank" href="mailto:<?php echo get_option('home_input_13'); ?>"><i class="icofont-envelope"></i>&nbsp;<?php echo get_option('home_input_13'); ?></a>&emsp;
				<a target="_blank" href="https://api.whatsapp.com/send?phone=55<?php echo get_option('home_input_12'); ?>&text=cwba"><i class="bx bxl-whatsapp"></i>&nbsp;<?php echo get_option('home_input_12'); ?></a>
			</div>			
		</div>
		<div id="topforms">
				<div class="search-form"><?php echo get_search_form() ?></div>
		</div>
	</div>

	<!-- ======= Header ======= -->
	<header id="header" class="fixed-top <?php hide_admin_bar(); ?>">
		<div class="container d-flex align-items-center">

			<a href="/" class="logo me-auto"><img src="<?php echo get_option('home_input_2'); ?>" alt="">
				&nbsp;
				<span><?php echo get_option('home_input_0'); ?></span><br>
				<small><?php echo get_option('home_input_1'); ?></small>				
			</a>

			<nav id="navbar" class="navbar order-last order-lg-0">
				<ul>					
					<li><a class="nav-link scrollto" href="<?php if (!is_home()) echo '/'; ?>#sobre">Sobre</a></li>
					<li><a class="nav-link scrollto" href="/<?php if (is_home() || is_page('cursos')) echo '#'; ?>cursos">Cursos</a></li>
					<li><a class="nav-link scrollto" href="<?php if (!is_home()) echo '/'; ?>#contact">Contato</a></li>
				</ul>
				<i class="bi bi-list mobile-nav-toggle"></i>				
			</nav><!-- .navbar -->
			<a class="shop" href="/carrinho"><i class="bx bx-shopping-bag"></i></a>&emsp;
			<a class="shop" href="/wp-admin"><i class="bx bx-user"></i></a>
		</div>
	</header><!-- End Header -->