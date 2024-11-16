<?php
$imgs_length = count($args['img']);
?>
<figure class="post-image">
	<div class="post-image__gallery">
		<div class="glide__track" data-glide-el="track">
			<div class="glide__slides">
				<?php
				// Boucle pour les images
				for ($i = 0; $i < $imgs_length; $i++):
					?>
					<a href="<?php echo esc_url(wp_get_attachment_image_src($args['img'][$i], 'large-img-big')[0]); ?>"
					   class="card__img__grid__item card__img__grid__item--<?php echo esc_attr($i); ?> glightbox"
					   data-gallery="gallery<?php echo esc_attr($args["post_id"]); ?>">
						<div class="post-image__gallery__item glide__slide">
							<img src="<?php echo esc_url(wp_get_attachment_image_src($args['img'][$i], 'large-img-medium')[0]); ?>"
								 alt="<?php echo esc_attr($args["post_creator_name"] . " gallery image"); ?>" />
						</div>
					</a>
				<?php endfor; ?>


			</div>
		</div>
	</div>
</figure>

<div data-glide-el="controls" class="card__img__controls btn-controls flex">
	<a href="javascript:void(0);" class="btn btn glide__arrow square glide__arrow--left" data-glide-dir="<">
		<span class="btn__content">
			<span class="u-sr-accessible">Précédent</span>
			<div class='o-svg-icon o-svg-icon-arrow-left'>
				<?php include get_stylesheet_directory() . '/src/images/icons/arrow-left.svg'; ?>
			</div>
		</span>
	</a>
	<a href="javascript:void(0);" class="btn btn glide__arrow square glide__arrow--right" data-glide-dir=">">
		<span class="btn__content">
			<span class="u-sr-accessible">Suivant</span>
			<div class='o-svg-icon o-svg-icon-arrow-right'>
				<?php include get_stylesheet_directory() . '/src/images/icons/arrow-right.svg'; ?>
			</div>
		</span>
	</a>
</div>

<div class="glide__bullet__wrap">
	<div class="glide__bullets" data-glide-el="controls[nav]">
		<?php
		// Générer les puces de navigation
		for ($i = 0; $i < $imgs_length + 1; $i++):
			?>
			<a class="glide__bullet" data-glide-dir="=<?php echo $i; ?>"></a>
		<?php endfor; ?>
	</div>
</div>
