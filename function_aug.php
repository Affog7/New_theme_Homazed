<?php


//todo_augustin : read_more

// Fonction pour limiter le contenu à 12 lignes
function limiterLignes($texte, $maxLignes = 12) {
	// Divise le contenu en lignes
	$lignes = explode("\n", wordwrap($texte, 20, "\n")); // 80 caractères par ligne en moyenne
	// Vérifie si le nombre de lignes dépasse la limite
	if (count($lignes) > $maxLignes) {
		// Garde seulement les premières lignes et ajoute "Lire plus"
		$texteAffiche = implode("\n", array_slice($lignes, 0, $maxLignes));
		$texteAffiche .= '... <a   href="#.post-content_" class="read-more-btn_">Lire la suite</a>';

		// Conteneur avec attribut pour le texte complet
		echo '<div class="expandablecontent" data-full-text="' . htmlspecialchars($texte) . '">';
		echo '<div class="post-content_">' . ($texteAffiche) . '</div>';
		echo '</div>';
	} else {
		// Sinon, afficher le contenu complet
		echo '<div class="post-content_">' . ($texte) . '</div>';
	}
}

//todo_augustin
add_action( 'limiterLignes', 'limiterLignes' );


// Fonction get_first_element
function get_first_element($string) {
    $array = explode(',', $string);
    echo trim($array[0]);
}

//todo_augustin
add_action( 'get_first_element', 'get_first_element' );


// Fonction get_first_element
function print_User_Category($account_category) {
 switch ($account_category) {
		case "individual-user": echo __('Individual user', 'homazed'); break;
		case "pro-user": echo __('Pro user', 'homazed'); break;
		case "company-user": echo __('Company user', 'homazed'); break;
	}
}

//todo_augustin
add_action( 'print_User_Category', 'print_User_Category' );






//todo_augustin Création d'un shortcode simple pour afficher une carte OpenStreetMap avec des coordonnées définies
function afficher_carte_openstreetmap_statique($atts) {
	// Paramètres par défaut du shortcode
	$atts = shortcode_atts(
		array(
			'address' => '15',
			'latitude' => '48.8566', // Latitude par défaut (ici Paris)
			'longitude' => '2.3522', // Longitude par défaut (ici Paris)
			'height' => '400px',     // Hauteur de la carte
			'width' => '100%',       // Largeur de la carte
			'zoom' => '5',          // Niveau de zoom par défaut
		),
		$atts,
		'osm_map'
	);

	// Code HTML et JavaScript pour afficher la carte avec OpenStreetMap
	ob_start();
	?>
	<div id="osm-map" style="width: <?php echo esc_attr($atts['width']); ?>; height: <?php echo esc_attr($atts['height']); ?>;"></div>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Initialisation de la carte avec zoomControl désactivé
			var map = L.map('osm-map', {
				zoomControl: false // Désactiver le contrôle de zoom par défaut
			}).setView([<?php echo esc_js($atts['latitude']); ?>, <?php echo esc_js($atts['longitude']); ?>], <?php echo esc_js($atts['zoom']); ?>);

			// Ajouter les tuiles OpenStreetMap
			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				maxZoom: 19,
				attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(map);

			// Ajouter un marqueur à la position donnée
			L.marker([<?php echo esc_js($atts['latitude']); ?>, <?php echo esc_js($atts['longitude']); ?>]).addTo(map)
				.bindPopup("<?php echo esc_js($atts['address']); ?>")
				.openPopup();

			// Ajouter un contrôle de zoom en bas à droite
			L.control.zoom({
				position: 'bottomright' // Position du contrôle de zoom
			}).addTo(map);
		});
	</script>
	<?php
	return ob_get_clean();
}


// Enregistrement du shortcode
add_shortcode('osm_map', 'afficher_carte_openstreetmap_statique');

