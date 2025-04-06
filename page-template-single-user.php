<?php
/**
* Template Name: Single user
*
* by hellomarcel.be
* -> hello@marcel-pirnay.be
*/
?>

<?php get_header(); ?>

<?php
$current_user_id = get_current_user_id();
$user_id = !empty(get_query_var("user_id")) ? get_query_var("user_id") : $current_user_id;
$user_data = get_user_by("id", intval($user_id));
$first_name = ucfirst($user_data->user_firstname);
$last_name = ucfirst($user_data->user_lastname);
$user_permalink = get_permalink()."?user=".$first_name."-".$last_name;
$account_type = get_field("user_account_type", "user_".$user_id);

$i_request_contactlist_users_relationships = get_field("i_request_contactlist_users_relationships", "user_".$current_user_id);
$i_accept_contactlist_users_relationships = get_field("i_accept_contactlist_users_relationships", "user_".$current_user_id);
$him_request_contactlist_users_relationships = get_field("i_request_contactlist_users_relationships", "user_".$user_id);
$him_accept_contactlist_users_relationships = get_field("i_accept_contactlist_users_relationships", "user_".$user_id);
// $i_refused_contactlist_users_relationships = get_field("i_refused_contactlist_users_relationships", "user_".$current_user_id);
$i_recommend_users_relationships = get_field("i_recommend_users_relationships", "user_".$current_user_id);
$him_recommend_users_relationships = get_field("users_recommend_me_relationships", "user_".$user_id);
?>

<main class="main" role="main" data-barba="container" data-barba-namespace="user" data-theme="theme-light" data-admin-ajax=<?php echo admin_url( 'admin-ajax.php' ); ?>>
	<span class="hide current_user_id page_user_id" data-u-id="<?php echo $current_user_id; ?>"></span>
	<div class="container container--default public-profile tabs-group">

		<!-- User resume -->
		<div class="card-form card-form flex flex--justify-between" data-barba-prevent="all">
			<?php if ($user_data):
				get_template_part("components/user-resume-profile", null, array(
					"user" => $user_data,
					'additional-classes' => '',
				));
			endif; ?>
			<?php if(get_current_user_id() == $user_id):
					get_template_part( 'components/btn', null,
						array(
							'label' => 'Complete your profile',
							'href' => get_permalink("468"),
							'target' => "_self",
							'skin'  => 'ghost',
							'icon-only'  => false,
							'disabled'  => false,
							'icon-position' => 'left',
							'icon' => 'pencil-write',
							'additional-classes' => '',
							'data-attribute' => 'data-open-modal=\'publish-profile\'',
							'theme' => "",
						)
					);
				endif; ?>
		</div>


		<!-- profile form -->
		<div class="modal micromodal-slide modal--publish" id="publish-profile" aria-hidden="true">
			<div class="modal__overlay" tabindex="-1" data-micromodal-close>
				<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="publish-projects-title">
					<header class="modal__header">
						<div class="flex flex--vertical">
							<h2 class="modal__title h2" id="publish-projects-title">Complete your Profile </h2>
						</div>
						<?php get_template_part("components/btn", null, array( 'label' => 'Close this modal window', 'href' => "", 'target' => "_self", 'skin'  => 'transparent', 'icon-only'  => true, 'disabled'  => false, 'icon-position' => 'right', 'icon' => 'close', 'additional-classes' => '', 'data-attribute' => 'data-close-modal', 'theme' => "", )); ?>
					</header>
					<main class="modal__content contact__form contact__form--light" id="publish-projects-content">
						<?php
							$account_type = get_field("user_account_type", "user_".get_current_user_id());
						/**
						 * todo_augustin type de compte
						 * */
							echo '<input type="hidden" value="'.$account_type.'" id="_account_type_id_">';

							echo do_shortcode( '[gravityform id="52" ajax="true" title="false"]' );


						?>
					</main>
				</div>
			</div>
		</div>
		<!-- profile file -->





		<!-- Profile actions -->
		<div class="profile-actions" data-barba-prevent="all">
			<!-- Profile display -->
			<div class="left">
				<div class="btn-group btn-group--related">
