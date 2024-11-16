<figure class="post-image">
		<div class="post-image__gallery">
			<div class="glide__track" data-glide-el="track">
				<div class="glide__slides">
				<?php foreach ($args['img'] as $gallery_image_id): ?>
					<a href="<?php echo wp_get_attachment_image_src($gallery_image_id, 'large-img-big')[0]; ?>"
					class="card__img__grid__item card__img__grid__item--<?php echo $i; ?> glightbox"  data-gallery="gallery<?php echo $args["post_id"]; ?>">
						<div class="post-image__gallery__item glide__slide">
							<img src="<?php echo wp_get_attachment_image_src($gallery_image_id, 'large-img-medium')[0]; ?>" alt="<?php echo $args["post_creator_name"]." gallery image"; ?>" />
						</div>
					</a>
				<?php endforeach; ?>
				</div>
			</div>
		</div>
	</figure>
	<div data-glide-el="controls" class="card__img__controls btn-controls flex">
		<button class="btn btn glide__arrow square glide__arrow--left" data-glide-dir="<">
			<span class="btn__content">
				<span class="u-sr-accessible">Previous</span>
				<?php
				echo "<div class='o-svg-icon o-svg-icon-arrow-left'>";                              
					include get_stylesheet_directory() . '/src/images/icons/arrow-left.svg';
				echo "</div>"; ?>	
			</span>
		</button>
		<button class="btn glide__arrow square glide__arrow--right" data-glide-dir=">">
			<span class="btn__content">
				<span class="u-sr-accessible">Next</span>	
				<?php
				echo "<div class='o-svg-icon o-svg-icon-arrow-right'>";                              
					include get_stylesheet_directory() . '/src/images/icons/arrow-right.svg';
				echo "</div>"; ?>	
			</span>
		</button>
	</div>
	<div class="glide__bullet__wrap">
		<div class="glide__bullets" data-glide-el="controls[nav]">
			<?php for ($i = 1; $i <= count($args['img']); $i++): ?>
				<a class="glide__bullet" data-glide-dir="=<?php echo $i - 1; ?>"></a>
			<?php endfor; ?>
		</div>
	</div>