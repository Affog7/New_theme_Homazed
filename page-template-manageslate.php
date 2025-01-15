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
$user_id = get_current_user_id();

// Vérifier si $_GET["post"] est défini
$post_id = isset($_GET["post"]) ? intval($_GET["post"]) : -1;

// Cas : Charger un post spécifique
if ($post_id != -1) {
	// Vérifier que le post existe et appartient à l'utilisateur
	$post = get_post($post_id);
	if ($post && (int)$post->post_author === $user_id) {
		$d_ = load_post_data($post_id);
		if($d_["premium"]) $data[] = $d_;
	} else {
		echo "<p>Post non trouvé ou vous n'avez pas l'autorisation d'y accéder.</p>";
	}
} else {
	// Cas : Charger tous les posts de l'utilisateur
	$query = new WP_Query([
		'post_author' => "$user_id",
		'post_type' => ['homes','jobs','projects'],
		'posts_per_page' => -1,
	]);
	$user_posts = $query->posts;
	

	// Charger les données pour chaque post
	if (!empty($user_posts)) {
		foreach ($user_posts as $post) {
			
			if($post->post_author == $user_id) {
				$d_ = load_post_data($post->ID);
				if($d_["premium"]) $data[] = $d_; 
			}
			
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
	$post_avatar_picture_id = ($main_picture_image_ids_array) ? $main_picture_image_ids_array[0] : ($post_gallery_image_ids_array[0] ?? null);
	$post_avatar_picture = $post_avatar_picture_id ? wp_get_attachment_url($post_avatar_picture_id, 'thumbnail') : '';

	// Autres informations
	$post_location = get_field("post_location_address", $post_id);
	$post_premium_duration = get_field("post_duration", $post_id);
	$post_price = get_field("post_home_price", $post_id);
	$post_bedrooms = get_field("post_home_number_of_bedrooms", $post_id);
	$post_bathrooms = get_field("post_home_number_of_bathrooms", $post_id);
	$post_premium = get_field("post_premium", $post_id);
	$type_post = get_post_type($post_id);
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
		
		// jobs post
 		"post_home_Jobs_title" => get_field("post_home_Jobs_title",$post_id),
		//------

		// projects post
		"title" => get_the_title($post_id),

		"post_projects-status" => get_field("post_projects-status",$post_id),
		"post_projects-category" => get_field("post_projects-category",$post_id),
		"post_projects-year" => get_field("post_projects-year",$post_id),
		//------

		'price' => $post_price,
		'post_premium_duration' => is_array($post_premium_duration) ? $post_premium_duration[0] : $post_premium_duration,
		'bedrooms' => $post_bedrooms,
		'bathrooms' => $post_bathrooms,
		'premium' => $post_premium,
		'type_post' => $type_post,
		'renewal' => $is_reniew_post_premium,
		'event_type' => $post_home_event_type,
		'event_text_1' => $events_text_1,
		'event_text_2' => $events_text_2,
	];
}

// Afficher les données
?>



	<main class="main main--congrats main_manage_slate" role="main" data-barba="container" data-barba-namespace="form" data-theme="theme-light">


		<div class="container container--default">
<span id="status_notif_"></span>
				<?php if (!empty($data)) : ?>
				<?php foreach ($data as $post_data) : 
 					get_template_part("components/manage-slate-".$post_data['type_post'], null, $post_data);	
				?>
				<?php endforeach; ?>
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


<script>
document.addEventListener("DOMContentLoaded", function () {
    // Sélectionner tous les checkboxes avec la classe .premium_renewal
    const premiumCheckboxes = document.querySelectorAll('.premium_renewal');
    const statusNotif = document.querySelector("#status_notif_");

    premiumCheckboxes.forEach(function(checkbox) {
        // Ajouter un événement onchange à chaque checkbox
        checkbox.addEventListener("change", function () {
            const postId = checkbox.getAttribute('data-id'); // Utiliser data-id pour récupérer l'ID du post
            const metaKey = checkbox.name; // Utiliser le nom du checkbox comme meta_key
            const metaValue = checkbox.checked ? checkbox.value : checkbox.getAttribute('data-null'); // La valeur est 1 si checked, sinon 0

            // Envoi de la requête à l'API REST pour chaque changement de checkbox
            fetch('<?php echo esc_url(rest_url('custom/v1/update-meta/')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>', // Utilisation du nonce de sécurité WordPress
                },
                body: JSON.stringify({
                    post_id: postId,
                    meta_key: metaKey,
                    meta_value: metaValue
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    statusNotif.textContent = data.message;
                    statusNotif.style.color = "green";
                } else {
                    statusNotif.textContent = "Erreur : Impossible de mettre à jour.";
                    statusNotif.style.color = "red";
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                statusNotif.textContent = "Erreur : Une erreur s'est produite.";
                statusNotif.style.color = "red";
            });
        });
    });

});
</script>



<?php get_footer();
