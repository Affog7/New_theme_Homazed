<?php
/**
 * Template Name: Manageslate
 *
 * by hellomarcel.be
 * -> hello@marcel-pirnay.be
 */

get_header();

// Récupération des informations du post et de l'utilisateur actuel
$post_id = $_GET["post"];
$user_id = wp_get_current_user()->ID;

//post_type
$post_type = get_post_type($post_id);
$post_status = get_post_status($post_id);

// Galerie d'images
$post_gallery_image_ids = get_field("post_home_gallery_ids", $post_id);
$post_gallery_image_ids_array = explode(',', $post_gallery_image_ids);

$main_picture_image_ids = get_field("post_home_main_picture_ids", $post_id);
$main_picture_image_ids_array = explode(',', $main_picture_image_ids);
$post_avatar_picture_id = ($main_picture_image_ids_array[0]) ? $main_picture_image_ids_array[0] : $post_gallery_image_ids_array[0];
$post_avatar_picture = wp_get_attachment_url($post_avatar_picture_id, 'thumbnail');


$post_location = get_field("post_location_address", $post_id);

// Informations supplémentaires
$post_price = get_field("post_home_price", $post_id);
$post_bedrooms = get_field("post_home_number_of_bedrooms", $post_id);
$post_bathrooms = get_field("post_home_number_of_bathrooms", $post_id);

$post_premium = get_field("post_premium", $post_id);
$is_reniew_post_premium = get_field("post_Is_Automatic_Renewal", $post_id);

//event tags
$events_text_1 = get_field("post_home_event_text_1", $post_id);
$events_text_2 = get_field("post_home_event_text_2", $post_id);

?>

	<main class="main main--congrats" role="main" data-barba="container" data-barba-namespace="form" data-theme="theme-light">
		<div class="container container--default">
			<div class="card-form" data-barba-prevent="all">


				<div class="post-container">
					<div class="post-header">
						<h1><?php echo esc_html($post_type."|".$post_status.($post_premium ? " - PREMIUM" : '' )); ?></h1>

						<div class="options">
							<button id="premium-toggle" class="premium-button">Premium</button>
							<button id="event-toggle" class="event-button">Event</button>
						</div>
					</div>

					<hr>
					<div class="row">
						<div><strong>Location:</strong> <?php echo esc_html($post_location); ?></div>
						<div><a href="<?php echo esc_url(get_post($post_id)->guid);	 ?>"><i>Go to Post Creation ></i></a></div>
					</div>
					<div class="row">
						<p><strong>Price:</strong> <?php echo number_format($post_price, 2) ; ?>€</p>
						<p><strong> <?php echo esc_html(get_the_title($post_id)); ?> </strong> </p>
					</div>
					<hr>

					<!-- premium -->
					<div id="premium-info" class="info-section" style="display: none;">
						<div class="row">
							<div>
								<img width="165" src="<?php echo esc_url($post_avatar_picture); ?>" alt="Main Picture">
							</div>
							<div class="info">
								<p>Premium duration: <span id="premium-duration">1 Month(s)</span></p>
								<p>Premium from: <span id="premium-start-date">28 AUG 2025</span></p>
								<p>Remaining time: <span id="premium-remaining-time">12 days 13 hours</span></p>
							</div>
						</div>
						<hr>
						<div class="row">
							<label class="custom-checkbox">
								<input type="checkbox" name="premium_auto_renewal" value="1" <?php if($is_reniew_post_premium!=null) echo "checked"; ?> >
								<span class="checkmark"></span> Premium Post - Automatic Renewal
							</label>
						</div>
						<hr>
						<div class="row">
							<div>
								<a class="see-stats" href="#">See statistics</a>
								<!-- Statistiques (initialement caché) -->
								<div class="statistics-container" style="display: none; margin-top: 20px; border-top: 2px solid #ccc; padding-top: 20px;">
									<h3>Statistics</h3>
									<div id="view-count">
										<p><strong>Number of views on this post:</strong> <span id="post-views">0</span></p>
									</div>
									<div id="event-info-stats" style="display:  ;">
										<p><strong>Event Stats:</strong></p>
										<ul>
											<li>Event Start Date: <span id="event-start-date"></span></li>
											<li>Event End Date: <span id="event-end-date"></span></li>
											<li>Number of people attended: <span id="event-attendees">0</span></li>
										</ul>
									</div>
									<div id="follow-us-stats">
										<p><strong>Follow Us Clicks:</strong> <span id="follow-us-clicks">0</span></p>
									</div>
								</div>

							</div>
						</div>
					</div>
					<!-- End premium -->
					<!-- event -->
					<div id="event-info" class="info-section" style="display: none;">
						<div class="row">
							<div>
								<img width="165" src="<?php echo esc_url($post_avatar_picture); ?>" alt="Main Picture">
							</div>
							<div class="info">
								<p><?php echo $events_text_1; ?></p>
								<p><?php echo $events_text_2; ?></p>
							</div>
						</div>
						<hr>
						<div class="row">
							<label class="custom-checkbox">
								<input type="checkbox" name="premium_auto_renewal" value="1"  >
								<span class="checkmark"></span> Active Event
							</label>
						</div>
						<hr>
						<div class="row">
							<div>
								<a class="see-stats" href="#">See statistics</a>
								<!-- Statistiques (initialement caché) -->
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

					<!-- end envent -->
				</div>
			</div>
		</div>
	</main>





	<script>
		document.addEventListener('DOMContentLoaded', function() {
			// Sélection des éléments
			const premiumButton = document.getElementById('premium-toggle');
			const eventButton = document.getElementById('event-toggle');
			const premiumInfo = document.getElementById('premium-info');
			const eventInfo = document.getElementById('event-info');

			// Fonction pour afficher la section "Premium" et cacher l'autre
			function showPremiumInfo() {
				premiumInfo.style.display = 'block';
				eventInfo.style.display = 'none';
			}

			// Fonction pour afficher la section "Event" et cacher l'autre
			function showEventInfo() {
				eventInfo.style.display = 'block';
				premiumInfo.style.display = 'none';
			}

			// Event listeners pour les boutons
			premiumButton.addEventListener('click', function() {
				showPremiumInfo();
			});

			eventButton.addEventListener('click', function() {
				showEventInfo();
			});

			// Par défaut, on affiche la section "Premium" lorsque la page est chargée
			showPremiumInfo();


			const seeStatsLinks = document.querySelectorAll('.see-stats'); // Sélectionner tous les liens

			// Fonction pour afficher les statistiques
			function showStatistics(statisticsContainer) {
				statisticsContainer.style.display = 'block';
			}

			// Ajouter un événement au clic sur chaque "See statistics"
			seeStatsLinks.forEach(function(seeStatsLink) {
				seeStatsLink.addEventListener('click', function(event) {
					event.preventDefault();  // Empêcher l'action par défaut du lien

					// Trouver le conteneur des statistiques (en parent de l'élément cliqué)
					const statisticsContainer = seeStatsLink.closest('.row').querySelector('.statistics-container');

					showStatistics(statisticsContainer); // Afficher les statistiques
				});
			});



		});

	</script>

<?php get_footer();
