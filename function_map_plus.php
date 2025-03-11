<?php
function wp_user_map_shortcode($atts) {
	$atts = shortcode_atts(array(
		'user_id' => get_current_user_id() // ID utilisateur par défaut
	), $atts);

	$user_id = intval($atts['user_id']);

	if (!$user_id) {
		return '<p>Utilisateur non valide.</p>';
	}

	// Récupérer les posts de l'utilisateur
	$args = array(
		'author'        => $user_id,
		'post_status'   => 'publish',
		'post_type'     => 'any', // Tous types de posts
		'posts_per_page'=> -1,
	);

	$posts = get_posts($args);
	$locations = [];

	foreach ($posts as $post) {
		$location = get_field('post_location_address', $post->ID);
		$lat = get_field('post_location_latitude', $post->ID);
		$lng = get_field('post_location_longitude', $post->ID);

		if (!empty($location) && !empty($lat) && !empty($lng)) {
			$locations[] = [
				'addr'      => esc_html($location),
				'lat'       => esc_html($lat),
				'lng'       => esc_html($lng),
				'title'     => esc_html(get_the_title($post->ID)),
				'post_type' => esc_html(get_post_type($post->ID))
			];
		}
	}

	// Récupérer les localisations du post_type "profile"
	$profile_args = array(
		'post_type'      => 'profile',
		'post_status'    => 'publish',
		'author'         => $user_id,
		'posts_per_page' => -1,
	);

	$profiles = get_posts($profile_args);
	foreach ($profiles as $profile) {
		$hidden_address = get_post_meta($profile->ID, 'hidden_address_plus', true);
		if (!empty($hidden_address)) {
			$addresses = explode('|', $hidden_address);
			foreach ($addresses as $address) {
				$parts = explode('@', $address);
				$addr = explode('=', $parts[0])[1] ?? '';
				$lat = explode('=', $parts[2])[1] ?? '';
				$lng = explode('=', $parts[3])[1] ?? '';

				if (!empty($addr) && !empty($lat) && !empty($lng)) {
					$locations[] = [
						'addr'      => esc_html($addr),
						'lat'       => esc_html($lat),
						'lng'       => esc_html($lng),
						'title'     => 'Profil',
						'post_type' => 'profile'
					];
				}
			}
		}
	}

	if (empty($locations)) {
		return '<p>Aucune localisation trouvée.</p>';
	}

	// ID unique de la carte
	$map_id = 'map_' . uniqid();

	ob_start();
	?>
	<div id="<?php echo esc_attr($map_id); ?>" style="height: 400px; width: 100%;"></div>
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			var map = L.map("<?php echo esc_js($map_id); ?>");

			// Ajouter le fond de carte OpenStreetMap
			L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
				attribution: "&copy; OpenStreetMap contributors"
			}).addTo(map);

			var locations = <?php echo json_encode($locations); ?>;
			var bounds = [];

			locations.forEach(function(loc) {
				var marker = L.marker([loc.lat, loc.lng]).addTo(map)
					.bindPopup("<b>" + loc.title + "</b><br>Type: " + loc.post_type + "<br>" + loc.addr);

				bounds.push([loc.lat, loc.lng]);
			});

			if (bounds.length > 0) {
				map.fitBounds(bounds, { padding: [20, 20] });
			}
		});
	</script>
	<?php

	return ob_get_clean();
}

add_shortcode('user_map', 'wp_user_map_shortcode');
