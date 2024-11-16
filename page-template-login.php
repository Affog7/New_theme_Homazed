<?php
/**
* Template Name: Login
*
* by hellomarcel.be
* -> hello@marcel-pirnay.be
*/

get_header(); ?>

<main class="main main--login" role="main" data-barba="container" data-barba-namespace="form" data-theme="theme-light">
	<div class="container container--default">
		<div class="login-wrapper" data-barba-prevent="all">
			<?php if(!is_user_logged_in()): ?>
			<div class="card-form content">
				<h2 class="h4"><?php echo get_the_title(); ?></h2>
				<?php if(isset($_GET["login"]) && $_GET["login"] == "failed"): ?>
					<div class="acf-notice -error acf-error-message -dismiss">
						<p>Login failed. Please make sure the username and password are valid.</p>
					</div>
				<?php endif; ?>
				<?php if(isset($_GET["action"]) && $_GET["action"] == "lostpassword"): ?>
					<?php 
						if(is_user_logged_in()){ 
							wp_redirect( esc_url( home_url() ) );
							exit;
						}
					?>
					<p>TODO: Reset your password</p>
				<?php else: ?>
					<?php echo do_shortcode(get_field("shortcode")); ?>
				<?php endif; ?>
			</div>
			<div class="card-form card-form__centered">
				<p>Not registered yet ?</p>
				<?php
				get_template_part("components/btn", null,
					array( 
						'label' => 'Create a new account',
						'href' => get_permalink("1793"),
						'target' => "_self",
						'skin'  => 'ghost',
						'icon-only'  => false,
						'disabled'  => false,
						'icon-position' => '', // left or right
						'icon' => '', // nom du fichier svg
						'additional-classes' => '',
						'data-attribute' => null,
						'theme' => "",
					)
				);
				?>
			</div>
			<?php else: ?>
			<div class="card-form card-form__centered">
				<p>You are already logged in.</p>
				<?php get_template_part("components/btn", null,
					array( 
						'label' => 'Go to your profile',
						'href' => get_permalink("251"),
						'target' => "_self",
						'skin'  => 'primary',
						'icon-only'  => false,
						'disabled'  => false,
						'icon-position' => '', // left or right
						'icon' => '', // nom du fichier svg
						'additional-classes' => '',
						'data-attribute' => null,
						'theme' => "",
					)
				); ?>
				<p class="sm mt-2">or</p>
				<?php $logout = wp_logout_url(home_url()); ?>
				<?php get_template_part("components/btn", null,
					array( 
						'label' => 'Logout',
						'href' => $logout,
						'target' => "_self",
						'skin'  => 'ghost',
						'icon-only'  => false,
						'disabled'  => false,
						'icon-position' => '', // left or right
						'icon' => '', // nom du fichier svg
						'additional-classes' => '',
						'data-attribute' => null,
						'theme' => "",
					)
				); ?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</main>

<?php get_footer();
