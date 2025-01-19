<?php
/**
 * Set up theme defaults and registers support for various WordPress feaures.
 */


/**
 * Enqueue scripts and styles.
 */
function enqueue_scripts()  {

	$theme = wp_get_theme();
	$theme_version = strval($theme->get( 'Version' ));

	// get the theme directory CSS and link to it in the header
	wp_enqueue_style('style', get_stylesheet_directory_uri() . '/dist/css/app.css', array(), $theme_version);

	// add theme scripts
	wp_enqueue_script( 'script', get_template_directory_uri() . '/dist/js/app.js', array(), $theme_version , true );

	wp_enqueue_style( 'leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css');

}
add_action( 'wp_enqueue_scripts', 'enqueue_scripts');



function get_language_shortcode() {
	return apply_filters( 'wpml_current_language', null );
}
add_shortcode( 'language', 'get_language_shortcode' );

function get_time_ago($time) {
	$time_difference = time() - $time;

	$my_current_lang = apply_filters( 'wpml_current_language', NULL );

	if($time_difference < 1) {
		if ( $my_current_lang == 'fr' ){
			return 'Il y a moins d\'une seconde';
		} elseif ( $my_current_lang == 'en' ){
			return 'less than 1 second ago';
		}
	}

	$condition = array(
		12 * 30 * 24 * 60 * 60 => __('year', "homazed"),
		30 * 24 * 60 * 60 => __('month', "homazed"),
		24 * 60 * 60 => __('day', "homazed"),
		60 * 60 => __('hour', "homazed"),
		60 =>  __('minute', "homazed"),
		1 =>  __('second', "homazed")
	);

	foreach($condition as $secs => $str) {
		$d = $time_difference / $secs;

		if($d >= 1) {
			$t = round( $d );
			if ( $my_current_lang == 'fr' ){
				return 'Il y a ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' );
			} elseif ( $my_current_lang == 'en' ){
				return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
			}
		}
	}
}

/**
 * Move Yoast to bottom in admin pages
 */
function yoasttobottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');

/**
 * Allow feature images on following objects
 */
add_theme_support('post-thumbnails', array(
	'post',
	'page',
	'collections', // Your CPT
));

/**
 * Change admin logo
 */
function wpm_login_style() { ?>
	<style type="text/css">
		#login h1 a, .login h1 a {
			background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/src/images/design/heading.png);
			background-size: 200px;
			width:100%;
		}
	</style>
<?php }
add_action( 'login_enqueue_scripts', 'wpm_login_style' );

/**
 * Images-Images-Images-Images-Images-Images sizes-sizes-sizes-sizes-sizes-sizes
 */
add_image_size( 'large-img-big', 1000, 958 );
add_image_size( 'large-img-big@2x', 2000, 1916 );

add_image_size( 'large-img-medium', 600, 400, array( 'center', 'center' ) );
add_image_size( 'large-img-medium@2x', 1200, 800, array( 'center', 'center' ) );

add_image_size( 'content-img', 418, 9999 );
add_image_size( 'content-img@2x', 836, 9999 );

/**
 * REMOVE-REMOVE-REMOVE-REMOVE-REMOVE-REMOVE-REMOVE-REMOVE-REMOVE-REMOVE-REMOVE-
 * REMOVE-REMOVE-REMOVE-REMOVE-REMOVE-REMOVE-REMOVE-REMOVE- WP-default-objects

 *
 * Remove the content editor from ALL pages - Please use ACF
 */
function remove_content_editor()
{
	remove_post_type_support('page', 'editor');
}
add_action('admin_head', 'remove_content_editor');

/**
 * Remove Gutenberg Block Library CSS from loading on the frontend
 */
// function smartwp_remove_wp_block_library_css(){
// 	wp_dequeue_style( 'wp-block-library' );
// 	wp_dequeue_style( 'wp-block-library-theme' );
// 	wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS
//    }
// add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );

/**
 * Remove classic theme css
 */
// function mywptheme_child_deregister_styles() {
// 	wp_dequeue_style( 'classic-theme-styles' );

// }
// add_action( 'wp_enqueue_scripts', 'mywptheme_child_deregister_styles', 20 );

/**
 *  Remove WISIWIG for CPT
 */
add_action('init', 'init_remove_support', 100);
function init_remove_support(){
	$post_type = 'projet';
	remove_post_type_support( $post_type, 'editor');
}

/**
 *  Remove comments from entire admin
 */
/**
 * Personnaliser la gestion des commentaires
 */
// add_action('admin_init', function () {
//     global $pagenow;

//     // Autoriser l'accès à la page des commentaires
//     if ($pagenow === 'edit-comments.php') {
//         // Ne pas rediriger
//     }

//     // Garder les commentaires pour les articles mais pas pour les autres types de contenu
//     foreach (get_post_types() as $post_type) {
//         if ($post_type !== 'post' && post_type_supports($post_type, 'comments')) {
//             //remove_post_type_support($post_type, 'comments');
//             //remove_post_type_support($post_type, 'trackbacks');
//         }
//     }
// });

// Restaurer les commentaires sur le front-end
/*add_filter('comments_open', function ($open, $post_id) {
    $post = get_post($post_id);

    // Autoriser les commentaires uniquement pour les articles
    if ($post->post_type === 'post') {
        return true;
    }
    return $open;
}, 20, 2);*/

// Ne pas masquer les commentaires existants
/*remove_filter('comments_array', '__return_empty_array', 10);

// Rétablir les commentaires dans le menu
add_action('admin_menu', function () {
    add_menu_page(
        __('Commentaires'),
        __('Commentaires'),
        'manage_options',
        'edit-comments.php',
        '',
        'dashicons-admin-comments',
        25
    );
});*/

// Rétablir l'icône des commentaires dans la barre d'administration
// add_action('init', function () {
//     if (is_admin_bar_showing()) {
//         add_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
//     }
// });


/**
 * Remove the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		/** This filter is documented in wp-includes/formatting.php */
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

		$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}

	return $urls;
}

/**
 * Prevent access to wp-admin
 */
// function remove_read_wpse_93843(){
//     $role = get_role( 'subscriber' );
//     $role->remove_cap( 'read' );
// }
// add_action( 'admin_init', 'remove_read_wpse_93843' );

/**
 * Hide WordPress toolbar
 */
function wpc_show_admin_bar() {
	return false;
}
add_filter('show_admin_bar' , 'wpc_show_admin_bar');

/**
 * Redirect logins to homepage
 */
// function redirect_sub_to_home_wpse_93843( $redirect_to, $request, $user ) {
//     if ( isset($user->roles) && is_array( $user->roles ) ) {
//       if ( in_array( 'subscriber', $user->roles ) ) {
//           return home_url( );
//       }
//     }
//     return $redirect_to;
// }
// add_filter( 'login_redirect', 'redirect_sub_to_home_wpse_93843', 10, 3 );