<!--					--><?php //if(get_current_user_id() == $user_id):
//						get_template_part( 'components/btn', null,
//							array(
//								'label' => 'My favorites:',
//								'href' => get_permalink("468"),
//								'target' => "_self",
//								'skin'  => 'ghost',
//								'icon-only'  => false,
//								'disabled'  => false,
//								'icon-position' => 'left',
//								'icon' => 'rating-star-ribbon',
//								'additional-classes' => '',
//								'data-attribute' => 'data-action=\'show-favorites-only\'',
//								'theme' => "",
//							)
//						);
//					endif; ?>
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
						'label' => 'Profile',
						'href' => "",
						'target' => "_self",
						'skin'  => 'ghost',
						'icon-only'  => true,
						'disabled'  => false,
						'icon-position' => '',
						'icon' => 'single-neutral-circle',
						'additional-classes' => 'tab-button square active',
						'data-attribute' => 'data-tabs-id=\'tabs-profile\'',
						'theme' => "",
					)
				); ?>
			</div>

			<!-- Profile quick actions -->
			<div class="flex profile-actions__quick-actions btn-group">
				<?php if(get_current_user_id() != $user_id): ?>

					<?php  // $i_refused_this_contact = (!empty($i_refused_contactlist_users_relationships) && in_array($user_id, $i_refused_contactlist_users_relationships)) ? true : false; ?>
					<?php $i_request_this_contact = (!empty($i_request_contactlist_users_relationships) && in_array($user_id, $i_request_contactlist_users_relationships)) ? true : false; ?>
					<?php $i_accept_this_contact = (!empty($i_accept_contactlist_users_relationships) && in_array($user_id, $i_accept_contactlist_users_relationships)) ? true : false; ?>
					<?php $him_request_me = (!empty($him_request_contactlist_users_relationships ) && in_array($current_user_id, $him_request_contactlist_users_relationships )) ? true : false; ?>
					<?php $him_accept_me = (!empty($him_accept_contactlist_users_relationships ) && in_array($current_user_id, $him_accept_contactlist_users_relationships )) ? true : false; ?>
					<?php
					$contact_classes = 'relation_btn relation_btn--contact-list';
					$contact_text = 'Add contact';
					$contact_text_default = 'Add contact';
					$contact_text_requested = 'Contact requested';
					$contact_icon = 'add-square';
					$relation_type = 'request-contact-list';

					if($i_request_this_contact && $i_accept_this_contact && $him_request_me && !$him_accept_me){
						// I request & him did not accept yet [GREEN1]";
						$contact_text = 'Contact requested';
						$contact_classes .= ' relation_btn--contact-requested';
						$contact_icon = 'single-neutral-actions-refresh';
						$relation_type = 'remove-request-contact-list';
					}elseif($i_request_this_contact && $i_accept_this_contact && $him_request_me && $him_accept_me){
						// relation done [RED]";
						$contact_text = 'Contact accepted';
						$contact_classes .= ' relation_btn--contact-relation-done';
						$contact_icon = 'check-circle-1';
						$relation_type = 'refuse-contact-list';
						// alert(are your sure ?)
					}elseif($i_request_this_contact  && !$i_accept_this_contact && $him_request_me && $him_accept_me){
						// He request, I did not accept yet [GREEN2]";
						$contact_text = 'Accept contact';
						$contact_classes .= ' relation_btn--contact-him-requested';
						$contact_icon = 'check-circle-1';
						$relation_type = 'accept-contact-list';
					}elseif(!$i_request_this_contact && !$i_accept_this_contact && !$him_request_me && !$him_accept_me){
						// No request for now [Default & BLACK]";
					}

					 ?>
					<?php get_template_part( 'components/btn', null,
						array(
							'label' => $contact_text,
							'href' => "/",
							'target' => "_self",
							'skin'  => 'ghost',
							'icon-only'  => false,
							'disabled'  => false,
							'icon-position' => 'left',
							'icon' => $contact_icon,
							'additional-classes' => $contact_classes,
							'data-attribute' => "data-relation-him=" . $user_id . " data-relation-type=" . $relation_type . " data-request-contact-default=" . rawurlencode($contact_text_default) . "  data-request-contact-requested=" . rawurlencode($contact_text_requested) . "",
							'theme' => "",
						)
					); ?>
					<?php if($account_type == "company_user" || $account_type == "pro_user"): ?>
						<?php $do_i_recommend_him = (!empty($i_recommend_users_relationships) && in_array($user_id, $i_recommend_users_relationships)) ? true : false; ?>
						<?php $is_he_recommended_by_me = (!empty($him_recommend_users_relationships) && in_array($current_user_id, $him_recommend_users_relationships)) ? true : false; ?>

						<?php get_template_part( 'components/btn', null,
							array(
								'label' => 'Recommend',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'ghost',
								'icon-only'  => true,
								'disabled'  => false,
								'icon-position' => '',
								'icon' => 'check-badge',
								'additional-classes' => $do_i_recommend_him ? 'relation_btn relation_btn--recommend relation_btn--checked' : 'relation_btn relation_btn--recommend',
								'data-attribute' => "data-relation-him=" . $user_id . " data-relation-type='recommend'",
								'theme' => "",
							)
						); ?>
					<?php endif; ?>
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
						'data-attribute' => 'data-open-modal=\'share-profile\'',
						'theme' => "",
					)
				); ?>
			</div>
		</div>

		<!-- Profile content -->
		<?php
			$sector_of_activity = get_field("user_current_user_sector_of_activity", "user_".$user_id);
			$work_position = get_field("user_current_work_position", "user_".$user_id);
			$services_products_provided = get_field("user_services_products_provided", "user_".$user_id);
			$work_and_skills = get_field("user_work_and_skills", "user_".$user_id);
			$interests = get_field("user_interests", "user_".$user_id);

			$phone_number = get_field("user_phone_number", "user_".$user_id);
			$email_address = $user_data->user_email;
			$website_link = get_field("user_website_link", "user_".$user_id);
			$events = get_field("user_event", "user_".$user_id);

			$user_location = get_field("user_location", "user_".$user_id);
			$image_ids = get_field("user_gallery_ids", "user_".$user_id);
			$image_ids_array = explode(',', $image_ids);
		?>

		<?php
			$posts_args = array(
				"post_type" => "homes",
				"post_status" => "publish",
				"posts_per_page" => -1,
				"orderby" => "date",
				"order" => "DESC",
				'author' => $current_user_id,
			);

			$posts_query = new WP_Query($posts_args);
			$users_post_content = [];
			$users_post_content_for_map = [];

			if(!empty($posts_query->have_posts())  ):
				$posts = [];

				while($posts_query->have_posts()):
					$posts_query->the_post();

					$post_address = get_field("post_location_address") . ", " . get_field("post_location_zip") . " " . get_field("post_location_city");
					$post_location_latitude = get_field("post_location_latitude");
					$post_location_longitude = get_field("post_location_longitude");
					$price = get_field("post_price");
					$bedrooms = get_field("post_number_of_bedrooms");
					$bathrooms = get_field("post_number_of_bathrooms");
					$home_size = get_field("post_home_size");
					$outdoor_size = get_field("post_outdoor_size");
					$post_id = get_the_ID();
					$post_init_terms = get_the_terms($post_id, 'posttags');

					if(is_array(get_field("post_home_category"))){
						$post_category = get_field("post_home_category")["label"];
					}else{
						$post_category = get_field("post_home_category");
					}
					if(get_the_author_meta('ID')==$user_id) {
						$post = [
							"id" => $post_id,
							"title" => get_the_title(),
							"post_type" => "Homes",
							"post_type_slug" => "real-estate",
							"card_gallery" => get_field("post_gallery"),
							"card_gallery_display" => get_field("post_pictures_display"),
							"type" => get_field("post_action"),
							"home_category" => get_field("post_home_category"),
							"first_name" => $first_name,
							"last_name" => $last_name,
							"user_id" => $user_id,
							"profile_picture" => get_field("user_profile_picture", "user_".get_the_author_meta('ID')),
							"work_position" => get_field("user_current_work_position", "user_".get_the_author_meta('ID')),
							"main_picture" => get_field("post_main_picture"),
							"price" => $price,
							"bedrooms" => $bedrooms,
							"bathrooms" => $bathrooms,
							"home_size" => $home_size,
							"outdoor_size" => $outdoor_size,
							"tags" => $post_init_terms,
							"home_amenities" => get_field("post_home_amenities"),
							"neighborhood_amenities" => get_field("post_neighborhood_amenities"),
							"transportation" => get_field("post_transportation"),
							"garages_parking" => get_field("post_garages_parking"),
							"schools" => get_field("post_schools_nearby"),
							"home_style_architecture" => get_field("post_home_style_and_architecture"),
							"additional_features" => get_field("post_additional_home_features"),
							"taxes" => get_field("post_property_taxes"),
							"fees" => get_field("post_other_property_fees"),
							"systems" => get_field("post_heating_cooling_systems"),
							"energy_rating" => get_field("post_energy_rating"),
							"energy_consumption" => get_field("post_estimated_energy_consumption"),
							"location" => $post_address,
							"publish_date" => get_post_timestamp()
						];

						$post_for_map = [
							"id" => $post_id,
							"title" => "Home", // house type
							"post_type_slug" => "real-estate",
							"permalink" => get_the_permalink($post_id),
							"lat" => $post_location_latitude,
							"lng" => $post_location_longitude,
							"account_type" => null,
							"location" => $post_address,
							"price" => $price,
							"bedrooms" => $bedrooms,
							"bathrooms" => $bathrooms,
							"home_size" => $home_size,
							"outdoor_size" => $outdoor_size,
						];

						array_push($users_post_content, $post);
						array_push($users_post_content_for_map, $post_for_map);
					}


				endwhile;
			endif;
			wp_reset_postdata();
			arsort($users_post_content);
		?>

		<div class="tab-content default-bckg profile-content__informations  content <?php if(isset($image_ids_array) && count($image_ids_array) > 1 ){  echo "carrousel glide"; } ?>" id="tabs-profile">
