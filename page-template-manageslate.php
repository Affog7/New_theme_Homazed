<?php
/**
 * Template Name: Manage Slate
 *
 */

get_header();



// Initialiser les données
$data = []; // Liste pour stocker les posts de l'utilisateur

// Récupération de l'utilisateur actuel
$current_user = wp_get_current_user();
$user_id = $current_user->ID;

// Vérifier si $_GET["post"] est défini
$post_id = isset($_GET["post"]) ? intval($_GET["post"]) : -1;

// Cas : Charger un post spécifique
if ($post_id != -1) {
	// Vérifier que le post existe et appartient à l'utilisateur
	$post = get_post($post_id);
	if ($post && (int)$post->post_author === $user_id) {
		$data[] = load_post_data($post_id);
	} else {
		echo "<p>Post non trouvé ou vous n'avez pas l'autorisation d'y accéder.</p>";
	}
} else {
	// Cas : Charger tous les posts de l'utilisateur
	$args = [
		'post_author' => $user_id,
		"post_type" => "homes",
		'posts_per_page' => -1, // Récupérer tous les posts
	];
	$user_posts = get_posts($args);

	// Charger les données pour chaque post
	if (!empty($user_posts)) {
		foreach ($user_posts as $post) {
			$data[] = load_post_data($post->ID);
		}
	} else {
		echo "<p>Aucun post trouvé pour cet utilisateur.</p>";
	}
}

