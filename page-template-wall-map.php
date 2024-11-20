<?php
/**
* Template Name: Wall map
*
* by hellomarcel.be
* -> hello@marcel-pirnay.be
*/
?>

<?php get_header(); ?>
<main class="main wall--map" role="main" data-barba="container" data-barba-namespace="wall--map" data-theme="theme-light"  data-admin-ajax=<?php echo admin_url( 'admin-ajax.php' ); ?>>
	<span class="hide current_user_id" data-u-id="<?php echo wp_get_current_user()->ID; ?>"></span>
	<div class="container--xlarge">
		<div data-barba-prevent="all" class="flex flex--vertical flex--wrap flex--vertical-center wall">
			<?php

			$user_args = array(
				'role' => 'Subscriber',
				'orderby' => 'display_name'
			);
			$posts_args = array(
				"post_type" => "homes",
				//"post_status" => "publish",
				"posts_per_page" => -1,
				"orderby" => "date",
				"order" => "DESC"
			);

			if(isset($_GET['tag'])) {
				$tag = $_GET['tag'];
				$user_tag_object = get_term_by('slug', $tag, 'usertags');
				$post_tag_object = get_term_by('slug', $tag, 'posttags');
				$users_with_tag = get_objects_in_term( $user_tag_object->term_id, 'usertags' );
				$user_args = array(
					'role' => 'Subscriber',
					'orderby' => 'display_name',
					'include' => $users_with_tag
				);
				$posts_args = array(
					"post_type" => "homes",
					//"post_status" => "publish",
					"posts_per_page" => -1,
					"orderby" => "date",
					"order" => "DESC",
					'tax_query' => array(
						array (
							'taxonomy' => 'posttags',
							'field' => 'slug',
							'terms' => $_GET['tag'],
						)
					)
				);

			}
			$users_query = new WP_User_Query($user_args);
			$posts_query = new WP_Query($posts_args);
			?>

			<div class="toolbar">
				<?php if(isset($_GET['tag'])): ?>
					<div class="filters">
						<a href="<?php echo get_permalink("604"); ?>" class="c-status-pill c-status-pill--default">
							<span class="c-status-pill__icon">
								<?php
									echo "<div class='o-svg-icon o-svg-icon-close'>";
										include get_stylesheet_directory() . '/src/images/icons/close.svg';
									echo "</div>";
								?>
							</span>
							<span class="c-status-pill__label">#<?php echo $tag ?></span>
						</a>
					</div>
				<?php endif; ?>
			</div>

			<?php
			$map_content = [];
			$wall_content = [];
			$wall_content_for_map = [];



			wp_reset_postdata();

			if(!empty($posts_query->have_posts())):
				$posts = [];

				while($posts_query->have_posts()):
					$posts_query->the_post();

					$user_id = get_the_author_meta('ID');
					$first_name = get_field("user_first_name", "user_" . $user_id);
					$last_name = get_field("user_last_name", "user_" . $user_id);
					$post_id = get_the_ID();



					// todo_augustin verifier si le post est dans la liste cachées de l'utilisateur avec le meta hidden_posts
					    $hidden_posts = get_user_meta(get_current_user_id(), 'hidden_posts', true) ?: array();
						$post_status = get_post_status($post_id);
					    $user_id = get_the_author_meta('ID');
						$show = false;

						if($user_id == get_current_user_id() && $post_status == 'private' ) {
							$show = true;
						}elseif ($user_id != get_current_user_id() && $post_status == 'private' ){
							$show = false;
						} elseif ($post_status == 'publish' ) {
							$show = true;
						}

					// todo_augustin affichage selon le status
   					 if (!in_array($post_id, $hidden_posts) && $show) {

						 $post_init_terms = get_the_terms($post_id, 'posttags');
						 $post_address = get_field("post_location_address") . ", " . get_field("post_location_zip") . " " . get_field("post_location_city");
						 $post_location_latitude = get_field("post_location_latitude");
						 $post_location_longitude = get_field("post_location_longitude");
						 $post_gallery_image_ids = get_field("post_home_gallery_ids", $post_id);
						 $post_gallery_image_ids_array = explode(',', $post_gallery_image_ids);
						 $main_picture_image_ids = get_field("post_home_main_picture_ids", $post_id);
						 $main_picture_image_ids_array = explode(',', $main_picture_image_ids);
						 $post_avatar_picture_id = ($main_picture_image_ids_array[0]) ? $main_picture_image_ids_array[0] : $post_gallery_image_ids_array[0];
						 $post_avatar_picture = wp_get_attachment_url($post_avatar_picture_id, 'thumbnail');

						 if(is_array(get_field("post_home_category"))){
							 $post_category = get_field("post_home_category")["label"];
						 }else{
							 $post_category = get_field("post_home_category");
						 }

						 $main_picture_image_ids = get_field("post_home_main_picture_ids");
						 $main_picture_image_ids_array = explode(',', $main_picture_image_ids);
						 $post_price = get_field("post_home_price");
						 $post_bedrooms = get_field("post_home_number_of_bedrooms");
						 $post_bathrooms = get_field("post_home_number_of_bathrooms");
						 $post_home_size = get_field("post_home_size");
						 $post_outdoor_size = get_field("post_home_outdoor_size");
						 $gallery_image_ids = get_field("post_home_gallery_ids");
						 $gallery_image_ids_array = explode(',', $gallery_image_ids);

						 $fmt = new NumberFormatter( 'fr_FR', NumberFormatter::CURRENCY );
						 $fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);

