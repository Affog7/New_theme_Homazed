<?php
/**
* Template Name: Account resume 2
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
				<?php $first_name = ucfirst($user->user_firstname); ?>
				<?php $last_name = ucfirst($user->user_lastname); ?>
				<?php $login = $user->user_login; ?>
				<?php $registered = $user->user_registered; ?>
				<?php $account_type = get_field('user_account_type', "user_".$user->ID); ?>
				<?php $language = get_field('user_language', "user_".$user->ID); ?>
				<?php $preferences = get_field('user_mention_preferences', "user_".$user->ID); ?>
				<?php $connections = get_field('user_connections', "user_".$user->ID); ?>
				<?php $profile_picture = get_field('user_profile_picture', "user_".$user->ID); ?>
				<?php //$city = get_field("user_city_of_residence", "user_".$user->ID); ?>
				<?php //$country = get_field("user_country_of_residence", "user_".$user->ID); ?>
				<?php $location = get_field("user_location_of_residence", "user_".$user->ID); ?>

				<?php get_template_part("components/user-resume-profile", null, array(
					"user" => $user,
					'additional-classes' => 'reverse',
				)); ?>

				<div class="quicklinks">
					<?php $edit_account_link = get_permalink("240"); ?> <!-- Edit account page -->
					<?php $edit_account_password_link = get_permalink("382"); ?>
					<a href="<?php echo $edit_account_link. "?scrollto=af-field-section-account-type"; ?>" data-scroll-to-class="af-field-section-account-type" class="quicklinks--item">
						<div class="flex flex--vertical">
							<h3 class="h4">Account type</h3>
							<?php if($account_type): ?>
								<p class="p-sm -light"><?php echo $account_type['label']; ?></p>
							<?php else: ?>
								<p class="p-sm -light">Not defined</p>
							<?php endif; ?>
						</div>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_account_link. "?scrollto=af-field-section-personal-informations"; ?>" data-scroll-to-class="af-field-section-personal-informations" class="quicklinks--item">
						<div class="flex flex--vertical">
							<h3 class="h4">Personal informations</h3>
							<p>
								<dl>
									<dt class="p-sm">Name:</dt>
									<dd class="p-sm -light"><?php echo $first_name; ?> <?php echo $last_name; ?></dd>
								</dl>
								<dl>
									<dt class="p-sm">Address of residence:</dt>
									<!-- <dd class="p-sm -light"><?php //echo $city.", ".$country; ?></dd> -->
									<?php if(!empty($location)): ?>
										<dd class="p-sm -light"><?php echo $location["markers"][0]["label"]; ?></dd>
									<?php endif; ?>
								</dl>
								<dl>
									<dt class="p-sm">language:</dt>
									<?php if($account_type): ?>
										<dd class="p-sm -light"><?php echo $language['label']; ?></dd>
										<?php else: ?>
										<dd class="p-sm -light">Not defined</dd>
									<?php endif; ?>
								</dl>
							</p>
						</div>
						
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_account_password_link; ?>" class="quicklinks--item">
						<h3 class="h4">Password</h3>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
					<a href="<?php echo $edit_account_link. "?scrollto=af-field-section-preferences"; ?>" data-scroll-to-class="af-field-section-preferences" class="quicklinks--item">
						
						<div class="flex flex--vertical">
							<h3 class="h4">Preferences</h3>
							<p>
								<dl>
									<dt class="p-sm">Connections:</dt>
									<?php if(!empty($connections)): ?>
										<dd class="p-sm -light"><?php echo $connections['label']; ?></dd>
									<?php endif; ?>
								</dl>
								<dl>
									<dt class="p-sm">Preferences:</dt>
									<?php if(!empty($preferences)): ?>
										<dd class="p-sm -light">
											<?php
											$last_element = end($preferences);
											foreach ($preferences as $item) {
												if(($item == $last_element)) {
													echo "- ".$item['label'];
												}
												else {
													echo "- ".$item['label'];
													?>
													<br />
												<?php
												}
											}
											?>
										</dd>
									<?php endif; ?>
								</dl>
							</p>
						</div>
						<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
					</a>
				</div>

				<div class="account-actions">
					<div class="logout">
						<?php
						$logout = esc_url(wp_logout_url(home_url()));
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