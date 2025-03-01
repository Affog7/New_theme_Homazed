<?php
function get_comments_template_content($request) {
	$post_id = $request->get_param('post_id');
	if (!$post_id) {
		return new WP_Error('missing_post_id', 'Le paramètre post_id est requis.', ['status' => 400]);
	}
	global $post;
	$post = get_post($post_id);

	setup_postdata($post); // Ajoute cette ligne !

	ob_start();
	get_template_part("components/comments", null, array(
		"post_id" => $post_id));
	$comments_content = ob_get_clean();

	wp_reset_postdata(); // Et celle-ci pour nettoyer après



	// Retourner le contenu capturé dans la réponse de l'API
	return rest_ensure_response(['comments_content' => $comments_content]);
}

// Enregistrer l'endpoint de l'API REST
add_action('rest_api_init', function () {
	register_rest_route('custom/v1', '/comments-template/', [
		'methods'  => 'GET',
		'callback' => 'get_comments_template_content',
		'args'     => [
			'post_id' => [
				'required' => true,
				'validate_callback' => function ($param) {
					return is_numeric($param);
				}
			]
		],
		'permission_callback' => '__return_true' // Modifier selon les besoins pour la sécurité
	]);
});
