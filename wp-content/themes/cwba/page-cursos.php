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

	<!-- ======= Portfolio Section ======= -->
	<section id="cursos" class="portfolio">
		<div id="grid-cursos" class="container" data-aos="fade-up">
			<?php
			$argsCat = array(
				'orderby'       => 'id',
				'order'         => 'ASC',
				'hide_empty'    => true
			);
			$categories = get_terms('product_cat', $argsCat);
			?>
			<div class="row" data-aos="fade-up" data-aos-delay="100">
				<div class="col-12">
					<input type="text" class="quicksearch" placeholder="Pesquisar Cursos" />
				</div>
				<h4>&nbsp;</h4>
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
			<br>
			<div class="row grid-cursos portfolio-container" data-aos="fade-up" data-aos-delay="200">

				<?php foreach ($categories as $category) {
					if ($category->slug != "sem-categoria") {
						$args = array(
							'post_type' => 'product',
							'product_cat' => $category->slug,
							'posts_per_page' => 100
						);
						$loop = new WP_Query($args);
						while ($loop->have_posts()) {
							$loop->the_post();
							$wc_product = new WC_product(get_the_ID());
							$array_images = $wc_product->get_gallery_image_ids();
				?>
							<div class="cursos-item col-lg-12 portfolio-item filter-<?php echo $category->slug; ?>">
								<div class="col-lg-4 col-cursos col-cursos1">
									<img src="<?php echo wp_get_attachment_url($array_images[0]); ?>" class="img-fluid" title="<?php echo get_the_title() ?>">

								</div>
								<div class="col-lg-8 col-cursos col-cursos2">
									<br><br>
									<a href="<?php the_permalink() ?>">
										<h4 class="center"><?php echo get_the_title() ?></h4>
									</a>
									<br>
									<a href="<?php the_permalink() ?>" class="btn-link" title="Link">Detalhes</a>
								</div>
							</div>
				<?php }
					}
				} ?>
			</div>
		</div>
	</section><!-- End Portfolio Section -->

</main><!-- End #main -->
<?php get_footer(); ?>