<!--			--><?php //if(isset($image_ids_array) && is_array($image_ids_array) ): ?>
<!--				<div class="profile-content__img">-->
<!--					--><?php //if(count($image_ids_array) > 1): ?>
<!--							--><?php //get_template_part("components/carrousel", null, array(
//								'img' => $image_ids_array,
//								'post_creator_name' => $first_name . " " . $last_name,
//							)); ?>
<!--						--><?php //else: ?>
<!--							--><?php //get_template_part("components/carrousel-single-image", null, array(
//								'img' => $image_ids_array,
//								'post_creator_name' => $first_name . " " . $last_name,
//							)); ?>
<!--					--><?php //endif; ?>
<!--				</div>-->
<!--			--><?php //endif; ?>

			<?php if($events): ?>
				<?php
//				foreach ($events as $event): ?>
<!--					<div class="profile-content--sct bt-2">-->
<!--						--><?php //get_template_part( 'components/btn', null,
//								array(
//									'label' => $event['user_action_button_text'],
//									'href' => "/",
//									'target' => "_self",
//									'skin'  => 'primary',
//									'icon-only'  => false,
//									'disabled'  => false,
//									'icon-position' => '',
//									'icon' => '',
//									'additional-classes' => '',
//									'data-attribute' => null,
//									'theme' => "",
//								)
//							); ?>
<!--							--><?php //if($event['user_add_more_text']): ?>
<!--								<p class="p-sm mg-t-1">--><?php //echo $event['user_add_more_text']; ?><!--</p>-->
<!--							--><?php //endif; ?>
<!--						</div>-->
<!--					--><?php //endforeach; ?>
			<?php endif; ?>

			<!-- <h2 class="h3 bt-2"">Profile informations</h2> -->
			<div class="profile-content--sct bt-2">
				<?php
