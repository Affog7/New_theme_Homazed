<?php

//todo_alassane


function enqueue_custom_script() {
	// Enregistrez un script vide pour pouvoir utiliser `wp_localize_script`
	wp_register_script('custom-congratulations-script', false);

	// Déterminez l'URL de la page à rediriger
	$welcome_page = site_url('/welcome/');

	// Localisez le script uniquement pour le modèle `page-template-congratulations.php`
	if (is_page_template('page-template-congrats.php')) {
		wp_localize_script('custom-congratulations-script', 'pageData', array(
			'welcomePageUrl' => $welcome_page,
		));
		// Chargez le script localisé sur la page
		wp_enqueue_script('custom-congratulations-script');
	}
}
add_action('wp_enqueue_scripts', 'enqueue_custom_script');


function enqueue_custom_script_complete_profil() {
	// Enregistrez un script vide pour pouvoir utiliser `wp_localize_script`
	wp_register_script('custom-welcome-script', false);

	// Déterminez l'URL de la page à rediriger
	$connect_page = "https://homazed.oasiscrea.com/profile-resume/";

	// Localisez le script uniquement pour le modèle `page-template-congratulations.php`
	if (is_page_template('page-template-welcome.php')) {
		wp_localize_script('custom-welcome-script', 'pageData', array(
			'connect' => $connect_page,
		));
		// Chargez le script localisé sur la page
		wp_enqueue_script('custom-welcome-script');
	}
}
add_action('wp_enqueue_scripts', 'enqueue_custom_script_complete_profil');

add_filter('gform_field_content', 'customize_gf_required_label', 10, 2);

// function customize_gf_required_label($field_content, $field) {
// 	// Vérifie si le champ est requis
// 	if ($field->isRequired) {
// 		// Remplace "(required)" par un astérisque (*)
// 		$field_content = str_replace('(Required)', '<span class="gfield_required" style="color: red; font-weight: bold; margin-right: 5px;font-size: 19px;">*</span>', $field_content);
// 	}
// 	return $field_content;
// }

function customize_gf_required_label($field_content, $field) {
    // Vérifie si le champ est requis
    if ($field->isRequired) {
        // Si le type du champ est "Email" ou "Password", remplace "(Required)" par un vide
        if (in_array($field->type, ['email', 'password'])) {
            $field_content = str_replace('(Required)', '', $field_content);
        } else {
            // Pour tous les autres champs requis, remplace "(Required)" par un astérisque
            $field_content = str_replace(
                '(Required)',
                '<span class="gfield_required" style="color: red; font-weight: bold; margin-right: 5px; font-size: 19px;">*</span>',
                $field_content
            );
        }
    }
    return $field_content;
}

add_action('wp_ajax_verify_activation_code', 'verify_activation_code');
add_action('wp_ajax_nopriv_verify_activation_code', 'verify_activation_code');

function verify_activation_code() {
    // Assurez-vous que le code est envoyé.
    if (empty($_POST['key'])) {
        wp_send_json_error(['message' => 'Code is missing.']);
    }

    $code = sanitize_text_field($_POST['key']);

    // Exemple : récupérer le code d'activation d'un utilisateur.
    // Remplacez cette partie par votre logique pour valider le code.
   /* global $wpdb;
    $table = $wpdb->prefix . 'signups';
    $signup = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE activation_key = %s", $code));

    if (!$signup) {
        wp_send_json_error(['message' => 'Invalid activation code.']);
    }*/

    // Activer l'utilisateur (Gravity Forms ou autre logique d'activation).
    $result = GFUserSignups::activate_signup($code);

    if (is_wp_error($result)) {
        wp_send_json_error(['message' => $result->get_error_message()]);
    }

    wp_send_json_success(['message' => 'User activated successfully.', 'redirect_url' => home_url('/welcome-page')]);
}

add_filter('gform_field_validation', function ($result, $value, $form, $field) {
    // Vérifiez si le champ est celui ciblé (ID du formulaire et ID du champ)
    if ($form['id'] == 2 && $field->id == 49 && !$result['is_valid']) {
        // Utilisez la valeur saisie par l'utilisateur dans le message personnalisé
        $result['message'] = "The profile name '{$value}' is already in use.";
    }
    return $result;
}, 10, 4);







