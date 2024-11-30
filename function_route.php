<?php
// Shortcode combiné pour gérer l'ajout et la suppression d'images
function shortcode_gallery_manager($atts) {
	$atts = shortcode_atts([
		'post_id' => 0,
		'max_images' => 10,
		'size' => 'thumbnail',
		'allowed_extensions' => 'jpg,png,jpeg',
	], $atts);

	$post_id = intval($atts['post_id']);
	if (!$post_id) {
		return '<p>Post ID non spécifié ou invalide.</p>';
	}

	if (!current_user_can('edit_post', $post_id)) {
		return '<p>Vous n\'avez pas la permission de modifier ce post.</p>';
	}

	$current_images = get_post_meta($post_id, 'post_home_gallery_ids', true);
	$current_images = $current_images ? array_filter(array_map('intval', explode(',', $current_images))) : [];

	ob_start();
	?>
	<div class="custom-gallery-wrapper">
		<h4 style="font-family: Arial, sans-serif; color: #333; text-align: center; margin-bottom: 20px;">Gérer la Galerie</h4>

		<!-- Affichage des images existantes avec boutons de suppression -->
		<div class="custom-gallery_a" style="display: flex; flex-wrap: wrap; gap: 10px; justify-content: center;">
			<?php if ($current_images): ?>
				<?php foreach ($current_images as $image_id): ?>
					<div class="gallery-item_a" data-id="<?php echo esc_attr($image_id); ?>" data-id-post="<?php echo esc_attr($post_id); ?>" style="position: relative; display: inline-block;">
						<?php echo wp_get_attachment_image($image_id, $atts['size'], false, ['style' => 'border: 1px solid #ddd; border-radius: 5px;']); ?>
						<button class="delete-image_a" data-id="<?php echo esc_attr($image_id); ?>" style="position: absolute; top: -5px; right: -5px; background: #ff5f5f; color: white; border: none; border-radius: 50%; padding: 5px; cursor: pointer;">
							&times;
						</button>
					</div>
				<?php endforeach; ?>
			<?php else: ?>
				<p style="color: #888;">Aucune image dans la galerie.</p>
			<?php endif; ?>
		</div>

		<!-- Formulaire pour ajouter de nouvelles images -->
		<h4 style="font-family: Arial, sans-serif; color: #333; text-align: center; margin: 20px 0;">Ajouter des Images</h4>
		<form id="gallery-upload-form" data-post-id="<?php echo esc_attr($post_id); ?>" style="text-align: center; margin-bottom: 20px;">
			<input
				type="file"
				id="gallery-upload"
				multiple
				accept=".<?php echo str_replace(',', ',.', esc_attr($atts['allowed_extensions'])); ?>"
				style="margin: 0 auto; padding: 5px; border: 1px solid #ccc; border-radius: 5px; display: block; width: 80%; max-width: 400px;"
			>
			<button
				type="button"
				id="gallery-upload-button"
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
			const postId = <?php echo esc_js($post_id); ?>;

			// Suppression d'image
			document.querySelectorAll('.delete-image_a').forEach(button => {
				button.addEventListener('click', function () {
					const imageId = this.dataset.id;
					const formData = new FormData();
					formData.append('action', 'delete_gallery_image');
					formData.append('image_id', imageId);
					formData.append('post_id', postId);

					fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
						method: 'POST',
						body: formData,
					})
						.then(response => response.json())
						.then(data => {
							if (data.success) {
								alert('Image supprimée.');
								this.closest('.gallery-item_a').remove();
							} else {
								alert(data.data || 'Erreur lors de la suppression.');
							}
						});
				});
			});

			// Ajout d'images
			document.getElementById('gallery-upload-button').addEventListener('click', function () {
				const files = document.getElementById('gallery-upload').files;
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
							alert('Images ajoutées.');

							// Charger dynamiquement les nouvelles images
							data.images.forEach(image => {
								const galleryContainer = document.querySelector('.custom-gallery_a');
								const imageElement = document.createElement('div');
								imageElement.classList.add('gallery-item_a');
								imageElement.setAttribute('data-id', image.id);
								imageElement.setAttribute('data-id-post', postId);
								imageElement.style.position = 'relative';
								imageElement.style.display = 'inline-block';

								// Ajouter l'image
								imageElement.innerHTML = `
						<img src="${image.url}" style="border: 1px solid #ddd; border-radius: 5px;">
						<button class="delete-image_a" data-id="${image.id}" style="position: absolute; top: -5px; right: -5px; background: #ff5f5f; color: white; border: none; border-radius: 50%; padding: 5px; cursor: pointer;">
							&times;
						</button>
					`;
								galleryContainer.appendChild(imageElement);

								// Ajouter l'écouteur pour suppression
								imageElement.querySelector('.delete-image_a').addEventListener('click', function () {
									const imageId = this.dataset.id;
									const formData = new FormData();
									formData.append('action', 'delete_gallery_image');
									formData.append('image_id', imageId);
									formData.append('post_id', postId);

									fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
										method: 'POST',
										body: formData,
									})
										.then(response => response.json())
										.then(data => {
											if (data.success) {
												alert('Image supprimée.');
												this.closest('.gallery-item_a').remove();
											} else {
												alert(data.data || 'Erreur lors de la suppression.');
											}
										});
								});
							});
						} else {
							alert(data.data || 'Erreur lors de l\'ajout.');
						}
					});
			});
		});

	</script>
	<?php
	return ob_get_clean();
}
add_shortcode('gallery_manager', 'shortcode_gallery_manager');

// AJAX : Ajouter des images
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

// AJAX : Supprimer une image
function ajax_delete_gallery_image() {
	if (isset($_POST['image_id']) && isset($_POST['post_id'])) {
		$image_id = intval($_POST['image_id']);
		$post_id = intval($_POST['post_id']);

		if (!current_user_can('delete_post', $post_id)) {
			wp_send_json_error('Permission refusée.');
		}

		wp_delete_attachment($image_id, true);

		$current_images = get_post_meta($post_id, 'post_home_gallery_ids', true);
		$current_images_array = $current_images ? explode(',', $current_images) : [];
		$updated_images_array = array_diff($current_images_array, [$image_id]);
		update_post_meta($post_id, 'post_home_gallery_ids', implode(',', $updated_images_array));

		wp_send_json_success('Image supprimée avec succès.');
	}

	wp_send_json_error('Données invalides.');
}
add_action('wp_ajax_delete_gallery_image', 'ajax_delete_gallery_image');
