<?php
/**
* Template Name: Edit profile
*
* by hellomarcel.be
* -> hello@marcel-pirnay.be
*/

get_header(); ?>

<main class="main" role="main" data-barba="container" data-barba-namespace="form" data-theme="theme-light" data-admin-ajax=<?php echo admin_url( 'admin-ajax.php' ); ?>>
	<div class="container container--default">
			<?php if(is_user_logged_in()): ?>
				<?php $user = wp_get_current_user(); ?>
				
				<div class="card-form">
					<?php get_template_part("components/user-resume-profile", null, array(
						"user" => $user,
						'additional-classes' => '',
					)); ?>
				</div>

				<div class="card-form">
					<h2 class="h4"><?php echo get_field("title"); ?></h2>
					<p><?php echo get_field("description"); ?></p>
					<div data-barba-prevent="all">
						<?php // echo do_shortcode(get_field("shortcode")); ?>
						<?php 
							// advanced_form( 'form_662b6947a88b6', array(
							// 	'submit_text' => 'Save',
							// 	'uploader' => 'basic',
							// 	'user' => 'current',
							// 	'redirect' => get_permalink("468")
							// ));
						?>
						
					</div>
					<!-- function af -->
				</div>
			<?php else: ?>
				<?php get_template_part("components/forbidden-access", null, array()); ?>
			<?php endif; ?>
	</div>
</main>

<?php get_footer();