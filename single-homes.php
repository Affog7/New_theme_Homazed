<?php get_header(); ?>

<?php
$current_user_id = get_current_user_id();
global $post;
$post_id = get_the_ID();

?>

<main class="main" role="main" data-barba="container" data-barba-namespace="post" data-theme="theme-light" data-admin-ajax=<?php echo admin_url( 'admin-ajax.php' ); ?>>
	<span class="hide current_user_id page_user_id" data-u-id="<?php echo $current_user_id; ?>"></span>
	<div class="container container--default public-profile tabs-group">
		<?php
			$author_id = $post->post_author;
			$author_data = get_user_by("id", intval($author_id));
			$author_profile_picture = get_field("user_profile_picture", "user_".$author_id);
			$author_first_name = get_field("user_first_name", "user_".$author_id);
			$author_last_name = get_field("user_last_name", "user_".$author_id);
			$author_permalink = get_permalink("602")."?user_id=".$author_id;
			$author_phone_number = get_field("user_phone_number", "user_".$author_id);
			$author_connections = get_field("user_connections", "user_".$author_id);
			$author_profile_privacy = get_field("user_profile_privacy", "user_".$author_id);
			$author_connections_settings = get_field("user_connections_settings", "user_".$author_id);
			$author_email_address = $author_data->user_email;
			$author_website_link = get_field("user_website_link", "user_".$author_id);
			$author_online_shop_link = get_field("user_online_shop_link", "user_".$author_id);

			// todo_augustin champs link
			$post_author_link = get_field("post_author_link",$post_id);
			$post_Add_my_webshop_link = get_field("post_Add_my_webshop_link", $post_id);
			$post_home_event_privacy = get_field("home_event_privacy", $post_id);

			$post_home_action_value = get_field("post_home_action", $post_id);
			switch ($post_home_action_value) {
				case "sale": $post_home_action_translate = "for Sale"; break;
				case "rent": $post_home_action_translate = "for Rent"; break;
				case "sold": $post_home_action_translate = "sold"; break;
				case "rented": $post_home_action_translate = "rented"; break;
			}
			$post_home_category_value = get_field("post_home_category", $post_id);
			switch ($post_home_category_value) {
				case "house": $post_home_category_translate = "House"; break;
				case "apartment": $post_home_category_translate = "Apartment"; break;
				case "new_construction": $post_home_category_translate = "New construction"; break;
				case "land_plot": $post_home_category_translate = "Land/Plot"; break;
				case "office": $post_home_category_translate = "Office"; break;
				case "commercial_industry": $post_home_category_translate = "Commercial/Industry"; break;
				case "garage_parking": $post_home_category_translate = "Garage/Parking"; break;
				case "other": $post_home_category_translate = "Other"; break;
			}
			$post_title = get_field("post_home_title") ? get_field("post_home_title") : get_the_title();
			$post_link = get_the_permalink($post_id);;
			$post_imgs = get_field("post_home_gallery", $post_id);
			$post_gallery_image_ids = get_field("post_home_gallery_ids", $post_id);
			$post_gallery_image_ids_array = explode(',', $post_gallery_image_ids);
			$post_main_content = get_the_content();
			$post_main_content_excerpt = get_the_excerpt();
			$post_price = get_field("post_home_price", $post_id);
			$post_bedrooms = get_field("post_home_number_of_bedrooms", $post_id);
			$post_bathrooms = get_field("post_home_number_of_bathrooms", $post_id);
			$post_home_size = get_field("post_home_size", $post_id);
			$post_outdoor_size = get_field("post_home_outdoor_size", $post_id);
			$post_home_amenities = get_field("post_home_amenities", $post_id);
			$post_home_year_built = get_field("post_home_year_built", $post_id);
			$post_neighborhood_amenities = get_field("post_home_neighborhood_amenities", $post_id);
			$post_transportation = get_field("post_home_transportation", $post_id);
			$post_garages_parking = get_field("post_home_garages_parking", $post_id);
			$post_schools = get_field("post_home_schools_nearby", $post_id);
			$post_home_style_architecture = get_field("post_home_style_and_architecture", $post_id);
			$post_additional_features = get_field("post_home_additional_home_features", $post_id);
			$post_taxes = get_field("post_home_property_taxes", $post_id);
			$post_fees = get_field("post_home_other_property_fees", $post_id);
			$post_systems = get_field("post_heating_cooling_systems", $post_id);
			$post_energy_rating = get_field("post_home_energy_rating", $post_id);

			$post_energy_consumption = get_field("post_home_estimated_energy_rating_energy_consumption", $post_id);

			//$post_address = get_field("post_location_address") . ", " . get_field("post_location_zip") . " " . get_field("post_location_city");
			$post_address = get_field("post_location_address") ? get_field("post_location_address") . ", " . get_field("post_location_zip") . " " . get_field("post_location_city") : get_field("post_address");


			$post_location_latitude = get_field("post_location_latitude");
			$post_location_longitude = get_field("post_location_longitude");
			$post_post_tags = get_the_terms($post_id, 'posttags');
			$post_join_file_id = get_field("post_home_join_file");
			$post_join_file = wp_get_attachment_url($post_join_file_id);

			$post_events_type = get_field("post_home_event_type");
			$post_events_text_1 = get_field("post_home_event_text_1");
			$post_events_text_2 = get_field("post_home_event_text_2");
			$post_events_privacy = get_field("post_home_event_privacy");

			$i_favorite_posts_relationships = get_field("i_favorite_posts_relationships", "user_".$current_user_id);
			$i_like_posts_relationships = get_field("i_like_posts_relationships", "user_".$current_user_id);

			$users_like_me_posts = get_field("users_like_me_posts", $post_id);
			$users_favorite_me_posts = get_field("users_favorite_me_posts", $post_id);

			$main_picture_image_ids = get_field("post_home_main_picture_ids", $post_id);
			$main_picture_image_ids_array = explode(',', $main_picture_image_ids);
			$post_avatar_picture_id = ($main_picture_image_ids_array[0]) ? $main_picture_image_ids_array[0] : $post_gallery_image_ids_array[0];

			$id_entry = get_field("_gravityformsadvancedpostcreation_entry_id", $post_id);
			$video_ =  do_shortcode( '[gf_entry_meta entry_id='.$id_entry.' meta_key="139"]');
		?>

		<!-- Post resume -->
		<div class="card-form content" data-barba-prevent="all">
			<div class="resume">
				<?php get_template_part("components/post-avatar", null, array(
						'post_main_picture' => wp_get_attachment_image_src($post_avatar_picture_id, 'large-img-medium'),
						'title' => $post_title,
				) ); ?>

				<div class="resume__data">
					<div class="flex flex--vertical-center">
						<h2 class="resume__name card-form__title"><?php echo $post_title; ?></h2>
					</div>

					<p style="float: right;"><?php echo $post_home_category_translate; ?> <?php echo $post_home_action_translate; ?></p>

					<ul class="resume__account-creation">
						<?php if(!empty($post_address)): ?>
							<li><?php echo $post_address; ?></li>
						<?php else: ?>
							<li>No Localization found</li>
						<?php endif; ?>
					</ul>

					<?php //todo_augustin ?>
					<a class="resume__owner" href="<?php //echo $author_permalink; ?>"><?php //echo $author_first_name . " " . $author_last_name;  ?></a>
				</div>
			</div>
		</div>

		<div class="profile-actions" data-barba-prevent="all">
			<!-- Profile display -->
			<div class="left">
				<div class="btn-group btn-group--related">
					<?php get_template_part( 'components/btn', null,
						array(
							'label' => 'List',
							'href' => "",
							'target' => "_self",
							'skin'  => 'ghost',
							'icon-only'  => false,
							'disabled'  => false,
							'icon-position' => '', // left or right
							'icon' => '',
							'additional-classes' => 'tab-button',
							'data-attribute' => 'data-tabs-id=\'tabs-list\'',
							'theme' => "",
						)
					); ?>
					<?php get_template_part( 'components/btn', null,
							array(
								'label' => 'Grid',
								'href' => "",
								'target' => "_self",
								'skin'  => 'ghost',
								'icon-only'  => false,
								'disabled'  => false,
								'icon-position' => '', // left or right
								'icon' => '',
								'additional-classes' => 'tab-button',
								'data-attribute' => 'data-tabs-id=\'tabs-grid\'',
								'theme' => "",
							)
						); ?>
					<?php get_template_part( 'components/btn', null,
							array(
								'label' => 'Map',
								'href' => "",
								'target' => "_self",
								'skin'  => 'ghost',
								'icon-only'  => false,
								'disabled'  => false,
								'icon-position' => '', // left or right
								'icon' => '',
								'additional-classes' => 'tab-button',
								'data-attribute' => 'data-tabs-id=\'tabs-map\'',
								'theme' => "",
							)
						); ?>
				</div>

					<?php get_template_part( 'components/btn', null,
						array(
							'label' => 'Home',
							'href' => "",
							'target' => "_self",
							'skin'  => 'ghost',
							'icon-only'  => true,
							'disabled'  => false,
							'icon-position' => '',
							'icon' => 'house-chimney-2',
							'additional-classes' => 'tab-button square active',
							'data-attribute' => 'data-tabs-id=\'tabs-home\'',
							'theme' => "",
						)
					); ?>


				<?php //todo_augustin manage slate
