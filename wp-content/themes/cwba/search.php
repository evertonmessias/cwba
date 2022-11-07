<?php if (!is_user_logged_in()) {
	$url = get_home_url() . '/wp-admin';
	wp_redirect($url);
	exit();
} else {
	get_header();
} ?>

<?php $s = get_search_query(); ?>

<main id="main" class="post" data-aos="fade-up">
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Busca: <?php echo $s ?></h2>
            </div>
        </div>
    </section><!-- End Breadcrumbs -->

    <section id="aulas" class="portfolio aulas">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-12 entries">

                    <div id="grid-aulas" class="container" data-aos="fade-up">
                        <div class="row grid-aulas portfolio-container">
                            <h3 class="title-cat">Resultado da Busca:</h3>
                            <?php
                            $args = array(
                                's' => $s,
                                'post_type' => 'post',
                                'posts_per_page' => 100
                            );
                            $x = 1;
                            $loop = new WP_Query($args);
                            $result = array();
                            foreach ($loop->posts as $post) {
                                $result[] = $post;
                            ?>
                                <div class="aulas-item col-lg-12 portfolio-item">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <?php echo $x; ?>&ensp;&bullet;&ensp;
                                            <a href="<?php echo get_the_permalink() ?>" class="details-link" title="Link">
                                                <?php echo $post->post_title; ?>
                                            </a>
                                            <a href="<?php echo get_post_meta($post->ID, 'post_video', true); ?>" class="venobox ico-play" title="Play" data-vbtype="video" data-autoplay="true"><i class="ri-video-line"></i></a>
                                        </div>
                                    </div>
                                </div>
                            <?php $x++;
                            }
                            wp_reset_postdata(); 
                            if(count($result) == 0)echo '<div class="aulas-item col-lg-12 portfolio-item"><div class="row"><div class="col-lg-12">Nada encontrado !</div></div></div>';
                            ?>
                        </div>
                    </div>
                </div>

            </div>
    </section><!-- End Blog Section -->

</main><!-- End #main -->
<?php get_footer(); ?>