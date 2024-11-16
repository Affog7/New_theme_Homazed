<?php
/**
* Template Name: Public profile
*
* by hellomarcel.be
* -> hello@marcel-pirnay.be
*/

get_header(); ?>

<main class="main" role="main" data-barba="container" data-barba-namespace="form" data-theme="theme-light">
	<div class="container container--body">
		<div class="card-form" data-barba-prevent="all">
			<?php if(is_user_logged_in()): ?>
				<?php $user = wp_get_current_user(); ?>

				<?php get_template_part("components/user-resume-profile", null, array(
					"user" => $user,
					'additional-classes' => '',
				)); ?>
			<?php else: ?>
				<?php get_template_part("components/forbidden-access", null, array()); ?>
			<?php endif; ?>
		</div>
	</div>
</main>

<?php get_footer();