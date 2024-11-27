<?php
// Ajouter un endpoint REST pour obtenir les informations d'un post
function get_post_details_api( $request ) {
	$post_id = $request->get_param('post_id');

	// Vérifier si le post existe
	if ( ! $post = get_post( $post_id ) ) {
		return new WP_Error( 'no_post', 'Post non trouvé', array( 'status' => 404 ) );
	}

	// Récupérer les informations de l'auteur
	$user_id = get_the_author_meta('ID', $post->post_author);
	$first_name = get_field("user_first_name", "user_" . $user_id);
	$last_name = get_field("user_last_name", "user_" . $user_id);

	// Récupérer les informations du post
	$post_init_terms = get_the_terms($post_id, 'posttags');
	$post_address = get_field("post_location_address") . ", " . get_field("post_location_zip") . " " . get_field("post_location_city",$post_id);
	$post_location_latitude = get_field("post_location_latitude",$post_id);
	$post_location_longitude = get_field("post_location_longitude",$post_id);

	// Galerie d'images
	$post_gallery_image_ids = get_field("post_home_gallery_ids", $post_id);
	$post_gallery_image_ids_array = explode(',', $post_gallery_image_ids);

	// Image principale
	$main_picture_image_ids = get_field("post_home_main_picture_ids", $post_id);
	$main_picture_image_ids_array = explode(',', $main_picture_image_ids);
	$post_avatar_picture_id = ($main_picture_image_ids_array[0]) ? $main_picture_image_ids_array[0] : $post_gallery_image_ids_array[0];
	$post_avatar_picture = wp_get_attachment_url($post_avatar_picture_id, 'thumbnail');

	// Catégorie
	if (is_array(get_field("post_home_category"))) {
		$post_category = get_field("post_home_category")["label"];
	} else {
		$post_category = get_field("post_home_category",$post_id);
	}

	// Informations additionnelles
	$post_price = get_field("post_home_price",$post_id);
	$post_bedrooms = get_field("post_home_number_of_bedrooms",$post_id);
	$post_bathrooms = get_field("post_home_number_of_bathrooms",$post_id);
	$post_home_size = get_field("post_home_size",$post_id);
	$post_outdoor_size = get_field("post_home_outdoor_size",$post_id);

	// Format de prix
	$fmt = new NumberFormatter('fr_FR', NumberFormatter::CURRENCY);
	$fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);

	// URL des images
	$image_urls = [];
	foreach ($post_gallery_image_ids_array as $id) {
		$image_src = wp_get_attachment_image_src($id, 'thumbnail');
		if ($image_src) {
			$image_urls[] = $image_src[0];
		}
	}

	// Action (vente, location, etc.)
	$post_home_action_value = get_field("post_home_action", $post_id);
	$post_home_action_translate = match ($post_home_action_value) {
		"sale" => "for Sale",
		"rent" => "for Rent",
		"sold" => "sold",
		"rented" => "rented",
		default => ""
	};

	// Traduction des catégories
	$post_home_category_value = get_field("post_home_category", $post_id);
	$post_home_category_translate = match ($post_home_category_value) {
		"house" => "House",
		"apartment" => "Apartment",
		"new_construction" => "New construction",
		"land_plot" => "Land/Plot",
		"office" => "Office",
		"commercial_industry" => "Commercial/Industry",
		"garage_parking" => "Garage/Parking",
		"other" => "Other",
		default => ""
	};

// template


	ob_start();
	  get_template_part("components/btn", null,
		array(
			'label' => '',
			'href' => "",
			'target' => "_self",
			'skin'  => 'transparent',
			'icon-only'  => true,
			'disabled'  => false,
			'icon-position' => 'right', // left or right
			'icon' => 'diagram-arrow-bend-down', // nom du fichier svg
			'additional-classes' => 'post-footer__button',
			'data-attribute' => 'data-open-modal=\'share-slate-' .$post_id . '\'' ,
			'theme' => "",
		)
	);
	$bouton_share_template = ob_get_clean();

	$i_favorite_posts_relationships = get_field("i_favorite_posts_relationships", "user_".$user_id);

	$is_checked_favorite = (!empty($i_favorite_posts_relationships) && in_array($post_id, $i_favorite_posts_relationships)) ? true : false;

	// Commence la mise en tampon de sortie
	ob_start();

