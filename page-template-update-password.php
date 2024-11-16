<?php
/**
* Template Name: Update password
*
* by hellomarcel.be
* -> hello@marcel-pirnay.be
*/

get_header(); ?>

<main class="main" role="main" data-barba="container" data-barba-namespace="form" data-theme="theme-light">
	<div class="container container--body">
		<div class="card-form" data-barba-prevent="all">
			<?php if(is_user_logged_in()): ?>
				<div data-barba-prevent="all">
					<h2 class="h4"><?php echo get_the_title(); ?></h2>
					<?php echo do_shortcode(get_field("shortcode")); ?>
				</div>
			<?php else: ?>
				<?php echo "You do not have permission to view this page"; ?>
			<?php endif; ?>
		</div>
	</div>
</main>

<?php get_footer();