// Stop WordPress from logging you out
function keep_me_logged_in_for_1_year( $expirein ) {
	return 31556926; // 1 year in seconds
}
add_filter( 'auth_cookie_expiration', 'keep_me_logged_in_for_1_year' );


// Remove the default styles for Advanced Forms
// function form_remove_default_styles() {
//   // Remove default Advanced Forms styles
//   wp_dequeue_style( 'af-form-style' );
//   wp_dequeue_style( 'af-form-style' );

//   // Remove default ACF styles
//   wp_dequeue_style( 'acf-input' );
//   wp_dequeue_style( 'acf-pro-input' );
// }
// add_action( 'af/form', 'form_remove_default_styles' );

function unqueue_af_css() {
	wp_deregister_style('acf-input');
	wp_dequeue_script('form.css');
}
add_action( 'wp_enqueue_scripts', 'unqueue_af_css', 9999 );

// function prefill_form_field( $value, $field, $form, $args ) {
//     return 'Pre-filled value';
// }
// add_filter( 'af/field/prefill_value/key=form_6629f57e7b669', 'prefill_form_field', 10, 4 );

function form_sign_in_user( $user ) {
	wp_set_auth_cookie( $user->ID );
}
add_action( 'af/form/editing/user_created/key=form_6629f57e7b669', 'form_sign_in_user', 10, 1 );

// Login page
function frontend_user_manager_init() {
	add_shortcode( 'frontend-login-form', 'frontend_login_form' );
}
add_action('init', 'frontend_user_manager_init');

/**
 * Print a login form or current user login
 *
 * @param array $atts An array of arguments
 * @return string The form mark-up or the current user login
 */
function frontend_login_form( $atts ){
	if( ! is_user_logged_in() ){
		$args = array(
			'echo'			=> false,
			'remember'		=> true,
			'redirect'		=> get_permalink("468"),
			'form_id'		=> 'loginform',
			'id_username'		=> 'user_login',
			'id_password'		=> 'user_pass',
			'id_remember'		=> 'rememberme',
			'id_submit'		=> 'wp-submit',
			'label_username'	=> __( 'Mail address' ),
			'label_password'	=> __( 'Password' ),
			'label_remember'	=> __( 'Remember Me' ),
			'label_log_in'		=> __( 'Connect' ),
			'value_username'	=> '',
			'value_remember'	=> false
		);
		$output = wp_login_form( $args );
	}else{
		$current_user = wp_get_current_user();
		$output = '<p>' . sprintf( __( 'Howdy %s' ), $current_user->user_login ) . '</p>';
		$output .= '<p>' . wp_loginout( get_permalink(), false ) . '</p>';
	}
	return $output;
}

function custom_excerpt_settings( $length ) {
	return 26; // Change 30 to the desired excerpt length.
}
add_filter( 'excerpt_length', 'custom_excerpt_settings', 999 );

function custom_excerpt_more( $more ) {
	return '... <a class="read-more" href="' . get_permalink() . '">read more</a>'; // Custom "Read more" link.
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );

add_action( 'login_form_middle', 'add_lost_password_link' );
function add_lost_password_link() {
	$referrer = $_SERVER['PHP_SELF'];
	return '<a class="reset-password" href="' . add_query_arg('action', 'lostpassword', get_permalink( 39 )) . '">Forgotten Password?</a>';
}

function custom_login_fail( $username ) {
	$referrer = $_SERVER['HTTP_REFERER'];
	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
		wp_redirect( add_query_arg('login', 'failed', $referrer) );
		exit;

	}
}
add_action( 'wp_login_failed', 'custom_login_fail' );

// Process shortcodes in text widgets
add_filter('widget_text', 'do_shortcode');

// Add "user_id" to the query variable list
function add_user_id_query_var( $vars ) {
	$vars[] = 'user_id';
	return $vars;
}
add_filter( 'query_vars', 'add_user_id_query_var' );

// Update password from a form field
add_action( 'af/form/editing/user_updated', function ( $user, $form, $args ) {
	// If we aren't handling the desired form, return early.
	if ( $form['key'] !== 'form_662a2fcf5ed6a' ) {
		return;
	}

	// Get the password from the submitted field.
	$password = af_get_field("user_password");

	// Set the password for the user. Note that this will log the user out.
	wp_set_password( $password, $user->ID );

	// Set the auth cookie so the user is logged back in immediately.
	wp_set_auth_cookie( $user->ID );
}, 10, 3 );


register_taxonomy('usertags', 'user', array(
	'public'        =>true,
	'labels'        =>array(
		'name'                      =>'User Tags',
		'singular_name'             =>'User tag',
		'menu_name'                 =>'User Tags',
		'search_items'              =>'Search user Tags',
		'popular_items'             =>'Popular user Tags',
		'all_items'                 =>'All user Tags',
		'edit_item'                 =>'Edit user Tag',
		'update_item'               =>'Update user Tag',
		'add_new_item'              =>'Add New user Tag',
		'new_item_name'             =>'New user Tag Name',
		'separate_items_with_commas'=>'Separate user tags with commas',
		'add_or_remove_items'       =>'Add or remove user tags',
		'choose_from_most_used'     =>'Choose from the most popular user tags',
		'show_in_rest' => false,
		'show_admin_column' => false
	),
	'rewrite'       =>array(
		'with_front'                =>true,
		'slug'                      =>'author/user_tag',
	),
	'capabilities'  => array(
		'manage_terms'              =>'edit_users',
		'edit_terms'                =>'edit_users',
		'delete_terms'              =>'edit_users',
		'assign_terms'              =>'edit_users',
	),
));

register_taxonomy('posttags', 'homes', array(
	'public'        =>true,
	'labels'        =>array(
		'name'                      =>'Post Tags',
		'singular_name'             =>'Post tag',
		'menu_name'                 =>'Post Tags',
		'search_items'              =>'Search post Tags',
		'popular_items'             =>'Popular post Tags',
		'all_items'                 =>'All post Tags',
		'edit_item'                 =>'Edit post Tag',
		'update_item'               =>'Update post Tag',
		'add_new_item'              =>'Add New post Tag',
		'new_item_name'             =>'New post Tag Name',
		'separate_items_with_commas'=>'Separate post tags with commas',
		'add_or_remove_items'       =>'Add or remove post tags',
		'choose_from_most_used'     =>'Choose from the most popular post tags',
	),
	'rewrite'       =>array(
		'with_front'                =>true,
		'slug'                      =>'author/post_tag',
	),
	'capabilities'  => array(
		'manage_terms'              =>'manage_categories',
		'edit_terms'                =>'manage_categories',
		'delete_terms'              =>'manage_categories',
		'assign_terms'              =>'edit_posts',
	),
));