//				if (get_current_user_id() == $author_id) : ?>
<!--					<a href="/manageslate/?post=--><?php //echo $post_id; ?><!--" title="Manage-Slate"   class="btn btn--ghost btn--icon  square active" >-->
<!--						<span class="btn__content">-->
<!--							<span class="u-sr-accessible">Manage Slate</span>-->
<!--							<div class="o-svg-icon ">-->
<!--								<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill-rule="evenodd" clip-rule="evenodd" d="M19.85 8.75l4.15.83v4.84l-4.15.83 2.35 3.52-3.43 3.43-3.52-2.35-.83 4.15H9.58l-.83-4.15-3.52 2.35-3.43-3.43 2.35-3.52L0 14.42V9.58l4.15-.83L1.8 5.23 5.23 1.8l3.52 2.35L9.58 0h4.84l.83 4.15 3.52-2.35 3.43 3.43-2.35 3.52zm-1.57 5.07l4-.81v-2l-4-.81-.54-1.3 2.29-3.43-1.43-1.43-3.43 2.29-1.3-.54-.81-4h-2l-.81 4-1.3.54-3.43-2.29-1.43 1.43L6.38 8.9l-.54 1.3-4 .81v2l4 .81.54 1.3-2.29 3.43 1.43 1.43 3.43-2.29 1.3.54.81 4h2l.81-4 1.3-.54 3.43 2.29 1.43-1.43-2.29-3.43.54-1.3zm-8.186-4.672A3.43 3.43 0 0 1 12 8.57 3.44 3.44 0 0 1 15.43 12a3.43 3.43 0 1 1-5.336-2.852zm.956 4.274c.281.188.612.288.95.288A1.7 1.7 0 0 0 13.71 12a1.71 1.71 0 1 0-2.66 1.422z"></path></g></svg>-->
<!--							</div>-->
<!--						</span>-->
<!--					</a>-->
<!--				--><?php //endif; ?>


			</div>

			<!-- Profile quick actions -->
			<div class="flex profile-actions__quick-actions btn-group">
				<?php if(get_current_user_id() != $author_id): ?>

					<?php $is_checked_favorite = (!empty($i_favorite_posts_relationships) && in_array($post_id, $i_favorite_posts_relationships)) ? true : false; ?>

					<?php get_template_part("components/btn", null, array(
						'label' => 'Favorite',
						'href' => "",
						'target' => "_self",
						'skin'  => 'ghost',
						'icon-only'  => true,
						'disabled'  => false,
						'icon-position' => '', // left or right
						'icon' => 'rating-star-ribbon', // nom du fichier svg
						'additional-classes' => $is_checked_favorite ? 'post-footer__button relation_btn--checked relation_btn relation_btn--favorite' : 'post-footer__button relation_btn relation_btn--favorite',
						'data-attribute' => "data-relation-him=" . $post_id . " data-relation-type='favorite'",
						'theme' => "",
					)); ?>
				<?php else: ?>

				<?php get_template_part( 'components/btn', null,
					array(
						'label' => 'Edit post',
						'href' => "/",
						'target' => "_self",
						'skin'  => 'ghost',
						'icon-only'  => false,
						'disabled'  => false,
						'icon-position' => 'left',
						'icon' => 'pencil-write',
						'additional-classes' => 'square edit_post_main',
						'data-attribute' => '',
						'theme' => "",
					)
				); ?>
				<?php endif; ?>
				<?php get_template_part( 'components/btn', null,
					array(
						'label' => 'Share',
						'href' => "/",
						'target' => "_self",
						'skin'  => 'ghost',
						'icon-only'  => true,
						'disabled'  => false,
						'icon-position' => '',
						'icon' => 'diagram-arrow-bend-down',
						'additional-classes' => 'square',
						'data-attribute' => 'data-open-modal=\'share-post\'',
						'theme' => "",
					)
				); ?>
			</div>
		</div>

