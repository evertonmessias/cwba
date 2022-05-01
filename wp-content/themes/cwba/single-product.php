<?php get_header(); ?>
<main id="main" class="post" data-aos="fade-up">
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2><?php the_title() ?></h2>
                <ol>
                    <li><a href="/">home</a></li>
                    <li><a href="/cursos">cursos</a></li>
                    <li>
                        <?php
                        if (url_active()[2] != "") echo url_active()[2];
                        ?>
                    </li>
                </ol>
            </div>
        </div>
    </section><!-- Breadcrumbs Section -->

    <!-- ======= Portfolio Details Section ======= -->
    <section class="portfolio-details">
        <div class="container">

            <div class="portfolio-details-container">
                    <?php
                    $wc_product = new WC_product(get_the_ID());
                    $array_images = $wc_product->get_gallery_image_ids();
                    foreach ($array_images as $image) { ?>
                        <img src="<?php echo wp_get_attachment_url($image); ?>" class="img-fluid img-produtos" title="<?php the_title() ?>">
                    <?php } ?>
            </div>
            <br><br>
            <div class="portfolio-description text-justify">
                <p class="center"><?php echo $wc_product->get_short_description(); ?></p>

                <?php if (is_user_logged_in()) { ?>
                    <?php if (current_user_can('administrator') || current_user_can('editor') || customer_orders(wp_get_current_user()->ID,get_the_ID()) == 2) { ?>
                        <br><hr><br>

                        <!-- conteúdo protegido -->
                        <?php echo get_the_content(); ?>
                        <!-- conteúdo protegido -->
                    
                    <?php } elseif(customer_orders(wp_get_current_user()->ID,get_the_ID()) == 1) { ?>
                        <br><br>
                        <hr>
                        <p class="center msgOK">Ok, Seu curso está sendo preparado ...</p>
                        <br>
                    <?php } else { ?>
                        <br><br>
                        <hr>
                        <p class="center">Para ver o conteúdo clique botão abaixo:</p>
                        <br>
                        <?php echo "<h5 class='center'>Preço: R$ " . $wc_product->get_price() . "</h5>"; ?>
                        <a class='btn-pedido' href="/carrinho/?add-to-cart=<?php echo get_the_ID(); ?>&quantity=1">Quero Comprar</a>
                    <?php }
                } else { ?>
                    <br><br>
                    <hr>
                    <p class="center">Para ver o conteúdo clique em um dos botões abaixo:</p>                    
                    <br>
                    <?php echo "<h5 class='center'>Preço: R$ " . $wc_product->get_price() . "</h5>"; ?>
                    <a class='btn-pedido' href="/carrinho/?add-to-cart=<?php echo get_the_ID(); ?>&quantity=1">Quero Comprar</a>
                    <br>
                    <a class='btn-pedido' href="/wp-admin">Já tenho conta</a>
                <?php } ?>
            </div>
        </div>
    </section><!-- End Portfolio Details Section -->
    <br>
</main><!-- End #main -->
<?php get_footer(); ?>