add_action('af/form/submission', 'user_tags_insertion', 10, 3);
function user_tags_insertion($form, $fields, $entry_id) {
	if ($form['key'] == 'form_662b6947a88b6') {
		// Replace 'your_field_name' with the name of the field that contains the term name
		$tags = af_get_field( 'user_tags_text' );
		$tags_array = explode(" #", $tags);
		// $user = get_user_by('id', $entry_id['user']);
		// $user_init_terms = get_the_terms($entry_id['user'], 'usertags');

		// die(var_dump($tags_array));

		// empty all relation between tags an users
		wp_set_object_terms( $entry_id['user'], array(), 'usertags', false );

		if (!empty($tags)) {
			foreach ($tags_array as $i => $tag) {
				$term_name = str_replace('#', '', $tag);
				$term = term_exists($term_name, 'usertags');

				if ($term === null) {
					// Term doesn't exist, so create it
					$term = wp_insert_term($term_name, 'usertags');
				}

				// Check if term creation or existence check was successful
				if (!is_wp_error($term)) {
					$term_id = is_array($term) ? $term['term_id'] : $term;

					// Assign the term to the user
					wp_set_object_terms($entry_id['user'], intval($term_id), 'usertags', true);
				}
			}
		}
	}
}

add_action( 'af/form/editing/post_created', 'post_tags_insertion', 20, 3 );
function post_tags_insertion($post, $form, $args) {
	if ($form['key'] == 'form_665ec37c06e30') {
		// Replace 'your_field_name' with the name of the field that contains the term name
		$tags = af_get_field( 'post_tags_text' );
		$tags_array = explode(" #", $tags);
		// $post = get_post( $entry_id );
		// $post_init_terms = get_the_terms($entry_id, 'tags');

		// empty all relation between tags an users
		wp_set_object_terms( $post->ID, array(), 'posttags', false );

		if (!empty($tags)) {
			foreach ($tags_array as $i => $tag) {
				$term_name = str_replace('#', '', $tag);
				$term = term_exists($term_name, 'posttags');

				if ($term === null) {
					// Term doesn't exist, so create it
					$term = wp_insert_term($term_name, 'posttags');
				}

				// Check if term creation or existence check was successful
				if (!is_wp_error($term)) {
					$term_id = is_array($term) ? $term['term_id'] : $term;

					// Assign the term to the user
					wp_set_object_terms($post->ID, intval($term_id), 'posttags', true);
				}
			}
		}
	}
}

function my_relationship_query( $args, $field, $post ) {
	// get posts for current logged in user
	$args['author'] = get_current_user_id();

	return $args;
}
add_filter('acf/fields/relationship/query/name=news_linked_post', 'my_relationship_query', 10, 3);

function filterFavoritesMap() {
	$user_id = $_POST['me_id'];
	$filter = $_POST['filter'];
	if($filter == "favorites"):
		$favoritesPostsIds = get_field("i_favorite_posts_relationships", "user_" . $user_id );
		$favoritesUsersIds = get_field("i_favorite_users_relationships", "user_" . $user_id );

		$ajaxposts = new WP_Query([
			"post_type" => "homes",
			"post_status" => "publish",
			"posts_per_page" => -1,
			"orderby" => "date",
			"order" => "DESC",
			'post__in' => $favoritesPostsIds
		]);
		$ajaxusers = new WP_User_Query([
			'role' => 'Subscriber',
			'orderby' => 'display_name',
			'include' => $favoritesUsersIds
		]);
	else:
		$ajaxposts = new WP_Query([
			"post_type" => "homes",
			"post_status" => "publish",
			"posts_per_page" => -1,
			"orderby" => "date",
			"order" => "DESC",
			'author' => $user_id,
		]);
		// $ajaxusers is empty here.
	endif;
	$response = '';
	$wall_content_for_map = [];

	if($ajaxposts->have_posts()) {
		while($ajaxposts->have_posts()) : $ajaxposts->the_post();
			$user_id = get_the_author_meta('ID');
			if( !empty(get_field("post_location")["markers"][0]["label"]) ){
				$address = get_field("post_location")["markers"][0]["label"];
			}else{
				$address = "Not well defined";
			}
			$post_id = get_the_ID();

			if(is_array(get_field("post_home_category"))){
				$post_category = get_field("post_home_category", $post_id)["label"];
			}else{
				$post_category = get_field("post_home_category", $post_id);
			}

			if( !empty(get_field("post_location", $post_id)["markers"][0]["label"]) ){
				$address = get_field("post_location", $post_id)["markers"][0]["label"];
				$lat = get_field("post_location", $post_id)["markers"][0]["lat"];
				$lng = get_field("post_location", $post_id)["markers"][0]["lng"];
			}else{
				$address = "Not well defined";
			}

			$post_for_map = [
				"id" => get_the_ID(),
				"title" => $post_category . " " . get_field("post_action", $post_id)['label'], // house type
				"post_type_slug" => "real-estate",
				"permalink" => get_the_permalink($post_id),
				"lat" => $lat,
				"lng" => $lng,
				"account_type" => null,
				"location" => $address,
				"price" => get_field("post_price", $post_id),
				"bedrooms" => get_field("post_number_of_bedrooms", $post_id),
				"bathrooms" => get_field("post_number_of_bathrooms", $post_id),
				"home_size" => get_field("post_home_size", $post_id),
				"outdoor_size" => get_field("post_outdoor_size", $post_id),
				"img" => get_field("post_pictures_display", $post_id)[0]['post_gallery_image']['sizes']['thumbnail']
			];
			array_push($wall_content_for_map, $post_for_map);
		endwhile;
	} else {
		$response = 'EmptyProducts';
	}

	$response = json_encode($wall_content_for_map);

	echo $response;
	exit;
}
add_action('wp_ajax_filterFavoritesMap', 'filterFavoritesMap');
add_action('wp_ajax_nopriv_filterFavoritesMap', 'filterFavoritesMap');


