<?php
/**
* Template Name: Congratulations
*
* by hellomarcel.be
* -> hello@marcel-pirnay.be
*/

get_header(); ?>

<main class="main main--congrats" role="main" data-barba="container" data-barba-namespace="form" data-theme="theme-light">
	<div class="container container--default">
		<div class="congrats__icon-container flex flex--center">
			<div class="congrats__icon">
				<?php echo file_get_contents(get_stylesheet_directory()."/src/images/icons/single-neutral-actions-check-2.svg"); ?>
			</div>
		</div>

		<div class="card-form" data-barba-prevent="all">
			<h2 class="h2 card-form__title">
				<?php $current_user = wp_get_current_user(); ?>
				<?php echo get_the_title()." ".$current_user->first_name." !"; ?>
			</h2>
			<h3 class="h3">Your account has been created</h3>
			<div class="congrats__profile-link"></div>
			<div class="congrats__actions">
				<p class="congrats__incentive">Make your profile stand out with pictures and more information about you.</p>
				<div class="congrats__actions-container">
					<?php if(is_user_logged_in()): ?>
						<?php
						get_template_part("components/btn", null,
							array( 
								'label' => 'Complete my profile',
								'href' => get_permalink("473"),
								'target' => "_self",
								'skin'  => 'primary',
								'icon-only'  => false,
								'disabled'  => false,
								'icon-position' => '', // left or right
								'icon' => '',
								'additional-classes' => '',
								'data-attribute' => null,
								'theme' => "",
							)
						);
						?>
						<div class="congrats__choice">or</div>
						<?php endif; ?>
					<?php
					get_template_part("components/btn", null,
						array( 
							'label' => 'Go to homepage',
							'href' => get_home_url(),
							'target' => "_self",
							'skin'  => 'ghost',
							'icon-only'  => false,
							'disabled'  => false,
							'icon-position' => '', // left or right
							'icon' => '',
							'additional-classes' => '',
							'data-attribute' => null,
							'theme' => "",
						)
					);
					?>
				</div>
			</div>
		</div>
	</div>
</main>

<?php get_footer();