//				if(!empty($users_post_content) || !empty($him_recommend_users_relationships) || !empty($him_accept_contactlist_users_relationships)): ?>
<!--					<h3 class="h4 mb-sm">Connections</h3>-->
<!--					<ul class="connection__list">-->
<!--						<li class="connection__list__item">-->
<!--							--><?php //if(!empty($users_post_content)): ?>
<!--								--><?php //if(count($users_post_content) >= 1): ?>
<!--									--><?php //$active_post_s_content = (count($users_post_content) == 1) ? "active post" :  "active posts"; ?>
<!--									<a href="" class="tab-button" data-tabs-id="tabs-list">--><?php //echo count($users_post_content); ?><!-- --><?php //echo $active_post_s_content; ?><!--</a>-->
<!--								--><?php //endif; ?>
<!--							--><?php //else: ?>
<!--								<p>No posts for now</p>-->
<!--							--><?php //endif; ?>
<!--						</li>-->
<!---->
<!--						<li class="connection__list__item">-->
<!--							--><?php //if(!empty($him_recommend_users_relationships)): ?>
<!--								--><?php //if(count($him_recommend_users_relationships) >= 1): ?>
<!--									--><?php //$recommend_user_s_content = (count($him_recommend_users_relationships) == 1) ? "user recommend" :  "users recommend"; ?>
<!--									--><?php //$recommend_user_s_title = (count($him_recommend_users_relationships) == 1) ? $first_name . " " . $last_name . " 's recommendation" : $first_name . " " . $last_name . " 's recommendations"; ?>
<!--									<a href="/" data-open-modal="list-recommendations">--><?php //echo count($him_recommend_users_relationships); ?><!-- --><?php //echo $recommend_user_s_content; ?><!--</a>-->
<!--								--><?php //endif; ?>
<!--							--><?php //else: ?>
<!--								<p>No recommendations for now</p>-->
<!--							--><?php //endif; ?>
<!--						</li>-->
<!---->
<!--						<li class="connection__list__item">-->
<!--							--><?php //if(!empty($him_accept_contactlist_users_relationships)): ?>
<!--								--><?php //if(count($him_accept_contactlist_users_relationships) > 1): ?>
<!--									--><?php //$connection_user_s_content = (count($him_accept_contactlist_users_relationships) == 1) ? "user in contact list" :  "users in contact list"; ?>
<!--									--><?php //$connection_user_s_title = $first_name . " " . $last_name . " 's contact list"; ?>
<!--									<a href="/" data-open-modal="list-connections">--><?php //echo count($him_accept_contactlist_users_relationships); ?><!-- --><?php //echo $connection_user_s_content; ?><!--</a>-->
<!--								--><?php //endif; ?>
<!--							--><?php //else: ?>
<!--								<p>No users in contact list for now</p>-->
<!--							--><?php //endif; ?>
<!--						</li>-->
<!--					</ul>-->
<!--				--><?php //endif; ?>
				<?php
