<header class="header <?php if(is_home()) {echo "header--home container--large";} ?>">

	<div class="header--wrapper flex flex--justify-between">
		<div class="header__left flex flex--vertical-center">
			<a href="<?php echo get_permalink("604"); ?>" data-barba-prevent="self" class="header__title">Homazed<sup>©</sup></a>
		</div>
		<div class="header__right flex flex--vertical-center" data-barba-prevent="all">

			<?php // echo do_shortcode('[wpml_language_selector_widget]'); ?>

			<?php if(is_page(468) || is_page(473)){ $is_active = " active"; }else{ $is_active = ""; } ?>
			<?php if(!is_user_logged_in()): ?>
				<?php get_template_part("components/btn", null,
					array( 
						'label' => 'Login',
						'href' => get_permalink("39"), // Login page
						'target' => "_self",
						'skin'  => 'transparent',
						'icon-only'  => false,
						'disabled'  => false,
						'icon-position' => 'right', // left or right
						'icon' => 'login-1', // nom du fichier svg
						'additional-classes' => 'menu-item' . $is_active,
						'data-attribute' => null,
						'theme' => "",
					)
				); 	?>
				<?php
				get_template_part("components/btn", null,
					array( 
						'label' => 'Register',
						'href' => get_permalink("1793"),
						'target' => "_self",
						'skin'  => 'primary',
						'icon-only'  => false,
						'disabled'  => false,
						'icon-position' => '', // left or right
						'icon' => '',
						'additional-classes' => '',
						'data-attribute' => null,
						'theme' => "white",
					)
				);
			?>
			<?php else: ?>
				<?php $user = wp_get_current_user(); ?>
				<?php $first_name = $user->user_firstname; ?>
				<?php $last_name = $user->user_lastname; ?>
				
				<a href="<?php echo get_permalink("602")."?user=".$first_name."-".$last_name; ?>" class="owner__link--header flex flex--vertical-center">
					<?php $profile_picture = get_field('user_profile_picture', "user_".$user->ID); ?>
					<?php if($profile_picture): ?>
						<?php if(is_array($profile_picture)){
							$profile_picture = array_values($profile_picture)[0];
						} ?>
						<img src="<?php echo esc_url(wp_get_attachment_url($profile_picture)); ?>" alt="<?php echo $first_name." ".$last_name." profile image"; ?>" class="owner__avatar owner__avatar--header act-for act-for-profile-resume act-for-edit-profile act-for-single-user <?php echo $is_active; ?>" />
					<?php else: ?>
						<div class="owner__avatar owner__avatar--header owner__avatar--header--blank act-for act-for-profile-resume act-for-edit-profile act-for-single-user flex flex--horizontal-center flex--center<?php echo $is_active; ?>">
							<span class="first-letters"><?php echo $first_name[0].$last_name[0]; ?></span>
						</div>
					<?php endif; ?>
				</a>
				<?php get_template_part("components/btn", null,
					array( 
						'label' => 'Messages',
						'href' => "/",
						'target' => "_self",
						'skin'  => 'transparent',
						'icon-only'  => true,
						'disabled'  => false,
						'icon-position' => 'right', // left or right
						'icon' => 'messages-bubble', // nom du fichier svg
						'additional-classes' => 'menu-item square',
						'data-attribute' => null,
						'theme' => "",
					)
				);
				?>
				<?php
				get_template_part("components/btn", null,
					array( 
						'label' => '',
						'href' => "/",
						'target' => "_self",
						'skin'  => 'transparent',
						'icon-only'  => true,
						'disabled'  => false,
						'icon-position' => '', // left or right
						'icon' => 'flag-plain-3', // nom du fichier svg
						'additional-classes' => 'menu-item square',
						'data-attribute' => null,
						'theme' => "",
					)
				); ?>
				<?php if(is_page(251) || is_page(240)){ $is_active = " active"; }else{ $is_active = ""; } ?>
				<?php get_template_part("components/btn", null,
					array( 
						'label' => 'Account',
						'href' => get_permalink("251"), // Account resume page
						'target' => "_self",
						'skin'  => 'transparent',
						'icon-only'  => true,
						'disabled'  => false,
						'icon-position' => '', // left or right
						'icon' => 'compass-directions', // nom du fichier svg
						'additional-classes' => 'menu-item square act-for act-for-account-resume act-for-edit-account' . $is_active,
						'data-attribute' => null,
						'theme' => "",
					)
				); ?>

				<?php 
					$i_request_contactlist_users_relationships = get_field("i_request_contactlist_users_relationships", "user_".$user->ID);
					$i_accept_contactlist_users_relationships = get_field("i_accept_contactlist_users_relationships", "user_".$user->ID);
					// $i_refused_contactlist_users_relationships = get_field("i_refused_contactlist_users_relationships", "user_".$user->ID);
					if(empty($i_accept_contactlist_users_relationships) && !empty($i_request_contactlist_users_relationships)){
						// "NO contact accepted, but request pending";
						$pendig_contactlist_requests = $i_request_contactlist_users_relationships;
					}elseif(!empty($i_request_contactlist_users_relationships)){
						$pendig_contactlist_requests = array_diff($i_request_contactlist_users_relationships, $i_accept_contactlist_users_relationships);
					}
				?>
				<?php if(!empty($pendig_contactlist_requests) && count($pendig_contactlist_requests) > 0): ?>
					<span class="tooltip-pill notifications" data-tooltip="tooltip-notification" data-tooltip-placement="bottom-end" data-tooltip-events="click">
							<div class="tooltip-trigger__content"><span class="notification_counter"><?php echo count($pendig_contactlist_requests); ?></span></div>
					</span>
					<div class="tooltip tooltip--dynamic_content" id="tooltip-notification" role="tooltip">
						<div class="popover__content">
							<div class="flex flex--vertical">
								<!-- <h4>your have <?php // echo count($pendig_contactlist_requests); ?> notifications</h4> -->
								<?php foreach($pendig_contactlist_requests as $pendig_contactlist_request_id): ?>
									<div class="notifications--section" id="notification-<?php echo $pendig_contactlist_request_id; ?>">
										<div class="flex">
											<div class="avatar-small">
												<?php $avatar = get_field("user_profile_picture", "user_".$pendig_contactlist_request_id); ?>
												<img src="<?php echo $avatar['sizes']['thumbnail']; ?>" alt="">
											</div>
											<p>
												<a href="<?php echo get_permalink("602")."?user_id=".$pendig_contactlist_request_id; ?>"><?php echo get_field("user_first_name", "user_".$pendig_contactlist_request_id); ?> <?php echo get_field("user_last_name", "user_".$pendig_contactlist_request_id); ?></a> wants to join your contact list
											</p>
										</div>
										<?php get_template_part( 'components/btn', null,
											array( 
												'label' => 'Refuse',
												'href' => "",
												'target' => "_self",
												'skin'  => 'ghost',
												'icon-only'  => false,
												'disabled'  => false,
												'icon-position' => '', // left or right
												'icon' => '',
												'additional-classes' => 'btn--small relation_btn relation_btn--contact-list-response',
												'data-attribute' => "data-relation-him=" . $pendig_contactlist_request_id . " data-relation-type='refuse-contact-list'",
												'theme' => "",
											)
										); ?>
										<?php get_template_part( 'components/btn', null,
											array( 
												'label' => 'Accept',
												'href' => "",
												'target' => "_self",
												'skin'  => 'primary',
												'icon-only'  => false,
												'disabled'  => false,
												'icon-position' => '', // left or right
												'icon' => '',
												'additional-classes' => 'btn--small relation_btn relation_btn--contact-list-response',
												'data-attribute' => "data-relation-him=" . $pendig_contactlist_request_id . " data-relation-type='accept-contact-list'",
												'theme' => "",
											)
										); ?>
									</div>
								<?php endforeach; ?>
							</div>
								
						</div>
						<div class="arrow"></div>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
</header>