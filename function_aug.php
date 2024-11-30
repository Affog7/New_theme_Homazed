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
			'zoom' => '15',          // Niveau de zoom par défaut
		),
		$atts,
		'osm_map'
	);

	// Code HTML et JavaScript pour afficher la carte avec OpenStreetMap
	ob_start();
	?>
	<div id="osm-map" style="width: <?php echo esc_attr($atts['width']); ?>; height: <?php echo esc_attr($atts['height']); ?>;"></div>
	<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="" crossorigin=""></script>
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


	// Enqueue the script on specific pages or everywhere
	if (is_page() || is_single()) { // Adjust to target specific pages or conditions
		wp_enqueue_script('custom-tags-js');
	}

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



//



include get_template_directory() . '/function_route.php';

