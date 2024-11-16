<?php
/**
* Template Name: Components
*
* by hellomarcel.be
* -> hello@marcel-pirnay.be
*/


get_header();
?>

<main class="main" role="main" data-barba="container" data-barba-namespace="form" data-theme="theme-light">

	<div class="component__list">

		<div class="container-vertical">
			<h2 class="anim_n">All components</h2>
		</div>

		<!-- <div class="container-vertical">
			<h3 class="h4 sub-title anim_els">Forms</h3>
			<?php
			// echo do_shortcode(get_field("shortcode"));
			?>
		</div> -->
		
		<div class="container-vertical">
			<h3 class="h4 sub-title anim_els">User resume</h3>
			<?php $user = wp_get_current_user(); ?>

			<div class="card-form">
				<?php get_template_part("components/user-resume-profile", null, array(
					"user" => $user,
					'additional-classes' => '',
				)); ?>
			</div>
			<div class="card-form">
				<?php get_template_part("components/user-resume-profile", null, array(
					"user" => $user,
					'additional-classes' => 'reverse',
				)); ?>
			</div>
		</div>

		<div class="container-vertical">
			<h3 class="h5 sub-title anim_els">Pills</h3>
			<div class="flex">
				<a href="" class="c-status-pill c-status-pill--default">
					<span class="c-status-pill__icon">
						<?php 
							echo "<div class='o-svg-icon o-svg-icon-close'>";                              
								include get_stylesheet_directory() . '/src/images/icons/close.svg';
							echo "</div>";
						?>
					</span>
					<span class="c-status-pill__label">#fairfield</span>
				</a>
				<a href="" class="c-status-pill c-status-pill--default">
					<span class="c-status-pill__icon">
						<?php 
							echo "<div class='o-svg-icon o-svg-icon-close'>";                              
								include get_stylesheet_directory() . '/src/images/icons/close.svg';
							echo "</div>";
						?>
					</span>
					<span class="c-status-pill__label">#seaview</span>
				</a>
				<a href="" class="c-status-pill c-status-pill--default">
					<span class="c-status-pill__icon">
						<?php 
							echo "<div class='o-svg-icon o-svg-icon-close'>";                              
								include get_stylesheet_directory() . '/src/images/icons/close.svg';
							echo "</div>";
						?>
					</span>
					<span class="c-status-pill__label">#rooftop</span>
				</a>
			</div>
		</div>
		
		<div class="container-vertical">
			<h3 class="h5 sub-title anim_els">Tooltips</h3>
			<div class="flex">
				<div class="flex">
					<?php get_template_part( 'components/tooltip', null,
							array(
								'icon' => 'information-circle',
								'content' => 'lorem Ipsum dolor es',
								'iteration' => '1',						
								'placement' => 'top',							
								'events' => 'click',							
							)
						); ?>
				</div>
				&nbsp; | &nbsp;
				<div class="flex">
					<?php get_template_part( 'components/tooltip', null,
							array(
								'icon' => 'information-circle',
								'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore',
								"iteration" => "2",
								'placement' => 'right',							
								'events' => 'hover',						
							)
						); ?>
				</div>
				<div class="flex" style="margin-top: 50px;">
					<span class="tooltip-trigger tooltip-pill" data-tooltip="tooltip-notification" data-tooltip-placement="bottom" data-tooltip-events="click">
							<div class="tooltip-trigger__content"><span class="notification_counter">3</span> notifications</div>
							<?php
							echo "<div class='o-svg-icon'>";                              
								include get_stylesheet_directory() . '/src/images/icons/alarm-bell.svg';
							echo "</div>";
							?>
					</span>
					<div class="tooltip popover" id="tooltip-notification" role="tooltip">
						<div class="popover__content">
							<div class="flex flex--vertical">
								<h3>your have X notifications</h3>
								<p>Lorem ispum</p>
							</div>
							<?php get_template_part( 'components/btn', null,
								array( 
									'label' => 'Refuse',
									'href' => "/",
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
							); ?>
							<?php get_template_part( 'components/btn', null,
								array( 
									'label' => 'Accept',
									'href' => "/",
									'target' => "_self",
									'skin'  => 'primary',
									'icon-only'  => false,
									'disabled'  => false,
									'icon-position' => 'right', // left or right
									'icon' => 'check-circle',
									'additional-classes' => 'green',
									'data-attribute' => null,
									'theme' => "",
								)
							); ?>
						</div>
						<div class="arrow"></div>
					</div>
				</div>
				<div class="flex" style="margin-top: 50px;">
					<span class="tooltip-trigger tooltip-pill notifications" data-tooltip="tooltip-notification" data-tooltip-placement="bottom" data-tooltip-events="click">
							<div class="tooltip-trigger__content"><span class="notification_counter">3</span></div>
					</span>
					<div class="tooltip tooltip--dynamic_content" id="tooltip-notification" role="tooltip">
						<div class="popover__content">
							<div class="flex flex--vertical">
								<h3>your have X notifications</h3>
								<p>Lorem ispum</p>
							</div>
							<?php get_template_part( 'components/btn', null,
								array( 
									'label' => 'Refuse',
									'href' => "/",
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
							); ?>
							<?php get_template_part( 'components/btn', null,
								array( 
									'label' => 'Accept',
									'href' => "/",
									'target' => "_self",
									'skin'  => 'primary',
									'icon-only'  => false,
									'disabled'  => false,
									'icon-position' => 'right', // left or right
									'icon' => 'check-circle',
									'additional-classes' => 'green',
									'data-attribute' => null,
									'theme' => "",
								)
							); ?>
						</div>
						<div class="arrow"></div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container-vertical">
			<h3 class="h5 sub-title anim_els">Copy paste button</h3>
				<?php get_template_part( 'components/copy-paste', null,
						array(
							'label' => 'Copier la référence client',
							'copyValue' => 'homazed.hellomarcel.be/myUrl',
							"iteration" => "3"		
						)
					); ?>
		</div>
		
		
		<div class="container-vertical">
			<h3 class="h5 sub-title anim_els">Modal</h3>
				<?php get_template_part( 'components/btn', null,
					array( 
						'label' => 'open modal',
						'href' => "/",
						'target' => "_self",
						'skin'  => 'primary',
						'icon-only'  => false,
						'disabled'  => false,
						'icon-position' => 'right', // left or right
						'icon' => 'diagram-arrow-bend-down',
						'additional-classes' => '',
						'data-attribute' => 'data-open-modal=\'modal-1\'',
						'theme' => "",
					)
				); ?>

				<div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
					<div class="modal__overlay" tabindex="-1" data-micromodal-close>
					<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
						<header class="modal__header">
							<div class="flex flex--vertical">
								<h2 class="modal__title h2" id="modal-1-title">Open Modal</h2>
							</div>
							<?php get_template_part("components/btn", null,
								array( 
									'label' => 'Close this modal window',
									'href' => "/",
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
						<main class="modal__content contact__form contact__form--light" id="modal-1-content">
							Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						</main>
					</div>
					</div>
				</div>

		</div>

		<div class="container-vertical">

			<h3 class="h4 sub-title anim_els">Buttons</h3>
			<div class="flex flex--vertical">
				<div class="mt-2">
					<h4 class="h5">Buttons Primary</h4>
					<div class="flex">
						<?php get_template_part( 'components/btn', null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'primary',
								'icon-only'  => false,
								'disabled'  => false,
								'icon-position' => 'right', // left or right
								'icon' => 'arrow-right',
								'additional-classes' => '',
								'data-attribute' => null,
								'theme' => "",
							)
						); ?>
						<?php get_template_part( 'components/btn', null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
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
						); ?>
						<?php get_template_part("components/btn", null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'primary',
								'icon-only'  => false,
								'disabled'  => false,
								'icon-position' => 'left', // left or right
								'icon' => 'messages-bubble',
								'additional-classes' => '',
								'data-attribute' => null,
								'theme' => "",
							)
						); ?>
						<?php get_template_part("components/btn", null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'primary',
								'icon-only'  => true,
								'disabled'  => false,
								'icon-position' => 'right', // left or right
								'icon' => 'real-estate-location-house-pin-1',
								'additional-classes' => 'menu-item',
								'data-attribute' => null,
								'theme' => "",
							)
						); ?>
						<?php get_template_part( 'components/btn', null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'primary',
								'icon-only'  => true,
								'disabled'  => false,
								'icon-position' => 'right', // left or right
								'icon' => 'arrow-right',
								'additional-classes' => 'menu-item',
								'data-attribute' => null,
								'theme' => ""
							)
						); ?>
					</div>
				</div>

				<div class="mt-2">
					<h4 class="h5">Buttons Ghost</h4>
					<div class="flex">
						<?php get_template_part( 'components/btn', null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'ghost',
								'icon-only'  => false,
								'disabled'  => false,
								'icon-position' => 'right', // left or right
								'icon' => 'arrow-right',
								'additional-classes' => '',
								'data-attribute' => null,
								'theme' => "",
							)
						); ?>
						<?php get_template_part( 'components/btn', null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
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
						); ?>
						<?php get_template_part("components/btn", null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'ghost',
								'icon-only'  => false,
								'disabled'  => false,
								'icon-position' => 'left', // left or right
								'icon' => 'messages-bubble',
								'additional-classes' => '',
								'data-attribute' => null,
								'theme' => "",
								'size' => "default" // default or small
							)
						); ?>
						<?php get_template_part("components/btn", null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'ghost',
								'icon-only'  => true,
								'disabled'  => false,
								'icon-position' => 'right', // left or right
								'icon' => 'real-estate-location-house-pin-1',
								'additional-classes' => 'menu-item',
								'data-attribute' => null,
								'theme' => "",
							)
						); ?>
						<?php get_template_part("components/btn", null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'ghost',
								'icon-only'  => true,
								'disabled'  => false,
								'icon-position' => 'right', // left or right
								'icon' => 'like-1',
								'additional-classes' => 'menu-item',
								'data-attribute' => null,
								'theme' => "",
							)
						); ?>
					</div>
				</div>
				
				<div class="mt-2">
					<h4 class="h5">Buttons Transparent</h4>
					<div class="flex">
						<?php get_template_part( 'components/btn', null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'transparent',
								'icon-only'  => false,
								'disabled'  => false,
								'icon-position' => 'right', // left or right
								'icon' => 'arrow-right',
								'additional-classes' => '',
								'data-attribute' => null,
								'theme' => "",
							)
						); ?>
						<?php get_template_part( 'components/btn', null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'transparent',
								'icon-only'  => false,
								'disabled'  => false,
								'icon-position' => '', // left or right
								'icon' => '',
								'additional-classes' => '',
								'data-attribute' => null,
								'theme' => "",
							)
						); ?>
						<?php get_template_part("components/btn", null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'transparent',
								'icon-only'  => false,
								'disabled'  => false,
								'icon-position' => 'left', // left or right
								'icon' => 'messages-bubble',
								'additional-classes' => '',
								'data-attribute' => null,
								'theme' => "",
							)
						); ?>
						<?php get_template_part("components/btn", null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'transparent',
								'icon-only'  => true,
								'disabled'  => false,
								'icon-position' => 'right', // left or right
								'icon' => 'real-estate-location-house-pin-1',
								'additional-classes' => '',
								'data-attribute' => null,
								'theme' => "",
							)
						); ?>
						<?php get_template_part("components/btn", null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'transparent',
								'icon-only'  => true,
								'disabled'  => false,
								'icon-position' => 'right', // left or right
								'icon' => 'like-1',
								'additional-classes' => '',
								'data-attribute' => null,
								'theme' => "",
							)
						); ?>
					</div>
				</div>

				<div class="mt-2">
					<h4 class="h5">Buttons Menu items</h4>
					<div class="flex">
						<?php get_template_part("components/btn", null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'transparent',
								'icon-only'  => true,
								'disabled'  => false,
								'icon-position' => 'right', // left or right
								'icon' => 'real-estate-location-house-pin-1',
								'additional-classes' => 'menu-item',
								'data-attribute' => null,
								'theme' => "",
							)
						); ?>
						<?php get_template_part("components/btn", null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'transparent',
								'icon-only'  => true,
								'disabled'  => false,
								'icon-position' => 'right', // left or right
								'icon' => 'like-1',
								'additional-classes' => 'menu-item',
								'data-attribute' => null,
								'theme' => "",
							)
						); ?>
						<?php get_template_part("components/btn", null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'transparent',
								'icon-only'  => true,
								'disabled'  => false,
								'icon-position' => 'right', // left or right
								'icon' => 'rating-star-ribbon',
								'additional-classes' => 'menu-item',
								'data-attribute' => null,
								'theme' => "",
							)
						); ?>
						<?php get_template_part("components/btn", null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'transparent',
								'icon-only'  => true,
								'disabled'  => false,
								'icon-position' => 'right', // left or right
								'icon' => 'diagram-arrow-bend-down',
								'additional-classes' => 'menu-item',
								'data-attribute' => null,
								'theme' => "",
							)
						); ?>
						<?php get_template_part("components/btn", null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'transparent',
								'icon-only'  => true,
								'disabled'  => false,
								'icon-position' => 'right', // left or right
								'icon' => 'filter-1',
								'additional-classes' => 'menu-item',
								'data-attribute' => null,
								'theme' => "",
							)
						); ?>
						<?php get_template_part("components/btn", null,
							array( 
								'label' => 'Voir les artistes',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'transparent',
								'icon-only'  => true,
								'disabled'  => false,
								'icon-position' => 'right', // left or right
								'icon' => 'close',
								'additional-classes' => 'menu-item',
								'data-attribute' => null,
								'theme' => "",
							)
						); ?>
					</div>
				</div>
								
			</div>
		</div>
		
		<div class="container container--default container-vertical">
			<h3 class="h4 sub-title anim_els">Cards</h3>

			<div class="flex flex--vertical wall">
				<?php
				get_template_part( 'components/card-homazed-homes', null,
					array(
						"id" => "25",
						'type' => "", /* compact or normal */
						'post_creator_link' => "/test",
						'post_creator_name' => "Lisa Perry",
						'first_name' => "Lisa",
						'last_name' => "Perry",
						'avatar' => "https://source.unsplash.com/random/?small-avatar",
						'img' => "https://source.unsplash.com/random/?house",
						'img_size' => 'thumbnail-m',
						'post_type' => "Homes",
						'post_type_slug' => "real-estate",
						'title' => "",
						'adress_name' => "364 Cypress st, Pacific Palisades, CA",
						'adress_link' => "/",
						'price' => "265 000,00",
						'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam",
						'bedrooms' => 3,
						'bathrooms' => 2,
						'house' => 1380,
						'land' => 1380,
						'publish_date' => "22 hours ago",
						'work_position' => 'Homes Agent',
						'sector_of_activity' => "Secteur d'activité",
					)
				);
				?>
				<?php
				// get_template_part( 'components/card-homazed-real', null,
				// 	array(
				// 		"id" => "25",
				// 		'type' => "", /* compact or normal */
				// 		'post_creator_link' => "",
				// 		'post_creator_name' => "Lisa Perry",
				// 		'first_name' => "Lisa",
				// 		'last_name' => "Perry",
				// 		'avatar' => "https://source.unsplash.com/random/?small-avatar",
				// 		'img' => "https://source.unsplash.com/random/?house",
				// 		'img_size' => 'thumbnail-m',
				// 		'post_type' => "Services",
				// 		'post_type_slug' => "services",
				// 		'title' => "",
				// 		'adress_name' => "364 Cypress st, Pacific Palisades, CA",
				// 		'adress_link' => "/",
				// 		'price' => "265 000,00",
				// 		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam",
				// 		'bedrooms' => 3,
				// 		'bathrooms' => 2,
				// 		'house' => 1380,
				// 		'land' => 1380,
				// 		'publish_date' => "22 hours ago",
				// 		'work_position' => 'Homes Agent',
				// 		'sector_of_activity' => "Secteur d'activité",
				// 	)
				// );
				?>
				<?php
				get_template_part( 'components/card-homazed-user', null,
					array(
						"id" => "25",
						'type' => "", /* compact or normal */
						'post_creator_link' => "",
						'post_creator_name' => "Lisa Perry",
						'first_name' => "Lisa",
						'last_name' => "Perry",
						'avatar' => "https://source.unsplash.com/random/?small-avatar",
						'img' => "https://source.unsplash.com/random/?person",
						'img_size' => 'thumbnail-m',
						'post_type' => "Users",
						'post_type_slug' => 'users',
						'title' => "",
						'adress_name' => "",
						'adress_link' => "",
						'price' => "",
						'content' => "Your bes Homes agen in fairfield ! If you are looking to buy ar sell property in the Walnut and Fairfiel areas just get in touch or give me a call",
						'bedrooms' => "",
						'bathrooms' => "",
						'house' => "",
						'land' => "",
						'publish_date' => "22 hours ago",
						'work_position' => 'Homes Agent',
						'sector_of_activity' => "Secteur d'activité",
					)
				);
				?>
				<?php
				// get_template_part( 'components/card-homazed', null,
				// 	array(
				// 		"id" => "25",
				// 		'type' => "compact", /* compact or normal */
				// 		'post_creator_link' => "",
				// 		'post_creator_name' => "Lisa Perry",
				// 		'first_name' => "Lisa",
				// 		'last_name' => "Perry",
				// 		'avatar' => "https://source.unsplash.com/random/?small-avatar",
				// 		'img' => "https://source.unsplash.com/random/?house",
				// 		'img_size' => 'thumbnail-m',
				// 		'post_type' => "Services",
				// 		'post_type_slug' => "services",
				// 		'title' => $title,
				// 		'adress_name' => "364 Cypress st, Pacific Palisades, CA",
				// 		'adress_link' => "/",
				// 		'price' => "265 000,00",
				// 		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam",
				// 		'bedrooms' => 3,
				// 		'bathrooms' => 2,
				// 		'house' => 1380,
				// 		'land' => 1380,
				// 		'publish_date' => "22 hours ago",
				// 		'work_position' => 'Homes Agent',
				// 		'sector_of_activity' => "Secteur d'activité",
				// 	)
				// );
				?>
			</div>
		</div>

		<div class="container-vertical">
			<h3 class="h5 sub-title">Typography</h3>
			<h1 class="mega-title">Whereas recognition</h1>
			<h1 class="h1">Whereas recognition of the inherent dignity</h1>
			<h2 class="h2">Whereas recognition of the inherent dignity</h2>
			<h3 class="h3">Whereas recognition of the inherent dignity</h3>
			<h4 class="h4">Whereas recognition of the inherent dignity</h4>
			<h5 class="h5">Whereas recognition of the inherent dignity</h5>
		
			<p class="p">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			<p class="p-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		</div>
		
		<div class="container--small container-vertical">
			<h3 class="h5 sub-title">Flexi-content (in container--small)</h3>
			<?php
				// flexi-text-image
				if( have_rows('content_bloc') ):
					while ( have_rows('content_bloc') ) : the_row();
						if( get_row_layout() == 'text_and_image' ):
							$content__tai__left = get_sub_field('content__tai__left');
							$content__tai__right = get_sub_field('content__tai__right');
							$title__left = $content__tai__left['title__left'];
							$paragraph__left = $content__tai__left['paragraph__left'];
							$image__right = $content__tai__right['image__right'];
							$legend__right = $content__tai__right['legend__right'];
							get_template_part( 'components/flexi-text-image', null,
							array( 
								'title' => $title__left,
								'text'  => $paragraph__left,
								'img-src'  => $image__right['sizes'],
								'img-alt'  => $image__right['alt'],
								'img-legend'  => $legend__right,
							));
						
						elseif( get_row_layout() == 'image_and_text' ):
							$content__iat__left = get_sub_field('content__iat__left');
							$content__iat__right = get_sub_field('content__iat__right');
							$title__right = $content__iat__right['title__right'];
							$paragraph__right = $content__iat__right['paragraph__right'];
							$image__left = $content__iat__left['image__left'];
							$legend__left = $content__iat__left['legend__left'];
							get_template_part( 'components/flexi-image-text', null,
							array( 
								'title' => $title__right,
								'text'  => $paragraph__right,
								'img-src'  => $image__left['sizes'],
								'img-alt'  => $image__left['alt'],
								'img-legend'  => $legend__left,
							));
						
						elseif( get_row_layout() == 'image_and_image' ):
							$content__iat__left = get_sub_field('content__iai__left');
							$content__iai__right = get_sub_field('content__iai__right');
							$image__left = $content__iai__left['image__left'];
							$legend__left = $content__iai__left['legend__left'];
							$image__right = $content__iai__right['image__right'];
							$legend__right = $content__iai__right['legend__right'];
							get_template_part( 'components/flexi-image-image', null,
							array( 
								'img-src'  => $image__left['sizes'],
								'img-alt'  => $image__left['alt'],
								'img-legend'  => $legend__left,
								'img-src-r'  => $image__right['sizes'],
								'img-alt-r'  => $image__right['alt'],
								'img-legend-r'  => $legend__right,
							));
						
						elseif( get_row_layout() == 'text_and_text' ):
							$content = get_sub_field('content__tat');
							$title = $content['title__tat'];
							$paragraph = $content['paragraph__tat'];
							get_template_part( 'components/flexi-text-text', null,
							array( 
								'title' => $title,
								'text'  => $paragraph,
							));
						
						elseif( get_row_layout() == 'image_only' ):
							$image = get_sub_field('image');
							$legend = get_sub_field('legend');
							get_template_part( 'components/flexi-image-only', null,
							array( 
								'img-src'  => $image['sizes'],
								'img-alt'  => $image['alt'],
								'img-legend'  => $legend,
							));
						endif;
					// End loop.
					endwhile;
				// No value.
				else :
					
				endif;
			?>
		</div>
	</div>





</main><!-- #main -->


<?php
get_footer();