//				if(!empty($him_accept_contactlist_users_relationships)): ?>
<!--					<div class="modal micromodal-slide" id="list-connections" aria-hidden="true">-->
<!--						<div class="modal__overlay" tabindex="-1" data-micromodal-close>-->
<!--							<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="publish-home-title">-->
<!--								<header class="modal__header">-->
<!--									<div class="flex flex--vertical">-->
<!--										<h2 class="modal__title h2" id="publish-home-title">--><?php //echo $connection_user_s_title ?><!--</h2>-->
<!--									</div>-->
<!--									--><?php //get_template_part("components/btn", null,
//										array(
//											'label' => 'Close this modal window',
//											'href' => "",
//											'target' => "_self",
//											'skin'  => 'secondary',
//											'icon-only'  => true,
//											'disabled'  => false,
//											'icon-position' => 'right', // left or right
//											'icon' => 'close',
//											'additional-classes' => '',
//											'data-attribute' => 'data-close-modal',
//											'theme' => "",
//										)
//									); ?>
<!--								</header>-->
<!--								<main class="modal__content contact__form contact__form--light">-->
<!--									<div class="avatar-list">-->
<!--										--><?php //foreach ($him_accept_contactlist_users_relationships as $user_connection_id): ?>
<!--											--><?php
//												$user_connected = get_user_by('id', $user_connection_id);
//												$user_id = $user_connected->data->ID;
//												$user_first_name = get_field("user_first_name", "user_" . $user_id);
//												$user_last_name = get_field("user_last_name", "user_" . $user_id);
//												$user_permalink = get_permalink("602")."?user_id=". $user_id;
//												$user_avatar = get_field("user_profile_picture", "user_" . $user_id);
//
//												?>
<!---->
<!--											--><?php //get_template_part("components/user-avatar-list", null,
//												array(
//													'user_first_name' => $user_first_name,
//													'user_last_name' => $user_last_name,
//													'user_avatar' => $user_avatar,
//													'user_id' => $user_connected->ID
//												)
//											); ?>
<!--										--><?php //endforeach; ?>
<!--									</div>-->
<!--								</main>-->
<!--							</div>-->
<!--						</div>-->
<!--					</div>-->
<!--				--><?php //endif; ?>
				<?php
