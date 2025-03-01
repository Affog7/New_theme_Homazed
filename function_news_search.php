<?php
add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/posts', array(
        'methods' => 'GET',
        'callback' => 'get_prepopulated_templates_by_title',
    ));
});

function get_prepopulated_templates_by_title(WP_REST_Request $request) {
	$id_post = $request->get_param('id_post'); // Récupérer le paramètre id_post
	$search_query = $request->get_param('search'); // Récupérer le paramètre de recherche



	// Récupérer l'ID de l'utilisateur connecté
	wp_get_current_user();
	$current_user_id = $request->get_param("post_auth");

// Vérifier si un utilisateur est connecté
	if ($current_user_id !=null && $search_query=='-1') {
		// Arguments de la requête
		$args = array(
			'post_type' => ['homes', 'jobs', 'projects'],  // Type de contenu (articles)
			'posts_per_page' => 3,       // Nombre de posts à récupérer
			'author' => $current_user_id, // Filtrer par auteur connecté
			'orderby' => 'date',  // Trier par date
			'order' => 'DESC'   // Du plus récent au plus ancien
		);
	} else {
		// Définition des arguments de la requête
		$args = array(
			'post_type'      => ['homes', 'jobs', 'projects'],
			'posts_per_page' => 3,
			'author' => $current_user_id,
		);
	}


	// Vérifier si id_post est fourni
	if (!empty($id_post)) {
		$args['p'] = intval($id_post); // Recherche par ID précis
	} elseif ($search_query !='-1' && !empty($search_query) ) {
		$args['s'] = $search_query; // Recherche par titre
	}

	$posts = get_posts($args);
	$templates = array();

	if (empty($posts)) {
		return new WP_Error('no_posts_found', 'No posts found.', array('status' => 404));
	}

	foreach ($posts as $post) {
		setup_postdata($post);

		// Déterminer le type de post
		$post_type = get_post_type($post);

		// Buffer le contenu pour capturer le template rendu
		ob_start();
		get_template_part('components/news/map-popup-'.$post_type, null, array(
			'id' => $post->ID
		));
		$template_content = ob_get_clean();

		// Ajouter les informations du template au tableau
		$templates[] = array(
			'title'   => get_the_title($post),
			'content' => $template_content,
			'type'    => $post_type,
			'id'      => $post->ID,
		);
	}

	wp_reset_postdata();

	return $templates;
}

// envoyer un preview
add_action('rest_api_init', function () {
	register_rest_route('custom/v1', '/link-preview_news/', [
		'methods'  => 'POST',
		'callback' => 'generate_link_preview_news',
		'permission_callback' => '__return_true',
	]);
});

function generate_link_preview_news(WP_REST_Request $request) {
	$post_link_parsed = sanitize_text_field($request->get_param('url'));

	if (empty($post_link_parsed)) {
		return new WP_Error('missing_url', 'URL manquante', ['status' => 400]);
	}

	$shortcode = do_shortcode('[wplinkpreview url="' . esc_url($post_link_parsed) . '"]');

	return new WP_REST_Response(['preview' => $shortcode], 200);
}
