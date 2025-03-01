<?php
/*<a href="<?php echo $args["post_link"]; ?>" class="grid-slate grid-slate--<?php echo $args["id"]; ?>">*/
/*    <img src="<?php echo $args["image"]; ?>" alt="">*/
//</a>

?>
<a href="<?php echo $args["image"]; ?>"
   class="grid-slate card__img__grid__item card__img__grid__item--<?php echo $args["id"]; ?> glightbox"  data-gallery="gallery<?php echo $args["post_id"]; ?>">
	<img src="<?php echo $args["image"]; ?>" alt=" gallery image" />
</a>
