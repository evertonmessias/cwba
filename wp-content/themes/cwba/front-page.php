<?php get_header(); ?>

<?php
if (!is_user_logged_in()) {
	registerdb($_SERVER['REMOTE_ADDR']);
}
?>

<!-- ======= Hero Section ======= -->
<section id="hero">
	<div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">

		<ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

		<div class="carousel-inner" role="listbox">

			<!-- Slide 1 -->
			<div class="carousel-item active" style="background-image: url(<?php echo get_option('home_input_31'); ?>)">
				<div class="container">
					<h2><?php echo get_option('home_input_32'); ?></h2>
					<a href="<?php echo get_option('home_input_33'); ?>" class="btn-get-started scrollto">Leia Mais</a>
				</div>
			</div>
			<!-- End Slide1 -->

			<!-- Slide 2 -->
			<div class="carousel-item" style="background-image: url(<?php echo get_option('home_input_41'); ?>)">
				<div class="container">
					<h2><?php echo get_option('home_input_42'); ?></h2>
					<a href="<?php echo get_option('home_input_43'); ?>" class="btn-get-started scrollto">Leia Mais</a>
				</div>
			</div>
			<!-- End Slide2 -->

			<!-- Slide 3 -->
			<div class="carousel-item" style="background-image: url(<?php echo get_option('home_input_51'); ?>)">
				<div class="container">
					<h2><?php echo get_option('home_input_52'); ?></h2>
					<a href="<?php echo get_option('home_input_53'); ?>" class="btn-get-started scrollto">Leia Mais</a>
				</div>
			</div>
			<!-- End Slide3 -->

		</div>

		<a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
			<span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
		</a>

		<a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
			<span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
		</a>

	</div>
</section><!-- End Hero -->