<!-- todo_augustin -->
<!-- Popup Structure with Multi-Step Form -->
<div id="editPostPopup" class="popup" style="display: none;">
   <div class="popup-content">
   	  <div class="popup-header">
         <h2>Home Post</h2>
         <div class="popup-controls">
			 <?php
			 // Récupérer le statut actuel du post
			 $current_status = get_post_status($post_id);

			 // Définir un libellé pour chaque statut
			 $status_labels = array(
				 'publish'  => 'Active',
				 'private'  => 'Inactive',
				 'draft'    => 'Erase',
			 );

			 // Vérifier si le statut actuel est dans le tableau, sinon par défaut 'Active'
			 $current_label = isset($status_labels[$current_status]) ? $status_labels[$current_status] : 'Active';
			 ?>

			 <div class="dropdown">
				 <!-- Affichage dynamique du statut actuel -->
				 <span id="post-status" class="active-status" onclick="toggleDropdown()">
        <?php echo esc_html($current_label); ?> ▼
    </span>
				 <div id="status-options" class="dropdown-content">
					 <a href="#" onclick="setStatus('publish', <?php echo $post_id; ?>)">Active</a>
					 <a href="#" onclick="setStatus('private', <?php echo $post_id; ?>)">Inactive</a>
					 <a href="#" onclick="setStatus('draft', <?php echo $post_id; ?>)">Erase</a>
				 </div>
			 </div>

            <button id="update-button" class="button-update">Update</button>
            <span class="close-btn-circle">&times;</span>
         </div>
      </div>

      <!-- Divider -->
      <hr>

      <!-- Sommaire (Step 0) -->
      <div class="form-step" id="step0">
         <h3>Sommaire des étapes</h3>
         <ul class="step-list">
            <li><a href="#" onclick="goToStep(1)">Media</a></li>
            <li><a href="#" onclick="goToStep(2)">Location</a></li>
            <li><a href="#" onclick="goToStep(3)">Texts & Key Info</a></li>
            <li><a href="#" onclick="goToStep(4)">Connections</a></li>
            <li><a href="#" onclick="goToStep(5)">Event</a></li>
            <li><a href="#" onclick="goToStep(6)">Premium</a></li>
         </ul>
      </div>

      <!-- Autres étapes du formulaire -->
      <div class="form-step" id="step1" style="display:none;">
         <h3>Media</h3>
         <main class="modal__content contact__form contact__form--light">
					<?php echo do_shortcode( '[gravityform id="4" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
				</main>
      </div>
      <div class="form-step" id="step2" style="display:none;">
         <h3>Location</h3>
		  <main class="modal__content contact__form contact__form--light">
			  <?php echo do_shortcode( '[gravityform id="19" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
		  </main>
      </div>
      <div class="form-step" id="step3" style="display:none;">
         <h3>Texts & Key Info</h3>
		<main class="modal__content contact__form contact__form--light">

		<?php echo do_shortcode( '[gravityform id="3" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>

		<?php echo do_shortcode( '[gravityform id="13" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>

		<?php echo do_shortcode( '[gravityform id="14" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>

		 <?php echo do_shortcode( '[gravityform id="7" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>

		 <?php echo do_shortcode( '[gravityform id="8" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>

		</main>
      </div>
      <div class="form-step" id="step4" style="display:none;">
         <h3>Connections</h3>
		 <main class="modal__content contact__form contact__form--light">
					<?php echo do_shortcode( '[gravityform id="11" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
		</main>      </div>
      <div class="form-step" id="step5" style="display:none;">
         <h3>Event</h3>
         <main class="modal__content contact__form contact__form--light">
					<?php echo do_shortcode( '[gravityform id="15" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
				</main>
      </div>
      <div class="form-step" id="step6" style="display:none;">
         <h3>Premium</h3>
         <!-- Champs relatifs à Premium -->
      </div>

      <!-- Contrôles de navigation -->
      <div class="form-navigation">
         <button id="prevBtn" onclick="navigateSteps(-1)">Previous</button>
         <span id="step-count">0 / 6</span>
         <button id="nextBtn" onclick="navigateSteps(1)">Next</button>
      </div>
		<div>
			<p class="active-status" id="status_notif_"></p>
		</div>

   </div>
</div>




<!-- fin todo_augustin -->
		<div class="tab-content default-bckg post-page <?php if(isset($post_gallery_image_ids_array) && count($post_gallery_image_ids_array) > 1 ){  echo "carrousel glide"; } ?>" data-barba-prevent="all" id="tabs-home">
			<div class="post-page__section">
				<?php if($post_price || $post_bedrooms || $post_bathrooms || $post_home_size || $post_outdoor_size): ?>
					<div class="flex flex--justify-between">
						<?php if($post_price): ?>
							<?php if($current_user_id == $author_id): ?>
								<div class="flex">
									<div class="flex edit-area hide">
										<?php
										// get_template_part( 'components/btn', null,
										// 	array(
										// 		'label' => 'Edit price',
										// 		'href' => "/",
										// 		'target' => "_self",
										// 		'skin'  => 'highlight',
										// 		'icon-only'  => true,
										// 		'disabled'  => false,
										// 		'icon-position' => '',
										// 		'icon' => 'pencil-write',
										// 		'additional-classes' => 'btn--xsmall btn--inline edit_post_btn mg-r-1',
										// 		'data-attribute' => 'data-open-modal=\'edit-post--price\'',
										// 		'theme' => "",
										// 	)
										// ); ?>
									</div>
								<?php endif; ?>
								<?php get_template_part( 'components/price', null, array(
									'price' => $post_price, )
								); ?>
								<?php if($current_user_id == $author_id): ?></div><?php endif; ?>
						<?php endif; ?>
						<?php if($post_bedrooms || $post_bathrooms || $post_home_size || $post_outdoor_size): ?>
							<ul class="post-details__caracteristics flex flex--vertical-center">
								<?php if($current_user_id == $author_id): ?>
									<li class="edit-area hide">
										<?php
										// get_template_part( 'components/btn', null,
										// 	array(
										// 		'label' => 'Edit details',
										// 		'href' => "/",
										// 		'target' => "_self",
										// 		'skin'  => 'highlight',
										// 		'icon-only'  => true,
										// 		'disabled'  => false,
										// 		'icon-position' => '',
										// 		'icon' => 'pencil-write',
										// 		'additional-classes' => 'btn--xsmall btn--inline edit_post_btn mg-r-1',
										// 		'data-attribute' => 'data-open-modal=\'edit-post--details-sizes\'',
										// 		'theme' => "",
										// 	)
										// ); ?>
									</li>
								<?php endif; ?>
								<?php if($post_bedrooms): ?>
									<li class="post-details__bedroom">
										<span class="post-details__prefix p-xs">BDR</span>
										<?php echo str_replace(' ', '', $post_bedrooms); ?>
									</li>
								<?php endif; ?>
								<?php if($post_bathrooms): ?>
								<li class="post-details__bathroom">
									<span class="post-details__prefix p-xs">BTH</span>
									<?php echo str_replace(' ', '', $post_bathrooms); ?>
								</li>
								<?php endif; ?>
								<?php if($post_home_size): ?>
								<li class="post-details__house">
									<span class="post-details__prefix p-xs">H</span>
									<?php echo str_replace(' ', '', $post_home_size); ?><span class="post-details__suffix p-xs">m2</span>
								</li>
								<?php endif; ?>
								<?php if($post_outdoor_size): ?>
								<li class="post-details__land">
									<span class="post-details__prefix p-xs">L</span>
									<?php echo str_replace(' ', '', $post_outdoor_size); ?><span class="post-details__suffix p-xs">m2</span>
								</li>
								<?php endif; ?>
							</ul>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
			<div class="post-page__section bt-2">
				<?php if(isset($post_gallery_image_ids_array) ): ?>
					<div class="profile-content__img glide">
						<div class="post-page__section floating-bar flex flex--vertical-center">

								<?php if($current_user_id == $author_id): ?>
									<div class="edit-area hide">
										<?php
										//  get_template_part( 'components/btn', null,
										// 	array(
										// 		'label' => 'Edit file',
										// 		'href' => "/",
										// 		'target' => "_self",
										// 		'skin'  => 'highlight',
										// 		'icon-only'  => true,
										// 		'disabled'  => false,
										// 		'icon-position' => '',
										// 		'icon' => 'pencil-write',
										// 		'additional-classes' => 'btn--xsmall btn--inline edit_post_btn mg-r-1',
										// 		'data-attribute' => 'data-open-modal=\'edit-post--files\'',
										// 		'theme' => "",
										// 	)
										// ); ?>
									</div>
								<?php endif; ?>
								<?php if($post_join_file): ?>
								<?php get_template_part( 'components/btn', null,
										array(
											'label' => 'File',
											'href' => $post_join_file,
											'target' => "_blank",
											'skin'  => 'ghost',
											'icon-only'  => false,
											'disabled'  => false,
											'icon-position' => 'left',
											'icon' => 'hyperlink-2',
											'additional-classes' => '',
											'data-attribute' => '',
											'theme' => "",
										)
									); ?>
								<?php endif; ?>
							<?php if(!empty($video_) && $video_): ?>
								<?php get_template_part( 'components/btn', null,
									array(
										'label' => 'Video',
										'href' => esc_url(stripslashes($video_)),
										'target' => "_blank",
										'skin'  => 'ghost',
										'icon-only'  => false,
										'disabled'  => false,
										'icon-position' => 'left',
										'icon' => 'hyperlink-2',
										'additional-classes' => 'btn--small',
										'data-attribute' => '',
										'theme' => "",
									)
								); ?>
							<?php endif; ?>
								<span class="gallery__size flex flex--vertical-center flex--horizontal-center">
									<b><?php echo count($post_gallery_image_ids_array); ?></b>
									<?php
										echo "<div class='o-svg-icon o-svg-icon-paginate-filter-picture'>";
											include get_stylesheet_directory() . '/src/images/icons/paginate-filter-picture.svg';
										echo "</div>";
									?>
								</span>
						</div>

						<?php if(count($post_gallery_image_ids_array) > 1): ?>
							<?php get_template_part("components/carrousel-post", null, array(
								'img' => $post_gallery_image_ids_array,
								'post_creator_name' => $post_title,
							)); ?>
						<?php elseif(!empty($post_gallery_image_ids_array[0])): ?>
							<?php get_template_part("components/carrousel-single-image", null, array(
								'img' => $post_gallery_image_ids_array,
								'post_creator_name' => $post_title,
							)); ?>
					<?php else: ?>
						<p>No images for now</p>
					<?php endif; ?>
					</div>
					<?php if($current_user_id == $author_id): ?>
						<div class="edit-area hide">
							<?php
							//  get_template_part( 'components/btn', null,
							// 		array(
							// 			'label' => 'Edit images',
							// 			'href' => "/",
							// 			'target' => "_self",
							// 			'skin'  => 'highlight',
							// 			'icon-only'  => false,
							// 			'disabled'  => false,
							// 			'icon-position' => 'left',
							// 			'icon' => 'pencil-write',
							// 			'additional-classes' => 'btn--small edit_post_btn btn--inline',
							// 			'data-attribute' => 'data-open-modal=\'edit-post--images\'',
							// 			'theme' => "",
							// 		)
							// 	); ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>

			<div class="post-page__section bt-2">
				<?php if($current_user_id == $author_id): ?>
					<div class="flex edit-area hide">
					<?php
					//  get_template_part( 'components/btn', null,
					// 		array(
					// 			'label' => 'Edit events',
					// 			'href' => "/",
					// 			'target' => "_self",
					// 			'skin'  => 'highlight',
					// 			'icon-only'  => false,
					// 			'disabled'  => false,
					// 			'icon-position' => 'left',
					// 			'icon' => 'pencil-write',
					// 			'additional-classes' => 'btn--small edit_post_btn btn--inline',
					// 			'data-attribute' => 'data-open-modal=\'edit-post--events\'',
					// 			'theme' => "",
					// 		)
					// 	); ?>
				<?php endif; ?>
				<?php if($current_user_id == $author_id): ?></div><?php endif; ?>

				<div class="event event--tour">
					<div class="event__frame">
						<a class="event__frame__link" href="/?">Schedule my tour</a>
					</div>
				</div>

				<?php if($post_events_text_1): ?>
					<?php get_template_part( 'components/event', null,
						array(
							'event_type' => $post_events_type,
							'event_privacy' => $post_events_privacy,
							'text_1' => $post_events_text_1,
							'text_2' => $post_events_text_2,
						)
					); ?>
				<?php endif; ?>
			</div>

			<div class="post-page__section bt-2">
				<?php if($current_user_id == $author_id): ?>
					<div class="flex edit-area hide">
					<?php
					// get_template_part( 'components/btn', null,
					// 	array(
					// 		'label' => 'Edit tags',
					// 		'href' => "/",
					// 		'target' => "_self",
					// 		'skin'  => 'highlight',
					// 		'icon-only'  => false,
					// 		'disabled'  => false,
					// 		'icon-position' => 'left',
					// 		'icon' => 'pencil-write',
					// 		'additional-classes' => 'btn--small edit_post_btn btn--inline',
					// 		'data-attribute' => 'data-open-modal=\'edit-post--tags\'',
					// 		'theme' => "",
					// 	)
					// ); ?>
				<?php endif; ?>
				<?php if($current_user_id == $author_id): ?></div><?php endif; ?>

				<?php /* todo_augustin  tags */
				if($post_post_tags): ?>
					<div class="tag-list-container">
						<span class="chevron left-chevron">&#9664;</span>
						<div class="tag-list-wrapper">
							<div class="tag-list">
								<p>
									<?php foreach ($post_post_tags as $tag): ?>
										<a href="<?php echo get_permalink("604"); ?>?tag=<?php echo $tag->slug ?>" class="tag">
											<span class="hash">#</span><?php echo $tag->name; ?>
										</a>
									<?php endforeach; ?>
								</p>
							</div>
						</div>
						<span class="chevron right-chevron">&#9654;</span>
					</div>
				<?php endif; ?>
			</div>




			<div class="post-page__section bt-2">
				<?php if($current_user_id == $author_id): ?>
					<div class="flex edit-area hide">
					<?php
					// get_template_part( 'components/btn', null,
					// 		array(
					// 			'label' => 'Edit description',
					// 			'href' => "/",
					// 			'target' => "_self",
					// 			'skin'  => 'highlight',
					// 			'icon-only'  => false,
					// 			'disabled'  => false,
					// 			'icon-position' => 'left',
					// 			'icon' => 'pencil-write',
					// 			'additional-classes' => 'btn--small edit_post_btn btn--inline',
					// 			'data-attribute' => 'data-open-modal=\'edit-post--description\'',
					// 			'theme' => "",
					// 		)
					// 	); ?>
				<?php endif; ?>
				<?php if($current_user_id == $author_id): ?></div><?php endif; ?>

				<?php
					// todo_augustin
					limiterLignes($post_main_content,32); ?>
			</div>
			<?php if ($author_data): ?>
				<div class="post-page__section bt-2">
					<?php get_template_part("components/user-resume-on-post", null, array(
							"user" => $author_data,
							'additional-classes' => '',
						)); ?>
				</div>
			<?php endif; ?>

			<?php if($author_email_address || $author_phone_number || $author_website_link || $post_Add_my_webshop_link) : ?>
				<div class="post-page__section bt-2 content">
					<ul class="contact__list">
						<?php if($author_email_address): ?>
							<li class="contact__list__item">
								<a href="<?php echo "mailto:" . $author_email_address; ?>" target="_blank">
									<svg fill="#000000" height="20" width="20" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M256,0C114.609,0,0,114.609,0,256s114.609,256,256,256s256-114.609,256-256S397.391,0,256,0z M256,472 c-119.297,0-216-96.703-216-216S136.703,40,256,40s216,96.703,216,216S375.297,472,256,472z"></path> <g> <path d="M368,234.375v74.438l-54.5-59.422l16.719-11.312c-5.984-1.531-11.641-3.922-16.688-7.203L256,271.75L166.281,208H256 h37.625c-2.391-4.984-4-10.344-4.812-16H256H128v160h128h128V223.062C379.422,227.75,373.969,231.531,368,234.375z M144,212.531 l54.5,36.859L144,308.812V212.531z M256,336h-92.406l45.562-79.422L256,288.25l46.844-31.672L348.406,336H256z"></path> </g> <path d="M344,144c-22.094,0-40,17.906-40,40s17.906,40,40,40s40-17.906,40-40S366.094,144,344,144z M344,214.406L324.797,192H336 v-32h16v32h11.203L344,214.406z"></path> </g> </g></svg>
									Send a message
								</a>
							</li>
						<?php endif; ?>

						<?php if($author_phone_number && in_array("phone_calls_available", $author_connections_settings)): ?>
							<li class="contact__list__item">
								<a href="<?php echo "tel:" . $author_phone_number; ?>" target="_blank">
									<svg viewBox="0 0 24 24" height="20" width="20" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M10 8H8.44444C8.2 8 8 8.2 8 8.44444C8 12.6178 11.3822 16 15.5556 16C15.8 16 16 15.8 16 15.5556V14.0044C16 13.76 15.8 13.56 15.5556 13.56C15.0044 13.56 14.4667 13.4711 13.9689 13.3067C13.9244 13.2889 13.8756 13.2844 13.8311 13.2844C13.7156 13.2844 13.6044 13.3289 13.5156 13.4133L12.5378 14.3911C11.28 13.7467 10.2489 12.72 9.60889 11.4622L10.5867 10.4844C10.7111 10.36 10.7467 10.1867 10.6978 10.0311C10.5333 9.53333 10.4444 9 10.4444 8.44444C10.4444 8.2 10.2444 8 10 8ZM9.77333 10.04C9.66667 9.67111 9.6 9.28444 9.57333 8.88889H8.90222C8.94222 9.47556 9.05778 10.04 9.24 10.5733L9.77333 10.04ZM15.1111 14.4311C14.72 14.4044 14.3333 14.3378 13.9556 14.2311L13.4222 14.76C13.96 14.9378 14.5244 15.0533 15.1111 15.0933V14.4311Z" fill="#000000"></path> <path d="M13.2216 9.52112V9.10456H15.3044V11.1874H14.8879V9.81568L12.9376 11.766L12.643 11.4714L14.5933 9.52112H13.2216Z" fill="#000000"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20Z" fill="#000000"></path> </g></svg>
									Call
								</a>
							</li>
						<?php endif; ?>

						<?php if($author_website_link && in_array("add_website_link", $author_connections_settings)): ?>
							<li class="contact__list__item">
								<a href="<?php echo esc_url($author_website_link); ?>" target="_blank">
									<svg viewBox="0 0 64 64" height="20" width="20" xmlns="http://www.w3.org/2000/svg" stroke-width="3" stroke="#000000" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M39.93,55.72A24.86,24.86,0,1,1,56.86,32.15a37.24,37.24,0,0,1-.73,6"></path><path d="M37.86,51.1A47,47,0,0,1,32,56.7"></path><path d="M32,7A34.14,34.14,0,0,1,43.57,30a34.07,34.07,0,0,1,.09,4.85"></path><path d="M32,7A34.09,34.09,0,0,0,20.31,32.46c0,16.2,7.28,21,11.66,24.24"></path><line x1="10.37" y1="19.9" x2="53.75" y2="19.9"></line><line x1="32" y1="6.99" x2="32" y2="56.7"></line><line x1="11.05" y1="45.48" x2="37.04" y2="45.48"></line><line x1="7.14" y1="32.46" x2="56.86" y2="31.85"></line><path d="M53.57,57,58,52.56l-8-8,4.55-2.91a.38.38,0,0,0-.12-.7L39.14,37.37a.39.39,0,0,0-.46.46L42,53.41a.39.39,0,0,0,.71.13L45.57,49Z"></path></g></svg>
									Website
								</a>
							</li>
						<?php endif; ?>

						<?php if($author_online_shop_link && in_array("add_online_shop_link", $author_connections_settings)): ?>
							<li class="contact__list__item">
								<a href="<?php echo $author_online_shop_link; ?>" target="_blank">
									<svg fill="#000000" height="20" width="20" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 491.52 491.52" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M491.52,419.84V0H0v419.84h153.6v51.2h-40.96v20.48h266.24v-20.48h-40.96v-51.2H491.52z M20.48,20.48h450.56v317.44H20.48 V20.48z M317.44,471.04H174.08v-51.2h143.36V471.04z M20.48,399.36V358.4h450.56v40.96H20.48z"></path> </g> </g> <g> <g> <path d="M386.67,128.24l-23.88-66.8h-53.555H288.43H256h-20.48h-32.43h-20.805H128.73l-23.88,66.8 c-4.605,12.9-2.715,26.74,5.2,37.96c3.427,4.869,7.843,8.833,12.83,11.842V296.96h245.76V178.042 c4.987-3.01,9.402-6.973,12.83-11.842C389.385,154.98,391.275,141.14,386.67,128.24z M348.36,81.92l14.639,40.96h-42.779 L312.9,81.92H348.36z M256,81.92h36.091l7.323,40.96H256V81.92z M302.506,143.36c-0.225,4.526-1.904,8.841-4.951,12.48 c-4.255,5.08-10.565,8-17.315,8h-1.94c-11.892,0-21.556-9.099-22.181-20.48H302.506z M199.429,81.92h36.091v40.96h-43.414 L199.429,81.92z M235.401,143.36c-0.626,11.381-10.289,20.48-22.181,20.48h-1.94c-6.75,0-13.06-2.92-17.315-8 c-3.047-3.639-4.726-7.954-4.951-12.48H235.401z M143.16,81.92h35.46l-7.319,40.96h-42.783L143.16,81.92z M126.79,154.41 c-2.357-3.349-3.53-7.161-3.738-11.05h44.589l-0.456,2.55c-1.86,10.39-11.1,17.93-21.975,17.93 C137.725,163.84,131.015,160.4,126.79,154.41z M348.16,276.48h-204.8v-92.271c0.619,0.026,1.228,0.111,1.85,0.111 c13.2,0,25.123-5.917,33.022-15.373c0.009,0.011,0.014,0.022,0.023,0.033c8.16,9.75,20.195,15.34,33.025,15.34h1.94 c13.094,0,24.687-5.945,32.54-15.093c7.853,9.148,19.446,15.093,32.54,15.093h1.94c12.83,0,24.865-5.59,33.025-15.34 c0.009-0.011,0.014-0.022,0.022-0.033c7.899,9.456,19.823,15.373,33.023,15.373c0.622,0,1.231-0.085,1.85-0.111V276.48z M364.73,154.41c-4.225,5.99-10.935,9.43-18.42,9.43c-10.875,0-20.115-7.54-21.975-17.93l-0.456-2.55h44.588 C368.261,147.249,367.088,151.061,364.73,154.41z"></path> </g> </g> </g></svg>
									Online shop
								</a>
							</li>
						<?php endif; ?>

						<?php if($post_home_event_privacy): ?>
							<li class="contact__list__item">
								<a href="<?php echo $post_home_event_privacy; ?>" target="_blank">
									<svg viewBox="0 0 192 192" height="20" width="20" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g fill="none" stroke="#000000" stroke-width="12"> <path stroke-linecap="round" d="M151.8 144.5a74 74 0 0 1-85.59 19.21A74 74 0 0 1 22.42 87.7a74 74 0 0 1 59.55-64.42m28.03.06a74 74 0 0 1 50.06 35.61 74 74 0 0 1 5.915 61.15"></path> <path d="M76 92h40c4.432 0 8 3.568 8 8v22c0 4.432-3.568 8-8 8H76c-4.432 0-8-3.568-8-8v-22c0-4.432 3.568-8 8-8zm4 0V77.7C80 69.029 87.163 62 96 62s16 7.029 16 15.7V92"></path> </g> </g></svg>
									Privacy
								</a>
							</li>
						<?php endif; ?>

						<?php if($post_author_link): ?>
<!--							<li class="contact__list__item">-->
<!--								<a href="--><?php //echo $post_author_link; ?><!--" target="_blank">-->
<!--									<svg fill="#000000" height="20" width="20" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 463 463" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="18.520000000000003"> <g> <path d="M436.675,200.432c-6.565-43.506-27.166-84.373-58.449-115.656c-10.71-10.71-22.549-20.158-35.226-28.231V15.5 C343,6.953,336.047,0,327.5,0h-192C126.953,0,120,6.953,120,15.5v41.045c-12.675,8.072-24.512,17.519-35.22,28.226 c-31.286,31.284-51.889,72.153-58.455,115.661C11.41,202.909,0,215.894,0,231.5s11.41,28.591,26.325,31.068 c6.565,43.507,27.167,84.374,58.451,115.658c7.972,7.972,16.57,15.244,25.671,21.774H95.5c-8.547,0-15.5,6.953-15.5,15.5v32 c0,8.547,6.953,15.5,15.5,15.5h272c8.547,0,15.5-6.953,15.5-15.5v-32c0-8.547-6.953-15.5-15.5-15.5h-14.948 c9.101-6.53,17.7-13.803,25.672-21.774c31.284-31.284,51.886-72.151,58.451-115.658C451.59,260.091,463,247.106,463,231.5 C463,215.894,451.59,202.909,436.675,200.432z M367.619,95.383c28.384,28.384,47.294,65.264,53.809,104.617H387.89 c-5.671-28.4-18.842-54.382-38.429-75.854l6.137-6.137c2.929-2.929,2.929-7.678,0-10.606c-2.929-2.929-7.678-2.929-10.606,0 l-6.137,6.137C317.382,93.952,291.4,80.781,263,75.11V41.572C302.354,48.087,339.235,66.998,367.619,95.383z M164.584,175.19 c-6.187,7.341-11.191,15.709-14.715,24.81H90.466c5.389-24.337,16.899-46.623,33.705-65.223L164.584,175.19z M134.777,124.17 c18.6-16.805,40.886-28.316,65.223-33.705v59.403c-9.101,3.524-17.469,8.528-24.81,14.715L134.777,124.17z M164.584,287.81 l-40.413,40.413c-16.806-18.6-28.316-40.886-33.705-65.223h59.403C153.393,272.101,158.397,280.469,164.584,287.81z M175.19,298.416c7.341,6.187,15.709,11.191,24.81,14.715v59.403c-24.337-5.389-46.623-16.899-65.223-33.705L175.19,298.416z M159,231.5c0-39.977,32.523-72.5,72.5-72.5s72.5,32.523,72.5,72.5S271.477,304,231.5,304S159,271.477,159,231.5z M263,149.869 V90.466c24.337,5.389,46.623,16.899,65.223,33.705l-40.414,40.414C280.469,158.397,272.101,153.393,263,149.869z M263,313.131 c9.101-3.524,17.469-8.528,24.81-14.715l40.414,40.414c-18.6,16.805-40.886,28.316-65.223,33.705V313.131z M298.416,287.81 c6.187-7.341,11.191-15.709,14.715-24.81h59.403c-5.389,24.337-16.899,46.623-33.705,65.223L298.416,287.81z M298.416,175.19 l40.414-40.414c16.806,18.6,28.316,40.886,33.705,65.223h-59.403C309.607,190.899,304.603,182.531,298.416,175.19z M327.5,15 c0.276,0,0.5,0.224,0.5,0.5v32.344c-20.409-10.731-42.554-18.066-65.432-21.519c-0.68-4.094-2.148-7.923-4.249-11.325H327.5z M215,31.5c0-9.098,7.402-16.5,16.5-16.5S248,22.402,248,31.5v114.067c-5.346-1.024-10.86-1.567-16.5-1.567 s-11.154,0.543-16.5,1.567V31.5z M135,15.5c0-0.276,0.224-0.5,0.5-0.5h69.181c-2.101,3.402-3.569,7.231-4.249,11.325 C177.554,29.778,155.408,37.113,135,47.844V15.5z M95.386,95.378C123.769,66.996,160.649,48.087,200,41.572V75.11 c-28.4,5.671-54.382,18.842-75.854,38.429l-6.137-6.137c-2.929-2.929-7.678-2.929-10.606,0c-2.929,2.929-2.929,7.678,0,10.606 l6.137,6.137C93.953,145.618,80.782,171.6,75.111,200H41.572C48.087,160.645,67,123.763,95.386,95.378z M15,231.5 c0-9.098,7.402-16.5,16.5-16.5h114.067c-1.024,5.346-1.567,10.86-1.567,16.5s0.543,11.154,1.567,16.5H31.5 C22.402,248,15,240.598,15,231.5z M95.383,367.619C66.998,339.235,48.087,302.354,41.572,263h33.538 c5.671,28.4,18.842,54.382,38.429,75.854l-6.137,6.137c-2.929,2.929-2.929,7.678,0,10.606c1.464,1.464,3.384,2.197,5.303,2.197 s3.839-0.732,5.303-2.197l6.137-6.137C145.618,369.048,171.6,382.218,200,387.89v33.538 C160.647,414.913,123.767,396.003,95.383,367.619z M95.5,448c-0.276,0-0.5-0.224-0.5-0.5v-32c0-0.276,0.224-0.5,0.5-0.5h39.203 c20.49,10.816,42.74,18.206,65.729,21.675c0.68,4.094,2.148,7.923,4.249,11.325H95.5z M248,431.5c0,9.098-7.402,16.5-16.5,16.5 s-16.5-7.402-16.5-16.5V317.433c5.346,1.024,10.86,1.567,16.5,1.567s11.154-0.543,16.5-1.567V431.5z M367.5,415 c0.276,0,0.5,0.224,0.5,0.5v32c0,0.276-0.224,0.5-0.5,0.5H258.319c2.101-3.402,3.569-7.231,4.249-11.325 c22.99-3.469,45.239-10.859,65.729-21.675H367.5z M367.617,367.619c-28.384,28.384-65.264,47.294-104.617,53.809V387.89 c28.4-5.671,54.382-18.842,75.854-38.429l6.137,6.137c1.464,1.464,3.384,2.197,5.303,2.197s3.839-0.732,5.303-2.197 c2.929-2.929,2.929-7.678,0-10.606l-6.137-6.137C369.048,317.382,382.218,291.4,387.89,263h33.538 C414.913,302.354,396.002,339.235,367.617,367.619z M431.5,248H317.433c1.024-5.346,1.567-10.86,1.567-16.5 s-0.543-11.154-1.567-16.5H431.5c9.098,0,16.5,7.402,16.5,16.5S440.598,248,431.5,248z"></path> <path d="M231.5,176c-30.603,0-55.5,24.897-55.5,55.5s24.897,55.5,55.5,55.5s55.5-24.897,55.5-55.5S262.103,176,231.5,176z M231.5,272c-22.332,0-40.5-18.168-40.5-40.5s18.168-40.5,40.5-40.5s40.5,18.168,40.5,40.5S253.832,272,231.5,272z"></path> <path d="M231.5,200c-17.369,0-31.5,14.131-31.5,31.5s14.131,31.5,31.5,31.5s31.5-14.131,31.5-31.5S248.869,200,231.5,200z M231.5,248c-9.098,0-16.5-7.402-16.5-16.5s7.402-16.5,16.5-16.5s16.5,7.402,16.5,16.5S240.598,248,231.5,248z"></path> </g> </g><g id="SVGRepo_iconCarrier"> <g> <path d="M436.675,200.432c-6.565-43.506-27.166-84.373-58.449-115.656c-10.71-10.71-22.549-20.158-35.226-28.231V15.5 C343,6.953,336.047,0,327.5,0h-192C126.953,0,120,6.953,120,15.5v41.045c-12.675,8.072-24.512,17.519-35.22,28.226 c-31.286,31.284-51.889,72.153-58.455,115.661C11.41,202.909,0,215.894,0,231.5s11.41,28.591,26.325,31.068 c6.565,43.507,27.167,84.374,58.451,115.658c7.972,7.972,16.57,15.244,25.671,21.774H95.5c-8.547,0-15.5,6.953-15.5,15.5v32 c0,8.547,6.953,15.5,15.5,15.5h272c8.547,0,15.5-6.953,15.5-15.5v-32c0-8.547-6.953-15.5-15.5-15.5h-14.948 c9.101-6.53,17.7-13.803,25.672-21.774c31.284-31.284,51.886-72.151,58.451-115.658C451.59,260.091,463,247.106,463,231.5 C463,215.894,451.59,202.909,436.675,200.432z M367.619,95.383c28.384,28.384,47.294,65.264,53.809,104.617H387.89 c-5.671-28.4-18.842-54.382-38.429-75.854l6.137-6.137c2.929-2.929,2.929-7.678,0-10.606c-2.929-2.929-7.678-2.929-10.606,0 l-6.137,6.137C317.382,93.952,291.4,80.781,263,75.11V41.572C302.354,48.087,339.235,66.998,367.619,95.383z M164.584,175.19 c-6.187,7.341-11.191,15.709-14.715,24.81H90.466c5.389-24.337,16.899-46.623,33.705-65.223L164.584,175.19z M134.777,124.17 c18.6-16.805,40.886-28.316,65.223-33.705v59.403c-9.101,3.524-17.469,8.528-24.81,14.715L134.777,124.17z M164.584,287.81 l-40.413,40.413c-16.806-18.6-28.316-40.886-33.705-65.223h59.403C153.393,272.101,158.397,280.469,164.584,287.81z M175.19,298.416c7.341,6.187,15.709,11.191,24.81,14.715v59.403c-24.337-5.389-46.623-16.899-65.223-33.705L175.19,298.416z M159,231.5c0-39.977,32.523-72.5,72.5-72.5s72.5,32.523,72.5,72.5S271.477,304,231.5,304S159,271.477,159,231.5z M263,149.869 V90.466c24.337,5.389,46.623,16.899,65.223,33.705l-40.414,40.414C280.469,158.397,272.101,153.393,263,149.869z M263,313.131 c9.101-3.524,17.469-8.528,24.81-14.715l40.414,40.414c-18.6,16.805-40.886,28.316-65.223,33.705V313.131z M298.416,287.81 c6.187-7.341,11.191-15.709,14.715-24.81h59.403c-5.389,24.337-16.899,46.623-33.705,65.223L298.416,287.81z M298.416,175.19 l40.414-40.414c16.806,18.6,28.316,40.886,33.705,65.223h-59.403C309.607,190.899,304.603,182.531,298.416,175.19z M327.5,15 c0.276,0,0.5,0.224,0.5,0.5v32.344c-20.409-10.731-42.554-18.066-65.432-21.519c-0.68-4.094-2.148-7.923-4.249-11.325H327.5z M215,31.5c0-9.098,7.402-16.5,16.5-16.5S248,22.402,248,31.5v114.067c-5.346-1.024-10.86-1.567-16.5-1.567 s-11.154,0.543-16.5,1.567V31.5z M135,15.5c0-0.276,0.224-0.5,0.5-0.5h69.181c-2.101,3.402-3.569,7.231-4.249,11.325 C177.554,29.778,155.408,37.113,135,47.844V15.5z M95.386,95.378C123.769,66.996,160.649,48.087,200,41.572V75.11 c-28.4,5.671-54.382,18.842-75.854,38.429l-6.137-6.137c-2.929-2.929-7.678-2.929-10.606,0c-2.929,2.929-2.929,7.678,0,10.606 l6.137,6.137C93.953,145.618,80.782,171.6,75.111,200H41.572C48.087,160.645,67,123.763,95.386,95.378z M15,231.5 c0-9.098,7.402-16.5,16.5-16.5h114.067c-1.024,5.346-1.567,10.86-1.567,16.5s0.543,11.154,1.567,16.5H31.5 C22.402,248,15,240.598,15,231.5z M95.383,367.619C66.998,339.235,48.087,302.354,41.572,263h33.538 c5.671,28.4,18.842,54.382,38.429,75.854l-6.137,6.137c-2.929,2.929-2.929,7.678,0,10.606c1.464,1.464,3.384,2.197,5.303,2.197 s3.839-0.732,5.303-2.197l6.137-6.137C145.618,369.048,171.6,382.218,200,387.89v33.538 C160.647,414.913,123.767,396.003,95.383,367.619z M95.5,448c-0.276,0-0.5-0.224-0.5-0.5v-32c0-0.276,0.224-0.5,0.5-0.5h39.203 c20.49,10.816,42.74,18.206,65.729,21.675c0.68,4.094,2.148,7.923,4.249,11.325H95.5z M248,431.5c0,9.098-7.402,16.5-16.5,16.5 s-16.5-7.402-16.5-16.5V317.433c5.346,1.024,10.86,1.567,16.5,1.567s11.154-0.543,16.5-1.567V431.5z M367.5,415 c0.276,0,0.5,0.224,0.5,0.5v32c0,0.276-0.224,0.5-0.5,0.5H258.319c2.101-3.402,3.569-7.231,4.249-11.325 c22.99-3.469,45.239-10.859,65.729-21.675H367.5z M367.617,367.619c-28.384,28.384-65.264,47.294-104.617,53.809V387.89 c28.4-5.671,54.382-18.842,75.854-38.429l6.137,6.137c1.464,1.464,3.384,2.197,5.303,2.197s3.839-0.732,5.303-2.197 c2.929-2.929,2.929-7.678,0-10.606l-6.137-6.137C369.048,317.382,382.218,291.4,387.89,263h33.538 C414.913,302.354,396.002,339.235,367.617,367.619z M431.5,248H317.433c1.024-5.346,1.567-10.86,1.567-16.5 s-0.543-11.154-1.567-16.5H431.5c9.098,0,16.5,7.402,16.5,16.5S440.598,248,431.5,248z"></path> <path d="M231.5,176c-30.603,0-55.5,24.897-55.5,55.5s24.897,55.5,55.5,55.5s55.5-24.897,55.5-55.5S262.103,176,231.5,176z M231.5,272c-22.332,0-40.5-18.168-40.5-40.5s18.168-40.5,40.5-40.5s40.5,18.168,40.5,40.5S253.832,272,231.5,272z"></path> <path d="M231.5,200c-17.369,0-31.5,14.131-31.5,31.5s14.131,31.5,31.5,31.5s31.5-14.131,31.5-31.5S248.869,200,231.5,200z M231.5,248c-9.098,0-16.5-7.402-16.5-16.5s7.402-16.5,16.5-16.5s16.5,7.402,16.5,16.5S240.598,248,231.5,248z"></path> </g> </g></svg>-->
<!--									Post Author Link-->
<!--								</a>-->
<!--							</li>-->
						<?php endif; ?>

						<?php if($post_Add_my_webshop_link): ?>
							<li class="contact__list__item">
								<a href="<?php echo esc_url($post_Add_my_webshop_link); ?>" target="_blank">
									<svg fill="#000000" height="20" width="20" viewBox="0 0 64 64" id="Layer_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M53.9,17.9l-20-11.3c-1.2-0.7-2.7-0.7-3.8,0l-20,11.3c-1.2,0.7-2,2-2,3.4V52c0,3.3,2.7,6,6,6h35.8c3.3,0,6-2.7,6-6V21.3 C55.9,19.9,55.1,18.6,53.9,17.9z M51.9,52c0,1.1-0.9,2-2,2H14.1c-1.1,0-2-0.9-2-2V21.3L32,10.1l19.9,11.3V52z"></path> <path d="M17.7,43.7c1.2,2.2,3.3,3.7,5.7,4.3c0.8,0.2,1.6,0.3,2.4,0.3c1.6,0,3.2-0.4,4.7-1.3l12.5-7.2c4.5-2.6,6-8.3,3.4-12.7 c-2.6-4.5-8.3-6-12.7-3.4L21.1,31C16.6,33.5,15.1,39.3,17.7,43.7z M35.6,27.2c0.8-0.5,1.8-0.7,2.7-0.7c1.8,0,3.6,1,4.6,2.7 c0.7,1.2,0.9,2.7,0.5,4c-0.4,1.4-1.3,2.5-2.5,3.2l-4.5,2.6l-5.3-9.2L35.6,27.2z M23.1,34.4l4.5-2.6l5.3,9.2l-4.5,2.6 c-1.2,0.7-2.7,0.9-4,0.5c-1.4-0.4-2.5-1.3-3.2-2.5c-0.7-1.2-0.9-2.7-0.5-4C21,36.3,21.9,35.1,23.1,34.4z"></path> </g> </g></svg>
									Webshop link
								</a>
							</li>
						<?php endif; ?>
					</ul>

				</div>
			<?php endif; ?>



			<div class="post-page__section bt-2 content">
				<?php if($current_user_id == $author_id): ?>
					<div class="flex edit-area hide">
					<?php
					// get_template_part( 'components/btn', null,
					// 		array(
					// 			'label' => 'Edit home features',
					// 			'href' => "/",
					// 			'target' => "_self",
					// 			'skin'  => 'highlight',
					// 			'icon-only'  => false,
					// 			'disabled'  => false,
					// 			'icon-position' => 'left',
					// 			'icon' => 'pencil-write',
					// 			'additional-classes' => 'btn--small edit_post_btn btn--inline',
					// 			'data-attribute' => 'data-open-modal=\'edit-post--features\'',
					// 			'theme' => "",
					// 		)
					// 	); ?>
				<?php endif; ?>
				<?php if($current_user_id == $author_id): ?></div><?php endif; ?>
				<?php if($post_home_year_built): ?>
					<dl><dt class="-light">Year built:</dt><dd><?php echo($post_home_year_built); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_home_amenities): ?>
					<dl><dt class="-light">Home amenities:</dt><dd><?php echo($post_home_amenities); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_neighborhood_amenities): ?>
					<dl><dt class="-light">Neighborhood amenities:</dt><dd><?php echo($post_neighborhood_amenities); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_transportation): ?>
					<dl><dt class="-light">Transportation:</dt><dd><?php echo($post_transportation); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_garages_parking): ?>
					<dl><dt class="-light">Nr of garages/parking:</dt><dd><?php echo($post_garages_parking); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_schools): ?>
					<dl><dt class="-light">Schools nearby:</dt><dd><?php echo($post_schools); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_home_style_architecture): ?>
					<dl><dt class="-light">Home style and architecture:</dt><dd><?php echo($post_home_style_architecture); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_additional_features): ?>
					<dl><dt class="-light">Additional home features:</dt><dd><?php echo($post_additional_features); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_taxes): ?>
					<dl><dt class="-light">Property taxes:</dt><dd><?php echo($post_taxes); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_fees): ?>
					<dl><dt class="-light">Other property Fees:</dt><dd><?php echo($post_fees); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_systems): ?>
					<dl><dt class="-light">Heating / Cooling systems:</dt><dd><?php echo($post_systems); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_energy_rating): ?>
					<dl><dt class="-light">Energy rating:</dt><dd><?php echo($post_energy_rating); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_energy_consumption): ?>
					<dl><dt class="-light">Energy rating and consumption:</dt><dd><?php echo($post_energy_consumption); ?></dd></dl>
				<?php endif; ?>
			</div>

			<br>
			<dl><dt class="-light">Address Map:</dt> </dl>
			<?php
			// todo_augustin : show map
			$location = get_field( 'post_address', $post_id); // Récupérer la géolocalisation
			$post_location_longitude = get_field( 'post_location_longitude', $post_id);
			$post_location_latitude = get_field( 'post_location_latitude', $post_id);
			echo do_shortcode('[osm_map address ="'.$location.'" latitude="'.$post_location_latitude.'" longitude="'.$post_location_longitude.'"  height="400px" width="100%" zoom="15"]');


			?>

			<div class="post-page__section bt-2">
				<?php if($current_user_id == $author_id): ?>
					<div class="flex edit-area hide">
					<?php
