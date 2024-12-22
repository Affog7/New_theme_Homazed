<?php
/**
* Template Name: Edit post
*
*/

$post_id = isset($_GET["post_id"]) ? intval($_GET["post_id"]) : 0;
if (!$post_id || get_post_status($post_id) === false) {
    wp_die("Invalid post or not found.");
}

add_filter('body_class', function ($classes) use ($post_id) {
    if ($post_id) {
        $classes[] = 'postid-' . $post_id;
    }
    return $classes;
});

get_header();


?>

<?php
$current_user_id = get_current_user_id();
global $post;

$post_id = htmlspecialchars($_GET["post_id"]);
$post = get_post($post_id);
$author_id = get_post_field( 'post_author', $post_id );

if($author_id != $current_user_id){
	dd("not allowed");
}

?>

<main class="main" role="main" data-barba="container" data-barba-namespace="post" data-theme="theme-light" data-admin-ajax=<?php echo admin_url( 'admin-ajax.php' ); ?>>
	<span class="hide current_user_id page_user_id" data-u-id="<?php echo $current_user_id; ?>"></span>
	<div class="container container--default public-profile tabs-group">
	 
	<div id="editPostPopup" class="popup" style="  background: #6c6c64b5;">
	<div class=" popup-content">
		<div class="body-popup">
			<div class="popup-header">
				<h2>Home Post</h2>
				<div class="popup-controls">
					<?php
					// Récupérer le statut actuel du post
					$current_status = get_post_status($post_id);
					$post_link = get_the_permalink($post_id);
					// Définir un libellé pour chaque statut
					$status_labels = array(
						'publish'  => 'Active',
						'private'  => 'Private',
						'erase'    => 'Erase',
					);

					// Vérifier si le statut actuel est dans le tableau, sinon par défaut 'Active'
					$current_label = isset($status_labels[$current_status]) ? $status_labels[$current_status] : 'Active';
					?>

					<div class="dropdown">
						<!-- Affichage dynamique du statut actuel -->
						<span id="post-status" class="active-status" onclick="toggleDropdown()">
					<?php echo esc_html($current_label); ?> ▼
					</span>
						<div id="status-options" class="dropdown-content">
							<a href="#" onclick="setStatus('publish', <?php echo $post_id; ?>)">Active</a>
							<a href="#" onclick="setStatus('private', <?php echo $post_id; ?>)">Inactive</a>
							<a href="#" onclick="setStatus('erase', <?php echo $post_id; ?>)">Erase</a>
						</div>
					</div>

								 <?php get_template_part( 'components/btn', null,
									 array(
										 'label' => 'Go back',
										 'href' => "$post_link",
										 'target' => "_self",
										 'skin'  => 'ghost',
										 'icon-only'  => false,
										 'disabled'  => false,
										 'icon-position' => '', // left or right
										 'icon' => '',
										 'additional-classes' => 'square',
										 'data-attribute' => '',
										 'theme' => "",
									 )
								 ); ?>

					 
				</div>
			</div>

			<!-- Divider -->
			<hr>

			<!-- Sommaire (Step 0) -->
			<div class="form-step" id="step0">
				<h3>Sommaire des étapes</h3>
				<ul class="step-list">
					<li><a href="#" onclick="goToStep(1)">Media</a></li>
					<li><a href="#" onclick="goToStep(2)">Location</a></li>
					<li><a href="#" onclick="goToStep(3)">Texts & Key Info</a></li>
					<li><a href="#" onclick="goToStep(4)">Connections</a></li>
					<li><a href="#" onclick="goToStep(5)">Event</a></li>
					<li><a href="#" onclick="goToStep(6)">Premium</a></li>
				</ul>
			</div>

			<!-- Autres étapes du formulaire -->
			<div class="form-step" id="step1" style="display:none;">
				<h3>Media</h3>
				<main class="modal__content contact__form contact__form--light">
					<?php	echo do_shortcode('[gallery_manager  max_images="15" size="medium" allowed_extensions="jpg,png"  post_id="' . $post_id . '"]');
					; ?>

					<?php	echo do_shortcode('[manage_post_media   post_id="' . $post_id . '"]');
					; ?>



					<?php	echo do_shortcode('[video_manager_url    post_id="' . $post_id . '"]');
					; ?>


					<!--				--><?php	//echo do_shortcode( '[gravityform id="4" title="false"  field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
				</main>
			</div>
			<div class="form-step" id="step2" style="display:none;">
				<h3>Location</h3>
				<main class="modal__content contact__form contact__form--light">
					<?php echo do_shortcode( '[gravityform id="17" title="false" ajax="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
				</main>
			</div>
			<div class="form-step" id="step3" style="display:none;">
				<h3>Texts & Key Info</h3>
				<main class="modal__content contact__form contact__form--light">

					 
				<?php echo do_shortcode( '[gravityform id="8" ajax="false" title="false" field_values="ID=' . $post_id . '&current_post_id=' . $post_id . '&post_retrieved_id=' . $post_id . '"]' ); ?>

				</main>
			</div>
			<div class="form-step" id="step4" style="display:none;">
				<h3>Connections</h3>
				<main class="modal__content contact__form contact__form--light">
					<?php echo do_shortcode( '[gravityform id="11" ajax="false" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
				</main>      </div>
			<div class="form-step" id="step5" style="display:none;">
				<h3>Event</h3>
				<main class="modal__content contact__form contact__form--light">
					<?php echo do_shortcode( '[gravityform id="15" title="false" ajax="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
				</main>
			</div>
			<div class="form-step" id="step6" style="display:none;">
				<h3>Premium</h3>
				<main class="modal__content contact__form contact__form--light">
					<?php echo do_shortcode( '[gravityform id="20" ajax="false" title="false" field_values="post_retrieved_id=' . $post_id . '"]' ); ?>
				</main>
			</div>

			<!-- Contrôles de navigation -->
			<div class="form-navigation">
				<button id="prevBtn" onclick="navigateSteps(-1)">Previous</button>
				<span id="step-count">0 / 6</span>
				<button id="nextBtn" onclick="navigateSteps(1)">Next</button>
			</div>
			<div>
				<p class="active-status" id="status_notif_"></p>
			</div>

		</div>
	</div>

</div>

	 </div>
</main>

<?php get_footer(); ?>
