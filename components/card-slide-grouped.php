<?php
/*<a href="<?php echo $args["post_link"]; ?>" class="grid-slate grid-slate--<?php echo $args["id"]; ?>">*/
/*    <img src="<?php echo $args["image"]; ?>" alt="">*/
//</a>


foreach ($args["all_img"] as $post_gallery_id):

	if ($post_gallery_id) : ?>
		<a href="<?php echo wp_get_attachment_image_src($post_gallery_id, 'large-img-medium')[0]; ?>"
		   class="grid-slate card__img__grid__item card__img__grid__item--<?php echo $post_gallery_id; ?> glightbox"  data-gallery="gallery<?php echo $args["id"]; ?>">
			<img src="<?php echo wp_get_attachment_image_src($post_gallery_id, 'large-img-medium')[0]; ?>" alt=" gallery image" />
		</a>

 <?php endif;
endforeach;
?>

