<?php get_header(); ?>
<main id="main" class="post" data-aos="fade-up">

<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
		<div class="container">
			<div class="d-flex justify-content-between align-items-center">
				<h2>cursos</h2>
				<ol>
					<li><a href="/">home</a></li>
					<li>
						<?php
						if (url_active()[2] == "") echo url_active()[1];
						else echo "<a href='/" . url_active()[1] . "'>" . url_active()[1] . "</a>";
						?>
					</li>
					<!--<li>
            <?php //if (url_active()[2] != "") echo url_active()[2]; 
			?>
          </li>-->
				</ol>
			</div>
		</div>
	</section><!-- Breadcrumbs Section -->

	<!-- ======= BLOG ======= -->
	<section id="blog" class="portfolio section-bg">
		<div class="container" data-aos="fade-up">

			<div class="section-title">
				<h2>BLOG</h2>
			</div>

			<div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

				<?php
				$args = array(
					'post_type' => 'post',
					'posts_per_page' => 20
				);
				$loop = new WP_Query($args);
				while ($loop->have_posts()) {
					$loop->the_post();
					if (has_post_thumbnail()) {
						$imagem = get_the_post_thumbnail_url(get_the_ID(),'full');
					} else {
						$imagem = SITEPATH . "assets/img/semimagem.png";
					}
				?>
					<div class="col-lg-4 portfolio-item">
						<img src="<?php echo $imagem; ?>" class="img-fluid" title="<?php echo get_the_title() ?>">
						<div class="portfolio-info">
							<a href="<?php the_permalink() ?>">
								<h4><?php the_title() ?></h4>
							</a>
							<a href="<?php echo $imagem; ?>" data-gall="portfolioGallery" class="venobox preview-link" title="<?php echo get_the_title() ?>"><i class="bx bx-search"></i></a>
							<a href="<?php the_permalink() ?>" class="details-link" title="Link"><i class="bx bx-link"></i></a>
						</div>
					</div>
				<?php }
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section><!-- End Portfolio Section -->

</main><!-- End #main -->
<h1>&nbsp;</h1>
<?php get_footer(); ?>