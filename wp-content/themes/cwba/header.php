<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title><?php bloginfo() ?></title>
	<meta content="" name="description">
	<meta content="" name="keywords">

	<!-- Favicons -->
	<link href="<?php echo get_option('portal_input_1'); ?>" rel="icon">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

	<!-- Vendor CSS Files -->
	<link href="<?php echo SITEPATH; ?>assets/vendor/animate.css/animate.min.css" rel="stylesheet">
	<link href="<?php echo SITEPATH; ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo SITEPATH; ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="<?php echo SITEPATH; ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
	<link href="<?php echo SITEPATH; ?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
	<link href="<?php echo SITEPATH; ?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">	
	<link href="<?php echo SITEPATH; ?>assets/vendor/icofont/icofont.min.css" rel="stylesheet">
	<link href="<?php echo SITEPATH; ?>assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
	<link href="<?php echo SITEPATH; ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
	<link href="<?php echo SITEPATH; ?>assets/vendor/venobox/venobox.css" rel="stylesheet">
	<link href="<?php echo SITEPATH; ?>assets/vendor/aos/aos.css" rel="stylesheet">

	<!-- Template Main CSS File -->
	<link href="<?php echo SITEPATH; ?>assets/css/style.css" rel="stylesheet">

	<?php wp_head(); ?>

</head>

<body>
	<!-- ======= Header ======= -->
	<header id="header" class="fixed-top d-flex align-items-center <?php if (is_user_logged_in() && !current_user_can('aluno')) echo "user-logged"; ?> <?php if (!is_front_page()) echo "header-pages"; ?>">
		<div class="container d-flex align-items-center">
			<a href="/" class="logo me-auto <?php if (!is_front_page()) echo 'logo-silver'; ?>"><img src="<?php echo get_option('portal_input_1'); ?>" title="logo">
			&ensp;<span><?php echo get_option('portal_input_0'); ?></span>
			</a>

			<nav id="navbar" class="navbar order-last order-lg-0">
				<ul>
					<li ><a class="nav-link scrollto <?php if (is_front_page()) echo 'active'; ?>" href="/#hero">Inicio</a></li>
					<li><a class="nav-link scrollto" href="/#sobre">Sobre</a></li>
					<li><a class="nav-link scrollto" href="/#contato">Contato</a></li>					
					<li><a class="nav-link scrollto" href="/aulas">Aulas</a></li>
				</ul>
				<i class="bi bi-list mobile-nav-toggle"></i>
			</nav><!-- .navbar -->
			<?php if (is_user_logged_in()){
				echo '<a class="login-aluno" title="Logout" href="/wp-login.php?action=logout"><i class="ri-user-unfollow-line"></i></a>';		
			}else{
				echo '<a class="login-aluno" title="Login" href="/wp-admin"><i class="ri-user-line"></i></a>';
			}
			?>
		</div>
	</header><!-- End Header -->