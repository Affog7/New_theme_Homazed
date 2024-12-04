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
	$connect_page = get_permalink("39");

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

function customize_gf_required_label($field_content, $field) {
	// Vérifie si le champ est requis
	if ($field->isRequired) {
		// Remplace "(required)" par un astérisque (*)
		$field_content = str_replace('(Required)', '<span class="gfield_required" style="color: red; font-weight: bold; margin-right: 5px;font-size: 19px;">*</span>', $field_content);
	}
	return $field_content;
}