function filterFavoritesGrid() {
	$user_id = $_POST['me_id'];
	$filter = $_POST['filter'];
	if($filter == "favorites"):
		$favoritesPostsIds = get_field("i_favorite_posts_relationships", "user_" . $user_id );
		$favoritesUsersIds = get_field("i_favorite_users_relationships", "user_" . $user_id );

		$ajaxposts = new WP_Query([
			"post_type" => "homes",
			"post_status" => "publish",
			"posts_per_page" => -1,
			"orderby" => "date",
			"order" => "DESC",
			'post__in' => $favoritesPostsIds
		]);
		$ajaxusers = new WP_User_Query([
			'role' => 'Subscriber',
			'orderby' => 'display_name',
			'include' => $favoritesUsersIds
		]);
	else:
		$ajaxposts = new WP_Query([
			"post_type" => "homes",
			"post_status" => "publish",
			"posts_per_page" => -1,
			"orderby" => "date",
			"order" => "DESC",
			'author' => $user_id,
		]);
		// $ajaxusers is empty here.
	endif;
	$response = '';
	$wall_content = [];

	if($ajaxposts->have_posts()) {
		while($ajaxposts->have_posts()) : $ajaxposts->the_post();
			$user_id = get_the_author_meta('ID');
			$first_name = get_field("user_first_name", "user_" . $user_id);
			$last_name = get_field("user_last_name", "user_" . $user_id);
			if( !empty(get_field("post_location")["markers"][0]["label"]) ){
				$address = get_field("post_location")["markers"][0]["label"];
			}else{
				$address = "Not well defined";
			}
			$post_id = get_the_ID();
			$post_init_terms = get_the_terms($post_id, 'posttags');

			if(is_array(get_field("post_home_category"))){
				$post_category = get_field("post_home_category", $post_id)["label"];
			}else{
				$post_category = get_field("post_home_category", $post_id);
			}

			$post = [
				"id" => get_the_ID(),
				"title" => $post_category . " " . get_field("post_action", $post_id)['label'],
				"post_type" => "Homes",
				"post_type_slug" => "real-estate",
				"card_gallery" => get_field("post_gallery", $post_id),
				"card_gallery_display" => get_field("post_home_pictures_display", $post_id),
				"type" => get_field("post_action", $post_id),
				"home_category" => get_field("post_home_category", $post_id),
				"first_name" => $first_name,
				"last_name" => $last_name,
				"user_id" => get_the_author_meta('ID'),
				"profile_picture" => get_field("user_profile_picture", "user_".get_the_author_meta('ID')),
				"work_position" => get_field("user_current_work_position", "user_".get_the_author_meta('ID')),
				"main_picture" => get_field("post_main_picture", $post_id),
				"price" => get_field("post_price", $post_id),
				"bedrooms" => get_field("post_number_of_bedrooms", $post_id),
				"bathrooms" => get_field("post_number_of_bathrooms", $post_id),
				"home_size" => get_field("post_home_size", $post_id),
				"outdoor_size" => get_field("post_outdoor_size", $post_id),
				"tags" => $post_init_terms,
				"home_amenities" => get_field("post_home_amenities", $post_id),
				"neighborhood_amenities" => get_field("post_neighborhood_amenities", $post_id),
				"transportation" => get_field("post_transportation", $post_id),
				"garages_parking" => get_field("post_garages_parking", $post_id),
				"schools" => get_field("post_schools_nearby", $post_id),
				"home_style_architecture" => get_field("post_home_style_and_architecture", $post_id),
				"additional_features" => get_field("post_additional_home_features", $post_id),
				"taxes" => get_field("post_property_taxes", $post_id),
				"fees" => get_field("post_other_property_fees", $post_id),
				"systems" => get_field("post_heating_cooling_systems", $post_id),
				"energy_rating" => get_field("post_energy_rating", $post_id),
				"energy_consumption" => get_field("post_estimated_energy_consumption", $post_id),
				"location" => $address,
				"publish_date" => get_post_timestamp()
			];
			array_push($wall_content, $post);
		endwhile;
	} else {
		$response = 'EmptyProducts';
	}

	// shuffle($wall_content);

	foreach($wall_content as $content):
		if($content["post_type_slug"] === "real-estate"):
			$response .= get_template_part("components/grid-slate", null, array(
				"id" => $content["id"],
				"post_link" => get_the_permalink( $content["id"]),
				"image" => $content["card_gallery"][0]["post_gallery_image"]
			));
		elseif($content["post_type_slug"] === "users"):
			$response .= get_template_part("components/card-homazed-user", null, array(
				"id" => $content["id"],
				'type' => null, // null or compact
				'post_creator_link' => get_permalink("602")."?user_id=".$content["id"],
				'post_creator_name' => $content["first_name"]." ".$content["last_name"],
				'first_name' => $content["first_name"],
				'last_name' => $content["last_name"],
				'avatar' => $content["profile_picture"],
				'work_position' => $content["work_position"],
				'sector_of_activity' => $content["sector_of_activity"],
				'img' => $content["card_gallery"],
				'img_display' => $content["card_gallery_display"],
				'img_size' => 'thumbnail-m',
				'post_type' => $content["post_type"],
				'post_type_slug' => $content["post_type_slug"],
				'content' => $content["card_text"],
				'tags' => $content["tags"],
				'location' => $content["location"],
				'publish_date' => get_time_ago($content["publish_date"])
			));
		endif;
	endforeach;

	echo $response;
	exit;
}
add_action('wp_ajax_filterFavoritesGrid', 'filterFavoritesGrid');
add_action('wp_ajax_nopriv_filterFavoritesGrid', 'filterFavoritesGrid');