//todo_augustin map images slide
						 $image_urls = [];

						 // Parcourir chaque ID dans $id_array
						 foreach ($post_gallery_image_ids_array as $id) {
							 // Récupérer l'URL de l'image de taille 'large-img-medium'
							 $image_src = wp_get_attachment_image_src($id, 'thumbnail');

							 // Vérifier si une URL a été trouvée
							 if ($image_src) {
								 // Ajouter l'URL de l'image au tableau $image_urls
								 $image_urls[] = $image_src[0];
							 }
						 }
// ends
						 //todo_augustin ajout_champs mapping necessaires
						 $post_for_map = [
							 "id" => $post_id,
							 "post_type_slug" => "real-estate",
							 "lat" => $post_location_latitude,
							 "lng" => $post_location_longitude,
						 ];


						 $post_home_action_value = get_field("post_home_action");
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
							 case "student": $post_home_category_translate = "Student"; break;

							 case "new_construction": $post_home_category_translate = "New construction"; break;
							 case "land_plot": $post_home_category_translate = "Land/Plot"; break;
							 case "office": $post_home_category_translate = "Office"; break;
							 case "commercial_industry": $post_home_category_translate = "Commercial/Industry"; break;
							 case "garage_parking": $post_home_category_translate = "Garage/Parking"; break;
							 case "other": $post_home_category_translate = "Other"; break;
						 }

						 $post = [
							 "id" => $post_id,
							 "title" => get_the_title(),
							 "content" => get_the_excerpt(),
							 "post_type" => "Homes",
							 "post_type_slug" => "real-estate",
							 "post_status" => $post_status,
							 "main_picture" => $main_picture_image_ids_array,
							 "card_gallery" => $gallery_image_ids_array,
							 "card_gallery_display" => get_field("post_home_pictures_display"),
							 "home_type" => $post_home_action_translate,
							 "home_category" => $post_home_category_translate,
							 "first_name" => $first_name,
							 "last_name" => $last_name,
							 "user_id" => get_the_author_meta('ID'),
							 "work_position" => get_field("user_current_work_position", "user_".get_the_author_meta('ID')),
							 "price" => $post_price,
							 "bedrooms" => $post_bedrooms,
							 "bathrooms" => $post_bathrooms,
							 "home_size" => $post_home_size,
							 "outdoor_size" => $post_outdoor_size,
							 "tags" => $post_init_terms,
							 "events_type" => get_field("post_home_event_type"),
							 "events_text_1" => get_field("post_home_event_text_1"),
							 "events_text_2" => get_field("post_home_event_text_2"),
							 "events_privacy" => get_field("post_home_event_privacy"),
							 "location" => get_field("post_location_address") . ", " . get_field("post_location_zip") . " " . get_field("post_location_city"),
							 "publish_date" => get_post_timestamp()
						 ];

						 array_push($wall_content_for_map, $post_for_map);
						 array_push($wall_content, $post);

					 }


				endwhile;
			endif;

			// shuffle($wall_content)	;

			?>
			<div class="split-view grid">
				<div class="left-map default-bckg np grid-col-5">
					<div id="map-data" data-fit-bounds="true" data-page="wall--map" data-buildings="<?php echo htmlspecialchars(json_encode($wall_content_for_map), ENT_QUOTES, 'UTF-8'); ?>"></div>
					<div class="map map--wall anim_els">
						<div id="map"></div>
					</div>
					<?php get_template_part( 'components/map-popup', null ); ?>
				</div>
				<div class="right-slates grid-col-7 hide--mobile">
					<?php
						foreach($wall_content as $content) :
							if($content["post_type_slug"] === "real-estate") :
								get_template_part("components/card-homazed-homes", null, array(
									"id" => $content["id"],
									"title" => $content["title"],
									"user_id" => $content["user_id"],
									"post_status" => $content["post_status"],
									'type' => null, // null or compact
									'home_category' => $content["home_category"],
									'home_type' => $content["home_type"],
									'post_creator_link' => get_permalink("602")."?user_id=".$content["user_id"],
									'post_creator_name' => $content["first_name"]." ".$content["last_name"],
									'first_name' => $content["first_name"],
									'last_name' => $content["last_name"],
									'work_position' => $content["work_position"],
									'main_picture' => $content["main_picture"],
									'img' => $content["card_gallery"],
									'img_display' => $content["card_gallery_display"],
									'img_size' => 'thumbnail-m',
									'post_type' => $content["post_type"],
									'post_type_slug' => $content["post_type_slug"],
									'address_name' => $content["location"],
									'address_link' => null,
									'price' => $content["price"],
									'content' => $content["content"],
									'bedrooms' => $content["bedrooms"],
									'bathrooms' => $content["bathrooms"],
									'house' => $content["home_size"],
									'land' => $content["outdoor_size"],
									'tags' => $content["tags"],
									"events_type" => $content["events_type"],
									"events_text_1" => $content["events_text_1"],
									"events_text_2" => $content["events_text_2"],
									"events_privacy" => $content["events_privacy"],
									"location" => $content["location"],
									'publish_date' => get_time_ago($content["publish_date"])
								));
							// elseif($content["post_type_slug"] === "users"):
							// 	get_template_part("components/card-homazed-user", null, array(
							// 		"id" => $content["id"],
							// 		'type' => "compact", // null or compact
							// 		'post_creator_link' => get_permalink("602")."?user_id=".$content["id"],
							// 		'post_creator_name' => $content["first_name"]." ".$content["last_name"],
							// 		'first_name' => $content["first_name"],
							// 		'last_name' => $content["last_name"],
							// 		'avatar' => $content["profile_picture"],
							// 		'work_position' => $content["work_position"],
							// 		'sector_of_activity' => $content["sector_of_activity"],
							// 		'img' => $content["card_gallery"],
							// 		'img_display' => $content["card_gallery_display"],
							// 		'img_size' => 'thumbnail-m',
							// 		'post_type' => $content["post_type"],
							// 		'post_type_slug' => $content["post_type_slug"],
							// 		'content' => $content["card_text"],
							// 		'tags' => $content["tags"],
							// 		'publish_date' => get_time_ago($content["publish_date"])
							// 	));
							endif;
						endforeach;
					?>
				</div>
			</div>


			<?php wp_reset_postdata(); ?>
		</div>
	</div>
</main>

<?php get_footer(); ?>