// Inclut le template, dont le contenu sera capturé dans le tampon
	get_template_part("components/btn", null, array(
		'label' => 'Favorite',
		'href' => "",
		'target' => "_self",
		'skin'  => 'transparent',
		'icon-only'  => true,
		'disabled'  => false,
		'icon-position' => '', // left or right
		'icon' => 'rating-star-ribbon', // nom du fichier svg
		'additional-classes' => $is_checked_favorite ? 'post-footer__button relation_btn--checked relation_btn relation_btn__posts relation_btn--favorite' : 'post-footer__button relation_btn relation_btn__posts relation_btn--favorite',
		'data-attribute' => "data-relation-him=" . $post_id. " data-relation-type='favorite'",
		'theme' => "",
	));

// Capture et stocke le contenu du tampon dans une variable
	$like_favorite_template = ob_get_clean();

// end template
	$images_temp = '<div class="map-slate__image  ">';
	$images_temp .= '<div class="card__img  ">';
	$images_temp .= '<div class=" carrousel glide glide--swipeable glide--ltr glide--carousel">';


  if($post_gallery_image_ids_array) {

	  ob_start(); ?>
	  <div class="image-slider_a">
		  <div class="slider-container_a">
			  <div class="slider-wrapper_a">
				  <!-- Les images dynamiques sont insérées ici via PHP -->
				  <?php foreach ($image_urls as $url): ?>
					  <div class="slider-slide_a">
						  <img src="<?php echo esc_url($url); ?>" alt="Image">
					  </div>
				  <?php endforeach; ?>
			  </div>
		  </div>
		  <!-- Contrôles gauche/droite -->
		  <?php if (count($image_urls)>1): ?>
			  <button class="slider-control_a prev" style="display: none" aria-label="Previous slide"><</button>
			  <button class="slider-control_a next" aria-label="Next slide">></button>
		  <?php endif; ?>



	  </div>

	  <?php
	  $images_temp .=ob_get_clean();
  }

	$images_temp .="</div>";
	$images_temp .="</div>";
	$images_temp .="</div>";


	// Préparer les données pour la réponse
	$response = [
		"id" => $post_id,
		"title" => get_the_title($post_id),
		"content" => get_the_excerpt($post_id),
		"post_type" => "Homes",
		"post_type_slug" => "real-estate",
		"main_picture" => $main_picture_image_ids_array,
		"card_gallery" => $post_gallery_image_ids_array,
		"card_gallery_display" => get_field("post_home_pictures_display"),
		"home_type" => $post_home_action_translate,
		"home_category" => $post_home_category_translate,
		"first_name" => $first_name,
		"last_name" => $last_name,
		"user_id" => $user_id,
		"work_position" => get_field("user_current_work_position", "user_" . $user_id),
		"price" => $fmt->formatCurrency($post_price, "EUR")."\n",
		"bedrooms" => $post_bedrooms,
		"bathrooms" => $post_bathrooms,
		"home_size" => $post_home_size,
		"outdoor_size" => $post_outdoor_size,
		"tags" => $post_init_terms,
		"events_type" => get_field("post_home_event_type"),
		"events_text_1" => get_field("post_home_event_text_1"),
		"events_text_2" => get_field("post_home_event_text_2"),
		"events_privacy" => get_field("post_home_event_privacy"),
		"location" => $post_address,
		"lat" => $post_location_latitude,
		"lng" => $post_location_longitude,
		"img" => $post_avatar_picture,
		"card_gallery_images" => $image_urls,
		"publish_date" => get_post_timestamp($post_id),
		"post_permalink" => get_the_permalink($post_id),
		"templates" => [
			"like_favorite_template" => $like_favorite_template,
			"bouton_share_template" =>$bouton_share_template,
			"images_temp"=>$images_temp
		]
	];

	return rest_ensure_response($response);
}

// Enregistrer le routeur API
add_action('rest_api_init', function () {
	register_rest_route('custom/v1', '/post-details', [
		'methods' => 'GET',
		'callback' => 'get_post_details_api',
		'args' => [
			'post_id' => [
				'required' => true,
				'validate_callback' => function($param) {
					return is_numeric($param);
				}
			],
		],
		'permission_callback' => '__return_true'
	]);
});

