<div id="map-popup-jobs" class="  default-bckg map-slate">
    <a href="#" class="map-slate--link flex">
		<div class="map-slate__image">
			<!-- D -->
			<?php
			$post_id = $args["id"];
			$user_id = $author_id = get_post_field('post_author', $post_id);


			// Galerie d'images
			$post_gallery_image_ids = get_field("post_home_gallery_ids", $post_id);

			$post_gallery_image_ids_array = explode(',', $post_gallery_image_ids);


			if($post_gallery_image_ids_array) {

				// URL des images
				$image_urls = [];
				foreach ($post_gallery_image_ids_array as $id) {
					$image_src = wp_get_attachment_image_src($id, 'thumbnail');
					if ($image_src) {
						$image_urls[] = $image_src[0];
					}
				}


				?>
				<div class="image-slider_a">
					<div class="slider-container_a">
						<div class="slider-wrapper_a">
							<!-- Les images dynamiques sont insérées ici via PHP -->
							<?php foreach ($image_urls as $url): ?>
								<div class="slider-slide_a">
									<img src="<?php echo esc_url($url); ?>" alt="Image">
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<!-- Contrôles gauche/droite -->
					<?php if (count($image_urls)>1): ?>
						<button class="slider-control_a prev" style="display: none" aria-label="Previous slide"><</button>
						<button class="slider-control_a next" aria-label="Next slide">></button>
					<?php endif; ?>
				</div>
				<?php
			}?>
			<!--  F-->
		</div>
        <div class="map-slate__content">
            <div class="post-details card__header__item flex flex--justify-between">
                <h2 class="h4 category">JOB</h2>
            </div>
            <div class="post-profile card__header__item flex flex--justify-between">Address</div>
            <div class="post-details card__header__item flex flex--justify-between">
                <ul class="post-details__caracteristics flex flex--vertical-center">
                        <li class="post-details_jobs_title">
                            <span class="value">X</span>
                        </li>
                </ul>
            </div>
        </div>

        <div class="sidebar-icons">
            <div class="icon"  >
             </div>
            <div class="icon favoriteButon">

            </div>
            <div class="icon shareButon">

            </div>
        </div>

    </a>
</div>