// Fonction pour charger les données d'un post
function load_post_data($post_id) {
	// Vérifier que le post existe
	if (!$post_id || !get_post($post_id)) {
		return null;
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

	// Galerie d'images
	$post_gallery_image_ids = get_field("post_home_gallery_ids", $post_id);
	$post_gallery_image_ids_array = $post_gallery_image_ids ? explode(',', $post_gallery_image_ids) : [];

	$main_picture_image_ids = get_field("post_home_main_picture_ids", $post_id);
	$main_picture_image_ids_array = $main_picture_image_ids ? explode(',', $main_picture_image_ids) : [];
	$post_avatar_picture_id = ($main_picture_image_ids_array[0]) ? $main_picture_image_ids_array[0] : ($post_gallery_image_ids_array[0] ?? null);
	$post_avatar_picture = $post_avatar_picture_id ? wp_get_attachment_url($post_avatar_picture_id, 'thumbnail') : '';

	// Autres informations
	$post_location = get_field("post_location_address", $post_id);
	$post_premium_duration = get_field("post_duration", $post_id);
	$post_price = get_field("post_home_price", $post_id);
	$post_bedrooms = get_field("post_home_number_of_bedrooms", $post_id);
	$post_bathrooms = get_field("post_home_number_of_bathrooms", $post_id);
	$post_premium = get_field("post_premium", $post_id);
	$is_reniew_post_premium = get_field("post_Is_Automatic_Renewal", $post_id);
	$post_home_event_type = get_field("post_home_event_type", $post_id);
	$events_text_1 = get_field("post_home_event_text_1", $post_id);
	$events_text_2 = get_field("post_home_event_text_2", $post_id);

	// Retourner les données du post sous forme de tableau
	return [
		'id' => $post_id,
		'action' => $post_home_action_translate,
		'category' => $post_home_category_translate,
		'avatar' => $post_avatar_picture,
		'location' => $post_location,
		'price' => $post_price,
		'post_premium_duration' => is_array($post_premium_duration) ? $post_premium_duration[0] : $post_premium_duration,
		'bedrooms' => $post_bedrooms,
		'bathrooms' => $post_bathrooms,
		'premium' => $post_premium,
		'renewal' => $is_reniew_post_premium,
		'event_type' => $post_home_event_type,
		'event_text_1' => $events_text_1,
		'event_text_2' => $events_text_2,
	];
}

// Afficher les données


get_footer();
?>



	<main class="main main--congrats main_manage_slate" role="main" data-barba="container" data-barba-namespace="form" data-theme="theme-light">


		<div class="container container--default">

				<?php if (!empty($data)) : ?>
				<?php foreach ($data as $post_data) : ?>

						<div class="card-form"  style="border: 2px solid #7e7c804d">
					<div class="post-container">
					<div class="post-header">
						<h1>HOME</h1>
						<div class="options">
							<button id="" class="premium-toggle premium-button">Premium</button>
							<button id="" class="event-toggle event-button">Event</button>
						</div>
					</div>


							<div class="row">
								<div>
									<strong><?php echo esc_html($post_data['category'])."   "; ?></strong>
									<?php echo esc_html($post_data['action']); ?>
								</div>
								<div>
									<a href="<?php echo esc_url(get_permalink($post_data['id'])); ?>">
										<i>Go to Post Creation ></i>
									</a>
								</div>
							</div>
							<hr>

							<!-- Premium Info -->
					<div class="premium-info">
						<div class="premium-header">

							<img
								class="premium-image"
								src="<?php echo esc_url($post_data['avatar']); ?>"
								alt="Main Picture"
							/>

							<div class="premium-details" style="display: ">
								<p>Premium duration: <span style="font-weight: 800;"><b><?php echo($post_data['post_premium_duration']); ?></b></span></p>
								<p>Premium from: <span  style="font-weight: 800;"><b>28 AUG 2025</b></span></p>
								<p>Remaining time: <span  style="font-weight: 800;"><b>12 days 13 hours</b></span></p>
							</div>

						</div>
						<hr />
						<div class="premium-options">
							<label class="custom-checkbox">
								<input type="checkbox" name="premium_auto_renewal" value="1" <?php echo $post_data['renewal'] ? "checked" : ""; ?> />
								<span class="checkmark"></span> <b>Premium Post - Automatic Renewal</b>
							</label>
						</div>
						<hr />
						<div class="premium-footer"  style="display: none">
							<a class="see-stats" href="#">See statistics</a>
							<div class="statistics-container" style="display: none;" >
								<h3>Statistics</h3>
								<div id="view-count">
									<p><strong>Number of views on this post:</strong> <span>0</span></p>
								</div>
								<div id="event-info-stats">
									<p><strong>Event Stats:</strong></p>
									<ul>
										<li>Event Start Date: <span id="event-start-date"></span></li>
										<li>Event End Date: <span id="event-end-date"></span></li>
										<li>Number of people attended: <span id="event-attendees">0</span></li>
									</ul>
								</div>
								<div id="follow-us-stats">
									<p><strong>Follow Us Clicks:</strong> <span>0</span></p>
								</div>
							</div>
						</div>
					</div>
							<!-- End Premium Info -->

					<!-- Event Info -->
					<div id="" class="event-info info-section" style="display: none;">

						<div class="premium-header">
							<img
								class="premium-image"
								src="<?php echo esc_url($post_data['avatar']); ?>"
								alt="Main Picture"
							/>
							<div class="premium-details" style="display: ">
								<p>Event Type : <span  style="font-weight: 800;"><b><?php echo esc_html($post_data['event_text_1']); ?></b></span></p>
								<p>Title 1 : <span  style="font-weight: 800;"><b><?php echo esc_html($post_data['event_text_1']); ?></b></span></p>
								<p>Title 2 : <span ><b><?php echo esc_html($post_data['event_text_2']); ?></b></span></p>
							</div>
						</div>

						<hr>
						<div class="premium-options">
							<label class="custom-checkbox">
								<input type="checkbox" name="premium_auto_renewal" value="1" <?php echo !empty($post_data['event_type']) ? "checked" : ""; ?>>
								<span class="checkmark"></span> <b>Active Event</b>
							</label>
						</div>

						<hr>
						<div class="row">
							<div>

							</div>
						</div>


						<div class="premium-footer" style="display: none">
							<a class="see-stats" href="#">See statistics</a>
							<!-- Statistics (hidden by default) -->
							<div class="statistics-container" style="display: none; margin-top: 20px; border-top: 2px solid #ccc; padding-top: 20px;">
								<h3>Statistics</h3>
								<div id="view-count">
									<p><strong>Number of views on this event:</strong> <span id="post-views">0</span></p>
								</div>
								<div id="follow-us-stats">
									<p><strong>Event Clicks:</strong> <span id="follow-us-clicks">0</span></p>
								</div>
							</div>
						</div>

					</div>


				</div>
				</div>		<?php endforeach; ?>
				<?php else : ?>
					<p>No posts found for the current user.</p>
				<?php endif; ?>

		</div>

	</main>


	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const premiumButtons = document.querySelectorAll('.premium-toggle');
			const eventButtons = document.querySelectorAll('.event-toggle');
			const premiumInfos = document.querySelectorAll('.premium-info');
			const eventInfos = document.querySelectorAll('.event-info');
			const seeStatsLinks = document.querySelectorAll('.see-stats');

			// Fonction pour afficher une section et masquer l'autre
			function toggleSection(activeButton, inactiveButtons, sectionsToShow, sectionsToHide) {
				sectionsToShow.forEach(section => (section.style.display = 'block')); // Affiche la section active
				sectionsToHide.forEach(section => (section.style.display = 'none'));  // Cache la section inactive

				// Mettre à jour les styles des boutons
				activeButton.style.backgroundColor = '#08090b'; // Bouton actif en bleu
				activeButton.style.color = '#fff'; // Texte blanc
				activeButton.style.cursor = 'default';

				inactiveButtons.forEach(button => {
					button.style.backgroundColor = '#ccc'; // Bouton inactif en gris
					button.style.color = '#555'; // Texte gris foncé
					button.style.cursor = 'pointer';
				});
			}

			// Ajouter des événements pour Premium et Event
			premiumButtons.forEach((button, index) => {
				button.addEventListener('click', () => {
					toggleSection(
						button, // Bouton actif
						[eventButtons[index]], // Boutons à désactiver
						[premiumInfos[index]], // Sections à afficher
						[eventInfos[index]] // Sections à cacher
					);
				});
			});

			eventButtons.forEach((button, index) => {
				button.addEventListener('click', () => {
					toggleSection(
						button, // Bouton actif
						[premiumButtons[index]], // Boutons à désactiver
						[eventInfos[index]], // Sections à afficher
						[premiumInfos[index]] // Sections à cacher
					);
				});
			});

			// Gestion des liens "See statistics"
			seeStatsLinks.forEach(link => {
				link.addEventListener('click', function (event) {
					event.preventDefault(); // Empêche l'action par défaut du lien
					const statisticsContainer = link.closest('.premium-footer').querySelector('.statistics-container');
					if (statisticsContainer) {
						statisticsContainer.style.display = 'block'; // Affiche la zone des statistiques
					}
				});
			});

			// Afficher la section Premium par défaut
			if (premiumButtons.length) {
				premiumButtons.forEach(p => {
					p.click();
				});
				 // Simule un clic sur le premier bouton Premium
			}
		});
	</script>



<?php get_footer();
