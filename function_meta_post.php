<?php 
add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/update-meta/', [
        'methods' => 'POST',
        'callback' => 'update_post_meta_via_rest',
        'args' => [
            'post_id' => [
                'required' => true,
                'validate_callback' => function ($param) {
                    return is_numeric($param);
                },
            ],
            'meta_key' => [
                'required' => true,
            ],
            'meta_value' => [
                'required' => true,
            ],
        ],
        'permission_callback' => function () {
            return current_user_can('edit_posts');
        },
    ]);
});

function update_post_meta_via_rest($data) {
    $post_id = $data['post_id'];
    $meta_key = $data['meta_key'];
    $meta_value = $data['meta_value'];

    if (!get_post($post_id)) {
        return new WP_Error('invalid_post', 'Le post n\'existe pas.', ['status' => 404]);
    }

    if (update_post_meta($post_id, $meta_key, $meta_value)) {
        return ['success' => true, 'message' => "Updated successfully"];
    } else {
        return new WP_Error('update_failed', 'Impossible de mettre à jour la meta valeur.', ['status' => 500]);
    }
}
