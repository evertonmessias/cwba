<?php get_header(); ?>
<?php
if ($_SERVER['REMOTE_ADDR'] != "143.106.16.153" && $_SERVER['REMOTE_ADDR'] != "177.55.129.61") {
	registerdb($_SERVER['REMOTE_ADDR']);
}
?>

<!-- ======= Hero Section ======= -->
<section id="hero" style="background: url('<?php echo get_option('portal_input_2'); ?>') top center no-repeat fixed;" class="d-flex align-items-center">

	<div class="container" data-aos="zoom-out" data-aos-delay="100">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="center"><?php echo get_option('portal_input_3'); ?></h2>
				<a href="/aulas" class="btn-get-started scrollto Center">Aulas</a>
			</div>
		</div>
	</div>

</section><!-- End Hero -->

<main id="main">

	<!-- ======= About Section ======= -->
	<section id="sobre" class="about">
		<div class="container" data-aos="fade-up">
		<div class="section-title">
				<h2>SOBRE O CURSO</h2>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<?php echo get_option('portal_input_4'); ?>
				</div>				
			</div>
		</div>
	</section><!-- End About Section -->


	<!-- ======= Contact Section ======= -->
	<section id="contato" class="contact">
	<div class="container" data-aos="fade-up">
			<div class="section-title">
				<h2>CONTATO</h2>
			</div>

			<div class="row">

				<div class="col-lg-12">
					<div class="row">
						<div class="col-md-6">
							<div class="info-box mt-4">
								<i class="bx bxl-whatsapp"></i>
								<h3>Whastsapp</h3>
								<p><a target="_blank" href="https://api.whatsapp.com/send?phone=55<?php echo get_option('portal_input_5'); ?>&text=Contato%20do%20Site%20CWBA"><?php echo get_option('portal_input_5'); ?></a></p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="info-box mt-4">
								<i class="bx bx-envelope"></i>
								<h3>E-mail</h3>
								<p><a href="mailto:<?php echo get_option('portal_input_6'); ?>"><?php echo get_option('portal_input_6'); ?></a></p>
							</div>
						</div>
					</div>
					<div class="php-email-form">
						<?php echo do_shortcode('[contact-form-7 id="130" title="Contato"]'); ?>
					</div>
				</div>

			</div>

		</div>
	</section><!-- End Contact Section -->

</main><!-- End #main -->
<?php get_footer(); ?>