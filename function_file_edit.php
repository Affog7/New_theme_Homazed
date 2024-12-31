<?php
function manage_post_media_shortcode($atts) {
	$atts = shortcode_atts(
		array(
			'post_id' => 0, // ID du post
		),
		$atts,
		'manage_post_media'
	);

	$post_id = intval($atts['post_id']);
	if (!$post_id || get_post_type($post_id) !== 'homes') {
		return '<p class="error-message">Invalid post or missing ID.</p>';
	}

	$output = '<div class="manage-post-media"> <h4>File</h4>';

	// Récupérer l'ID du fichier joint (custom field 'post_home_join_file')
	$post_join_file_id = get_field('post_home_join_file', $post_id);
	$post_join_file = $post_join_file_id ? wp_get_attachment_url($post_join_file_id) : null;

	if ($post_join_file) {
		$output .= "
        <div class='file-info'>

            <form method='post'>
               <p>    <a href='$post_join_file' target='_blank'>" . basename($post_join_file) . "</a>


                <button type='submit' name='delete_file' class='btn btn-danger' style=' margin: 0px 0 10px 10px;background: #ff5f5f; color: white; border: none; border-radius: 50%;   cursor: pointer;'>
							×
				</button>
                </p>
            </form>
        </div>";
	} else {
		$output .= '
        <div class="no-file">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48" fill="#ffc107">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-3.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                <path d="M11 7h2v6h-2zm0 8h2v2h-2z"/>
            </svg>
            <p>No attached files.</p>
        </div>';
	}

	// Formulaire pour remplacer le fichier
	$output .= '
        <form method="post" enctype="multipart/form-data" class="manage-media-form">
            <div class="form-group">

                <input type="file" name="replace_file" id="replace_file" style="margin: 0 auto; padding: 5px; border: 1px solid #ccc; border-radius: 5px; display: block; width: 80%; max-width: 400px;">
            </div>
            <div class="form-group">
                <button type="submit" name="replace_file_submit" class="btn btn--ghost"  style="background-color: #0073aa ;    padding: 10px 20px;color: white;    border: none;  font-size: 14px;cursor: pointer;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                        <path d="M5 12H19M12 5L19 12L12 19" stroke="#ffffff" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Update
                </button>
            </div>
        </form>
    </div>';

	// Traitement des actions de formulaire
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (isset($_POST['delete_file']) && $post_join_file_id) {
			wp_delete_attachment($post_join_file_id, true);
			update_field('post_home_join_file', null, $post_id);
			$output .= '<p class="success-message">The file has been successfully deleted.</p>';
		}

		if (isset($_POST['replace_file_submit']) && isset($_FILES['replace_file'])) {
			$file = $_FILES['replace_file'];

			if ($file['error'] === UPLOAD_ERR_OK) {
				$upload = wp_handle_upload($file, array('test_form' => false));

				if (!isset($upload['error'])) {
					$attachment_id = wp_insert_attachment(
						array(
							'guid'           => $upload['url'],
							'post_mime_type' => $upload['type'],
							'post_title'     => basename($upload['file']),
							'post_content'   => '',
							'post_status'    => 'inherit',
						),
						$upload['file'],
						$post_id
					);

					require_once ABSPATH . 'wp-admin/includes/image.php';
					$attach_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
					wp_update_attachment_metadata($attachment_id, $attach_data);

					update_field('post_home_join_file', $attachment_id, $post_id);

					$output .= '<p class="success-message">The file has been successfully replaced.</p>';
				} else {
					$output .= '<p class="error-message">Error : ' . esc_html($upload['error']) . '</p>';
				}
			} else {
				$output .= '<p class="error-message">Error uploading.</p>';
			}
		}
	}

	return $output;
}
add_shortcode('manage_post_media', 'manage_post_media_shortcode');
