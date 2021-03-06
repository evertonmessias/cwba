  <!-- ======= Footer ======= -->
  <footer id="footer">
  	<div class="footer-top">
  		<div class="container">
  			<div class="row">

  				<div class="col-lg-3 col-md-6">
  					<div class="footer-info">
  						<h3><?php echo get_option('home_input_1'); ?></h3>
  						<p><?php echo get_option('home_input_14'); ?><br><br>
  							<strong>Telefone: </strong><?php echo get_option('home_input_12'); ?><br>
  							<strong>E-mail: </strong><?php echo get_option('home_input_13'); ?><br>
  						</p>
  						<div class="social-links mt-3">
  							<a target="_blank" href="<?php echo get_option('home_input_16'); ?>" class="facebook"><i class="bx bxl-facebook"></i></a>
  							<a target="_blank" href="<?php echo get_option('home_input_17'); ?>" class="instagram"><i class="bx bxl-instagram"></i></a>
  						</div>
  					</div>
  				</div>

  				<div class="col-lg-3 col-md-6 footer-links">
  					<h4>Acesso Rápido</h4>
  					<ul>
  						<li><i class="bx bx-chevron-right"></i> <a class="nav-link scrollto" href="/">Início</a></li>
  						<li><i class="bx bx-chevron-right"></i> <a class="nav-link scrollto" href="<?php if (!is_home()) echo '/'; ?>#sobre">Sobre</a></li>
  						<li><i class="bx bx-chevron-right"></i> <a class="nav-link scrollto" href="<?php if (!is_home()) echo '/'; ?>cursos">Cursos</a></li>
  						<li><i class="bx bx-chevron-right"></i> <a class="nav-link scrollto" href="<?php if (!is_home()) echo '/'; ?>#contact">Contato</a></li>
  						<li><i class="bx bx-chevron-right"></i> <a class="nav-link scrollto" href="/blog">Blog</a></li>
  					</ul>
  				</div>

  				<div class="col-lg-3 col-md-6 footer-links">
  					<h4>Cursos</h4>
  					<ul>
  						<?php
							$args = array(
								'post_type' => 'product',
								'orderby'       => 'id',
								'order'         => 'ASC',
								'posts_per_page' => 10
							);
							$loop = new WP_Query($args);
							while ($loop->have_posts()) {
								$loop->the_post();								
							?>
  							<li><i class="bx bx-chevron-right"></i> <a class="nav-link scrollto" href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></li>
  						<?php } ?>
  					</ul>
  				</div>

  				<div id="participe" class="col-lg-3 col-md-6 footer-newsletter">
  					<h4>Fique por dentro.</h4>
  					<div class="php-email-form2">
  						<?php echo do_shortcode('[wpforms id="29"]'); ?>
  					</div>
  				</div>

  			</div>
  		</div>
  	</div>

  	<div class="container">
  		<div class="copyright">
  			<strong><span><a href="/wp-admin/"><?php echo get_option('home_input_0'); ?></a></span></strong>
  		</div>
  		<div class="credits">
  			Designed by <a target="_blank" href="https://portfolio.evertonm.com/">EvM</a><br>
  			<small>Visitas:
  				<?php
					$last_ip = list_access('id');
					$last_ip = end($last_ip);
					echo $last_ip->id;
					?>
  			</small>
  		</div>
  	</div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?php echo SITEPATH; ?>assets/vendor/aos/aos.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/php-email-form/validate.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/counterup/counterup.min.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/venobox/venobox.min.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/purecounter/purecounter.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="<?php echo SITEPATH; ?>assets/js/main.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/js/quicksearch.js"></script>
  <script src="<?php echo SITEPATH; ?>assets/js/cwba.js"></script>

  <?php wp_footer(); ?>
  </body>

  </html>