function filterFavoritesList() {
	$user_id = $_POST['me_id'];
	$filter = $_POST['filter'];
	if($filter == "favorites"):
		$favoritesPostsIds = get_field("i_favorite_posts_relationships", "user_" . $user_id );
		$favoritesUsersIds = get_field("i_favorite_users_relationships", "user_" . $user_id );

		$ajaxposts = new WP_Query([
			"post_type" => "homes",
			"post_status" => "publish",
			"posts_per_page" => -1,
			"orderby" => "date",
			"order" => "DESC",
			'post__in' => $favoritesPostsIds
		]);
		$ajaxusers = new WP_User_Query([
			'role' => 'Subscriber',
			'orderby' => 'display_name',
			'include' => $favoritesUsersIds
		]);
	else:
		$ajaxposts = new WP_Query([
			"post_type" => "homes",
			"post_status" => "publish",
			"posts_per_page" => -1,
			"orderby" => "date",
			"order" => "DESC",
			'author' => $user_id,
		]);
		// $ajaxusers is empty here.
	endif;
	$response = '';
	$wall_content = [];

	if($ajaxposts->have_posts()) {
		while($ajaxposts->have_posts()) : $ajaxposts->the_post();
			$user_id = get_the_author_meta('ID');
			$first_name = get_field("user_first_name", "user_" . $user_id);
			$last_name = get_field("user_last_name", "user_" . $user_id);
			if( !empty(get_field("post_location")["markers"][0]["label"]) ){
				$address = get_field("post_location")["markers"][0]["label"];
			}else{
				$address = "Not well defined";
			}
			$post_id = get_the_ID();
			$post_init_terms = get_the_terms($post_id, 'posttags');

			if(is_array(get_field("post_home_category"))){
				$post_category = get_field("post_home_category", $post_id)["label"];
			}else{
				$post_category = get_field("post_home_category", $post_id);
			}

			$post = [
				"id" => get_the_ID(),
				"title" => $post_category . " " . get_field("post_action", $post_id)['label'],
				"post_type" => "Homes",
				"post_type_slug" => "real-estate",
				"card_gallery" => get_field("post_gallery", $post_id),
				"card_gallery_display" => get_field("post_home_pictures_display", $post_id),
				"type" => get_field("post_action", $post_id),
				"home_category" => get_field("post_home_category", $post_id),
				"first_name" => $first_name,
				"last_name" => $last_name,
				"user_id" => get_the_author_meta('ID'),
				"profile_picture" => get_field("user_profile_picture", "user_".get_the_author_meta('ID')),
				"work_position" => get_field("user_current_work_position", "user_".get_the_author_meta('ID')),
				"main_picture" => get_field("post_main_picture", $post_id),
				"price" => get_field("post_price", $post_id),
				"bedrooms" => get_field("post_number_of_bedrooms", $post_id),
				"bathrooms" => get_field("post_number_of_bathrooms", $post_id),
				"home_size" => get_field("post_home_size", $post_id),
				"outdoor_size" => get_field("post_outdoor_size", $post_id),
				"tags" => $post_init_terms,
				"home_amenities" => get_field("post_home_amenities", $post_id),
				"neighborhood_amenities" => get_field("post_neighborhood_amenities", $post_id),
				"transportation" => get_field("post_transportation", $post_id),
				"garages_parking" => get_field("post_garages_parking", $post_id),
				"schools" => get_field("post_schools_nearby", $post_id),
				"home_style_architecture" => get_field("post_home_style_and_architecture", $post_id),
				"additional_features" => get_field("post_additional_home_features", $post_id),
				"taxes" => get_field("post_property_taxes", $post_id),
				"fees" => get_field("post_other_property_fees", $post_id),
				"systems" => get_field("post_heating_cooling_systems", $post_id),
				"energy_rating" => get_field("post_energy_rating", $post_id),
				"energy_consumption" => get_field("post_estimated_energy_consumption", $post_id),
				"location" => $address,
				"publish_date" => get_post_timestamp()
			];
			array_push($wall_content, $post);
		endwhile;
	} else {
		$response = 'EmptyProducts';
	}

	// shuffle($wall_content);

	foreach($wall_content as $content):
		if($content["post_type_slug"] === "real-estate"):
			$response .= get_template_part("components/card-homazed-homes", null, array(
				"id" => $content["id"],
				"title" => $content["title"],
				"user_id" => $content["user_id"],
				'type' => null, // null or compact
				'post_creator_link' => get_permalink("602")."?user_id=".$content["user_id"],
				'post_creator_name' => $content["first_name"]." ".$content["last_name"],
				'first_name' => $content["first_name"],
				'last_name' => $content["last_name"],
				'avatar' => $content["profile_picture"],
				'work_position' => $content["work_position"],
				'img' => $content["card_gallery"],
				'img_display' => $content["post_home_pictures_display"],
				'img_size' => 'thumbnail-m',
				'post_type' => $content["post_type"],
				'post_type_slug' => $content["post_type_slug"],
				'address_name' => $content["location"],
				'address_link' => null,
				'price' => $content["price"],
				'content' => null,
				'bedrooms' => $content["bedrooms"],
				'bathrooms' => $content["bathrooms"],
				'house' => $content["home_size"],
				'land' => $content["outdoor_size"],
				'tags' => $content["tags"],
				'location' => $content["location"],
				'publish_date' => get_time_ago($content["publish_date"])
			));
		elseif($content["post_type_slug"] === "users"):
			$response .= get_template_part("components/card-homazed-user", null, array(
				"id" => $content["id"],
				'type' => null, // null or compact
				'post_creator_link' => get_permalink("602")."?user_id=".$content["id"],
				'post_creator_name' => $content["first_name"]." ".$content["last_name"],
				'first_name' => $content["first_name"],
				'last_name' => $content["last_name"],
				'avatar' => $content["profile_picture"],
				'work_position' => $content["work_position"],
				'sector_of_activity' => $content["sector_of_activity"],
				'img' => $content["card_gallery"],
				'img_display' => $content["card_gallery_display"],
				'img_size' => 'thumbnail-m',
				'post_type' => $content["post_type"],
				'post_type_slug' => $content["post_type_slug"],
				'content' => $content["card_text"],
				'tags' => $content["tags"],
				'publish_date' => get_time_ago($content["publish_date"])
			));
		endif;
	endforeach;

	echo $response;
	exit;
}
add_action('wp_ajax_filterFavoritesList', 'filterFavoritesList');
add_action('wp_ajax_nopriv_filterFavoritesList', 'filterFavoritesList');


function makeRelationBtw() {
	$me_uid = $_POST["me_uid"];
	$him_id = $_POST["him"];
	$field_me = $_POST["field_me"]; // i_like_posts_relationships

	if(!empty($him_id) && !empty($field_me)):
		$existing_entries_me_array = [];

		$existing_entries_me = get_field($field_me, $me_uid); // i_like_posts_relationships // user_XXXme

		foreach($existing_entries_me as $existing_entry_me){
			array_push($existing_entries_me_array, $existing_entry_me);
		}

		if(!in_array($him_id, $existing_entries_me_array)):
			array_push($existing_entries_me_array, $him_id);
			$response = "Relation added";
		else:
			$key_2 = array_search($him_id, $existing_entries_me_array);
			array_splice($existing_entries_me_array, $key_2, 1);
			$response = "Relation removed";
		endif;
		//$response = print_r([$field_me,$existing_entries_me_array,$response,$me_uid]);
		update_field($field_me, $existing_entries_me_array, $me_uid);
	endif;

	echo $response;
	exit;
}
add_action('wp_ajax_makeRelationBtw', 'makeRelationBtw');
add_action('wp_ajax_nopriv_makeRelationBtw', 'makeRelationBtw');

function requestContact() {
	$me_uid = $_POST["me_uid"];
	$him_id = $_POST["him"];
	$field_me = "i_request_contactlist_users_relationships";
	$field_accepted = "i_accept_contactlist_users_relationships";

	if(!empty($him_id) && !empty($field_me)):
		$existing_entries_me_array = [];
		$existing_entries_accepted_array = [];

		$existing_entries_me = get_field($field_me, $me_uid); // i_like_posts_relationships // user_XXXme
		$existing_entries_accepted = get_field($field_accepted, $me_uid);

		foreach($existing_entries_me as $existing_entry_me){
			array_push($existing_entries_me_array, $existing_entry_me);
		}
		foreach($existing_entries_accepted as $existing_entry_accepted){
			array_push($existing_entries_accepted_array, $existing_entry_accepted);
		}

		if(!in_array($him_id, $existing_entries_me_array)):
			array_push($existing_entries_me_array, $him_id);
			$response = "Contact request send";
		else:
			$key_2 = array_search($him_id, $existing_entries_me_array);
			array_splice($existing_entries_me_array, $key_2, 1);
			$response = "Contact request unsend";
		endif;

		if(!in_array($him_id, $existing_entries_accepted_array)):
			array_push($existing_entries_accepted_array, $him_id);
		else:
			$key_2 = array_search($him_id, $existing_entries_accepted_array);
			array_splice($existing_entries_accepted_array, $key_2, 1);
		endif;

		update_field($field_me, $existing_entries_me_array, $me_uid);
		update_field($field_accepted, $existing_entries_accepted_array, $me_uid); // Non bidirectionnal
	endif;

	echo $response;
	exit;
}
add_action('wp_ajax_requestContact', 'requestContact');
add_action('wp_ajax_nopriv_requestContact', 'requestContact');

