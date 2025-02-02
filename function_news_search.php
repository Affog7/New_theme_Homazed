<?php
add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/posts', array(
        'methods' => 'GET',
        'callback' => 'get_prepopulated_templates_by_title',
    ));
});

function get_prepopulated_templates_by_title(WP_REST_Request $request) {
    $search_query = $request->get_param('search'); // Récupérer le paramètre de recherche

    // Arguments de la requête pour les posts
    $args = array(
        'post_type' => ['homes', 'jobs', 'projects'],
        's' => $search_query,
        'posts_per_page' => -1,
    );

    $posts = get_posts($args);
    $templates = array();

    if (empty($posts)) {
        return new WP_Error('no_posts_found', 'No posts found for the given title.', array('status' => 404));
    }

    foreach ($posts as $post) {
        setup_postdata($post);

        // Déterminer le type de post
        $post_type = get_post_type($post);

        // Buffer le contenu pour capturer le template rendu
        ob_start();

        // Inclure le template approprié en fonction du type de post

        get_template_part('components/news/map-popup-'.$post_type,null, array(
            'id' => $post->ID
        ));


        $template_content = ob_get_clean(); // Récupérer le contenu du buffer

        // Ajouter le contenu du template au tableau avec des informations supplémentaires
        $templates[] = array(
            'title' => get_the_title($post),
            'content' => $template_content,
            'type' => $post_type,
            'id' => $post->ID,
        );
    }

    wp_reset_postdata();

    return $templates;
}
