<div class="resume__profile-picture">
	<?php
	if (!is_array($args["post_main_picture"]) && strlen($args["post_main_picture"]) > 6) {
		?>
		<img class="resume__image" src="<?php echo esc_url($args["post_main_picture"]); ?>"
			 alt="<?php echo esc_attr($args["first_name"] . " " . $args["last_name"] . " profile image"); ?>" />
		<?php
	} elseif (is_array($args["post_main_picture"]) && !empty($args["post_main_picture"][0])) {
		$avatar_ids_array = explode(',', $args["post_main_picture"][0]);

		if (!empty($avatar_ids_array[0])) {
			$image_src = wp_get_attachment_image_src($avatar_ids_array[0], 'large-img-medium');
			if (!empty($image_src[0])) {
				?>
				<img class="resume__image" src="<?php echo esc_url($image_src[0]); ?>"
					 alt="<?php echo esc_attr($args["first_name"] . " " . $args["last_name"] . " profile image"); ?>" />
				<?php
			}
		}
	}

	// Affichage de l'image par défaut si aucune image valide n'est trouvée
	if (empty($image_src[0]) && (empty($args["post_main_picture"]) || empty($args["post_main_picture"][0]))) {
		?>
		<div class="resume__image resume__image--blank flex flex--horizontal-center flex--center"
			 style="height: 65px; width: 70px;">
            <span class="first-letters">
                <?php echo esc_html($args["first_name"][0] . $args["last_name"][0]); ?>
            </span>
		</div>
		<?php
	}
	?>
</div>
<?php echo file_get_contents(get_stylesheet_directory() . '/src/images/icons/badge-check-verified.svg'); ?>
