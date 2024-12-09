<?php
// Shortcode pour gérer l'affichage, l'ajout et la suppression d'une vidéo via une URL
function shortcode_video_manager_url($atts) {
	$atts = shortcode_atts([
		'post_id' => 0,
		'allowed_extensions' => 'mp4,avi,mov',
	], $atts);

	$post_id = intval($atts['post_id']);
	if (!$post_id) {
		return '<p>Post ID not specified or invalid.</p>';
	}

	if (!current_user_can('edit_post', $post_id)) {
		return '<p>You do not have permission to edit this post.</p>';
	}

	// Récupérer l'URL actuelle de la vidéo
	$video_url = get_post_meta($post_id, 'post_home_video', true);

	ob_start();
	?>
	<div class="custom-video-wrapper" style="    margin-top: 25px;">
		<h4>Video</h4>

		<?php if ($video_url): ?>
			<div class="video-preview" style="margin-bottom: 20px;">
				<video controls style="max-width: 100%; border: 1px solid #ccc; border-radius: 5px;">
					<source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
					Your browser does not support video playback.
				</video>
				<button class="delete-video" data-post-id="<?php echo esc_attr($post_id); ?>" style="margin-top: 10px; padding: 10px; background: #ff5f5f; color: white; border: none; border-radius: 5px; cursor: pointer;">Delete Video</button>
			</div>
		<?php else: ?>
			<p>There is no video associated with this recording.</p>
		<?php endif; ?>

		<form id="video-upload-form" data-post-id="<?php echo esc_attr($post_id); ?>" style="margin-top: 20px;">
			<input type="file" id="video-upload" accept=".<?php echo str_replace(',', ',.', esc_attr($atts['allowed_extensions'])); ?>" style="padding: 5px;">
			<button type="button" id="video-upload-button" style="margin-left: 10px; padding: 10px; background: #0073aa; color: white; border: none; border-radius: 5px; cursor: pointer;">Add or Replace Video</button>
			<p style="font-size: 12px; color: #888; margin-top: 10px;">Extensions allowed: <?php echo esc_html($atts['allowed_extensions']); ?>.</p>
		</form>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const postId = <?php echo esc_js($post_id); ?>;

			// Suppression de la vidéo
			document.querySelector('.delete-video')?.addEventListener('click', function () {
				const formData = new FormData();
				formData.append('action', 'delete_video_url');
				formData.append('post_id', postId);

				fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
					method: 'POST',
					body: formData,
				})
					.then(response => response.json())
					.then(data => {
						if (data.success) {
							alert('Vidéo supprimée.');
							location.reload();
						} else {
							alert(data.data || 'Erreur lors de la suppression.');
						}
					});
			});

			// Ajout ou remplacement de la vidéo
			document.getElementById('video-upload-button').addEventListener('click', function () {
				const file = document.getElementById('video-upload').files[0];
				if (!file) {
					alert('Veuillez sélectionner une vidéo.');
					return;
				}

				const formData = new FormData();
				formData.append('action', 'add_replace_video_url');
				formData.append('video', file);
				formData.append('post_id', postId);

				fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
					method: 'POST',
					body: formData,
				})
					.then(response => response.json())
					.then(data => {
						if (data.success) {
							alert('Vidéo mise à jour.');
							location.reload();
						} else {
							alert(data.data || 'Erreur lors de la mise à jour.');
						}
					});
			});
		});
	</script>
	<?php
	return ob_get_clean();
}
add_shortcode('video_manager_url', 'shortcode_video_manager_url');

// AJAX : Ajouter ou remplacer une vidéo
function ajax_add_replace_video_url() {
	if (!empty($_FILES['video']) && isset($_POST['post_id'])) {
		$post_id = intval($_POST['post_id']);
		if (!current_user_can('edit_post', $post_id)) {
			wp_send_json_error('Permission refused.');
		}

		$file = $_FILES['video'];
		$upload = wp_handle_upload($file, ['test_form' => false]);

		if (isset($upload['error'])) {
			wp_send_json_error($upload['error']);
		}

		// Mettre à jour le champ post_home_video avec la nouvelle URL
		update_post_meta($post_id, 'post_home_video', $upload['url']);

		wp_send_json_success('Video added or replaced successfully.');
	}

	wp_send_json_error('No valid video found.');
}
add_action('wp_ajax_add_replace_video_url', 'ajax_add_replace_video_url');

// AJAX : Supprimer une vidéo
function ajax_delete_video_url() {
	if (isset($_POST['post_id'])) {
		$post_id = intval($_POST['post_id']);

		if (!current_user_can('edit_post', $post_id)) {
			wp_send_json_error('Permission refusée.');
		}

		delete_post_meta($post_id, 'post_home_video');

		wp_send_json_success('Video deleted successfully.');
	}

	wp_send_json_error('Invalid data.');
}
add_action('wp_ajax_delete_video_url', 'ajax_delete_video_url');