//				if(!empty($him_recommend_users_relationships)): ?>
<!--					<div class="modal micromodal-slide" id="list-recommendations" aria-hidden="true">-->
<!--							<div class="modal__overlay" tabindex="-1" data-micromodal-close>-->
<!--								<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="publish-home-title">-->
<!--									<header class="modal__header">-->
<!--										<div class="flex flex--vertical">-->
<!--											<h2 class="modal__title h2" id="publish-home-title">--><?php //echo $recommend_user_s_title; ?><!--</h2>-->
<!--										</div>-->
<!--										--><?php //get_template_part("components/btn", null,
//											array(
//												'label' => 'Close this modal window',
//												'href' => "",
//												'target' => "_self",
//												'skin'  => 'secondary',
//												'icon-only'  => true,
//												'disabled'  => false,
//												'icon-position' => 'right', // left or right
//												'icon' => 'close',
//												'additional-classes' => '',
//												'data-attribute' => 'data-close-modal',
//												'theme' => "",
//											)
//										); ?>
<!--									</header>-->
<!--									<main class="modal__content contact__form contact__form--light">-->
<!--										<div class="avatar-list">-->
<!--											--><?php //foreach ($him_recommend_users_relationships as $user_recommended_id): ?>
<!--												--><?php
//													$user_recommended = get_user_by('id', $user_recommended_id);
//													$user_id = $user_recommended->data->ID;
//													$user_first_name = get_field("user_first_name", "user_" . $user_id);
//													$user_last_name = get_field("user_last_name", "user_" . $user_id);
//													$user_permalink = get_permalink("602")."?user_id=". $user_id;
//													$user_avatar = get_field("user_profile_picture", "user_" . $user_id);
//												?>
<!--												--><?php //get_template_part("components/user-avatar-list", null,
//													array(
//														'user_first_name' => $user_first_name,
//														'user_last_name' => $user_last_name,
//														'user_avatar' => $user_avatar,
//														'user_id' => $user_recommended->ID
//													)
//												); ?>
<!--											--><?php //endforeach; ?>
<!--										</div>-->
<!--									</main>-->
<!--								</div>-->
<!--							</div>-->
<!--						</div>-->
<!--				--><?php //endif; ?>
			</div>

			<?php $user_init_terms = get_the_terms($user_id, 'usertags'); ?>
			<?php
//			 if($user_init_terms): ?>
<!--				<div class="profile-content--sct bt-2">-->
<!--					<h3 class="h4 mb-sm">Tags</h3>-->
<!--					<div class="tag-list">-->
<!--						--><?php //foreach ($user_init_terms as $tags): ?>
<!--							<a href="--><?php //echo get_permalink("604"); ?><!--?tag=--><?php //echo $tags->slug ?><!--" class="tag">#--><?php //echo $tags->name ; ?><!--</a>-->
<!--						--><?php //endforeach; ?>
<!--					</div>-->
<!--				</div>-->
<!--			--><?php //endif; ?>

			<!-- <?php if($services_products_provided): ?>
				<div class="profile-content--sct bt-2">
					<p><?php echo $services_products_provided; ?></p>
				</div>
			<?php endif; ?> -->

			<?php if($email_address || $phone_number || $website_link): ?>
				<div class="profile-content--sct bt-2">
					<h3 class="h4 mb-sm">Contact</h3>
					<ul class="contact__list">
						<?php if($email_address): ?>
							<li class="contact__list__item"><a href="<?php echo "mailto:" . $email_address ?>" target="_blank">Send an email</a></li>
						<?php endif; ?>
						<?php if($phone_number): ?>
							<li class="contact__list__item"><a href="<?php echo "tel:" . $phone_number ?>" target="_blank">Call</a></li>
						<?php endif; ?>
						<?php if($website_link): ?>
							<li class="contact__list__item"><a href="<?php echo $website_link ?>" target="_blank">Website</a></li>
						<?php endif; ?>
					</ul>
				</div>
			<?php endif; ?>
			<div class="profile-content--sct bt-2">
