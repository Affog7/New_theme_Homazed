<?php
/**
* Template Name: Edit post
*
* by hellomarcel.be
* -> hello@marcel-pirnay.be
*/

get_header(); ?>

<?php
$current_user_id = get_current_user_id();
global $post;
echo 'Hello ' . htmlspecialchars($_GET["post_id"]) . '!';
echo 'Hello ' . htmlspecialchars($_GET["user_id"]) . '!';

$post_id = htmlspecialchars($_GET["post_id"]);
$user_id = htmlspecialchars($_GET["user_id"]);
$post = get_post($post_id);

if($user_id != $current_user_id){
	die("not allowed");
}

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
			$author_email_address = $author_data->user_email;
			$author_website_link = get_field("user_website_link", "user_".$author_id);

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
			//$title_post = get_field("post_home_title");

			$post_link = get_the_permalink($post_id);;
			$post_imgs = get_field("post_home_gallery", $post_id);
			$post_gallery_image_ids = get_field("post_home_gallery_ids", $post_id);
			$post_gallery_image_ids_array = explode(',', $post_gallery_image_ids);
			$post_main_content = get_the_content();
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

			$post_energy_consumption = get_field("post_home_estimated_energy_consumption", $post_id);
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

					<p><?php echo $post_home_category_translate; ?> <?php echo $post_home_action_translate; ?></p>

					<ul class="resume__account-creation">
						<?php if(!empty($post_address)): ?>
							<li><?php echo $post_address; ?></li>
						<?php else: ?>
							<li>No Localization found</li>
						<?php endif; ?>
					</ul>


					<a class="resume__owner" href="<?php echo $author_permalink; ?>"><?php echo $author_first_name . " " . $author_last_name;  ?></a>
				</div>
			</div>
		</div>

		<div class="profile-actions" data-barba-prevent="all">
			<!-- Profile display -->
			<div class="left">
				<div class="btn-group btn-group--related">
					<?php get_template_part( 'components/btn', null,
						array(
							'label' => 'News',
							'href' => "",
							'target' => "_self",
							'skin'  => 'ghost',
							'icon-only'  => false,
							'disabled'  => false,
							'icon-position' => '', // left or right
							'icon' => '',
							'additional-classes' => 'tab-button',
							'data-attribute' => 'data-tabs-id=\'tabs-news\'',
							'theme' => "",
						)
					); ?>
				</div>
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


		<div class="tab-content default-bckg post-page <?php if(isset($post_gallery_image_ids_array) && count($post_gallery_image_ids_array) > 1 ){  echo "carrousel glide"; } ?>" data-barba-prevent="all" id="tabs-home">
			<div class="post-page__section">
				<?php if($post_price || $post_bedrooms || $post_bathrooms || $post_home_size || $post_outdoor_size): ?>
					<div class="flex flex--justify-between">
						<?php if($post_price): ?>
							<?php if($current_user_id == $author_id): ?>
								<div class="flex">
									<?php get_template_part( 'components/btn', null,
										array(
											'label' => 'Edit price',
											'href' => "/",
											'target' => "_self",
											'skin'  => 'highlight',
											'icon-only'  => true,
											'disabled'  => false,
											'icon-position' => '',
											'icon' => 'pencil-write',
											'additional-classes' => 'btn--xsmall btn--inline edit_post_btn mg-r-1',
											'data-attribute' => 'data-open-modal=\'edit-post--price\'',
											'theme' => "",
										)
									); ?>
							<?php endif; ?>
							<?php get_template_part( 'components/price', null, array(
								'price' => $post_price, )
							); ?>
							<?php if($current_user_id == $author_id): ?></div><?php endif; ?>
						<?php endif; ?>
						<?php if($post_bedrooms || $post_bathrooms || $post_home_size || $post_outdoor_size): ?>
							<ul class="post-details__caracteristics flex flex--vertical-center">
								<?php if($current_user_id == $author_id): ?>
									<li>
										<?php get_template_part( 'components/btn', null,
											array(
												'label' => 'Edit price',
												'href' => "/",
												'target' => "_self",
												'skin'  => 'highlight',
												'icon-only'  => true,
												'disabled'  => false,
												'icon-position' => '',
												'icon' => 'pencil-write',
												'additional-classes' => 'btn--xsmall btn--inline edit_post_btn mg-r-1',
												'data-attribute' => 'data-open-modal=\'edit-post--details-sizes\'',
												'theme' => "",
											)
										); ?>
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
						<div class="post-page__section floating-bar">
							<div class="flex">
								<?php if($current_user_id == $author_id): ?>
									<?php get_template_part( 'components/btn', null,
										array(
											'label' => 'Edit file',
											'href' => "/",
											'target' => "_self",
											'skin'  => 'highlight',
											'icon-only'  => true,
											'disabled'  => false,
											'icon-position' => '',
											'icon' => 'pencil-write',
											'additional-classes' => 'btn--xsmall btn--inline edit_post_btn mg-r-1',
											'data-attribute' => 'data-open-modal=\'edit-post--files\'',
											'theme' => "",
										)
									); ?>
								<?php endif; ?>
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
							</div>
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
						<?php get_template_part( 'components/btn', null,
								array(
									'label' => 'Edit images',
									'href' => "/",
									'target' => "_self",
									'skin'  => 'highlight',
									'icon-only'  => false,
									'disabled'  => false,
									'icon-position' => 'left',
									'icon' => 'pencil-write',
									'additional-classes' => 'btn--small edit_post_btn btn--inline',
									'data-attribute' => 'data-open-modal=\'edit-post--images\'',
									'theme' => "",
								)
							); ?>
					<?php endif; ?>
				<?php endif; ?>
			</div>

			<div class="post-page__section bt-2">
				<?php if($current_user_id == $author_id): ?>
					<div class="flex">
					<?php get_template_part( 'components/btn', null,
							array(
								'label' => 'Edit events',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'highlight',
								'icon-only'  => false,
								'disabled'  => false,
								'icon-position' => 'left',
								'icon' => 'pencil-write',
								'additional-classes' => 'btn--small edit_post_btn btn--inline',
								'data-attribute' => 'data-open-modal=\'edit-post--events\'',
								'theme' => "",
							)
						); ?>
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
					<div class="flex">
					<?php get_template_part( 'components/btn', null,
						array(
							'label' => 'Edit tags',
							'href' => "/",
							'target' => "_self",
							'skin'  => 'highlight',
							'icon-only'  => false,
							'disabled'  => false,
							'icon-position' => 'left',
							'icon' => 'pencil-write',
							'additional-classes' => 'btn--small edit_post_btn btn--inline',
							'data-attribute' => 'data-open-modal=\'edit-post--tags\'',
							'theme' => "",
						)
					); ?>
				<?php endif; ?>
				<?php if($current_user_id == $author_id): ?></div><?php endif; ?>

				<?php if($post_post_tags): ?>
					<div class="tag-list">
						<p>
							<?php foreach ($post_post_tags as $tag): ?>
								<a href="<?php echo get_permalink("604"); ?>?tag=<?php echo $tag->slug ?>" class="tag">#<?php echo $tag->name ; ?></a>
							<?php endforeach; ?>
						</p>
					</div>
				<?php endif; ?>
			</div>

			<div class="post-page__section bt-2">
				<?php if($current_user_id == $author_id): ?>
					<div class="flex">
					<?php get_template_part( 'components/btn', null,
							array(
								'label' => 'Edit description',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'highlight',
								'icon-only'  => false,
								'disabled'  => false,
								'icon-position' => 'left',
								'icon' => 'pencil-write',
								'additional-classes' => 'btn--small edit_post_btn btn--inline',
								'data-attribute' => 'data-open-modal=\'edit-post--description\'',
								'theme' => "",
							)
						); ?>
				<?php endif; ?>
				<?php if($current_user_id == $author_id): ?></div>
				<?php endif; ?>
				<?php echo $post_main_content; ?>
			</div>
			<?php if ($author_data): ?>
				<div class="post-page__section bt-2">
					<?php get_template_part("components/user-resume-profile", null, array(
							"user" => $author_data,
							'additional-classes' => '',
						)); ?>
				</div>
			<?php endif; ?>

			<?php if($author_email_address || $author_phone_number || $author_website_link): ?>
				<div class="post-page__section bt-2 content">
					<ul class="contact__list">
						<?php if($author_email_address): ?>
							<li class="contact__list__item"><a href="<?php echo "mailto:" . $author_email_address ?>" target="_blank">Send an email</a></li>
						<?php endif; ?>
						<?php if($author_phone_number): ?>
							<li class="contact__list__item"><a href="<?php echo "tel:" . $author_phone_number ?>" target="_blank">Call</a></li>
						<?php endif; ?>
						<?php if($author_website_link): ?>
							<li class="contact__list__item"><a href="<?php echo $author_website_link ?>" target="_blank">Website</a></li>
						<?php endif; ?>
					</ul>
				</div>
			<?php endif; ?>

			<div class="post-page__section bt-2 content">
				<?php if($current_user_id == $author_id): ?>
					<div class="flex">
					<?php get_template_part( 'components/btn', null,
							array(
								'label' => 'Edit home features',
								'href' => "/",
								'target' => "_self",
								'skin'  => 'highlight',
								'icon-only'  => false,
								'disabled'  => false,
								'icon-position' => 'left',
								'icon' => 'pencil-write',
								'additional-classes' => 'btn--small edit_post_btn btn--inline',
								'data-attribute' => 'data-open-modal=\'edit-post--features\'',
								'theme' => "",
							)
						); ?>
				<?php endif; ?>
				<?php if($current_user_id == $author_id): ?></div><?php endif; ?>
				<?php if($post_home_year_built): ?>
					<dl><dt class="-light">Year built:</dt><dd><?php echo $post_home_year_built; ?></dd></dl>
				<?php endif; ?>
				<?php if($post_home_amenities): ?>
					<dl><dt class="-light">Home amenities:</dt><dd><?php echo $post_home_amenities; ?></dd></dl>
				<?php endif; ?>
				<?php if($post_neighborhood_amenities): ?>
					<dl><dt class="-light">Neighborhood amenities:</dt><dd><?php echo $post_neighborhood_amenities; ?></dd></dl>
				<?php endif; ?>
				<?php if($post_transportation): ?>
					<dl><dt class="-light">Transportation:</dt><dd><?php echo $post_transportation; ?></dd></dl>
				<?php endif; ?>
				<?php if($post_garages_parking): ?>
					<dl><dt class="-light">Garages parking:</dt><dd><?php echo $post_garages_parking; ?></dd></dl>
				<?php endif; ?>
				<?php if($post_schools): ?>
					<dl><dt class="-light">Schools:</dt><dd><?php echo $post_schools; ?></dd></dl>
				<?php endif; ?>
				<?php if($post_home_style_architecture): ?>
					<dl><dt class="-light">Architecture style:</dt><dd><?php echo $post_home_style_architecture; ?></dd></dl>
				<?php endif; ?>
				<?php if($post_additional_features): ?>
					<dl><dt class="-light">Additionnal features:</dt><dd><?php echo $post_additional_features; ?></dd></dl>
				<?php endif; ?>
				<?php if($post_taxes): ?>
					<dl><dt class="-light">Taxes:</dt><dd><?php echo $post_taxes; ?></dd></dl>
				<?php endif; ?>
				<?php if($post_fees): ?>
					<dl><dt class="-light">Fees:</dt><dd><?php echo $post_fees; ?></dd></dl>
				<?php endif; ?>
				<?php if($post_systems): ?>
					<dl><dt class="-light">Systems:</dt><dd><?php echo $post_systems; ?></dd></dl>
				<?php endif; ?>
				<?php if($post_energy_rating): ?>
					<dl><dt class="-light">Energy rating:</dt><dd><?php echo $post_energy_rating; ?></dd></dl>
				<?php endif; ?>
				<?php if($post_energy_consumption): ?>
					<dl><dt class="-light">Energy consumption:</dt><dd><?php echo $post_energy_consumption; ?></dd></dl>
				<?php endif; ?>
			</div>
			<div class="post-page__section bt-2">
				<!-- <?php if($current_user_id == $author_id): ?>
					<div class="flex">
					<?php
					// get_template_part( 'components/btn', null,
					// 		array(
					// 			'label' => 'Edit location',
					// 			'href' => "/",
					// 			'target' => "_self",
					// 			'skin'  => 'highlight',
					// 			'icon-only'  => false,
					// 			'disabled'  => false,
					// 			'icon-position' => 'left',
					// 			'icon' => 'pencil-write',
					// 			'additional-classes' => 'btn--small edit_post_btn btn--inline',
					// 			'data-attribute' => 'data-open-modal=\'edit-post--location\'',
					// 			'theme' => "",
					// 		)
					//	); ?>
				<?php endif; ?>
				<?php if($current_user_id == $author_id): ?></div><?php endif; ?> -->
				<?php
				$post_content_for_map = [];
				$post_for_map = [
						"id" => $post_id,
						"title" => $post_home_type, // house type
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

				<div id="map-data" data-fit-bounds="true" data-page="single-post" data-buildings="<?php echo htmlspecialchars(json_encode($post_content_for_map), ENT_QUOTES, 'UTF-8'); ?>"></div>
				<div class="map map--single anim_els">
					<div id="map"></div>
				</div>
				<div class="post-page__section post-page__section--footer mt-2 bt-2">
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
		<div class="tab-content post-page hide" data-barba-prevent="all" id="tabs-news">
			<?php
				// wp_reset_postdata();
				// $news_args = array(
				// 	"post_type" => "news",
				// 	"post_status" => "publish",
				// 	"posts_per_page" => -1,
				// 	'author' => $author_id,
				// );
				// $news_query = new WP_Query($news_args);

				// if(!empty($news_query->have_posts())):
				// 	while($news_query->have_posts()):
				// 		$news_query->the_post();
				// 		$news_id = get_the_ID();

				// 		get_template_part("components/card-homazed-news", null, array(
				// 			"id" => $news_id,
				// 			'type' => null, // null or compact
				// 			'title' => get_field("news_title", $news_id),
				// 			'post_creator_link' => get_permalink("602")."?user_id=".$author_id,
				// 			'post_creator_name' =>  get_field("user_first_name", "user_".$author_id)." ".get_field("user_last_name", "user_".$author_id),
				// 			'first_name' => get_field("user_first_name", "user_".$author_id),
				// 			'last_name' => get_field("user_last_name", "user_".$author_id),
				// 			'avatar' => get_field("user_profile_picture", "user_".$author_id),
				// 			'img' => get_field("news_gallery", $news_id),
				// 			'img_display' => get_field("post_home_pictures_display", $news_id),
				// 			'img_size' => 'thumbnail-m',
				// 			// 'post_type' => get_field("post_type", $news_id),
				// 			// 'post_type_slug' => get_field("post_type_slug", $news_id),
				// 			'content' => get_field("news_content", $news_id),
				// 			'publish_date' => get_time_ago(get_post_timestamp())
				// 		));

				// 	endwhile;
				// else:
				// 	echo "No news linked to this home";
				// endif;

				echo "news todo";


			?>
		</div>

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

	<div class="modal micromodal-slide" id="share-post" aria-hidden="true">
		<div class="modal__overlay" tabindex="-1" data-micromodal-close>
			<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="publish-home-title">
				<header class="modal__header">
					<div class="flex flex--vertical">
						<div class="flex flex--vertical-center">
							<h2 class="resume__name card-form__title"><?php echo $post_title ?></h2>
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