//todo_augustin
// Fonction pour mettre à jour le statut du post via AJAX
function update_post_status_via_ajax() {
	// Vérifier les autorisations (s'assurer que l'utilisateur est autorisé à effectuer cette action)
	if (!current_user_can('edit_posts')) {
		wp_send_json_error(array('message' => 'You are not allowed to update post status.'));
		return;
	}

	// Vérifier si les données nécessaires sont présentes
	if (isset($_POST['post_id']) && isset($_POST['status'])) {
		$post_id = intval($_POST['post_id']);
		$status = sanitize_text_field($_POST['status']);

		// Mettre à jour le statut du post
		$valid_statuses = array('publish', 'erase', 'private', 'inactive'); // Inclure 'inactive' comme statut personnalisé si nécessaire
		if (!in_array($status, $valid_statuses)) {
			wp_send_json_error(array('message' => 'Invalid status.'));
		}

		if($status == 'erase') {
			// Supprimer le post
			$deleted = wp_delete_post($post_id, true); // Le deuxième paramètre "true" force la suppression définitive

			// Vérifier si le post a bien été supprimé
			if ($deleted) {
				wp_send_json_success(array('message' => 'Post supprimé avec succès.'));


			} else {
				wp_send_json_error(array('message' => 'Échec de la suppression du post.'));
			}
		}
		else {
			// Mise à jour du statut du post
			$result = wp_update_post(array(
				'ID' => $post_id,
				'post_status' => ($status == 'Inactive') ? 'private' : $status // 'Inactive' sera traduit en 'private'
			));

			if ($result) {
				wp_send_json_success(array('message' => 'Post status updated successfully.'));
			} else {
				wp_send_json_error(array('message' => 'Failed to update post status.'));
			}
		}

	} else {
		wp_send_json_error(array('message' => 'Missing post_id or status.'));
	}
}

// Ajouter l'action AJAX pour la mise à jour du statut du post
add_action('wp_ajax_update_post_status', 'update_post_status_via_ajax'); // Pour les utilisateurs connectés
add_action('wp_ajax_nopriv_update_post_status', 'update_post_status_via_ajax'); // Pour les utilisateurs non connectés (si nécessaire)



// Fonction pour récupérer la valeur d'une métadonnée spécifique d'une entrée Gravity Forms
function gf_entry_meta_shortcode($atts) {
	global $wpdb;

	// Définir les attributs par défaut du shortcode
	$atts = shortcode_atts(
		array(
			'entry_id' => '',
			'meta_key' => '',
		),
		$atts,
		'gf_entry_meta'
	);

	// Vérification des paramètres requis
	if (empty($atts['entry_id']) || empty($atts['meta_key'])) {
		return 'Paramètres manquants : entry_id ou meta_key';
	}

	// Requête pour récupérer la valeur de la métadonnée
	$table_name = $wpdb->prefix . 'gf_entry_meta';
	$meta_value = $wpdb->get_var($wpdb->prepare(
		"SELECT meta_value FROM $table_name WHERE entry_id = %d AND meta_key = %s",
		$atts['entry_id'],
		$atts['meta_key']
	));
	$meta_value =$meta_value  ? json_decode($meta_value, true) : null;
	// Retourner la valeur de la métadonnée
	return $meta_value ? esc_html($meta_value[0]) :  null;
}

// Déclaration du shortcode
add_shortcode('gf_entry_meta', 'gf_entry_meta_shortcode');
// 139
// gf_entry_meta("_gravityformsadvancedpostcreation_entry_id",$post_id)

// Dans functions.php de votre thème
include get_template_directory() . '/functions_api_post_map.php';



function enqueue_custom_tag_script() {
	// Register the custom JS file
	wp_register_script(
		'custom-tags-js', // Handle name for the script
		get_template_directory_uri() . '/src/js/custom_scripts.js', // Path to your JavaScript file
		array('jquery'), // Dependencies (optional, here we’re using jQuery)
		null, // Version number (optional)
		true // Load in footer
	);

	wp_localize_script('custom-tags-js', 'ajaxurl', admin_url('admin-ajax.php'));



		wp_enqueue_script('custom-tags-js');


	// Localize script to pass nonce
	wp_localize_script('custom-tags-js', 'customApi', array(
		'nonce' => wp_create_nonce('wp_rest')
	));


}
add_action('wp_enqueue_scripts', 'enqueue_custom_tag_script');

///todo_augustin API cacher un post et signalé
// Callback for hiding a post
function custom_api_hide_post($request) {
	$post_id = $request['id'];

	if (!current_user_can('edit_post', $post_id)) {
		return new WP_Error('permission_denied', 'You do not have permission to hide this post.', array('status' => 403));
	}

	// Example of marking the post as hidden in user meta (can be customized)
	$user_id = get_current_user_id();
	$hidden_posts = get_user_meta($user_id, 'hidden_posts', true) ?: array();
	if (!in_array($post_id, $hidden_posts)) {
		$hidden_posts[] = $post_id;
		update_user_meta($user_id, 'hidden_posts', $hidden_posts);
	}

	return rest_ensure_response(array('success' => true));
}

// Callback for reporting a post
function custom_api_report_post($request) {
	$post_id = $request['id'];

	// Send an email to the site administrator (or handle this as needed)
	$admin_email = get_option('admin_email');

	$post_url = get_permalink($post_id);
	$subject = "Post Reported: ID $post_id";
	$message = "The post with ID $post_id has been reported. You can view it here: $post_url";

	wp_mail($admin_email, $subject, $message);

	return rest_ensure_response(array('success' => true));
}

