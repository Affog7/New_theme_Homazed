<?php
function toggle_profile_recommend() {
	// Vérifier la requête AJAX
	if (!isset($_POST['post_id']) || !isset($_POST['user_id'])) {
		wp_send_json_error("Requête invalide.");
	}

	$post_id = intval($_POST['post_id']);
	$user_id = intval($_POST['user_id']);

	// Récupérer la liste actuelle des recommandations
	$recommended_users = get_post_meta($post_id, 'profile-recommend', true);

	if (!is_array($recommended_users)) {
		$recommended_users = [];
	}

	// Ajouter ou retirer l'utilisateur
	if (in_array($user_id, $recommended_users)) {
		$recommended_users = array_diff($recommended_users, [$user_id]);
		$status = "removed";
	} else {
		$recommended_users[] = $user_id;
		$status = "added";
	}

	// Mettre à jour la meta
	update_post_meta($post_id, 'profile-recommend', array_values($recommended_users));

	wp_send_json_success(["status" => $status, "updated_list" => $recommended_users]);
}
add_action("wp_ajax_toggle_profile_recommend", "toggle_profile_recommend");
add_action("wp_ajax_nopriv_toggle_profile_recommend", "toggle_profile_recommend"); // Si les utilisateurs non connectés doivent aussi pouvoir l'utiliser
