<?php
// Ajout à un post
function shortcode_add_images_with_params($atts) {
	// Définir les attributs du shortcode
	$atts = shortcode_atts(
		[
			'post_id' => 0, // ID du post
			'max_images' => 10, // Nombre maximal d'images
			'size' => 'thumbnail', // Taille des images affichées
			'allowed_extensions' => 'jpg,png,jpeg', // Extensions autorisées
		],
		$atts
	);

	$post_id = intval($atts['post_id']);
	if (!$post_id) {
		return '<p>Post ID non spécifié ou invalide.</p>';
	}

	// Vérifie si l'utilisateur a la permission d’éditer le post
	if (!current_user_can('edit_post', $post_id)) {
		return '<p>Vous n\'avez pas la permission de modifier ce post.</p>';
	}


	// Affichage HTML
	ob_start();

	?>
	<div class="custom-gallery-wrapper">
		<h4 style="font-family: Arial, sans-serif; color: #333; text-align: center; margin-bottom: 20px;">Ajouter des images à la galerie</h4>
		<form id="add-images-form" data-post-id="<?php echo esc_attr($post_id); ?>" style="text-align: center; margin-bottom: 20px;">
			<label for="image-upload" style="display: block; font-size: 16px; font-weight: bold; color: #555; margin-bottom: 10px;">Sélectionnez des images :</label>
			<input
				type="file"
				id="image-upload"
				multiple
				accept=".<?php echo str_replace(',', ',.', esc_attr($atts['allowed_extensions'])); ?>"
				style="margin: 0 auto; padding: 5px; border: 1px solid #ccc; border-radius: 5px; display: block; width: 80%; max-width: 400px;"
			>
			<button
				type="button"
				id="upload-images-button"
				style="margin-top: 15px; padding: 10px 20px; background-color: #0073aa; color: white; border: none; border-radius: 5px; font-size: 14px; cursor: pointer;"
			>
				Ajouter les images
			</button>
			<p style="margin-top: 10px; font-size: 12px; color: #888;">
				Extensions autorisées : <?php echo esc_html($atts['allowed_extensions']); ?>.
			</p>
			<p style="font-size: 12px; color: #888;">
				Nombre maximal d'images : <?php echo esc_html($atts['max_images']); ?>.
			</p>
		</form>


	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const uploadButton = document.getElementById('upload-images-button');
			const postId = document.getElementById('add-images-form').dataset.postId;

			uploadButton.addEventListener('click', function () {
				const files = document.getElementById('image-upload').files;
				const formData = new FormData();

				for (const file of files) {
					formData.append('images[]', file);
				}

				formData.append('action', 'add_gallery_images');
				formData.append('post_id', postId);

				fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
					method: 'POST',
					body: formData,
				})
					.then(response => response.json())
					.then(data => {
						if (data.success) {
							alert('Images ajoutées avec succès !');

						} else {
							alert(data.data || 'Une erreur s\'est produite.');
						}
					})
					.catch(error => {
						console.error(error);
						alert('Une erreur est survenue.');
					});
			});


		});
	</script>
	<?php

	return ob_get_clean();
}
add_shortcode('add_images_with_params', 'shortcode_add_images_with_params');

function ajax_add_gallery_images() {
	if (isset($_POST['post_id']) && !empty($_FILES['images'])) {
		$post_id = intval($_POST['post_id']);

		if (!current_user_can('edit_post', $post_id)) {
			wp_send_json_error('Permission refusée.');
		}

		$uploaded_ids = [];
		foreach ($_FILES['images']['tmp_name'] as $index => $tmp_name) {
			$file = [
				'name' => $_FILES['images']['name'][$index],
				'type' => $_FILES['images']['type'][$index],
				'tmp_name' => $tmp_name,
				'error' => $_FILES['images']['error'][$index],
				'size' => $_FILES['images']['size'][$index],
			];

			$upload = wp_handle_upload($file, ['test_form' => false]);

			if (!isset($upload['error'])) {
				$attachment_id = wp_insert_attachment([
					'guid' => $upload['url'],
					'post_mime_type' => $upload['type'],
					'post_title' => sanitize_file_name($file['name']),
					'post_content' => '',
					'post_status' => 'inherit',
				], $upload['file'], $post_id);

				require_once(ABSPATH . 'wp-admin/includes/image.php');
				wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $upload['file']));
				$uploaded_ids[] = $attachment_id;
			}
		}

		if ($uploaded_ids) {
			$current_images = get_post_meta($post_id, 'post_home_gallery_ids', true);
			$current_images_array = $current_images ? explode(',', $current_images) : [];
			$updated_images_array = array_unique(array_merge($current_images_array, $uploaded_ids));
			update_post_meta($post_id, 'post_home_gallery_ids', implode(',', $updated_images_array));

			wp_send_json_success('Images ajoutées avec succès.');
		}
	}

	wp_send_json_error('Aucune image valide trouvée.');
}
add_action('wp_ajax_add_gallery_images', 'ajax_add_gallery_images');