//					get_template_part( 'components/btn', null,
//							array(
//								'label' => 'Edit location',
//								'href' => "/",
//								'target' => "_self",
//								'skin'  => 'highlight',
//								'icon-only'  => false,
//								'disabled'  => false,
//								'icon-position' => 'left',
//								'icon' => 'pencil-write',
//								'additional-classes' => 'btn--small edit_post_btn btn--inline',
//								'data-attribute' => 'data-open-modal=\'edit-post--location\'',
//								'theme' => "",
//							)
//						); ?>
				<?php endif; ?>
				<?php if($current_user_id == $author_id): ?></div><?php endif; ?>
				<?php
				$post_content_for_map = [];
				$post_for_map = [
						"id" => $post_id,
						"title" => $post_title, // house type
						"post_type_slug" => "real-estate",
						"permalink" => get_the_permalink($post_id),
						"lat" => $post_location_latitude,
						"lng" => $post_location_longitude,
						"account_type" => null,
						"location" => $post_address,
						"price" => $post_price,
						"bedrooms" => $post_bedrooms,
						"bathrooms" => $post_bathrooms,
						"home_size" => $post_home_size,
						"outdoor_size" => $post_outdoor_size,
						"img" => get_the_post_thumbnail()
					];
					array_push($post_content_for_map, $post_for_map);
					?>

				<!-- <div id="map-data" data-fit-bounds="true" data-page="single-post" data-buildings="<?php echo htmlspecialchars(json_encode($post_content_for_map), ENT_QUOTES, 'UTF-8'); ?>"></div>
				<div class="map map--single anim_els">
					<div id="map"></div>
				</div> -->
				<div class="post-page__section post-page__section--footer mt-2 ">
					<p class="post-footer__publish-date p-xs">
						<?php echo get_time_ago(get_post_timestamp()); ?>
					</p>
				</div>
			</div>
		</div>
		<div class="tab-content default-bckg profile-content__grid hide" id="tabs-grid">
			<div class="grid-slate__list">
				<?php foreach($post_gallery_image_ids_array as $post_gallery_id):
					get_template_part("components/grid-slate", null, array(
						"id" => "",
						"post_link" => "",
						"image" => wp_get_attachment_image_src($post_gallery_id, 'large-img-medium')[0]
					));
				endforeach; ?>
			</div>
		</div>
		<div class="tab-content post-page hide" data-barba-prevent="all" id="tabs-list">
			<?php
				get_template_part("components/card-homazed-homes", null, array(
					"id" => $post_id,
					"title" => $post_title,
					"user_id" => $author_id,
					'type' => null, // null or compact
					'home_category' => $post_home_category_translate,
					'home_type' => $post_home_action_translate,
					'post_creator_link' => get_permalink("602")."?user_id=".$author_id,
					'post_creator_name' => $author_first_name."&nbsp;".$author_last_name,
					'first_name' => $author_first_name,
					'last_name' => $author_last_name,
					'work_position' => "",
					'main_picture' => $main_picture_image_ids_array,
					'img' => $post_gallery_image_ids_array,
					'img_display' => get_field("post_home_pictures_display", $post_id),
					"card_gallery" => $post_gallery_image_ids,
					'img_size' => 'thumbnail-m',
					"post_type" => "Homes",
					"post_type_slug" => "real-estate",
					'address_name' => "post_address",
					'address_link' => null,
					'content' => $post_main_content_excerpt,
					'price' => $post_price,
					'bedrooms' => $post_bedrooms,
					'bathrooms' => $post_bathrooms,
					'house' => $post_home_size,
					'land' => $post_outdoor_size,
					'tags' => $post_post_tags,
					"events_type" => $post_events_type,
					"events_text_1" => $post_events_text_1,
					"events_text_2" => $post_events_text_2,
					"events_privacy" => $post_events_privacy,
					'publish_date' =>  get_time_ago(get_post_timestamp())
				));
			?>
		</div>
		<div class="tab-content default-bckg post-page hide" data-barba-prevent="all" id="tabs-map">
			<h3 class="map"></h3>
			<div id="map-data" data-fit-bounds="true" data-page="single-post" data-buildings="<?php echo htmlspecialchars(json_encode($post_content_for_map), ENT_QUOTES, 'UTF-8'); ?>"></div>
			<div class="map map--single anim_els">
				<div id="map"></div>
			</div>
		</div>

