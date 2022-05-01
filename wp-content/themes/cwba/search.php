<?php get_header(); ?>
<?php 
$s = get_search_query();
$args = array(
   's' => $s
);
$the_query = new WP_Query($args);
?>
<main id="main" class="post" data-aos="fade-up">
   <!-- ======= Breadcrumbs ======= -->
   <?php if ($the_query->have_posts()) { ?>
      <section class="breadcrumbs">
         <div class="container">
            <div class="d-flex justify-content-between align-items-center">
               <?php echo "<h2 class='page-title'>Resultado da Busca para: " . get_query_var('s') . "</h2>"; ?>
            </div>
         </div>
      </section><!-- End Breadcrumbs -->
      <section class="portfolio-details">
         <div class="container">

            <ul>
               <?php
               while ($the_query->have_posts()) {
                  $the_query->the_post();
               ?>
                  <li>
                     <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  </li>
               <?php
               } ?>
            </ul>

         </div>
      </section>
   <?php
   } else {
   ?>
      <section class="breadcrumbs">
         <div class="container">
            <div class="d-flex justify-content-between align-items-center">
               <h2>Nada encontrado.</h2>
            </div>
         </div>
      </section><!-- End Breadcrumbs -->
      <section class="portfolio-details">
         <div class="container">

            <p>Nenhuma ocorrência encontrada !</p>

         </div>
      </section>
   <?php } ?>
</main><!-- End #main -->
<?php get_footer(); ?>