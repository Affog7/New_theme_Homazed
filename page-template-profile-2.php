<?php
/**
* Template Name: Profile resume 2
*
* by hellomarcel.be
* -> hello@marcel-pirnay.be
*/

get_header(); ?>


<main class="main" role="main" data-barba="container" data-barba-namespace="form" data-theme="theme-light">
	<div class="container container--default">
		<div class="card-form" data-barba-prevent="all">
			<?php if(is_user_logged_in()): ?>
				<?php $user = wp_get_current_user(); ?>
				<?php 
					$user_address = get_field("user_location_address", "user_".$user->ID) . ", " . get_field("user_location_zip", "user_".$user->ID) . " " . get_field("user_location_city", "user_".$user->ID);
					$user_location_latitude = get_field("user_location_latitude", "user_".$user->ID);
					$user_location_longitude = get_field("user_location_longitude", "user_".$user->ID);
				?>


				<?php get_template_part("components/user-resume-profile", null, array(
					"user" => $user,
					'additional-classes' => '',
				)); ?>

				<div class="quicklinks">
					<?php $edit_profile_link = get_permalink("473"); ?> <!-- Edit profile page -->
					<a href="" data-open-modal="edit-user--images" class="quicklinks--item">
						<h3 class="h4">Images</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="" data-open-modal="edit-user--key_info" class="quicklinks--item">
						<h3 class="h4">Todo: Key Info</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<?php 
					if (isset($user_init_terms)) {
						// Afficher les termes utilisateur de manière formatée
						highlight_string('<?php $data = ' . var_export($user_init_terms, true) . ';?>'); 
					} else {
						echo 'Aucun terme utilisateur trouvé.';
					}
					?>

					<a href="" data-open-modal="edit-user--tags" class="quicklinks--item">
						<div class="flex flex--vertical">
							<h3 class="h4">Todo: Tags <?php if($user_init_terms): ?>(<?php echo count($user_init_terms); ?>)<?php endif; ?></h3>
						</div>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
						</a>
					<a href="" data-open-modal="edit-user--location" class="quicklinks--item">
						<h3 class="h4">Locations</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_profile_link. "?scrollto=af-field-activity-area"; ?>" data-scroll-to-class="af-field-activity-area" class="quicklinks--item">
						<h3 class="h4">Todo: Activity Info</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_profile_link. "?scrollto=af-field-connections"; ?>" data-scroll-to-class="af-field-connections" class="quicklinks--item">
						<h3 class="h4">Todo: Connections</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_profile_link. "?scrollto=af-field-profile-linked-accounts"; ?>" data-scroll-to-class="af-field-profile-linked-accounts" class="quicklinks--item">
						<h3 class="h4">Todo: Profile Linked Accounts</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_profile_link. "?scrollto=section-title__files"; ?>" data-scroll-to-class="section-title__files" class="quicklinks--item">
						<h3 class="h4">Todo: Files</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_profile_link. "?scrollto=af-field-add-event"; ?>" data-scroll-to-class="af-field-add-event" class="quicklinks--item">
						<h3 class="h4">Todo: Event</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_profile_link. "?scrollto=af-field-premium-profile"; ?>" data-scroll-to-class="af-field-premium-profile" class="quicklinks--item">
						<h3 class="h4">Todo: Premium</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_profile_link. "?scrollto=af-field-promote-post-profile"; ?>" data-scroll-to-class="af-field-promote-post-profile" class="quicklinks--item">
						<h3 class="h4">Todo: Ads</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
				</div>

				<div class="account-actions">
					<div class="logout">
						<?php
						$logout = wp_logout_url(home_url());
						get_template_part("components/btn", null,
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
						);
						?>
					</div>
				</div>
			<?php else: ?>
				<?php get_template_part("components/forbidden-access", null, array()); ?>
			<?php endif; ?>
		</div>
	</div>
</main>

