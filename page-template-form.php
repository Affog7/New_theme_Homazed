<?php
/**
* Template Name: Forms
*
* by hellomarcel.be
* -> hello@marcel-pirnay.be
*/

get_header(); ?>

<main class="main" role="main" data-barba="container" data-barba-namespace="form" data-theme="theme-light">
	<!-- <div class="container container--body">
		<div class="card-form" data-barba-prevent="all">
			<?php if(is_user_logged_in()): ?>
				<?php $user = wp_get_current_user(); ?>
				<?php $first_name = ucfirst($user->user_firstname); ?>
				<?php $last_name = ucfirst($user->user_lastname); ?>
				<?php $login = $user->user_login; ?>
				<?php $registered = $user->user_registered; ?>
				
				<?php get_template_part("components/user-resume-profile", null, array(
					"user_id" => $user->ID,
					"first_name" => $first_name,
					"last_name" => $last_name,
					"login" => $login,
					"registered" => $registered,
					"profile_picture" => $profile_picture
				)); ?>
				<div data-barba-prevent="all">
					<h2 class="h4"><?php echo get_the_title(); ?></h2>
					<?php echo do_shortcode(get_field("shortcode")); ?>
				</div>
			<?php else: ?>
				<?php echo "You do not have permission to view this page"; ?>
			<?php endif; ?>
		</div>
	</div> -->
	TO delete
</main>

<?php get_footer();