<?php if (!is_user_logged_in()) {
	$url = get_home_url() . '/wp-admin';
	wp_redirect($url);
	exit();
} else {
	get_header();
} ?>

<main id="main" class="post" data-aos="fade-up">
	<!-- ======= Breadcrumbs ======= -->
	<section class="breadcrumbs">
		<div class="container">
			<div class="d-flex justify-content-between align-items-center">
				<h2><strong>Aulas</strong></h2>
				<ol>
					<li><a href="/">home</a></li>&ensp;/&ensp;
					<li><?php echo url_active()[1]; ?></li>
				</ol>
			</div>
		</div>
	</section><!-- End Breadcrumbs -->

	<section id="aulas" class="portfolio aulas">
		<div class="container" data-aos="fade-up">
			<div class="row">
				<div class="col-lg-9 entries">

					<div id="grid-aulas" class="container" data-aos="fade-up">
						<?php
						$argt = array(
							'orderby' => 'title',
							'order' => 'ASC'
						);
						$categories = get_terms('category', $argt);
						?>
						<div class="row" data-aos="fade-up" data-aos-delay="100">
							<div class="col-12">
								<input type="text" class="quicksearch" placeholder="Filtrar" />
							</div>
						</div>
						<br>
						<?php foreach ($categories as $category) { ?>
							<div id="<?php echo $category->slug; ?>" class="row grid-aulas portfolio-container">
								<h3 class="title-cat"><?php echo $category->name . " - " . $category->description; ?></h3>
								<?php
								$args = array(
									'post_type' => 'post',
									'category_name' => $category->slug,
									'posts_per_page' => 100,
									'orderby' => 'title',
									'order' => 'ASC'
								);
								$loop = new WP_Query($args);
								foreach ($loop->posts as $post) {
									$vid = get_post_meta($post->ID, 'post_video', true);
								?>
									<div class="aulas-item col-lg-12 portfolio-item">
										<div class="row">
											<div class="col-lg-12">
												<?php if($vid != ""){ ?>
												<a href="<?php echo get_the_permalink() ?>" class="details-link" title="Link">
													<?php echo $post->post_title; ?>
												</a>
												<a href="https://youtu.be/<?php echo $vid; ?>" class="venobox ico-play" title="Play" data-vbtype="video" data-autoplay="true"><i class="ri-video-line"></i></a>
												<?php }else{ ?>
													<?php echo $post->post_title; ?>
												<?php } ?>
											</div>
										</div>
									</div>
								<?php }
								wp_reset_postdata(); ?>
							</div>
						<?php }
						?>
					</div>

				</div>

				<div class="col-lg-3">
					<div class="sidebar">
						<h3 class="sidebar-title">Busca</h3>

						<div class="sidebar-item search-form search">
							<form action="/" method="get">
								<input type="text" placeholder="Pesquisar" required name="s" id="search" value="<?php the_search_query(); ?>" />
								<button type="submit"><i class="bi bi-search"></i></button>
							</form>
						</div><!-- End sidebar search formn-->

						<h3 class="sidebar-title">Categorias</h3>
						<div class="sidebar-item categories">
							<ul>
								<?php
								$args = array(
									'orderby' => 'name',
									'order' => 'ASC',
									'parent' => 0
								);
								$categories = get_categories($args);
								foreach ($categories as $category) {
									if ($category->slug != "sem-categoria") {
										echo '<li><a class="getstarted empty" href="/aulas/' . $category->slug . '">' . $category->name . ' <span>(' . $category->count . ')</span></a></li>';
									}
								}
								?>
							</ul>
						</div><!-- End sidebar categories-->

					</div><!-- End blog sidebar -->

				</div>

			</div>
		</div>
	</section>
</main><!-- End #main -->
<?php get_footer(); ?>