<div class="modal micromodal-slide" id="edit-user--images" aria-hidden="true">
	<div class="modal__overlay" tabindex="-1" data-micromodal-close>
		<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="edit-user--images">
			<header class="modal__header">
				<div class="flex flex--vertical">
					<div class="flex flex--vertical-center">
						<h2 class="resume__name card-form__title">Edit your images</h2>
					</div>
				</div>
				<?php get_template_part("components/btn", null,
					array( 
						'label' => 'Close this modal window',
						'href' => "",
						'target' => "_self",
						'skin'  => 'secondary',
						'icon-only'  => true,
						'disabled'  => false,
						'icon-position' => 'right', // left or right
						'icon' => 'close',
						'additional-classes' => '',
						'data-attribute' => 'data-close-modal',
						'theme' => "",
					)
				); ?>
			</header>
			<main class="modal__content contact__form contact__form--light">
				<?php echo do_shortcode( '[gravityform id="5" title="false"]' ); ?>
			</main>
		</div>
	</div>
</div>

<div class="modal micromodal-slide" id="edit-user--location" aria-hidden="true">
	<div class="modal__overlay" tabindex="-1" data-micromodal-close>
		<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="edit-user-media">
			<header class="modal__header">
				<div class="flex flex--vertical">
					<div class="flex flex--vertical-center">
						<h2 class="resume__name card-form__title">Change your location</h2>
					</div>
				</div>
				<?php get_template_part("components/btn", null,
					array( 
						'label' => 'Close this modal window',
						'href' => "",
						'target' => "_self",
						'skin'  => 'secondary',
						'icon-only'  => true,
						'disabled'  => false,
						'icon-position' => 'right', // left or right
						'icon' => 'close',
						'additional-classes' => '',
						'data-attribute' => 'data-close-modal',
						'theme' => "",
					)
				); ?>
			</header>
			<main class="modal__content contact__form contact__form--light">
				<?php echo do_shortcode( '[gravityform id="10" title="false" field_values="user_retrieved_id=user_' .  $user->ID . '&user_address=' . $user_address . '&user_location_latitude=' . $user_location_latitude . '&user_location_longitude=' . $user_location_longitude . ']' ); ?>
			</main>
		</div>
	</div>
</div>

<div class="modal micromodal-slide" id="edit-user--tags" aria-hidden="true">
	<div class="modal__overlay" tabindex="-1" data-micromodal-close>
		<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="edit-user-media">
			<header class="modal__header">
				<div class="flex flex--vertical">
					<div class="flex flex--vertical-center">
						<h2 class="resume__name card-form__title">Change your tags <?php echo $user_address; ?></h2>
					</div>
				</div>
				<?php get_template_part("components/btn", null,
					array( 
						'label' => 'Close this modal window',
						'href' => "",
						'target' => "_self",
						'skin'  => 'secondary',
						'icon-only'  => true,
						'disabled'  => false,
						'icon-position' => 'right', // left or right
						'icon' => 'close',
						'additional-classes' => '',
						'data-attribute' => 'data-close-modal',
						'theme' => "",
					)
				); ?>
			</header>
			<main class="modal__content contact__form contact__form--light">
				<?php echo do_shortcode( '[gravityform id="12" title="false" field_values="user_retrieved_id=user_' .  $user->ID . '"]' ); ?>
			</main>
		</div>
	</div>
</div>

<div class="modal micromodal-slide" id="edit-user--key_info" aria-hidden="true">
	<div class="modal__overlay" tabindex="-1" data-micromodal-close>
		<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="edit-user--key_info">
			<header class="modal__header">
				<div class="flex flex--vertical">
					<div class="flex flex--vertical-center">
						<h2 class="resume__name card-form__title">Edit your key informations</h2>
					</div>
				</div>
				<?php get_template_part("components/btn", null,
					array( 
						'label' => 'Close this modal window',
						'href' => "",
						'target' => "_self",
						'skin'  => 'secondary',
						'icon-only'  => true,
						'disabled'  => false,
						'icon-position' => 'right', // left or right
						'icon' => 'close',
						'additional-classes' => '',
						'data-attribute' => 'data-close-modal',
						'theme' => "",
					)
				); ?>
			</header>
			<main class="modal__content contact__form contact__form--light">
				<?php echo do_shortcode( '[gravityform id="6" title="false"]' ); ?>
			</main>
		</div>
	</div>
</div>

<?php get_footer();