<?php

function enable_comments_for_gravity_forms_posts($post_id) {
    $post_type = get_post_type($post_id);

    // Vérifiez si le type de contenu est celui créé par Gravity Forms
    if ($post_type === 'post' || $post_type === 'page') { // Remplacez par le type exact utilisé
        wp_update_post([
            'ID' => $post_id,
            'comment_status' => 'open',
        ]);
    }
}
add_action('gform_post_submission', 'enable_comments_for_gravity_forms_posts', 10, 2);


function comment_support_for_my_custom_post_type() {
    add_post_type_support( 'homes', 'comments' );
}
add_action( 'init', 'comment_support_for_my_custom_post_type' );