<?php if($current_user_id == $author_id): ?>

	<div class="modal micromodal-slide" id="edit-post--price" aria-hidden="true">
		<div class="modal__overlay" tabindex="-1" data-micromodal-close>
			<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="edit-home-title">
				<header class="modal__header">
					<div class="flex flex--vertical">
						<div class="flex flex--vertical-center">
							<h2 class="resume__name card-form__title"><?php echo $post_title ?></h2>
							<div class="resume__title_supplement">- Edit price</div>
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
					<?php echo do_shortcode( '[gravityform id="3" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
				</main>
			</div>
		</div>
	</div>

	<div class="modal micromodal-slide" id="edit-post--files" aria-hidden="true">
		<div class="modal__overlay" tabindex="-1" data-micromodal-close>
			<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="edit-home-title">
				<header class="modal__header">
					<div class="flex flex--vertical">
						<div class="flex flex--vertical-center">
							<h2 class="resume__name card-form__title"><?php echo $post_title ?></h2>
							<div class="resume__title_supplement">- Edit file</div>
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
					<?php echo do_shortcode( '[gravityform id="13" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
				</main>
			</div>
		</div>
	</div>

	<div class="modal micromodal-slide" id="edit-post--details-sizes" aria-hidden="true">
		<div class="modal__overlay" tabindex="-1" data-micromodal-close>
			<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="edit-home-title">
				<header class="modal__header">
					<div class="flex flex--vertical">
						<div class="flex flex--vertical-center">
							<h2 class="resume__name card-form__title"><?php echo $post_title ?></h2>
							<div class="resume__title_supplement">- Edit details</div>
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
					<?php echo do_shortcode( '[gravityform id="14" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
				</main>
			</div>
		</div>
	</div>

	<div class="modal micromodal-slide" id="edit-post--events" aria-hidden="true">
		<div class="modal__overlay" tabindex="-1" data-micromodal-close>
			<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="edit-home-title">
				<header class="modal__header">
					<div class="flex flex--vertical">
						<div class="flex flex--vertical-center">
							<h2 class="resume__name card-form__title"><?php echo $post_title ?></h2>
							<div class="resume__title_supplement">- Edit events</div>
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
					<?php echo do_shortcode( '[gravityform id="15" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
				</main>
			</div>
		</div>
	</div>

	<div class="modal micromodal-slide" id="edit-post--description" aria-hidden="true">
		<div class="modal__overlay" tabindex="-1" data-micromodal-close>
			<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="edit-home-title">
				<header class="modal__header">
					<div class="flex flex--vertical">
						<div class="flex flex--vertical-center">
							<h2 class="resume__name card-form__title"><?php echo $post_title ?></h2>
							<div class="resume__title_supplement">- Edit description</div>
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
					<?php echo do_shortcode( '[gravityform id="7" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
				</main>
			</div>
		</div>
	</div>

	<div class="modal micromodal-slide" id="edit-post--tags" aria-hidden="true">
		<div class="modal__overlay" tabindex="-1" data-micromodal-close>
			<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="edit-home-title">
				<header class="modal__header">
					<div class="flex flex--vertical">
						<div class="flex flex--vertical-center">
							<h2 class="resume__name card-form__title"><?php echo $post_title ?></h2>
							<div class="resume__title_supplement">- Edit tags</div>
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
					<?php echo do_shortcode( '[gravityform id="11" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
				</main>
			</div>
		</div>
	</div>

	<div class="modal micromodal-slide" id="edit-post--features" aria-hidden="true">
		<div class="modal__overlay" tabindex="-1" data-micromodal-close>
			<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="edit-home-title">
				<header class="modal__header">
					<div class="flex flex--vertical">
						<div class="flex flex--vertical-center">
							<h2 class="resume__name card-form__title"><?php echo $post_title ?></h2>
							<div class="resume__title_supplement">- Edit features</div>
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
					<?php echo do_shortcode( '[gravityform id="8" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
				</main>
			</div>
		</div>
	</div>

	<!-- <div class="modal micromodal-slide" id="edit-post--location" aria-hidden="true">
		<div class="modal__overlay" tabindex="-1" data-micromodal-close>
			<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="edit-home-title">
				<header class="modal__header">
					<div class="flex flex--vertical">
						<div class="flex flex--vertical-center">
							<h2 class="resume__name card-form__title"><?php // echo $post_title ?></h2>
							<div class="resume__title_supplement">- Edit location <?php // echo $post_address; ?></div>
						</div>
					</div>
					<?php // get_template_part("components/btn", null,
						// array(
						// 	'label' => 'Close this modal window',
						// 	'href' => "",
						// 	'target' => "_self",
						// 	'skin'  => 'secondary',
						// 	'icon-only'  => true,
						// 	'disabled'  => false,
						// 	'icon-position' => 'right', // left or right
						// 	'icon' => 'close',
						// 	'additional-classes' => '',
						// 	'data-attribute' => 'data-close-modal',
						// 	'theme' => "",
						// )
					// ); ?>
				</header>
				<main class="modal__content contact__form contact__form--light">
					<?php // echo do_shortcode( '[gravityform id="9" title="false" field_values="post_retrieved_id=' . $post_id . '&post_address=' . $post_address . '&post_location_latitude=' . $post_location_latitude . '&post_location_longitude=' . $post_location_longitude . '"]' ); ?>
				</main>
			</div>
		</div>
	</div> -->

	<div class="modal micromodal-slide" id="edit-post--images" aria-hidden="true">
		<div class="modal__overlay" tabindex="-1" data-micromodal-close>
			<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="edit-home-title">
				<header class="modal__header">
					<div class="flex flex--vertical">
						<div class="flex flex--vertical-center">
							<h2 class="resume__name card-form__title"><?php echo $post_title ?></h2>
							<div class="resume__title_supplement">- Edit images</div>
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
					<?php echo do_shortcode( '[gravityform id="4" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
				</main>
			</div>
		</div>
	</div>
<?php endif; ?>

	<div class="modal micromodal-slide" id="share-post" aria-hidden="true">
		<div class="modal__overlay" tabindex="-1" data-micromodal-close>
			<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="publish-home-title">
				<header class="modal__header">
					<div class="flex flex--vertical">
						<div class="flex flex--vertical-center">
							<h2 class="resume__name card-form__title">SHARE POST</h2>
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
					<?php get_template_part("components/share-box", null, array(
							'post_permalink' => $post_link,
							"post_id" => $post_id
						)
					); ?>
				</main>
			</div>
		</div>
	</div>

</main>

<?php get_footer(); ?>