function custom_api_register_routes() {
	// Hide Post Endpoint
	register_rest_route('custom-api/v1', '/hide_post/(?P<id>\d+)', array(
		'methods' => 'POST',
		'callback' => 'custom_api_hide_post',
		'permission_callback' => 'is_user_logged_in', // Only allow logged-in users
	));

	// Report Post Endpoint
	register_rest_route('custom-api/v1', '/report_post/(?P<id>\d+)', array(
		'methods' => 'POST',
		'callback' => 'custom_api_report_post',
		'permission_callback' => '__return_true', // Allow anyone to report
	));
}
add_action('rest_api_init', 'custom_api_register_routes');
// fin chaché et signalé




// funtion pour prendre les neews associés à un post

function register_get_posts_by_post_w_linked() {
	function get_posts_by_post_w_linked($linked_post_id, $post_type = 'news') {
		$args = [
			'post_type'      => $post_type,
			'posts_per_page' => -1,
			'meta_query'     => [
				[
					'key'     => 'post_w_linked',
					'value'   => $linked_post_id,
					'compare' => '='
				]
			]
		];

		$query = new WP_Query($args);
		$posts = [];

		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				$posts[] = [
					'ID'    => get_the_ID(),
					'title' => get_the_title(),
					'link'  => get_permalink()
				];
			}
			wp_reset_postdata();
		}



		if (!empty($posts)) {

			foreach ($posts as $post) {
				$author_id_ = get_post_field('post_author', $post["ID"]);
				$post_address = get_field("post_location_address", $post["ID"]) ? get_field("post_location_address", $post["ID"]) . ", " . get_field("post_location_zip", $post["ID"]) . " " . get_field("post_location_city", $post["ID"]) : get_field("post_address", $post["ID"]);

				get_template_part("components/card-homazed-news", null, array(
					"id" => $post["ID"],
					"title" => $post["title"],
					"content" => get_the_excerpt($post["ID"]),
					"post_type" => get_post_type($post["ID"]),
					"card_gallery" => get_field("post_home_gallery_ids", $post["ID"]),
					"video_" =>  get_field("post_home_video", $post["ID"]),
					"card_gallery_display" => get_field("post_home_pictures_display", $post["ID"]),
					'post_creator_name' => get_field("user_first_name", "user_".$author_id_)."&nbsp;".get_field("user_last_name", "user_".$author_id_),
					"first_name"=> get_field("user_first_name", "user_".$author_id_),
					"last_name" =>get_field("user_last_name", "user_".$author_id_),

					"user_id" => $author_id_,
					"work_position" => get_field("user_current_work_position", "user_".$author_id_),
					"title_post" => get_field("post_home_title",$post["ID"]),
					"post_type_slug" => "real-estate",
					"img" => explode(',', get_field("post_home_gallery_ids", $post["ID"])),

					'address_name' => $post_address,
					// news post
					"post_w_linked" => get_field("post_w_linked",$post["ID"]),
					//------

					"tags" => get_the_terms($post["ID"], 'posttags'),
					"events_type" => get_field("post_home_event_type",$post["ID"]),
					"events_text_1" => get_field("post_home_event_text_1",$post["ID"]),
					"events_text_2" => get_field("post_home_event_text_2",$post["ID"]),
					"events_privacy" => get_field("post_home_event_privacy",$post["ID"]),
					"location" => get_field("post_location_address",$post["ID"]) ? get_field("post_location_address",$post["ID"]) . ", " . get_field("post_location_zip",$post["ID"]) . " " . get_field("post_location_city",$post["ID"]) : get_field("post_address",$post["ID"]),
					"publish_date" => get_time_ago(get_post_timestamp($post["ID"]))
				));
			}

		}
		//return $posts;
	}
}
add_action('init', 'register_get_posts_by_post_w_linked');


function register_get_posts_by_user() {
	function get_posts_by_user($user_id, $post_type = 'post') {
		$args = [
			'post_type'      => ["homes","projects","jobs","news","profile"],
			'posts_per_page' => -1,
			'author'         => $user_id
		];

		$query = new WP_Query($args);
		$posts = [];
		$wall_content = [];
		if ($query->have_posts()) {
			while($query->have_posts()):
				$query->the_post();

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

						// news post
						"post_w_linked" => get_field("post_w_linked",$post_id),

						//------

						// projects post
						"post_projects-status" => get_field("post_projects-status",$post_id),
						"post_projects-category" => get_field("post_projects-category",$post_id),
						"post_projects-year" => get_field("post_projects-year",$post_id),
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
			wp_reset_postdata();
		}


		if (!empty($wall_content)) {
			foreach ($wall_content as $content) {


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

					// news post
					"post_w_linked" => $content["post_w_linked"],

					//project post
					"post_projects-category" =>  $content["post_projects-category"],
					"post_projects-year" =>  $content["post_projects-year"],
					"post_projects-status" =>  $content["post_projects-status"],


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
			}
		}

		return $posts;
	}
}
add_action('init', 'register_get_posts_by_user');


