<?php
/**
* Template Name: Profile resume
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

				<?php get_template_part("components/user-resume-profile", null, array(
					"user" => $user,
					'additional-classes' => '',
				)); ?>

				<div class="quicklinks">
					<?php $edit_profile_link = get_permalink("473"); ?> <!-- Edit profile page -->
					<a href="<?php echo $edit_profile_link. "?scrollto=af-field-media"; ?>" data-scroll-to-class="af-field-media" class="quicklinks--item">
						<h3 class="h4">Media</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_profile_link. "?scrollto=af-field-display"; ?>" data-scroll-to-class="af-field-display" class="quicklinks--item">
						<h3 class="h4">Display</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_profile_link. "?scrollto=af-field-main-picture"; ?>" data-scroll-to-class="af-field-main-picture" class="quicklinks--item">
						<h3 class="h4">Main Picture</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_profile_link. "?scrollto=af-field-key-info"; ?>" data-scroll-to-class="af-field-key-info" class="quicklinks--item">
						<h3 class="h4">Key Info</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<?php $user_init_terms = get_the_terms($user->ID, 'usertags'); ?>
					<a href="<?php echo $edit_profile_link. "?scrollto=af-field-tags"; ?>" data-scroll-to-class="af-field-tags" class="quicklinks--item">
						<div class="flex flex--vertical">
							<h3 class="h4">Tags</h3>
							<?php if($user_init_terms): ?>
								<p>
									<?php foreach ($user_init_terms as $tags): ?>
									<span class="tag">#<?php echo $tags->name ; ?></span>
									<?php endforeach; ?>
								</p>
								<?php endif; ?>
							</div>
							<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
						</a>
					<a href="<?php echo $edit_profile_link. "?scrollto=af-field-locations"; ?>" data-scroll-to-class="af-field-locations" class="quicklinks--item">
						<h3 class="h4">Locations</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_profile_link. "?scrollto=af-field-activity-area"; ?>" data-scroll-to-class="af-field-activity-area" class="quicklinks--item">
						<h3 class="h4">Activity Info</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_profile_link. "?scrollto=af-field-connections"; ?>" data-scroll-to-class="af-field-connections" class="quicklinks--item">
						<h3 class="h4">Connections</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_profile_link. "?scrollto=af-field-profile-linked-accounts"; ?>" data-scroll-to-class="af-field-profile-linked-accounts" class="quicklinks--item">
						<h3 class="h4">Profile Linked Accounts</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_profile_link. "?scrollto=section-title__files"; ?>" data-scroll-to-class="section-title__files" class="quicklinks--item">
						<h3 class="h4">Files</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_profile_link. "?scrollto=af-field-add-event"; ?>" data-scroll-to-class="af-field-add-event" class="quicklinks--item">
						<h3 class="h4">Event</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_profile_link. "?scrollto=af-field-premium-profile"; ?>" data-scroll-to-class="af-field-premium-profile" class="quicklinks--item">
						<h3 class="h4">Premium</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_profile_link. "?scrollto=af-field-promote-post-profile"; ?>" data-scroll-to-class="af-field-promote-post-profile" class="quicklinks--item">
						<h3 class="h4">Ads</h3>
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

<?php get_footer();