function acceptContact() {
	$me_uid = $_POST["me_uid"];
	$him_id = $_POST["him"];
	$field_accepted = "i_accept_contactlist_users_relationships";

	if(!empty($him_id) && !empty($me_uid)):
		$existing_entries_me_accepted_array = [];

		$existing_entries_me_accepted = get_field($field_accepted, $me_uid);

		foreach($existing_entries_me_accepted as $existing_entry_me_accepted){
			array_push($existing_entries_me_accepted_array, $existing_entry_me_accepted);
		}

		if(!in_array($him_id, $existing_entries_me_accepted_array)):
			array_push($existing_entries_me_accepted_array, $him_id);
			$response = "Contact accepted";
		endif;

		update_field($field_accepted, $existing_entries_me_accepted_array, $me_uid); // Non bidirectionnal
	endif;

	echo $response;
	exit;
}
add_action('wp_ajax_acceptContact', 'acceptContact');
add_action('wp_ajax_nopriv_acceptContact', 'acceptContact');

function refuseContact() {
	$me_uid = $_POST["me_uid"];
	$me_id = $_POST["me"];
	$him_id = $_POST["him"];
	$field_requested = "i_request_contactlist_users_relationships";
	$field_accepted = "i_accept_contactlist_users_relationships";

	if(!empty($him_id) && !empty($me_uid)):
		$existing_entries_me_requested = [];
		$existing_entries_me_accepted_array = [];
		$existing_entries_him_accepted_array = [];

		$existing_entries_me_requested = get_field($field_requested, $me_uid);
		$existing_entries_me_accepted = get_field($field_accepted, $me_uid);
		$existing_entries_him_accepted = get_field($field_accepted, "user_" . $him_id);

		foreach($existing_entries_me_requested as $existing_entry_me_requested){
			array_push($existing_entries_me_requested_array, $existing_entry_me_requested);
		}
		foreach($existing_entries_me_accepted as $existing_entry_me_accepted){
			array_push($existing_entries_me_accepted_array, $existing_entry_me_accepted);
		}
		foreach($existing_entries_him_accepted as $existing_entry_him_accepted){
			array_push($existing_entries_him_accepted_array, $existing_entry_him_accepted);
		}

		if(in_array($him_id, $existing_entries_me_accepted_array)):
			$key_0 = array_search($him_id, $existing_entries_me_accepted_array);
			array_splice($existing_entries_me_accepted_array, $key_0, 1);
			$response = "Contact removed";
		endif;

		if(in_array($him_id, $existing_entries_me_requested_array)):
			$key_1 = array_search($him_id, $existing_entries_me_requested_array);
			array_splice($existing_entries_me_requested_array, $key_1, 1);
			$response = "Contact removed";
		endif;

		if(in_array($me_id, $existing_entries_him_accepted_array)):
			$key_2 = array_search($me_id, $existing_entries_him_accepted_array);
			array_splice($existing_entries_him_accepted_array, $key_2, 1);
			$response = "Contact removed";
		endif;

		update_field($field_requested, $existing_entries_me_requested_array, $me_uid); // Bidirectionnal
		update_field($field_accepted, $existing_entries_me_accepted_array, $me_uid); // Non bidirectionnal
		update_field($field_accepted, $existing_entries_him_accepted_array, "user_" . $him_id); // Non bidirectionnal
	endif;

	echo $response;
	exit;
}
add_action('wp_ajax_refuseContact', 'refuseContact');
add_action('wp_ajax_nopriv_refuseContact', 'refuseContact');



add_filter( 'gform_required_legend', '__return_empty_string' );


add_filter( 'gform_field_validation_2_18', 'character_validation', 10, 4 );
function character_validation( $result, $value, $form, $field ) {
	if ( ! preg_match( '/^[A-Za-z0-9-]+$/', $value ) ) {
		$result['is_valid'] = false;
		$result['message'] = 'Please enter only letters (a-z), numbers and dashes.';
	}

	return $result;
}


add_filter( 'gform_field_validation_2_33', 'character_validation_slug', 10, 4 );
function character_validation_slug( $result, $value, $form, $field ) {
	$splitted_value = explode("/", $value);
	$last_word = $splitted_value[count($splitted_value) -1];
	if ( ! preg_match(  '/^[A-Za-z0-9-]+$/', $last_word ) ) {
		$result['is_valid'] = false;
		$result['message'] = 'Please enter only letters (a-z), numbers and dashes for the last part of the url: <b>' . $last_word . '<b/>';
		// $result['message'] = $last_word;
	}
	// if ( ! preg_match( '/^homazed\.com\/homazer\/.*/', $value ) ) {
	if ( ! preg_match( '/^homazed\.com\/homazer\/.*/', $value ) ) {
		$result['is_valid'] = false;
		$result['message'] = 'Please do not remove the <b>homazed.com/homazer/</b> part';
	}

	return $result;
}



//  GFORM UPDATED AND CREATE FUNCTIONS

add_action('gform_user_updated', 'link_acf_images_ids_to_user_when_updated', 10, 4);
// Form ID 5: Edit profile -- Medias

function link_acf_images_ids_to_user_when_updated($user_id, $feed, $entry, $user_pass) {
	$target_form_id = 5;
	$form_id = $entry['form_id'];

	if ($form_id == $target_form_id) {

		// Get the uploaded files from the entry
		$uploaded_gallery_ids = $entry['gpml_ids_1'];
		$uploaded_avatar_ids = $entry['gpml_ids_4'];

		if (!empty($uploaded_gallery_ids)) {
			$gallery_ids_string = implode(',', $uploaded_gallery_ids);
			error_log('gallery_ids_string ' . print_r($gallery_ids_string, true));
			update_field('user_gallery_ids', $gallery_ids_string, 'user_' . $user_id);
		}
		if (!empty($uploaded_avatar_ids)) {
			$avatar_ids_string = implode(',', $uploaded_avatar_ids);
			error_log('avatar_ids_string ' . print_r($avatar_ids_string, true));
			update_field('user_avatar_ids', $avatar_ids_string, 'user_' . $user_id);
		}
	}
}

