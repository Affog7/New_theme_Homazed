<?php get_header(); ?>

<main class="main" role="main" data-barba="container" data-barba-namespace="home" data-theme="theme-light">
	<div class="container container--large">
		<div class="card-form">
			<h2 class="h4">
				<?php echo get_the_title(); ?> - default page
			</h2>
			<?php echo do_shortcode(get_field("shortcode")); ?>
		</div>
	</div>
</main>

<?php get_footer(); ?>
