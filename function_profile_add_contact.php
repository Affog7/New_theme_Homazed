<?php
function toggle_contact() {
if (!isset($_POST['user_id']) || !isset($_POST['contact_id'])) {
wp_send_json_error("Requête invalide.");
}

$user_id = intval($_POST['user_id']);
$contact_id = intval($_POST['contact_id']);

// Récupérer la liste actuelle des contacts
$contact_list = get_field("i_request_contactlist_users_relationships", "user_".$user_id);

if (!is_array($contact_list)) {
$contact_list = [];
}

// Ajouter ou retirer le contact
if (in_array($contact_id, $contact_list)) {
$contact_list = array_diff($contact_list, [$contact_id]);
$status = "removed";
} else {
$contact_list[] = $contact_id;
$status = "added";
}

// Mettre à jour la meta
update_field("i_request_contactlist_users_relationships", array_values($contact_list), "user_".$user_id);

wp_send_json_success(["status" => $status, "updated_list" => $contact_list]);
}
add_action("wp_ajax_toggle_contact", "toggle_contact");
add_action("wp_ajax_nopriv_toggle_contact", "toggle_contact"); // Si accessible aux non-connectés