add_action( 'gform_advancedpostcreation_post_after_creation_1', 'populate_images_array', 10, 4 ); //homes
add_action( 'gform_advancedpostcreation_post_after_creation_24', 'populate_images_array', 10, 4 ); //jobs
add_action( 'gform_advancedpostcreation_post_after_creation_30', 'populate_images_array', 10, 4 ); //projects
// Form ID 1: Create home post
function populate_images_array( $post_id, $feed, $entry, $form ){

	$uploaded_gallery_ids = $entry['gpml_ids_1'];
	$uploaded_main_picture_ids = $entry['gpml_ids_87'];

	if (!empty($uploaded_gallery_ids)) {
		$gallery_ids_string = implode(',', $uploaded_gallery_ids);
		error_log('gallery_ids_string ' . print_r($gallery_ids_string, true));
		update_field('post_home_gallery_ids', $gallery_ids_string, $post_id);
	}
	if (!empty($uploaded_main_picture_ids)) {
		$main_picture_string = implode(',', $uploaded_main_picture_ids);
		error_log('main_picture_string ' . print_r($main_picture_string, true));
		update_field('post_home_main_picture_ids', $main_picture_string, $post_id);
	}
}


// todo_augustin tags et champs post
// Form ID 1 : Ajoutez les tags et autres métadonnées après la création du post
add_action('gform_advancedpostcreation_post_after_creation', 'add_tags_to_post_and_meta', 10, 4);

function add_tags_to_post_and_meta($post_id, $feed, $entry, $form) {

	// Ajout des tags
	$tags_input = $entry['65'];
	if (!empty($tags_input)) {
		$tags = array_map('trim', explode(',', $tags_input));
		wp_set_post_terms($post_id, $tags, 'posttags', true); // Utilisez 'post_tag' pour la taxonomie des tags
	}

	// Ajout des métadonnées uniques
	$single_meta_fields = [
		'45' => 'post_address',
		'29' => 'post_home_outdoor_size',
		'133' => 'post_home_title',
		'111' => 'post_home_status',
		'28' => 'post_home_size',
		'30' => 'post_home_number_of_bathrooms',
		'26' => 'post_home_number_of_bedrooms',
		'25' => 'post_home_price',
		'113' => 'post_home_amenities',
		'67' => 'post_home_year_built',
		'92.1' => 'post_comment_available', //checkbox comments available
		'93.1' => 'post_phone_calls_available', // checkbox Phone calls available
		'94.1' => 'post_add_my_website_link', //checkbox
		'114' => 'post_home_neighborhood_amenities',
		'116' => 'post_home_transportation',
		'115' => 'post_home_garages_parking',
		'117' => 'post_home_schools_nearby',
		'84' => 'post_home_style_and_architecture',
		'86' => 'post_home_additional_home_features',
		'120' => 'post_home_property_taxes',
		'121' => 'post_home_other_property_fees',
		'118' => 'post_heating_cooling_systems',
		'122' => 'post_home_estimated_energy_rating_energy_consumption',
		'123' => 'post_author_link',
		'95.1' => 'Is_Add_my_webshop_link',
		'124' => 'post_Add_my_webshop_link',
		'131' => 'post_home_event_text_1',
		'132' => 'post_home_event_text_2',
		'105.1' => 'post_premium',
		'107' => 'post_voucher',
		'108.1' => 'post_Is_Automatic_Renewal'
	];

	foreach ($single_meta_fields as $input_key => $meta_key) {
		if (!empty($entry[$input_key])) {
			$meta_value = sanitize_text_field($entry[$input_key]);
			if (!add_post_meta($post_id, $meta_key, $meta_value, true)) {
				update_post_meta($post_id, $meta_key, $meta_value);
			}
		}
	}

	// le titre et le lien todo_augustin
	$city =$entry['62.3']; // Remplacez '1' par l'ID du champ de la ville
	$postal_code = $entry['62.5'] ; // Remplacez '2' par l'ID du champ du code postal
	$post_title = $entry['133'];   // Remplacez '3' par l'ID du champ du titre du post

	// Nettoyer les valeurs et générer un slug unique
	$city = sanitize_title($city ?: 'unknown-city');
	$postal_code = sanitize_title($postal_code ?: '0000');
	$random_number = rand(100000, 999999);

	// Créer un slug unique basé sur le titre, la ville, le code postal et un numéro aléatoire
	$custom_slug = sanitize_title($post_title . '-' . $city . '-' . $postal_code . '/' . $random_number);

	// Mettre à jour le post existant avec ces informations
	$post_data = array(
		'ID'           => $post_id,           // L'ID du post à mettre à jour
		'post_title'   => $post_title,        // Titre du post
		'post_name'    => $custom_slug,       // Slug personnalisé
		'post_status'  => 'publish',          // Définir le statut du post
	);

	// Mettre à jour le post
	$updated_post_id = wp_update_post($post_data);


	// Gestion des champs de sélection multiple pour `post_choice`
	$post_choice = [];
	$multiple_choice_fields = ['92.1', '93.1', '94.1'];
	foreach ($multiple_choice_fields as $input_key) {
		if (!empty($entry[$input_key])) {
			$post_choice[] = sanitize_text_field($entry[$input_key]);
		}
	}

	if (!empty($post_choice)) {
		if (!add_post_meta($post_id, 'post_choice', $post_choice, true)) {
			update_post_meta($post_id, 'post_choice', $post_choice);
		}
	}

	// Gestion du champ de durée (`post_duration`) - prend la première valeur non nulle
	$duration_fields = ['106.1', '106.2', '106.3'];
	$post_duration = null;
	foreach ($duration_fields as $input_key) {
		if (!empty($entry[$input_key])) {
			$post_duration = sanitize_text_field($entry[$input_key]);
			break; // Prend la première valeur non nulle
		}
	}

	if ($post_duration !== null) {
		if (!add_post_meta($post_id, 'post_duration', $post_duration, true)) {
			update_post_meta($post_id, 'post_duration', $post_duration);
		}
	}


}





add_action('gform_after_submission', 'add_tags_from_input65', 10, 2);
function add_tags_from_input65($entry, $form) {
	// ID du champ Gravity Forms pour les tags
	$input_id = '65';
	// ID du post créé par Gravity Forms
	$post_id = rgar($entry, 'post_id');

	// Vérifiez que le post a bien été créé
	if (!empty($post_id)) {
		// Récupérez les tags depuis le champ `input_65`
		$tags_string = rgar($entry, $input_id);

		// Convertir la chaîne de tags en tableau, en utilisant la virgule comme séparateur
		$tags = array_map('trim', explode(',', $tags_string));

		// Vérifiez qu'il y a bien des tags avant de les ajouter
		if (!empty($tags)) {
			// Assigner les tags au post
			wp_set_post_terms($post_id, $tags, 'posttags', true);
		}
	}
}