<main id="main">

	<!-- ======= About Us Section ======= -->
	<section id="sobre" class="about section-bg">
		<div class="container" data-aos="fade-up">
			<div class="section-title">
				<h2>SOBRE</h2>
			</div>
			<div class="row">
				<div class="col-lg-6 align-items-stretch video-box" style='background-image: url("<?php echo get_option('home_input_6'); ?>");' data-aos="fade-right">
					<a href="<?php echo get_option('home_input_6_2'); ?>" class="venobox btn-watch-video" data-vbtype="video" data-autoplay="true"><i class="icofont-play-alt-2"></i></a>
				</div>
				<div class="col-lg-6 pt-4 pt-lg-0 content text-justify" data-aos="fade-left">
					<?php echo get_option('home_input_7'); ?>
				</div>
			</div>
		</div>
	</section><!-- End About Us Section -->

	<!-- ======= Product Section 1 ======= -->
	<section id="cursos" class="portfolio">
		<div class="container" data-aos="fade-up">
			<?php
			$argsCat = array(
				'orderby'       => 'id',
				'order'         => 'ASC'
			);
			$categories = get_terms('product_cat', $argsCat);
			foreach ($categories as $category) {
				$cat_portfolio[] = $category->slug;
			}
			?>

			<div class="section-title">
				<h2>CURSOS</h2>
			</div>

			<div class="row" data-aos="fade-up" data-aos-delay="100">
				<div class="col-lg-12 d-flex justify-content-center">
					<ul id="portfolio-flters" class="portfolio-ul">
						<a href="/cursos">
							<li class="filter-active">Todos</li>
						</a>
						<?php
						foreach ($categories as $category) {
							if ($category->slug != "sem-categoria") { ?>
								<li data-filter=".filter-<?php echo $category->slug; ?>"><?php echo $category->name; ?></li>
						<?php }
						} ?>
					</ul>
				</div>
			</div>

			<div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

				<?php foreach ($categories as $category) {
					$args = array(
						'post_type' => 'product',
						'product_cat' => $category->slug,
						'orderby' => 'id',
						'order' => 'ASC'
					);
					$loop = new WP_Query($args);
					while ($loop->have_posts()) {
						$loop->the_post();
						$wc_product = new WC_product(get_the_ID());
						$array_images = $wc_product->get_gallery_image_ids();
				?>
						<div class="col-lg-4 portfolio-item filter-<?php echo $category->slug; ?>">
							<img src="<?php echo wp_get_attachment_url($array_images[0]); ?>" class="img-fluid" title="<?php echo get_the_title() ?>">
							<div class="portfolio-info">
								<h4><?php echo get_the_title() ?></h4>
								<a class="btn-details" href="<?php the_permalink() ?>">QUERO CONHECER</a>
							</div>
						</div>
				<?php }
					wp_reset_postdata();
				} ?>
			</div>
		</div>
	</section><!-- End Portfolio Section -->

	<!-- ======= Counts Section ======= -->
	<section id="counts" class="counts">
		<div class="container">
			<div class="section-title">
				<h2>NÚMEROS</h2>
			</div>
		</div>
		<div class="container" data-aos="fade-up">

			<div class="row no-gutters">
				<?php
				$bloco_count1 = explode(',', get_option('home_input_8'));
				$bloco_count2 = explode(',', get_option('home_input_9'));
				$bloco_count3 = explode(',', get_option('home_input_10'));
				$bloco_count4 = explode(',', get_option('home_input_11'));
				$bloco_counts = array($bloco_count1, $bloco_count2, $bloco_count3, $bloco_count4);
				foreach ($bloco_counts as $bloco) {
					if ($bloco[0] != "" && $bloco[1] != "" && $bloco[2] != "") {
				?>
						<div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
							<div class="count-box">
								<i class="bx <?php echo $bloco[0]; ?>"></i>
								<span data-purecounter-start="0" data-purecounter-end="<?php echo $bloco[1]; ?>" data-purecounter-duration="1" class="purecounter"></span>
								<p><?php echo $bloco[2]; ?></p>
							</div>
						</div>
				<?php
					}
				} ?>

			</div>

		</div>
		<br><br>
	</section><!-- End Counts Section -->
	<br><br>

	<!-- ======= Cursos ======= -->
	<section class="gallery section-bg">
		<div class="container">
			<div class="section-title">
				<h2>BLOG</h2>
			</div>
		</div>
		<div class="container" data-aos="fade-up">
			<div class="gallery-slider swiper">
				<div class="swiper-wrapper align-items-center">

					<?php
					$args = array(
						'post_type' => 'post',
						'posts_per_page' => 10
					);
					$loop = new WP_Query($args);
					while ($loop->have_posts()) {
						$loop->the_post();
						if (has_post_thumbnail()) {
							$imagem = get_the_post_thumbnail_url(get_the_ID(), 'full');
						} else {
							$imagem = SITEPATH . "assets/img/semimagem.png";
						}
					?>

						<div class="swiper-slide">
							<a class="gallery-lightbox" href="<?php echo $imagem; ?>">
								<img src="<?php echo $imagem; ?>" class="img-fluid" title="<?php echo get_the_title() ?>">
							</a>
							<p><?php echo get_the_title() ?></p>
							<a href="<?php the_permalink(); ?>" class="btn-link" title="Link">Participar</a>
						</div>
					<?php }
					wp_reset_postdata();
					?>
				</div>
				<div class="swiper-pagination"></div>
			</div>

		</div>
	</section><!-- End Gallery Section -->

	<!-- ======= Contact Section ======= -->
	<section id="contact" class="contact">
		<div class="container">
			<div class="section-title">
				<h2>Contato</h2>
			</div>
		</div>
		<div class="container">

			<div class="row mt-5">

				<div class="col-lg-6">

					<div class="row">
						<div class="col-md-12">
							<div class="info-box">
								<i class="bx bx-map"></i>
								<h3>Endereço</h3>
								<p><?php echo get_option('home_input_14'); ?></p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="info-box mt-4">
								<i class="bx bx-envelope"></i>
								<h3>E-mail</h3>
								<p><?php echo get_option('home_input_13'); ?></p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="info-box mt-4">
								<i class="bx bx-phone-call"></i>
								<h3>Telefone</h3>
								<p><?php echo get_option('home_input_12'); ?></p>
							</div>
						</div>
					</div>

				</div>

				<div class="col-lg-6">
					<div class="php-email-form">
						<?php echo do_shortcode('[wpforms id="31"]'); ?>
					</div>
				</div>

			</div>

		</div>
		<div class="google-maps">
			<iframe style="border:0; width: 100%; height: 350px;" src="<?php echo get_option('home_input_15'); ?>" frameborder="0" allowfullscreen></iframe>
		</div>
	</section><!-- End Contact Section -->

</main><!-- End #main -->
<?php get_footer(); ?>