// Suppression
function custom_gallery_with_delete($atts) {
	// Définit les attributs par défaut et récupère les valeurs passées
	$atts = shortcode_atts([
		'ids' => '',     // Liste des IDs d'images, séparés par des virgules
		'post_id' => 0,  // ID du post
	], $atts, 'post_gallery_edit');

	// Vérifie si des IDs ont été fournis
	if (empty($atts['ids'])) {
		return '<p>No images available in the gallery.</p>';
	}

	// Sépare les IDs et vérifie leur validité
	$ids = array_filter(array_map('intval', explode(',', $atts['ids'])));
	$post_id = intval($atts['post_id']);

	$html = '<div class="custom-gallery_a">';
	foreach ($ids as $id) {
		$image_url = wp_get_attachment_image_url($id, 'thumbnail');

		// Vérifie si l'URL de l'image est valide
		if ($image_url) {
			$html .= '<div class="gallery-item_a" data-id="' . esc_attr($id) . '" data-id-post="' . esc_attr($post_id) . '">';
			$html .= '<img src="' . esc_url($image_url) . '" alt="Gallery Image">';
			$html .= '<button class="delete-image_a" data-id="' . esc_attr($id) . '">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.75 6.16667C2.75 5.70644 3.09538 5.33335 3.52143 5.33335L6.18567 5.3329C6.71502 5.31841 7.18202 4.95482 7.36214 4.41691C7.36688 4.40277 7.37232 4.38532 7.39185 4.32203L7.50665 3.94993C7.5769 3.72179 7.6381 3.52303 7.72375 3.34536C8.06209 2.64349 8.68808 2.1561 9.41147 2.03132C9.59457 1.99973 9.78848 1.99987 10.0111 2.00002H13.4891C13.7117 1.99987 13.9056 1.99973 14.0887 2.03132C14.8121 2.1561 15.4381 2.64349 15.7764 3.34536C15.8621 3.52303 15.9233 3.72179 15.9935 3.94993L16.1083 4.32203C16.1279 4.38532 16.1333 4.40277 16.138 4.41691C16.3182 4.95482 16.8778 5.31886 17.4071 5.33335H19.9786C20.4046 5.33335 20.75 5.70644 20.75 6.16667C20.75 6.62691 20.4046 7 19.9786 7H3.52143C3.09538 7 2.75 6.62691 2.75 6.16667Z" fill="#1C274C"></path>
                            <path d="M11.6068 21.9998H12.3937C15.1012 21.9998 16.4549 21.9998 17.3351 21.1366C18.2153 20.2734 18.3054 18.8575 18.4855 16.0256L18.745 11.945C18.8427 10.4085 18.8916 9.6402 18.45 9.15335C18.0084 8.6665 17.2628 8.6665 15.7714 8.6665H8.22905C6.73771 8.6665 5.99204 8.6665 5.55047 9.15335C5.10891 9.6402 5.15777 10.4085 5.25549 11.945L5.515 16.0256C5.6951 18.8575 5.78515 20.2734 6.66534 21.1366C7.54553 21.9998 8.89927 21.9998 11.6068 21.9998Z" fill="#1C274C"></path>
                        </svg>
                      </button>';
			$html .= '</div>';
		}
	}
	$html .= '</div>';

	return $html;
}

// Enregistre le shortcode
add_shortcode('post_gallery_edit', 'custom_gallery_with_delete');



function delete_gallery_image_ajax() {
	if (isset($_POST['image_id'])) {
		$image_id = intval($_POST['image_id']);
		$post_id = intval($_POST['post_id']);

		// Vérification des permissions de l'utilisateur
		if (current_user_can('delete_post', $post_id)) {
			// Supprimer l'image
			wp_delete_attachment($image_id, true);

			// Mise à jour des IDs de la galerie dans le champ
			$gallery_ids = get_field('post_home_gallery_ids', $post_id);
			if ($gallery_ids) {
				$gallery_ids = array_diff(explode(',', $gallery_ids), [$image_id]);
				update_field('post_home_gallery_ids', implode(',', $gallery_ids), $post_id);
			}

			wp_send_json_success('Image deleted successfully.');
		} else {
			wp_send_json_error('Permission denied.');
		}
	} else {
		wp_send_json_error('No image ID provided.');
	}
}
add_action('wp_ajax_delete_gallery_image', 'delete_gallery_image_ajax');
add_action('wp_ajax_nopriv_delete_gallery_image', 'delete_gallery_image_ajax');
