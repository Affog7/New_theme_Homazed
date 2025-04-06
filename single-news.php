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
			$post_link_parsed = get_field("post_link_parsed", $post_id );

			// checkbox  todo_augustin
			$post_comment_available = get_field("post_comment_available", $post_id);
			$post_phone_calls_available = get_field("post_phone_calls_available", $post_id);
			$post_add_my_website_link = get_field("post_add_my_website_link", $post_id);

			$author_online_shop_link = get_field("user_online_shop_link", "user_".$author_id);

			// todo_augustin champs link
			$post_author_link = get_field("post_author_link",$post_id);
			$post_Add_my_webshop_link = get_field("post_Add_my_webshop_link", $post_id);
			$Is_Add_my_webshop_link = get_field("Is_Add_my_webshop_link", $post_id);


			$post_home_event_privacy = get_field("home_event_privacy", $post_id);


			//$post_home_sector_activity = get_field("post_home_sector_activity",$post_id);
			//$post_home_Jobs_title = get_field("post_home_Jobs_title",$post_id);
			$post_w_linked = get_field("post_w_linked",$post_id);

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


			$post_job_type = get_field("post_job_type", $post_id);
			$post_main_work_location = get_field("post_main_work_location", $post_id);
			$post_key_roles = get_field("post_key_roles", $post_id);
			$post_requirements = get_field("post_requirements", $post_id);
			$post_preferred_qualifications = get_field("post_preferred_qualifications", $post_id);
			$post_career_growth = get_field("post_career_growth", $post_id);
			$post_company_culture = get_field("post_company_culture", $post_id);
			$post_reporting_structure = get_field("post_reporting_structure", $post_id);
			$post_work_hours = get_field("post_work_hours", $post_id);
			$post_compensation = get_field("post_compensation", $post_id);
			$post_benefits = get_field("post_benefits", $post_id);

			$post_application_process = get_field("post_application_process", $post_id);
			$post_job_application_deadline = get_field("post_job_application_deadline", $post_id);
			$post_other = get_field("post_other", $post_id);

			//$post_address = get_field("post_location_address") . ", " . get_field("post_location_zip") . " " . get_field("post_location_city");
			$post_address = get_field("post_location_address") ? get_field("post_location_address") . ", " . get_field("post_location_zip") . " " . get_field("post_location_city") : "";


			$post_location_latitude = get_field("post_location_latitude");
			$post_location_longitude = get_field("post_location_longitude");
			$post_post_tags = get_the_terms($post_id, 'posttags');
			if (!is_wp_error($post_post_tags) && !empty($post_post_tags)) {
				usort($post_post_tags, function($a, $b) {
					return $a->term_id - $b->term_id; // Tri en ordre croissant selon l'ID
				});
			}

			$post_join_file_id = get_field("post_home_join_file");
			$post_join_file = !wp_get_attachment_url($post_join_file_id)?$post_join_file_id:wp_get_attachment_url($post_join_file_id);

			$post_events_type = get_field("post_home_event_type");
			$post_events_text_1 = get_field("post_home_event_text_1");

			$i_request_contactlist_users_relationships = get_field("i_request_contactlist_users_relationships", "user_".$current_user_id);
			$i_accept_contactlist_users_relationships = get_field("i_accept_contactlist_users_relationships", "user_".$current_user_id);
			$him_request_contactlist_users_relationships = get_field("i_request_contactlist_users_relationships", "user_".$author_id);
			$him_accept_contactlist_users_relationships = get_field("i_accept_contactlist_users_relationships", "user_".$author_id);



		// si un post est lié, on recupère le main du post
		if($post_w_linked) {
			$main_picture_image_ids = get_field("post_home_main_picture_ids",intval($post_w_linked));
			$main_picture_image_ids_array = explode(',', $main_picture_image_ids);

			if($main_picture_image_ids==null) {
				$main_picture_image_ids = get_field("post_home_gallery_ids",intval($post_w_linked));
				$main_picture_image_ids_array = explode(',', $main_picture_image_ids);
			}

			$gallery_image_ids = get_field("post_home_gallery_ids");
			$gallery_image_ids_array = explode(',', $gallery_image_ids);

			$post_avatar_picture_id = (!empty($main_picture_image_ids_array[0])) ? $main_picture_image_ids_array[0] : $gallery_image_ids_array[0];
			$user_avatar_id = $post_avatar_picture_id;
		} else {
			$user_avatar_id = get_field("user_avatar_ids", "user_".$author_id);
		}
		//______________todo augustin 15_12_2024
			$i_request_this_contact = (!empty($i_request_contactlist_users_relationships) && in_array($author_id, $i_request_contactlist_users_relationships)) ? true : false;
			$i_accept_this_contact = (!empty($i_accept_contactlist_users_relationships) && in_array($author_id, $i_accept_contactlist_users_relationships)) ? true : false;
			$him_request_me = (!empty($him_request_contactlist_users_relationships ) && in_array($current_user_id, $him_request_contactlist_users_relationships )) ? true : false;
			$him_accept_me = (!empty($him_accept_contactlist_users_relationships ) && in_array($current_user_id, $him_accept_contactlist_users_relationships )) ? true : false;


		if($i_request_this_contact && $i_accept_this_contact && $him_request_me && !$him_accept_me){
			// I request & him did not accept yet [GREEN1]";
			$post_events_text_1 = 'Contact requested';
			$contact_classes .= ' relation_btn--contact-requested';
			$contact_icon = 'single-neutral-actions-refresh';
			$relation_type = 'remove-request-contact-list';
 		}elseif($i_request_this_contact && $i_accept_this_contact && $him_request_me && $him_accept_me){
			// relation done [RED]";
			$post_events_text_1 = 'Contact accepted';
			$contact_classes .= ' relation_btn--contact-relation-done';
			$contact_icon = 'check-circle-1';
			$relation_type = 'refuse-contact-list';
 			// alert(are your sure ?)
		}elseif($i_request_this_contact  && !$i_accept_this_contact && $him_request_me && $him_accept_me){
			// He request, I did not accept yet [GREEN2]";
			$post_events_text_1 = 'Accept contact';
			$contact_classes .= ' relation_btn--contact-him-requested';
			$contact_icon = 'check-circle-1';
			$relation_type = 'accept-contact-list';
 		}
			if($i_request_this_contact && $i_accept_this_contact && $him_request_me && $him_accept_me){
				// relation done [RED]";
				$post_events_text_1 = 'Contact accepted';
				$contact_classes .= ' relation_btn--contact-relation-done';
				$contact_icon = 'check-circle-1';
				$relation_type = 'refuse-contact-list';
				// alert(are your sure ?)
 			}


