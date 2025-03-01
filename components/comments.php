<?php
global $post;
$post = get_post($args["post_id"]);
comments_template();

setup_postdata($post); // Ajoute cette ligne !
