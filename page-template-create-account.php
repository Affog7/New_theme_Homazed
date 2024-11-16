<?php
/**
* Template Name: Create account
*
* by hellomarcel.be
* -> hello@marcel-pirnay.be
*/

get_header(); ?>

<main class="main main--login" role="main" data-barba="container" data-barba-namespace="form" data-theme="theme-light">
	<div class="container container--default">
			<div class="card-form" data-barba-prevent="all">
				<h2 class="h4"><?php echo get_the_title(); ?></h2>
				<?php echo do_shortcode(get_field("shortcode")); ?>
			</div>
	</div>
</main>

<?php get_footer();