add_action( 'gform_after_submission_4', 'update_home_post_images', 10, 2 );
// Form ID 4: Edit Home -- Images
function update_home_post_images( $entry, $form ) {
	$post_id = $entry['87'];

	$gallery_initial_ids_string = get_field('post_home_gallery_ids', $post_id);
	$main_picture_initial_ids_string = get_field('post_home_main_picture_ids', $post_id);
	if(!empty($gallery_initial_ids_string)){
		$gallery_initial_ids_array = explode(',', $gallery_initial_ids_string);
		$gallery_array_to_delete = array_diff($gallery_initial_ids_array, $entry['gpml_ids_95']);

	}else{
		error_log('No images initially');
	}

	if(!empty($main_picture_initial_ids_string)){
		$main_picture_initial_ids_array = explode(',', $$main_picture_initial_ids_string);
		$main_picture_array_to_delete = array_diff($main_picture_initial_ids_array, $entry['gpml_ids_105']);
	}else{
		error_log('No images initially');
	}


	foreach ($gallery_array_to_delete as $gallery_id){
		delete_media_by_id( $gallery_id );
	}
	foreach ($main_picture_array_to_delete as $main_picture_id){
		delete_media_by_id( $main_picture_id );
	}

	if(count($entry['gpml_ids_95']) > 0){
		error_log('Images added : entry gpml_ids_95 count > 0');
		$gallery_ids_string = implode(',', $entry['gpml_ids_95']);
	}else{
		error_log('No Images added entry gpml_ids_95 count <= 0');
		$gallery_ids_string = $entry['gpml_ids_95'][0];
	}

	if(count($entry['gpml_ids_105']) > 0){
		error_log('Images added : entry gpml_ids_105 count > 0');
		$main_picture_ids_string = implode(',', $entry['gpml_ids_105']);
	}else{
		error_log('No Images added entry gpml_ids_105 count <= 0');
		$main_picture_ids_string = $entry['gpml_ids_105'][0];
	}

	update_field('post_home_gallery_ids', $gallery_ids_string, $post_id);
	update_field('post_home_main_picture_ids', $main_picture_ids_string, $post_id);

}

add_action( 'gform_after_submission_13', 'update_post_home_files', 10, 2 );
// Form ID 4: Edit Home -- Images
function update_post_home_files( $entry, $form ) {


	// Specify the form ID you want to target.
	$target_form_id = 13; // Replace with your form ID

	if ( $form['id'] != $target_form_id ) {
		return; // Exit if this is not the targeted form.
	}

	// Specify the post ID to update.
	$post_id = rgar( $entry, '87' ); // Replace 'post_id_field' with your Gravity Forms field ID
	error_log('$post_id: '. print_r($post_id, true));
	$field_file = $entry['gpml_ids_89'];
	$field_file_id = $field_file[0];

	error_log('post_home_join_file updated: '. print_r($field_file_id, true));
	update_field('post_home_join_file', $field_file_id, $post_id);

}

add_filter('gform_pre_render', 'prepopulate_image_hopper');
// Form ID 4: Edit Home -- Images
function prepopulate_image_hopper($form) {

	$form_id_edit_home = 4;
	$images_ids_prepopulated_ids_field_id = 98;

	if ($form['id'] == $form_id_edit_home) {

		foreach ($form['fields'] as $field) {

			if ($field->id == $images_ids_prepopulated_ids_field_id) {

				if($field->gppa_hydrated_value){
					$image_prepopulated_ids = $field->gppa_hydrated_value;
					$image_prepopulated_ids_array = explode(',', $image_prepopulated_ids);
					$pre_populated_array_of_urls = [];
					error_log('image_prepopulated_ids: ' . print_r($image_prepopulated_ids, true));
					foreach($image_prepopulated_ids_array as $image_prepopulated_id){
						$arr = [
							'temp_filename' => '',
							'uploaded_filename' => wp_get_attachment_image_src($image_prepopulated_id, 'large')[0],
						];
						array_push($pre_populated_array_of_urls, $arr);
					}
					error_log('pre_populated_array_of_urls: ' . print_r($pre_populated_array_of_urls, true));
					GFFormsModel::$uploaded_files[ $form['id'] ]['input_95'] = $pre_populated_array_of_urls;
				}


			}
		}
	}

	return $form;
}



function delete_media_by_id( $media_id ) {
	if ( ! empty( $media_id ) ) {

		error_log('delete_media_by_id: '. print_r($media_id, true));
		// Check if the media ID is valid
		$attachment = get_post( $media_id );
		if ( ! $attachment || 'attachment' !== $attachment->post_type ) {
			return false; // Invalid attachment ID
		}

		// Delete the media
		$deleted = wp_delete_attachment( $media_id, true );

		// Return true if the media was deleted, false otherwise
		return ( $deleted !== false );
	}

	return false;
}



//todo_augustin
include get_template_directory() . '/function_aug.php';
include get_template_directory() . '/function_al.php';

// Personnaliser l'email d'activation des utilisateurs
add_filter('wp_mail', 'custom_activation_email_with_link');

function custom_activation_email_with_link($args) {
    // Vérifie si l'email concerne l'activation de compte
    if (strpos($args['message'], 'To activate your user') !== false) {
        // Récupère dynamiquement le lien d'activation
        preg_match('/https?:\/\/[^\s]+gfur_activation=[^\s]+/', $args['message'], $matches);
        $activation_link = $matches[0] ?? '';

        // Définit le sujet et le contenu de l'email personnalisé
        $args['subject'] = 'Activate Your Account - Homazed';
        $args['message'] = "Hello Dear User,\n\n";
        $args['message'] .= "Thank you for joining us.\n";
        $args['message'] .= "To activate your account, please click the following link:\n\n";
        $args['message'] .= "$activation_link\n\n";
        $args['message'] .= "After you activate your account, you will receive *another email* with your login details.\n\n";
        $args['message'] .= "Thank you.\n";
        $args['message'] .= "Best regards,\n";
        $args['message'] .= "Homazed Team.";
    }

    return $args;
}

add_filter('wp_mail', 'custom_user_details_email');

function custom_user_details_email($args) {
    // Vérifie si l'e-mail contient le message par défaut de connexion
    if (strpos($args['message'], 'Use the password you set at registration to login.') !== false) {
        // Extraction des informations dynamiques
        preg_match('/Username: ([^\s]+)/', $args['message'], $username_match);

        $username = $username_match[1] ?? 'User';
        $login_url = 'https://homazed.oasiscrea.com/log-in'; // Lien de connexion personnalisé

        // Ajouter l'en-tête pour l'email texte brut
        $args['headers'] = array('Content-Type: text/plain; charset=UTF-8');

        // Redéfinir le sujet et le contenu de l'email en texte brut
        $args['subject'] = 'Welcome to Homazed';
        $args['message'] = "Hello $username,\n\n";
        $args['message'] .= "Thank you for registering on Homazed! Here are your login details:\n\n";
        $args['message'] .= "Username: $username\n";
        $args['message'] .= "Password: Please use the password you set during registration to log in.\n\n";
        $args['message'] .= "To access your account directly, click the following link:\n";
        $args['message'] .= "$login_url\n\n";
        $args['message'] .= "Thank you for joining us!\n";
        $args['message'] .= "Best regards,\n";
        $args['message'] .= "The Homazed Team.";
    }

    return $args;
}

add_filter('gfur_user_activation_enabled', '__return_false');
