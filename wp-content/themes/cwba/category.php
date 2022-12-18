<?php if (!is_user_logged_in()) {
	$url = get_home_url() . '/wp-admin';
	wp_redirect($url);
	exit();
} else {
	get_header();
} ?>

<?php
if (url_active()[2] == "") {
    $base = url_active()[1];
    $lli = "&ensp;/&ensp;<li>".url_active()[1]."</li>";
} else {
    $base = url_active()[2];
    $lli = "&ensp;/&ensp;<li><a href='/".url_active()[1]."'>".url_active()[1]."</a></li>&ensp;/&ensp;<li>".url_active()[2]."</li>";
}
$category = get_category_by_slug($base) ?>

<main id="main" class="post" data-aos="fade-up">
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Categoria: <?php echo $category->name ?></h2>
                <ol>
                    <li><a href="/">home</a></li>
                    <?php echo $lli; ?>
                </ol>
            </div>
        </div>
    </section><!-- End Breadcrumbs -->

    <section id="aulas" class="portfolio aulas">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-lg-9 entries">

                    <div id="grid-aulas" class="container" data-aos="fade-up">
                        <div class="row" data-aos="fade-up" data-aos-delay="100">
                            <div class="col-12">
                                <input type="text" class="quicksearch" placeholder="Filtrar" />
                            </div>
                        </div>
                        <br>
                        <div id="<?php echo $category->slug; ?>" class="row grid-aulas portfolio-container">
                            <h3 class="title-cat"><?php echo $category->name ." - ". $category->description; ?></h3>
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
                                <li><a class="getstarted empty" href="/aulas">Todos as Categorias</a></li>
                                <li><a class="getstarted" href="/aulas/<?php echo $category->slug ?>"><?php echo $category->name ?> <span>(<?php echo $category->count ?>)</span></a></li>
                                <?php
                                $args = array(
                                    'orderby' => 'name',
                                    'order' => 'ASC',
                                    'parent' => 0
                                );
                                $categories = get_categories($args);
                                foreach ($categories as $cat) {
                                    if ($cat->slug != $category->slug) {
                                        echo '<li><a class="getstarted empty" href="/aulas/' . $cat->slug . '">' . $cat->name . ' <span>(' . $cat->count . ')</span></a></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div><!-- End sidebar categories-->

                    </div><!-- End blog sidebar -->

                </div>

            </div>
    </section><!-- End Blog Section -->
</main><!-- End #main -->
<?php get_footer(); ?>