function register_get_posts_grid_by_user() {
	function get_posts_grid_by_user($user_id, $post_id = []) {
		$args = [
			'post_type'      => ['news', 'homes', 'projects', 'jobs', 'profile'],
			'posts_per_page' => -1,

		];
		// Si un post_id est fourni, on filtre directement sur ce post
		if (!empty($post_id)) {
			$args['post__in'] = $post_id;
		} else {
			$args['author'] = $user_id;
		}

		$query = new WP_Query($args);



		$wall_content = [];

		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				$current_post_id = get_the_ID();

 				$main_picture_image_ids = [];
				$main_picture_image_ids_array = !empty($main_picture_image_ids) ? explode(',', $main_picture_image_ids) : [];

				$gallery_image_ids = get_field("post_home_gallery_ids", $current_post_id);
				$gallery_image_ids_array = !empty($gallery_image_ids) ? explode(',', $gallery_image_ids) : [];

				$wall_content[] = [
					"id" => $current_post_id,
					"post_type" => get_post_type($current_post_id),
					"main_picture" => $main_picture_image_ids_array,
					"card_gallery" => $gallery_image_ids_array,
				];
			}
			wp_reset_postdata();
		}
 		if (!empty($wall_content)) {
			?>
			<!-- Conteneur des posts -->
			<div class="posts_prof">
				<?php foreach ($wall_content as $content): ?>
					<?php
					get_template_part("components/card-slide-grouped", null, array(
						'main_picture' => !empty($content["main_picture"][0]) ? $content["main_picture"] : $content["card_gallery"],
						'all_img' => $content["card_gallery"],
						'img_size' => 'thumbnail-m',
						'id' => $content["id"],
						'post_type' => $content["post_type"]
					));
					?>
				<?php endforeach; ?>
			</div>

			<!-- Modal pour afficher les images du post -->
			<div id="postModal_prof" class="modal_prof">
				<span class="close">&times;</span>
				<div class="modal_prof-content">
					<!-- Les images du post seront injectées ici -->
				</div>
				<div class="modal_prof-navigation">
					<span class="prev">&lt;</span>
					<span class="next">&gt;</span>
				</div>
			</div>
			<?php
		}
	}
}
add_action('init', 'register_get_posts_grid_by_user');



function register_get_news_grid_for_w_linked() {
	function get_news_grid_for_w_linked($linked_post_id, $post_type = 'news') {
		$args = [
			'post_type'      => $post_type,
			'posts_per_page' => -1,
			'meta_query'     => [
				[
					'key'     => 'post_w_linked',
					'value'   => $linked_post_id,
					'compare' => '='
				]
			]
		];

		$query = new WP_Query($args);
		$posts = [];

		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				$posts[] = [
					'ID'    => get_the_ID(),
					'title' => get_the_title(),
					'link'  => get_permalink()
				];
			}
			wp_reset_postdata();
		}



		if (!empty($posts)) {

			foreach ($posts as $post) {

				$post_gallery_image_ids = get_field("post_home_gallery_ids", $post["ID"]);
				$post_gallery_image_ids_array = explode(',', $post_gallery_image_ids);

				foreach ($post_gallery_image_ids_array as $post_gallery_id):

				 if ($post_gallery_id)
					get_template_part("components/grid-slate", null, array(
						"id" => $post_gallery_id,
						"post_link" => "",
						"image" => wp_get_attachment_image_src($post_gallery_id, 'large-img-medium')[0]
					));
				endforeach;
			}

		}
		//return $posts;
	}
}
add_action('init', 'register_get_news_grid_for_w_linked');







//



include get_template_directory() . '/function_route.php';
include get_template_directory() . '/function_file_edit.php';
include get_template_directory() . '/function_modif_video.php';
include get_template_directory() . '/function_meta_post.php';
include get_template_directory() . '/function_news_search.php';
include get_template_directory() . '/function_map_plus.php';
include get_template_directory() . '/function_profile_recommend.php';
include get_template_directory() . '/function_profile_add_contact.php';
include get_template_directory() . '/function_profile.php';

