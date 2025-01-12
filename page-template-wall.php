<?php
/**
* Template Name: Wall
*
* by hellomarcel.be
* -> hello@marcel-pirnay.be
*/
?>

<?php get_header(); ?>
<main class="main" role="main" data-barba="container" data-barba-namespace="wall" data-theme="theme-light"  data-admin-ajax=<?php echo admin_url( 'admin-ajax.php' ); ?>>
	<span class="hide current_user_id" data-u-id="<?php echo wp_get_current_user()->ID; ?>"></span>
	<div class="container container--default">
		<div data-barba-prevent="all" class="flex flex--vertical flex--wrap flex--vertical-center wall">
			<?php

			// $user_args = array(
			// 	'role' => 'Subscriber',
			// 	'orderby' => 'display_name'
			// );
			$posts_args = array(
				"post_type" => ["homes","jobs"],
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
					// $user_args = array(
					// 	'role' => 'Subscriber',
					// 	'orderby' => 'display_name',
					// 	'include' => $users_with_tag
					// );
					$posts_args = array(
						"post_type" => ["homes","jobs"],
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
			// $users_query = new WP_User_Query($user_args);
			$posts_query = new WP_Query($posts_args);
			$wall_content = [];
			?>

			<?php if(isset($_GET['tag'])): ?>
				<div class="toolbar">
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
				</div>
			<?php endif; ?>

			<?php



			if(!empty($posts_query->have_posts())):
				$posts = [];

				while($posts_query->have_posts()):
					$posts_query->the_post();

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

						$fields = get_fields($post_id);

						$user_id = get_the_author_meta('ID');
						$first_name = get_field("user_first_name", "user_" . $user_id);
						$last_name = get_field("user_last_name", "user_" . $user_id);
						$post_id = get_the_ID();



						/**
						 * todo_augustin : trier les tags
						 */
						$post_init_terms = get_the_terms($post_id, 'posttags');
						if (!is_wp_error($post_init_terms) && !empty($post_init_terms)) {
							usort($post_init_terms, function($a, $b) {
								return $a->term_id - $b->term_id; // Tri en ordre croissant selon l'ID
							});
						}


						//$post_init_terms = get_the_terms($post_id, 'posttags');

						if(is_array(get_field("post_home_category"))){
							$post_category = get_field("post_home_category")["label"];
						}else{
							$post_category = get_field("post_home_category");
						}

						$main_picture_image_ids = get_field("post_home_main_picture_ids");
						$main_picture_image_ids_array = explode(',', $main_picture_image_ids);

						$gallery_image_ids = get_field("post_home_gallery_ids");
						$gallery_image_ids_array = explode(',', $gallery_image_ids);

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
							case "student": $post_home_category_translate = "Student"; break;
							case "apartment": $post_home_category_translate = "Apartment"; break;
							case "new_construction": $post_home_category_translate = "New construction"; break;
							case "land_plot": $post_home_category_translate = "Land/Plot"; break;
							case "office": $post_home_category_translate = "Office"; break;
							case "commercial_industry": $post_home_category_translate = "Commercial/Industry"; break;
							case "garage_parking": $post_home_category_translate = "Garage/Parking"; break;
							case "other": $post_home_category_translate = "Other"; break;
						}
						// todo_augustin :  post_title, affichage home post, id_entry,video
//						$id_entry = get_field("_gravityformsadvancedpostcreation_entry_id", $post_id);
//						$video_ =  do_shortcode( '[gf_entry_meta entry_id='.$id_entry.' meta_key="139"]');
						 $video_ =  get_field("post_home_video", $post_id);
						$post = [
							"id" => $post_id,
							"title" => get_the_title(),
							"content" => get_the_excerpt(),
							"post_type" => get_post_type($post_id),
							"post_status" => $post_status,
							"post_type_slug" => "real-estate",
							"main_picture" => $main_picture_image_ids_array,
							"card_gallery" => $gallery_image_ids_array,
							"video_" => $video_,
							"card_gallery_display" => get_field("post_home_pictures_display"),
														
							"first_name" => ucfirst($first_name),
							"last_name" => ucfirst($last_name),
							"user_id" => get_the_author_meta('ID'),
							"work_position" => get_field("user_current_work_position", "user_".get_the_author_meta('ID')),
							"title_post" => get_field("post_home_title"),
							
							// homes post
							"home_type" => $post_home_action_translate,
							"price" => get_field("post_home_price"),
							"home_category" => $post_home_category_translate,
							"bedrooms" => get_field("post_home_number_of_bedrooms"),
							"bathrooms" => get_field("post_home_number_of_bathrooms"),
							"home_size" => get_field("post_home_size"),
							"outdoor_size" => get_field("post_home_outdoor_size"),
							//------

							// jobs post
							"post_home_sector_activity" => get_field("post_home_sector_activity",$post_id),
							"post_home_Jobs_title" => get_field("post_home_Jobs_title",$post_id),
							//------

							"tags" => $post_init_terms,
							"events_type" => get_field("post_home_event_type"),
							"events_text_1" => get_field("post_home_event_text_1"),
							"events_text_2" => get_field("post_home_event_text_2"),
							"events_privacy" => get_field("post_home_event_privacy"),
							"location" => get_field("post_location_address") ? get_field("post_location_address") . ", " . get_field("post_location_zip") . " " . get_field("post_location_city") : get_field("post_address"),
							"publish_date" => get_post_timestamp()
						];

					 //todo_augustin_var
						array_push($wall_content, $post);
					}

				endwhile;
			endif;


			// shuffle($wall_content);
		//var_dump($wall_content);
		//todo_augustin accueil home
			foreach($wall_content as $content):
				if($content["post_type_slug"] === "real-estate"):
					get_template_part("components/card-homazed-".$content['post_type'], null, array(
						"id" => $content["id"],
						"title" => $content["title"],
						"video_" => $content["video_"],
						"post_status" => $content["post_status"],
						"title_post" => $content["title_post"],
						"user_id" => $content["user_id"],
						'type' => null, // null or compact
						'content' => $content["content"],

						//homes post						
						'home_type' => $content["home_type"],
						'home_category' => $content["home_category"],						
						'price' => $content["price"],
						'bedrooms' => $content["bedrooms"],
						'bathrooms' => $content["bathrooms"],
						'house' => $content["home_size"],
						'land' => $content["outdoor_size"],
						//-----

						//jobs post
						"post_home_sector_activity" =>  $content["post_home_sector_activity"],
						"post_home_Jobs_title" =>  $content["post_home_Jobs_title"],


						'post_creator_link' => get_permalink("602")."?user_id=".$content["user_id"],
						'post_creator_name' => $content["first_name"]."&nbsp;".$content["last_name"],
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
						'tags' => $content["tags"],
						"events_type" => $content["events_type"],
						"events_text_1" => $content["events_text_1"],
						"events_text_2" => $content["events_text_2"],
						"events_privacy" => $content["events_privacy"],
						"location" => $content["location"],
						'publish_date' => get_time_ago($content["publish_date"])
					));

					
				endif;
			endforeach;
			?>

			<?php wp_reset_postdata(); ?>
		</div>
	</div>
</main>

<?php get_footer(); ?>