<!--				<h3 class="h4 mb-sm">Linked account</h3>-->
<!--				<ul class="contact__list">-->
<!--					<li class="contact__list__item"><a href="">Todo: linked account</a></li>-->
<!--					<li class="contact__list__item"><a href="">Todo: linked account</a></li>-->
<!--				</ul>-->
			</div>

			<?php if($sector_of_activity || $work_position || $services_products_provided || $work_and_skills || $interests): ?>
				<div class="profile-content--sct bt-2">
					<h3 class="h4 mb-sm">Professionals informations</h3>
					<?php if($sector_of_activity): ?>
						<dl><dt class="-light">Sector:</dt><dd><?php echo $sector_of_activity; ?></dd></dl>
					<?php endif; ?>
					<?php if($work_position): ?>
						<dl><dt class="-light">Current work position:</dt><dd><?php echo $work_position; ?></dd></dl>
					<?php endif; ?>
					<?php if($services_products_provided): ?>
						<dl><dt class="-light">Services or Product provided:</dt><dd><?php echo $services_products_provided; ?></dd></dl>
					<?php endif; ?>
					<?php if($work_and_skills): ?>
						<dl><dt class="-light">Work & Skills:</dt><dd><?php echo $work_and_skills; ?></dd></dl>
					<?php endif; ?>
					<?php if($interests): ?>
						<dl><dt class="-light">Interests:</dt><dd><?php echo $interests; ?></dd></dl>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="profile-content--sct bt-2">
				<h3 class="h4 mb-sm">Currently looking for</h3>
				<?php get_template_part( 'components/btn', null,
					array(
						'label' => '3 searching posts',
						'href' => "/",
						'target' => "_self",
						'skin'  => 'ghost',
						'icon-only'  => false,
						'disabled'  => false,
						'icon-position' => '', // left or right
						'icon' => 'real-estate-search-house',
						'additional-classes' => 'square',
						'data-attribute' => null,
						'theme' => "",
					)
				); ?>
			</div>
		</div>
		<div class="tab-content default-bckg profile-content__map hide" id="tabs-map">
			<div id="map-data" data-fit-bounds="true" data-page="single-user" data-buildings="<?php echo htmlspecialchars(json_encode($users_post_content_for_map), ENT_QUOTES, 'UTF-8'); ?>"></div>
			<div class="map map--single anim_els">
				<div id="map"></div>
			</div>
			<?php get_template_part( 'components/map-popup', null ); ?>
		</div>
		<div class="tab-content default-bckg profile-content__grid hide" id="tabs-grid">
			<div class="grid-slate__list">
				<?php foreach($users_post_content as $content):
					get_template_part("components/grid-slate", null, array(
						"id" => $content["id"],
						"post_link" => get_the_permalink( $content["id"]),
						"image" => $content["card_gallery"][0]["post_gallery_image"]
					));
				endforeach; ?>
			</div>
		</div>
		<div class="tab-content profile-content__list hide" id="tabs-list">
			<?php foreach($users_post_content as $content):
				get_template_part("components/card-homazed-homes", null, array(
					"id" => $content["id"],
					"title" => $content["title"],
					"user_id" => $content["user_id"],
					'type' => null, // null or compact
					'post_creator_link' => get_permalink("602")."?user_id=".$content["id"],
					'post_creator_name' => $content["first_name"]." ".$content["last_name"],
					'first_name' => $content["first_name"],
					'last_name' => $content["last_name"],
					'avatar' => $content["profile_picture"],
					'work_position' => $content["work_position"],
					'img' => $content["card_gallery"],
					'img_display' => $content["card_gallery_display"],
					'img_size' => 'thumbnail-m',
					'post_type' => $content["post_type"],
					'post_type_slug' => $content["post_type_slug"],
					'address_name' => $content["location"],
					'address_link' => null,
					'price' => $content["price"],
					'content' => null,
					'bedrooms' => $content["bedrooms"],
					'bathrooms' => $content["bathrooms"],
					'house' => $content["home_size"],
					'land' => $content["outdoor_size"],
					'tags' => $content["tags"],
					'publish_date' => get_time_ago($content["publish_date"])
				));
			endforeach; ?>
		</div>
	</div>

	<div class="modal micromodal-slide" id="share-profile" aria-hidden="true">
		<div class="modal__overlay" tabindex="-1" data-micromodal-close>
			<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="publish-home-title">
				<header class="modal__header">
					<div class="flex flex--vertical">
						<h2 class="h1">Share <?php echo $first_name . " " .$last_name; ?> profile</h2>
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
					<?php get_template_part( 'components/copy-paste', null,
						array(
							'label' => 'Copy user link',
							'copyValue' =>  get_field("user_profile_url", "user_".$user_id),
							"iteration" => $user_id
						)
					); ?>
				</main>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
