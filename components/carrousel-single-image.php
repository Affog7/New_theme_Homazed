<figure class="post-image">
	<a href="<?php echo wp_get_attachment_image_src($args['img'][0], 'large-img-big')[0]; ?>"
		class="glightbox-single">
	<img src="<?php echo wp_get_attachment_image_src($args['img'][0], 'large-img-medium')[0]; ?>" alt="<?php echo $args["post_creator_name"]." image"; ?>"  />
</figure>
