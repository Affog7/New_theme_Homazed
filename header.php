<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<link rel="stylesheet" href="https://use.typekit.net/cpa4ltc.css">

<?php 
	$site_title = (!empty(get_bloginfo( 'description' ))) ? get_bloginfo( 'name' ) . " - " . get_bloginfo( 'description' ) : get_bloginfo( 'name' );
?>
<title><?php echo get_the_title() . " - " . $site_title; ?> </title>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri() . '/src/images/favicon/apple-touch-icon.png'; ?>">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri() . '/src/images/favicon/favicon-32x32.png'; ?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri() . '/src/images/favicon/favicon-16x16.png'; ?>">
<link rel="manifest" href="<?php echo get_template_directory_uri() . '/src/images/favicon/site.webmanifest'; ?>">
<link rel="mask-icon" href="<?php echo get_template_directory_uri() . '/src/images/favicon/safari-pinned-tab.svg'; ?>" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff"> -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />


<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> data-barba="wrapper">

<?php get_template_part( 'components/header', null, null); ?>