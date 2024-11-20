
	<div class="user__actions">
		<div class="user__actions__container">
			<div class="flex flex--justify-between flex--vertical-center" data-barba-prevent="all">
				<?php if(is_page(604)){ $is_wall = " active"; }else{ $is_wall = ""; } ?>
				<?php if(is_page(1290)){ $is_map__wall = " active"; }else{ $is_map__wall = ""; } ?>
				<?php get_template_part( 'components/btn', null,
						array(
							'label' => 'Wall view',
							'href' => get_permalink("604"),
							'target' => "_self",
							'skin'  => 'transparent',
							'icon-only'  => true,
							'disabled'  => false,
							'icon-position' => '', // left or right
							'icon' => 'house-chimney-2',
							'additional-classes' => 'square act-for act-for-wall' . $is_wall,
							'data-attribute' => null,
							'theme' => "",
						)
				); ?>
				<?php get_template_part( 'components/btn', null,
						array(
							'label' => 'Map view',
							'href' => get_permalink("1290"),
							'target' => "_self",
							'skin'  => 'transparent',
							'icon-only'  => true,
							'disabled'  => false,
							'icon-position' => '', // left or right
							'icon' => 'real-estate-location-house-pin-1',
							'additional-classes' => 'square' . $is_map__wall,
							'data-attribute' => null,
							'theme' => "",
						)
				); ?>
				<?php get_template_part( 'components/btn', null,
						array(
							'label' => 'Share',
							'href' => "/",
							'target' => "_self",
							'skin'  => 'transparent',
							'icon-only'  => true,
							'disabled'  => false,
							'icon-position' => '', // left or right
							'icon' => 'messages-bubble',
							'additional-classes' => 'square',
							'data-attribute' => null,
							'theme' => "",
						)
				); ?>
				<?php get_template_part( 'components/btn', null,
						array(
							'label' => 'Share',
							'href' => "/",
							'target' => "_self",
							'skin'  => 'transparent',
							'icon-only'  => true,
							'disabled'  => false,
							'icon-position' => '', // left or right
							'icon' => 'navigation-menu',
							'additional-classes' => 'square',
							'data-attribute' => null,
							'theme' => "",
						)
				); ?>
				<?php get_template_part( 'components/btn', null,
						array(
							'label' => 'Publish',
							'href' => "/",
							'target' => "_self",
							'skin'  => 'transparent',
							'icon-only'  => true,
							'disabled'  => false,
							'icon-position' => '', // left or right
							'icon' => 'add-square',
							'additional-classes' => 'square tooltip-pill',
							'data-attribute' => 'data-tooltip=\'tooltip-publish\' data-tooltip-placement=\'top-end\' data-tooltip-events=\'click\'',
							'theme' => "",
						)
				); ?>

					<div class="tooltip" id="tooltip-publish" role="tooltip">
						<div class="popover__content">
							<div class="flex flex--vertical">
								<?php get_template_part( 'components/btn', null,
										array(
										'label' => 'Publish home',
										'href' => "/",
										'target' => "_self",
										'skin'  => 'transparent',
										'icon-only'  => false,
										'disabled'  => false,
										'icon-position' => 'right', // left or right
										'icon' => 'add-square',
										'additional-classes' => '',
										'data-attribute' => 'data-open-modal=\'publish-home\'',
										'theme' => "",
										)
								); ?>
							</div>

						</div>
						<div class="arrow"></div>
					</div>
			</div>
		</div>
	</div>

	<div class="modal micromodal-slide modal--publish" id="publish-home" aria-hidden="true">
		<div class="modal__overlay" tabindex="-1" data-micromodal-close>
			<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="publish-home-title">
				<header class="modal__header">
					<div class="flex flex--vertical">
						<h2 class="modal__title h2" id="publish-home-title">Share your HOME post</h2>
					</div>
					<?php get_template_part("components/btn", null, array( 'label' => 'Close this modal window', 'href' => "", 'target' => "_self", 'skin'  => 'transparent', 'icon-only'  => true, 'disabled'  => false, 'icon-position' => 'right', 'icon' => 'close', 'additional-classes' => '', 'data-attribute' => 'data-close-modal', 'theme' => "", )); ?>
				</header>
				<main class="modal__content contact__form contact__form--light" id="publish-home-content">
					<?php
					   $account_type = get_field("user_account_type", "user_".get_current_user_id());
					/**
					 * todo_augustin type de compte
					 * */
					echo '<input type="hidden" value="'.$account_type["value"].'" id="_account_type_id_">';
					// var_dump($account_type);
//					   if($account_type && $account_type["value"] == "individual_user" ) {
						echo do_shortcode( '[gravityform id="1" ajax="true" title="false"]' );
//					   } else {
//						echo do_shortcode( '[gravityform id="16" ajax="true" title="false"]' );
//					   }


					?>
				</main>
			</div>
		</div>
	</div>


	</div>





	<?php wp_footer(); ?>
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

	<script src="https://unpkg.com/leaflet-geosearch@latest/dist/bundle.min.js"></script>
</body>
</html>