//________________ 15_12_2024

			$post_events_text_2 = get_field("post_home_event_text_2");
			$post_events_privacy = get_field("post_home_event_privacy");

			$i_favorite_posts_relationships = get_field("i_favorite_posts_relationships", "user_".$current_user_id);
			$i_like_posts_relationships = get_field("i_like_posts_relationships", "user_".$current_user_id);

			$users_like_me_posts = get_field("users_like_me_posts", $post_id);
			$users_favorite_me_posts = get_field("users_favorite_me_posts", $post_id);

			$main_picture_image_ids = get_field("post_home_main_picture_ids", $post_id);
			$main_picture_image_ids_array = explode(',', $main_picture_image_ids);
			$post_avatar_picture_id = ($main_picture_image_ids_array[0]) ? $main_picture_image_ids_array[0] : $post_gallery_image_ids_array[0];

//			$id_entry = get_field("_gravityformsadvancedpostcreation_entry_id", $post_id);
//			$video_ =  do_shortcode( '[gf_entry_meta entry_id='.$id_entry.' meta_key="139"]');
			$video_ =  get_field("post_home_video", $post_id);;
		?>

		<!-- Post resume -->
		<div class="card-form content" data-barba-prevent="all">
			<div class="resume">
				<?php get_template_part("components/post-avatar", null, array(
						'post_main_picture' => wp_get_attachment_image_src($user_avatar_id, 'large-img-medium'),
						'title' => $post_title,
				) ); ?>

				<div class="resume__data">
					<div class="flex flex--vertical-center">
						<h2 class="resume__name card-form__title">
							<?php echo $author_first_name."&nbsp;".$author_last_name;

						if($post_w_linked){
								echo "<a href=".get_permalink(intval($post_w_linked))."> ; ".get_the_title(intval($post_w_linked))." </a>";
							}?></h2>


					</div>

					<?php // Todo gerer les posts liés $post_w_linked  ?>
 					<p style=""> <?php


						?>   </p>

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
						'href' => $post_link."/?post_id=".$post_id."&post_auth=".$current_user_id,
						'target' => "_self",
						'skin'  => 'ghost',
						'icon-only'  => false,
						'disabled'  => false,
						'icon-position' => 'left',
						'icon' => 'pencil-write',
						'additional-classes' => 'square ',//edit_post_main
						'data-attribute' => '',
						'theme' => "",
					)
				); ?>
				<?php endif; ?>
				<?php get_template_part('components/btn', null,
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
 <?php
$post_id_presenece = isset($_GET["post_id"]) ? intval($_GET["post_id"]) : 0;
$show = $post_id == $post_id_presenece;
?>

<div id="editPostPopup" class="popup" style="display: <?php if(!$show) echo 'none'  ?> ;    background: #6c6c64b5;">
	<div class=" popup-content">
		<div class="body-popup">
			<div class="popup-header">
				<h2>News Post</h2>
				<div class="popup-controls">
					<?php
					// Récupérer le statut actuel du post
					$current_status = get_post_status($post_id);

					// Définir un libellé pour chaque statut
					$status_labels = array(
						'publish'  => 'Active',
						'private'  => 'Inactive',
						'erase'    => 'Erase',
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
							<a href="#" onclick="setStatus('erase', <?php echo $post_id; ?>)">Erase</a>
						</div>
					</div>

								 <?php get_template_part( 'components/btn', null,
									 array(
										 'label' => 'close',
										 'href' => $post_link ,
										 'target' => "_self",
										 'skin'  => 'ghost',
										 'icon-only'  => false,
										 'disabled'  => false,
										 'icon-position' => '', // left or right
										 'icon' => '',
										 'additional-classes' => 'square',
										 'data-attribute' => '',
										 'theme' => "",
									 )
								 ); ?>


					<!-- <span class="close-btn-circle">&times;</span> -->
				</div>
			</div>

			<!-- Divider -->
			<hr>

			<!-- Sommaire (Step 0) -->
			<div class="form-step" id="step0">
 				<ul class="step-list">
					<li><a href="#" onclick="goToStep(1)">Media ></a></li>
					<li><a href="#" onclick="goToStep(2)">Location ></a></li>
					<li><a href="#" onclick="goToStep(3)">Texts & Key Info ></a></li>
					<li><a href="#" onclick="goToStep(7)">Linked ></a></li>
					<li><a href="#" onclick="goToStep(4)">Connections ></a></li>
					<li><a href="#" class="premium" onclick="goToStep(5)">add Event</a></li>
					<li><a href="#" class="premium" onclick="goToStep(6)">add Premium</a></li>
				</ul>
			</div>

			<!-- Autres étapes du formulaire -->
			<div class="form-step" id="step1" style="display:none;">
				<h3>Media</h3>
				<main class="modal__content contact__form contact__form--light" >
					<?php echo do_shortcode( '[gravityform id="50" title="false" ajax="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>


					<?php	echo do_shortcode('[gallery_manager  max_images="15" size="medium" allowed_extensions="jpg,png"  post_id="' . $post_id . '"]');
					; ?>

					<?php	echo do_shortcode('[video_manager_url    post_id="' . $post_id . '"]');
					; ?>


					<?php	//echo do_shortcode('[main_picture_manager   post_id="' . $post_id . '"]');
					; ?>
<hr>
					<?php	echo do_shortcode('[manage_post_media   post_id="' . $post_id . '"]');
					; ?>






					<!--				--><?php	//echo do_shortcode( '[gravityform id="4" title="false"  field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
				</main>
			</div>

			<!--  Location-->
			<div class="form-step" id="step2" style="display:none;height:450px">
				<div style="height: 400px; overflow: auto;">
					<h3>Location</h3>
					<main class="modal__content contact__form contact__form--light" style="text-align: justify;">
						<?php echo do_shortcode( '[gravityform id="48" title="false" ajax="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
					</main>
				</div>
				<div>
							<?php get_template_part( 'components/btn', null,
									 array(
										 'label' => 'SAVE updates',
										 'href' => "#" ,
										 'target' => "_self",
										 'skin'  => 'ghost',
										 'icon-only'  => false,
										 'disabled'  => false,
										 'icon-position' => '', // left or right
										 'icon' => '',
										 'additional-classes' => 'square',
										 'data-attribute' => 'id="submit_" data-form_id="48" data-step="2"',
										 'theme' => "",
									 )
								 ); ?>

				</div>
			</div>



			<!-- feaatures -->
			<div class="form-step" id="step3" style="display:none; height:450px">
				<div style="height: 400px; overflow: auto;">
					<main class="modal__content contact__form contact__form--light" style="text-align: justify;" >

						<?php echo do_shortcode( '[gravityform id="47" ajax="false" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>

					</main>
				</div>
				<div>
							<?php get_template_part( 'components/btn', null,
									 array(
										 'label' => 'SAVE updates',
										 'href' => "#" ,
										 'target' => "_self",
										 'skin'  => 'ghost',
										 'icon-only'  => false,
										 'disabled'  => false,
										 'icon-position' => '', // left or right
										 'icon' => '',
										 'additional-classes' => 'square',
										 'data-attribute' => 'id="submit_" data-form_id="47" data-step="3"',
										 'theme' => "",
									 )
								 ); ?>

				</div>

			</div>

			<!--  -->
			<div class="form-step" id="step4" style="display:none;height:450px">
				<div style="height: 400px; overflow: auto;">
					<h3>Connections</h3>
					<main class="modal__content contact__form contact__form--light" style="text-align: justify;">
						<?php echo do_shortcode( '[gravityform id="49" ajax="false" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
					</main>
				</div>
				<div>
							<?php get_template_part( 'components/btn', null,
									 array(
										 'label' => 'SAVE updates',
										 'href' => "#" ,
										 'target' => "_self",
										 'skin'  => 'ghost',
										 'icon-only'  => false,
										 'disabled'  => false,
										 'icon-position' => '', // left or right
										 'icon' => '',
										 'additional-classes' => 'square',
										 'data-attribute' => 'id="submit_" data-form_id="49" data-step="4"',
										 'theme' => "",
									 )
								 ); ?>

				</div>
			</div>

			<!--  -->
			<div class="form-step" id="step5" style="display:none;height:450px">
				<div style="height: 400px; overflow: auto;">
					<h3>Event</h3>
					<main class="modal__content contact__form contact__form--light" style="text-align: justify;">
						<?php echo do_shortcode( '[gravityform id="46" title="false" ajax="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
					</main>
				</div>
				<div>
							<?php get_template_part( 'components/btn', null,
									 array(
										 'label' => 'SAVE updates',
										 'href' => "#" ,
										 'target' => "_self",
										 'skin'  => 'ghost',
										 'icon-only'  => false,
										 'disabled'  => false,
										 'icon-position' => '', // left or right
										 'icon' => '',
										 'additional-classes' => 'square',
										 'data-attribute' => 'id="submit_" data-form_id="46" data-step="5"',
										 'theme' => "",
									 )
								 ); ?>

				</div>
			</div>

			<!--  -->
			<div class="form-step" id="step6" style="display:none;height:450px">
				<div style="height: 400px; overflow: auto;">
					<h3>Premium</h3>
					<main class="modal__content contact__form contact__form--light" style="text-align: justify;">
						<?php echo do_shortcode( '[gravityform id="45" ajax="false" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
					</main>
				</div>
				<div>
							<?php get_template_part( 'components/btn', null,
									 array(
										 'label' => 'SAVE updates',
										 'href' => "#" ,
										 'target' => "_self",
										 'skin'  => 'ghost',
										 'icon-only'  => false,
										 'disabled'  => false,
										 'icon-position' => '', // left or right
										 'icon' => '',
										 'additional-classes' => 'square',
										 'data-attribute' => 'id="submit_" data-form_id="45" data-step="6"',
										 'theme' => "",
									 )
								 ); ?>

				</div>
			</div>


			<!--  Linked-->
			<div class="form-step" id="step7" style="display:none;height:450px">
				<div style="height: 400px; overflow: auto;">
					<main class="modal__content contact__form contact__form--light" style="text-align: justify;">
						<?php echo do_shortcode( '[gravityform id="51" title="false" ajax="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
					</main>
				</div>
				<div>
					<?php get_template_part( 'components/btn', null,
						array(
							'label' => 'SAVE updates',
							'href' => "#" ,
							'target' => "_self",
							'skin'  => 'ghost',
							'icon-only'  => false,
							'disabled'  => false,
							'icon-position' => '', // left or right
							'icon' => '',
							'additional-classes' => 'square',
							'data-attribute' => 'id="submit_" data-form_id="51" data-step="7"',
							'theme' => "",
						)
					); ?>

				</div>
			</div>
			<!-- Contrôles de navigation -->
			<div class="form-navigation" style="display : none">
				<button id="prevBtn" onclick="navigateSteps(-1)">Previous</button>
				 <span id="step-count">0 / 7</span>
			 	<button id="nextBtn" onclick="navigateSteps(1)">Next</button>
			</div>
			<div>
				<p class="active-status" id="status_notif_"></p>
			</div>

		</div>
	</div>

</div>
<?php if(isset($_GET["premium"])) : ?>
	<script>
		document.addEventListener("DOMContentLoaded", function () {
		navigateSteps(6)
		})
	</script>

<?php endif ;?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Sélectionner tous les boutons dont l'ID est 'submit_' et comportant l'attribut 'data-form_id'
    const buttons = document.querySelectorAll('a#submit_');

    // Parcourir chaque bouton et ajouter un gestionnaire d'événements
    buttons.forEach(button => {
        button.addEventListener("click", function () {
            // Récupérer l'ID du formulaire depuis l'attribut 'data-form_id'
            const formId = button.getAttribute("data-form_id");
            const idStep = button.getAttribute("data-step");

            // Trouver le formulaire et le bouton de soumission associé
            const form = document.querySelector(`#step${idStep} form#gform_${formId}`);
            const submitButton = form.querySelector(`#gform_submit_button_${formId}`);

            if (form && submitButton) {
                // Simuler le clic sur le bouton de soumission du formulaire
                submitButton.click();
            } else {
                // Afficher une notification d'erreur si le formulaire n'existe pas
                const statusNotification = document.querySelector("#status_notif_");
                if (statusNotification) {
                    statusNotification.textContent = `Erreur : Formulaire pour l'ID ${formId} non trouvé.`;
                    statusNotification.style.color = "red";
                }
            }
        });
    });
});
</script>




<!-- fin todo_augustin -->
		<div class="tab-content default-bckg post-page <?php if(isset($post_gallery_image_ids_array) && count($post_gallery_image_ids_array) > 1 ){  echo "carrousel glide"; } ?>" data-barba-prevent="all" id="tabs-home">

			<div class="post-page__section ">
				<?php
				if($post_link_parsed) {?>

					<div style="position: relative">
						<div class="floating-bar flex">
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
										'additional-classes' => 'btn--small',
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
						</div>
						<?php echo do_shortcode('[wplinkpreview  url= ' . $post_link_parsed . ' ]'); ?>
					</div>
					<?php

				} else {
				?>
				<?php if(isset($post_gallery_image_ids_array) ): ?>
					<div class="profile-content__img glide">
						<div class="post-page__section floating-bar flex flex--vertical-center">

								<?php if($current_user_id == $author_id): ?>
									<div class="edit-area hide">

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
											'additional-classes' => 'btn--small',
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

						</div>
					<?php endif; ?>
				<?php endif; ?>
				<?php } ?>

			</div>

			<div class="post-page__section bt-2">
				<?php if($current_user_id == $author_id): ?>
					<div class="flex edit-area hide">

				<?php endif; ?>
				<?php if($current_user_id == $author_id): ?></div><?php endif; ?>




				<?php if($post_events_text_1 && $post_events_type != "None"): ?>
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

			<div class="<?php if($post_post_tags) echo "bt-2" ?>">
				<?php if($current_user_id == $author_id): ?>
					<div class="flex edit-area hide">
					<?php
				  ?>
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


				<?php endif; ?>
				<?php if($current_user_id == $author_id): ?></div><?php endif; ?>

				<?php
					// todo_augustin
					limiterLignes($post_main_content,32); ?>
			</div>

      <div class="post-page__section bt-2">
		<dl>

			<dt class="-light">Contact Information :</dt>


			<br>

			<dd>


			<?php if ($author_data): ?>
				<div class="post-page__section">
					<?php get_template_part("components/user-resume-on-post", null, array(
							"user" => $author_data,
							'additional-classes' => '',
						)); ?>
				</div>
			<?php endif; ?>

			<?php if($author_email_address || $author_phone_number || $author_website_link || $post_Add_my_webshop_link) : ?>
				<div class="post-page__section content">
					<ul class="contact__list">
						<?php if($author_email_address): ?>
							<li class="contact__list__item">
								<a href="<?php echo "mailto:" . $author_email_address; ?>" target="_blank">
									<svg fill="#000000" height="20" width="20" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M256,0C114.609,0,0,114.609,0,256s114.609,256,256,256s256-114.609,256-256S397.391,0,256,0z M256,472 c-119.297,0-216-96.703-216-216S136.703,40,256,40s216,96.703,216,216S375.297,472,256,472z"></path> <g> <path d="M368,234.375v74.438l-54.5-59.422l16.719-11.312c-5.984-1.531-11.641-3.922-16.688-7.203L256,271.75L166.281,208H256 h37.625c-2.391-4.984-4-10.344-4.812-16H256H128v160h128h128V223.062C379.422,227.75,373.969,231.531,368,234.375z M144,212.531 l54.5,36.859L144,308.812V212.531z M256,336h-92.406l45.562-79.422L256,288.25l46.844-31.672L348.406,336H256z"></path> </g> <path d="M344,144c-22.094,0-40,17.906-40,40s17.906,40,40,40s40-17.906,40-40S366.094,144,344,144z M344,214.406L324.797,192H336 v-32h16v32h11.203L344,214.406z"></path> </g> </g></svg>
									Send a message
								</a>
							</li>
						<?php endif; ?>



						<?php

						if(($author_phone_number && $post_phone_calls_available) ||($author_phone_number &&  $author_connections_settings && in_array("phone_calls_available", $author_connections_settings))): ?>
							<li class="contact__list__item">
								<a href="<?php echo "tel:" . $author_phone_number; ?>" target="_blank">
									<svg viewBox="0 0 24 24" height="20" width="20" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M10 8H8.44444C8.2 8 8 8.2 8 8.44444C8 12.6178 11.3822 16 15.5556 16C15.8 16 16 15.8 16 15.5556V14.0044C16 13.76 15.8 13.56 15.5556 13.56C15.0044 13.56 14.4667 13.4711 13.9689 13.3067C13.9244 13.2889 13.8756 13.2844 13.8311 13.2844C13.7156 13.2844 13.6044 13.3289 13.5156 13.4133L12.5378 14.3911C11.28 13.7467 10.2489 12.72 9.60889 11.4622L10.5867 10.4844C10.7111 10.36 10.7467 10.1867 10.6978 10.0311C10.5333 9.53333 10.4444 9 10.4444 8.44444C10.4444 8.2 10.2444 8 10 8ZM9.77333 10.04C9.66667 9.67111 9.6 9.28444 9.57333 8.88889H8.90222C8.94222 9.47556 9.05778 10.04 9.24 10.5733L9.77333 10.04ZM15.1111 14.4311C14.72 14.4044 14.3333 14.3378 13.9556 14.2311L13.4222 14.76C13.96 14.9378 14.5244 15.0533 15.1111 15.0933V14.4311Z" fill="#000000"></path> <path d="M13.2216 9.52112V9.10456H15.3044V11.1874H14.8879V9.81568L12.9376 11.766L12.643 11.4714L14.5933 9.52112H13.2216Z" fill="#000000"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20Z" fill="#000000"></path> </g></svg>
									Call
								</a>
							</li>
						<?php endif; ?>

						<?php if($author_website_link && $post_add_my_website_link && in_array("add_website_link", $author_connections_settings)): ?>

						<?php endif; ?>

						<?php if($author_online_shop_link && in_array("add_online_shop_link", $author_connections_settings)): ?>

						<?php endif; ?>

						<?php if($post_home_event_privacy): ?>
							<li class="contact__list__item">
								<a href="<?php echo $post_home_event_privacy; ?>" target="_blank">
									<svg viewBox="0 0 64 64" height="20" width="20" xmlns="http://www.w3.org/2000/svg" stroke-width="3" stroke="#000000" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M39.93,55.72A24.86,24.86,0,1,1,56.86,32.15a37.24,37.24,0,0,1-.73,6"></path><path d="M37.86,51.1A47,47,0,0,1,32,56.7"></path><path d="M32,7A34.14,34.14,0,0,1,43.57,30a34.07,34.07,0,0,1,.09,4.85"></path><path d="M32,7A34.09,34.09,0,0,0,20.31,32.46c0,16.2,7.28,21,11.66,24.24"></path><line x1="10.37" y1="19.9" x2="53.75" y2="19.9"></line><line x1="32" y1="6.99" x2="32" y2="56.7"></line><line x1="11.05" y1="45.48" x2="37.04" y2="45.48"></line><line x1="7.14" y1="32.46" x2="56.86" y2="31.85"></line><path d="M53.57,57,58,52.56l-8-8,4.55-2.91a.38.38,0,0,0-.12-.7L39.14,37.37a.39.39,0,0,0-.46.46L42,53.41a.39.39,0,0,0,.71.13L45.57,49Z"></path></g></svg>
									Privacy
								</a>
							</li>
						<?php endif; ?>

						<?php if( $post_author_link && $post_add_my_website_link): ?>
							<li class="contact__list__item">
								<a href="<?php echo esc_url($post_author_link); ?>" target="_blank">
									<svg viewBox="0 0 64 64" height="20" width="20" xmlns="http://www.w3.org/2000/svg" stroke-width="3" stroke="#000000" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M39.93,55.72A24.86,24.86,0,1,1,56.86,32.15a37.24,37.24,0,0,1-.73,6"></path><path d="M37.86,51.1A47,47,0,0,1,32,56.7"></path><path d="M32,7A34.14,34.14,0,0,1,43.57,30a34.07,34.07,0,0,1,.09,4.85"></path><path d="M32,7A34.09,34.09,0,0,0,20.31,32.46c0,16.2,7.28,21,11.66,24.24"></path><line x1="10.37" y1="19.9" x2="53.75" y2="19.9"></line><line x1="32" y1="6.99" x2="32" y2="56.7"></line><line x1="11.05" y1="45.48" x2="37.04" y2="45.48"></line><line x1="7.14" y1="32.46" x2="56.86" y2="31.85"></line><path d="M53.57,57,58,52.56l-8-8,4.55-2.91a.38.38,0,0,0-.12-.7L39.14,37.37a.39.39,0,0,0-.46.46L42,53.41a.39.39,0,0,0,.71.13L45.57,49Z"></path></g></svg>
									Website
								</a>
							</li>
						<?php endif; ?>

						<?php if($post_Add_my_webshop_link  && $Is_Add_my_webshop_link): ?>
							<li class="contact__list__item">
								<a href="<?php echo esc_url($post_Add_my_webshop_link); ?>" target="_blank">
									<svg viewBox="0 0 64 64" height="20" width="20" xmlns="http://www.w3.org/2000/svg" stroke-width="3" stroke="#000000" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M39.93,55.72A24.86,24.86,0,1,1,56.86,32.15a37.24,37.24,0,0,1-.73,6"></path><path d="M37.86,51.1A47,47,0,0,1,32,56.7"></path><path d="M32,7A34.14,34.14,0,0,1,43.57,30a34.07,34.07,0,0,1,.09,4.85"></path><path d="M32,7A34.09,34.09,0,0,0,20.31,32.46c0,16.2,7.28,21,11.66,24.24"></path><line x1="10.37" y1="19.9" x2="53.75" y2="19.9"></line><line x1="32" y1="6.99" x2="32" y2="56.7"></line><line x1="11.05" y1="45.48" x2="37.04" y2="45.48"></line><line x1="7.14" y1="32.46" x2="56.86" y2="31.85"></line><path d="M53.57,57,58,52.56l-8-8,4.55-2.91a.38.38,0,0,0-.12-.7L39.14,37.37a.39.39,0,0,0-.46.46L42,53.41a.39.39,0,0,0,.71.13L45.57,49Z"></path></g></svg>
									Webshop
								</a>
							</li>
						<?php endif; ?>
					</ul>

				</div>
			<?php endif; ?>
			</dd>
		</dl>
		</div>


			<div class="post-page__section bt-2 content">






				<?php if($current_user_id == $author_id): ?>
					<div class="flex edit-area hide">
					<?php
					  ?>


				<?php endif; ?>
				<?php if($current_user_id == $author_id): ?></div><?php endif; ?>

				<?php if($post_job_type): ?>
					<dl><dt class="-light">Job Type:</dt><dd><?php echo(  $post_job_type); ?></dd></dl>
				<?php endif; ?>

				<?php if($post_main_work_location): ?>
					<dl><dt class="-light">Main work location:</dt><dd><?php echo($post_main_work_location); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_key_roles): ?>
					<dl><dt class="-light">Key Roles:</dt><dd><?php echo($post_key_roles); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_requirements): ?>
					<dl><dt class="-light">Requirements:</dt><dd><?php echo($post_requirements); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_preferred_qualifications): ?>
					<dl><dt class="-light">Preferred Qualifications:</dt><dd><?php echo($post_preferred_qualifications); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_career_growth): ?>
					<dl><dt class="-light">Career Growth:</dt><dd><?php echo($post_career_growth); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_company_culture): ?>
					<dl><dt class="-light">Company Culture:</dt><dd><?php echo($post_company_culture); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_reporting_structure): ?>
					<dl><dt class="-light">Reporting Structure:</dt><dd><?php echo($post_reporting_structure); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_work_hours): ?>
					<dl><dt class="-light">Work Hours:</dt><dd><?php echo($post_work_hours); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_compensation): ?>
					<dl><dt class="-light">Compensation:</dt><dd><?php echo($post_compensation); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_benefits): ?>
					<dl><dt class="-light">Benefits:</dt><dd><?php echo($post_benefits); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_application_process): ?>
					<dl><dt class="-light">Application Process:</dt><dd><?php echo($post_application_process); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_job_application_deadline): ?>
					<dl><dt class="-light">Job Application Deadline:</dt><dd><?php echo($post_job_application_deadline); ?></dd></dl>
				<?php endif; ?>
				<?php if($post_other): ?>
					<dl><dt class="-light">Other:</dt><dd><?php echo($post_other); ?></dd></dl>
				<?php endif; ?>
			</div>



			<?php
			// todo_augustin : show map
			$location = get_field( 'post_location_address', $post_id); // Récupérer la géolocalisation
			$post_location_longitude = get_field( 'post_location_longitude', $post_id);
			$post_location_latitude = get_field( 'post_location_latitude', $post_id);

			if($location&&$post_location_latitude&&$post_location_longitude) {
				echo '<br><dl><dt class="-light"></dt> </dl>';
				echo do_shortcode('[osm_map address ="'.$location.'" latitude="'.$post_location_latitude.'" longitude="'.$post_location_longitude.'"  height="400px" width="100%" zoom="15"]');

			}


			?>

			<div class="post-page__section  <?php if($location) echo 'bt-2'; ?> ">
				<?php if($current_user_id == $author_id): ?>
					<div class="flex edit-area hide">
					<?php
			  ?>
				<?php endif; ?>
				<?php if($current_user_id == $author_id): ?></div><?php endif; ?>
				<?php

				$posts_args = array(
					"post_type" => "news",
					"p" => $post_id,
					//"post_status" => "publish",
					"posts_per_page" => -1,
					"orderby" => "date",

					"order" => "DESC"
				);

 				$posts_query = new WP_Query($posts_args);

				wp_reset_postdata();
				$post_content_for_map = [];
				if(!empty($posts_query->have_posts())):
				$posts = [];

				while($posts_query->have_posts()):
					$posts_query->the_post();
					$post_id_ = get_the_ID();
					$post_for_map = [
						"id" => $post_id_,
						"title" =>  get_field("post_home_title",$post_id_) ? get_field("post_home_title",$post_id_) : get_the_title(), // house type
						"post_type_slug" => "real-estate",
						"lat" => get_field("post_location_latitude",$post_id_),
						"lng" => get_field("post_location_longitude",$post_id_),
 						"location" => get_field("post_location_address",$post_id_) ? get_field("post_location_address",$post_id_) . ", " . get_field("post_location_zip",$post_id_) . " " . get_field("post_location_city",$post_id_) : get_field("post_address",$post_id_),

					];
					array_push($post_content_for_map, $post_for_map);
				endwhile;
				endif;


					?>


				<div class="post-page__section post-page__section--footer mt-2 ">
					<p class="post-footer__publish-date p-xs">
						<?php echo get_time_ago(get_post_timestamp()); ?>
					</p>
				</div>
			</div>
		</div>


<?php

// ----------- Edit ---------------

if($current_user_id == $author_id): ?>

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

	<div class="modal micromodal-slide" id="share-post" aria-hidden="true" style = "z-index: 1001">
		<div class="modal__overlay" tabindex="-1" data-micromodal-close>
			<div class="modal__container" style="overflow: hidden" role="dialog" aria-modal="true" aria-labelledby="publish-home-title">
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

<?php comments_template(); ?>

</main>

<?php get_footer(); ?>

