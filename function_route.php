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
	<div class="custom-gallery-wrapper manage-post-media">

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
				<i style="color: #888;">No images in the gallery.</i>
			<?php endif; ?>
		</div>

		<!-- Formulaire pour ajouter de nouvelles images -->
		<h4 style="font-family: Arial, sans-serif; color: #333; text-align: center; margin: 20px 0;">Add Images</h4>
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
				class="btn btn--ghost"
				style="margin-top: 15px; padding: 10px 20px; background-color: #0073aa; color: white; border: none;   font-size: 14px; cursor: pointer;"
			>
				Save
			</button> <br>
			<i style="margin-top: 10px; font-size: 12px; color: #888;">
				Extensions allowed : <?php echo esc_html($atts['allowed_extensions']); ?>.
			</i>

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
							document.getElementById('gallery-upload').value = '';

							alert('Images added.');

							// Charger dynamiquement les nouvelles images
							data.data.images.forEach(image => {
								const galleryContainer = document.querySelector('.custom-gallery_a');
								const imageElement = document.createElement('div');
								imageElement.classList.add('gallery-item_a');
								imageElement.setAttribute('data-id', image.id);
								imageElement.setAttribute('data-id-post', postId);
								imageElement.style.position = 'relative';
								imageElement.style.display = 'inline-block';

								// Ajouter l'image
								imageElement.innerHTML = `
						<img src="${image.url}" width="300" height="200" style="border: 1px solid #ddd; border-radius: 5px;">
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
		$image_data = []; // Nouveau tableau pour stocker les URLs et les IDs des images ajoutées

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

				// Ajouter les données de l'image (ID et URL) au tableau $image_data
				$image_data[] = [
					'id' => $attachment_id,
					'url' => wp_get_attachment_image_url($attachment_id, 'thumbnail'),
				];
			}
		}

		if ($uploaded_ids) {
			// Mettre à jour les métadonnées du post avec les nouveaux IDs
			$current_images = get_post_meta($post_id, 'post_home_gallery_ids', true);
			$current_images_array = $current_images ? explode(',', $current_images) : [];
			$updated_images_array = array_unique(array_merge($current_images_array, $uploaded_ids));
			update_post_meta($post_id, 'post_home_gallery_ids', implode(',', $updated_images_array));

			// Renvoyer les données des images ajoutées
			wp_send_json_success([
				'message' => 'Images ajoutées avec succès.',
				'images' => $image_data,
			]);
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












//-------------------------------------------------------------------------------------------------------------
/**
 * MAIN PICTURE
 */
//-------------------------------------------------------------------------------------------------------------


// Shortcode pour gérer l'image principale
function shortcode_main_picture_manager($atts) {
    $atts = shortcode_atts([
        'post_id' => 0,
        'size' => 'thumbnail',
		'allowed_extensions' => 'jpg,png,jpeg',
		'is_profile' => false,
    ], $atts);

    $post_id = intval($atts['post_id']);
    $is_profile = 	 filter_var($atts["is_profile"], FILTER_VALIDATE_BOOLEAN);
    if (!$post_id) {
        return '<p>Post ID non spécifié ou invalide.</p>';
    }

    if (!current_user_can('edit_post', $post_id)) {
        return '<p>Vous n\'avez pas la permission de modifier ce post.</p>';
    }

    $current_main_image = get_post_meta($post_id, 'post_home_main_picture_ids', true);



    ob_start();
    ?>
    <div class="main-picture-wrapper" style="text-align: center; margin: 20px 0;">
        <h4 style=" ">Main Picture</h4>

        <!-- Afficher l'image principale actuelle -->
        <div id="main-picture-preview" style="margin-bottom: 20px;">
            <?php if ($current_main_image): ?>
                <div style="position: relative; display: inline-block;">
                    <?php echo wp_get_attachment_image($current_main_image, $atts['size'], false, ['style' => 'border: 1px solid #ddd; border-radius: 5px;']); ?>
                    <button
                        id="delete-main-picture-button"
                        data-id="<?php echo esc_attr($current_main_image); ?>"
                        data-post-id="<?php echo esc_attr($post_id); ?>"
                        data-is-profile="<?php echo esc_attr($is_profile); ?>"
                        style="position: absolute; top: -10px; right: -10px; background: #ff5f5f; color: white; border: none; border-radius: 50%; padding: 5px; cursor: pointer;"
                    >
                        &times;
                    </button>
                </div>
            <?php else: ?>
                <i style="color: #888;">No main picture set.</i>
            <?php endif; ?>
        </div>

        <!-- Formulaire pour changer l'image principale -->
        <form id="main-picture-form" data-post-id="<?php echo esc_attr($post_id); ?>" data-is-profile="<?php echo esc_attr($is_profile); ?>" style="text-align: center;">
            <input
                type="file"
                id="main-picture-upload"
                accept=".jpg,.png,.jpeg"
                style="margin-bottom: 10px; padding: 5px; border: 1px solid #ccc; border-radius: 5px; text-align: center;"
            > <br>
			<button   class="btn btn--ghost"  style="background-color: #0073aa ;    padding: 10px 20px;color: white;    border: none;  font-size: 14px;cursor: pointer;"
			type="button"
                id="set-main-picture-button"
                style="padding: 10px 20px; background-color: #0073aa; color: white; border: none; border-radius: 5px; cursor: pointer;"
            >
			Save
            </button><br>
			<i style="margin-top: 10px; font-size: 12px; color: #888;">
				Extensions allowed : <?php echo esc_html($atts['allowed_extensions']); ?>.
			</i>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const postId = <?php echo esc_js($post_id); ?>;
			const  is_profile = <?php echo esc_js($is_profile); ?>
            // Ajouter une nouvelle image principale
            document.getElementById('set-main-picture-button').addEventListener('click', function () {
                const fileInput = document.getElementById('main-picture-upload');
                const file = fileInput.files[0];
                if (!file) {
                    alert('Veuillez sélectionner une image.');
                    return;
                }

                const formData = new FormData();
                formData.append('image', file);
                formData.append('action', 'set_main_picture');
                formData.append('post_id', postId);
                formData.append('is_profile', is_profile);

                fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Image principale mise à jour.');
                        const preview = document.getElementById('main-picture-preview');
                        preview.innerHTML = `
                            <div style="position: relative; display: inline-block;">
                                <img src="${data.data.url}" style="border: 1px solid #ddd; border-radius: 5px;">
                                <button
                                    id="delete-main-picture-button"
                                    data-id="${data.data.id}"
                                    data-post-id="${postId}"
                                    data-is-profile="${is_profile}"
                                    style="position: absolute; top: -10px; right: -10px; background: #ff5f5f; color: white; border: none; border-radius: 50%; padding: 5px; cursor: pointer;"
                                >
                                    &times;
                                </button>
                            </div>
                        `;

                        // Ajouter l'écouteur de suppression
                        addDeleteListener();
                    } else {
                        alert(data.data || 'Erreur lors de la mise à jour.');
                    }
                });
            });

            // Supprimer l'image principale
            function addDeleteListener() {
                const deleteButton = document.getElementById('delete-main-picture-button');
                if (!deleteButton) return;

                deleteButton.addEventListener('click', function () {
                    const imageId = this.dataset.id;

                    const formData = new FormData();
                    formData.append('action', 'delete_main_picture');
                    formData.append('post_id', postId);
                    formData.append('image_id', imageId);
                    formData.append('is_profile', is_profile);

                    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Image principale supprimée.');
                            document.getElementById('main-picture-preview').innerHTML = `
                                <i style="color: #888;">Aucune image principale définie.</i>
                            `;
                        } else {
                            alert(data.data || 'Erreur lors de la suppression.');
                        }
                    });
                });
            }

            // Initialiser l'écouteur de suppression au chargement
            addDeleteListener();
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('main_picture_manager', 'shortcode_main_picture_manager');

// AJAX : Définir l'image principale
function ajax_set_main_picture() {
    if (isset($_POST['post_id']) && !empty($_FILES['image'])) {
        $post_id = intval($_POST['post_id']);
		$is_profile = filter_var($_POST['is_profile'], FILTER_VALIDATE_BOOLEAN);

        if (!current_user_can('edit_post', $post_id)) {
            wp_send_json_error('Permission refusée.');
        }

        $file = $_FILES['image'];
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

			if ($is_profile) {
				$author_id = get_post_field('post_author', $post_id);

				update_user_meta($author_id, 'user_profile_picture', $attachment_id);
				update_user_meta($author_id, 'user_avatar_ids', $attachment_id);
			}
            update_post_meta($post_id, 'post_home_main_picture_ids', $attachment_id);

            wp_send_json_success([
                'message' => 'Image principale mise à jour.',
                'id' => $attachment_id,
                'url' => wp_get_attachment_image_url($attachment_id, 'thumbnail'),
            ]);
        }
    }

    wp_send_json_error('Erreur lors de l\'envoi de l\'image.');
}
add_action('wp_ajax_set_main_picture', 'ajax_set_main_picture');

// AJAX : Supprimer l'image principale
function ajax_delete_main_picture() {
    if (isset($_POST['post_id']) && isset($_POST['image_id'])) {
        $post_id = intval($_POST['post_id']);
        $image_id = intval($_POST['image_id']);
		$is_profile = filter_var($_POST['is_profile'], FILTER_VALIDATE_BOOLEAN);

        if (!current_user_can('edit_post', $post_id)) {
            wp_send_json_error('Permission refusée.');
        }

		if ($is_profile) {
			$author_id = get_post_field('post_author', $post_id);

			delete_user_meta($author_id, 'user_profile_picture');
			delete_user_meta($author_id, 'user_avatar_ids');
		}

        // Supprimer l'image de la méta
        delete_post_meta($post_id, 'post_home_main_picture_ids');

        // Supprimer l'attachement
        wp_delete_attachment($image_id, true);

        wp_send_json_success('Image principale supprimée.');
    }

    wp_send_json_error('Données invalides.');
}
add_action('wp_ajax_delete_main_picture', 'ajax_delete_main_picture');

