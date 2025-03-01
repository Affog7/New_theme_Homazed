<?php
	$imgs_length = (count($args['img']) > 3) ? 2 : count($args['img']) - 1;
	$imgs_max_length = $imgs_length + 1;
	$field_name = $args['image_field_name'];
?>

<div class="card__img__grid card__img__grid--<?php echo $imgs_max_length; ?>">
	<?php
	for ($i = 0; $i <= $imgs_length; $i++): ?>

		<a href="<?php echo wp_get_attachment_image_src($args['img'][$i], 'large-img-big')[0]; ?>"
		   class="card__img__grid__item card__img__grid__item--<?php echo $i; ?> glightbox"  data-gallery="gallery<?php echo $args["post_id"]; ?>">

			<img src="<?php echo wp_get_attachment_image_src($args['img'][$i], 'large-img-medium')[0] ?>" alt="<?php echo $args["post_creator_name"]." gallery image"; ?>" />
		</a>
	<?php endfor; ?>
</div>
<?php // echo $args['post_id']; ?>
