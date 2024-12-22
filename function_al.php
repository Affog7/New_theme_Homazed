<?php

//todo_alassane


function enqueue_custom_script() {
	// Enregistrez un script vide pour pouvoir utiliser `wp_localize_script`
	wp_register_script('custom-congratulations-script', false);

	// Déterminez l'URL de la page à rediriger
	$welcome_page = "https://homazed.oasiscrea.com/welcome/";


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



add_action('wp_ajax_check_profile_name', 'check_profile_name');
add_action('wp_ajax_nopriv_check_profile_name', 'check_profile_name');

function check_profile_name() {
    global $wpdb;

    // Vérifier que le paramètre 'profile_name' est fourni
    if (isset($_POST['profile_name'])) {
        $profile_name = sanitize_text_field($_POST['profile_name']);

        // Rechercher le profil dans la base de données (table `wp_users`)
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM wp_users WHERE display_name = %s",
            $profile_name
        ));

        if ($exists > 0) {
            wp_send_json(['exists' => true]);
        } else {
            wp_send_json(['exists' => false]);
        }
    } else {
        wp_send_json(['error' => 'No profile name provided'], 400);
    }

    wp_die(); // Terminer proprement la requête AJAX
}


function enqueue_profile_name_validation_script() {
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            var profileInput = document.getElementById('input_2_49');
            var messageContainer = document.createElement('div');
            messageContainer.style.marginTop = '10px';
            messageContainer.style.fontSize = '12px';

            if(profileInput) profileInput.parentNode.appendChild(messageContainer);

            // Fonction pour valider le profil name
            function validateProfileName(profileName) {
                // Réinitialiser le message
                messageContainer.textContent = '';
                messageContainer.style.color = '';

                if (profileName.length > 0) {
                    // Effectuer une requête AJAX pour vérifier le profil name
                    fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'action=check_profile_name&profile_name=' + encodeURIComponent(profileName),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            messageContainer.textContent = 'The profile name is already taken';
                            messageContainer.style.color = 'red';
                        } else {
                            messageContainer.textContent = 'Profile name is available.';
                            messageContainer.style.color = 'green';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            }

            if(profileInput) {
                    // Vérification initiale si le champ contient déjà une valeur
                if (profileInput.value.length > 0) {
                    validateProfileName(profileInput.value);
                }

                // Observer les changements dynamiques
                var lastValue = profileInput.value;
                setInterval(function () {
                    if (profileInput.value !== lastValue) {
                        lastValue = profileInput.value;
                        validateProfileName(lastValue);
                    }
                }, 500); // Vérification toutes les 500 ms

                // Ajouter un écouteur pour les modifications manuelles
                profileInput.addEventListener('input', function () {
                    validateProfileName(profileInput.value);
                });
            }
            
        });
    </script>
    <?php
}
add_action('wp_footer', 'enqueue_profile_name_validation_script');



/*add_action('wp_ajax_send_custom_email', 'send_custom_email_callback');
add_action('wp_ajax_nopriv_send_custom_email', 'send_custom_email_callback');

function send_custom_email_callback() {
    // Vérifie si les données sont envoyées
    if (isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['message'])) {
        $email = sanitize_email($_POST['email']);
        $subject = sanitize_text_field($_POST['subject']);
        $message = wp_kses_post($_POST['message']); // Pour sécuriser le HTML

        // Envoie l'email avec la fonction mail de WordPress
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $mail_sent = wp_mail($email, $subject, $message, $headers);
        
        if ($mail_sent) {
            wp_send_json_success(array('message' => 'Email envoyé avec succès.'));
        } else {
            wp_send_json_error(array('message' => 'Erreur lors de l\'envoi de l\'email.'));
        }
    } else {
        wp_send_json_error(array('message' => 'Données manquantes.'));
    }

    wp_die(); // Toujours appeler wp_die() après une requête AJAX.
}
*/






/*
add_action('wp_footer', 'validate_matching_fields_before_submit');
function validate_matching_fields_before_submit() {
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Ciblez le bouton de soumission du formulaire
            const submitButton = document.getElementById('gform_submit_button_2');

            if (submitButton) {
                submitButton.addEventListener('click', function (event) {
                    // Récupérez les valeurs des champs input_2_61 et input_2_54
                    const field1 = document.getElementById('input_2_61')?.value.trim();
                    const field2 = document.getElementById('input_2_54')?.value.trim();

                    // Vérifiez si les valeurs sont identiques
                    if (field1 !== field2) {
                        event.preventDefault(); // Empêche la soumission du formulaire
                        console.log("Les deux code");
                        console.log(field1);
                        console.log(field2);
                        alert("Les deux champs doivent avoir la même valeur avant de soumettre le formulaire.");
                        return false;
                    }
                });
            }
        });
    </script>
    <?php
}
*/