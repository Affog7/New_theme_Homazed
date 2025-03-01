<div id="map-popup-homes" class="default-bckg map-slate">
   <a href="#" class="map-slate--link flex">
      <div class="map-slate__image" style="box-shadow: unset">
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
				// Informations additionnelles
				$post_price = get_field("post_home_price",$post_id);
				$post_bedrooms = get_field("post_home_number_of_bedrooms",$post_id);
				$post_bathrooms = get_field("post_home_number_of_bathrooms",$post_id);
				$post_home_size = get_field("post_home_size",$post_id);
				$post_outdoor_size = get_field("post_home_outdoor_size",$post_id);

            ?>
         <div class="image-slider_a"  style="border: unset;border-radius: unset">
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
            <h2 class="h4 title">Home</h2>
         </div>
         <div class="post-location card__header__item flex flex--justify-between"><?php echo $post_price." €"; ?></div>
         <div class="post-details card__header__item flex flex--justify-between">
            <ul class="post-details__caracteristics flex flex--vertical-center">
               <li class="post-details__bedroom">
                  <span class="post-details__prefix p-xs">BDR</span>
                  <span class="value"> <?php echo $post_bedrooms; ?> </span>
               </li>
               <li class="post-details__bathroom">
                  <span class="post-details__prefix p-xs">BTH</span>
                  <span class="value"><?php echo $post_bathrooms; ?></span>
               </li>
               <li class="post-details__house">
                  <span class="post-details__prefix p-xs">H</span>
                  <span class="value"><?php echo $post_home_size; ?></span><span class="post-details__suffix p-xs">m2</span>
               </li>
               <li class="post-details__land">
                  <span class="post-details__prefix p-xs">L</span>
                  <span class="value"><?php echo $post_outdoor_size; ?></span><span class="post-details__suffix p-xs">m2</span>
               </li>
            </ul>
         </div>
      </div>

      <div class="sidebar-icons">

         <div class="icon"  >
			 <button onclick="window.open('<?php echo get_the_permalink($post_id) ?>')" class="btn btn--transparent btn--icon post-footer__button" data-open-modal="share-slate-5711">
				<span class="btn__content">
				<svg width="25" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Edit / Add_Plus_Circle"> <path id="Vector" d="M8 12H12M12 12H16M12 12V16M12 12V8M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
				</span>
			 </button>
         </div>

         <div class="icon favoriteButon">
			<button  title="Favorite"  class="btn btn--transparent btn--icon post-footer__button relation_btn relation_btn__posts relation_btn--favorite" data-relation-him="<?php echo $post_id; ?>" data-relation-type="favorite">
				<span class="btn__content">
							<span class="u-sr-accessible">Favorite</span>
					<div class="o-svg-icon o-svg-icon-rating-star-ribbon"><svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M15.8825 20.2542L10.735 16.5108C10.2968 16.1923 9.70322 16.1923 9.265 16.5108L4.1175 20.2542C3.92757 20.3922 3.67629 20.4122 3.46694 20.3059C3.25759 20.1995 3.12551 19.9848 3.125 19.75V2.875C3.125 2.18464 3.68464 1.625 4.375 1.625H15.625C16.3154 1.625 16.875 2.18464 16.875 2.875V19.75C16.8745 19.9848 16.7424 20.1995 16.5331 20.3059C16.3237 20.4122 16.0724 20.3922 15.8825 20.2542V20.2542Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
			<path fill-rule="evenodd" clip-rule="evenodd" d="M10.4417 5.82584L11.4825 7.87417H13.255C13.4547 7.86929 13.637 7.98736 13.7142 8.1716C13.7914 8.35584 13.7477 8.56857 13.6042 8.7075L11.9767 10.3092L12.8784 12.38C12.9599 12.5745 12.908 12.7993 12.7496 12.9385C12.5912 13.0776 12.3616 13.1001 12.1792 12.9942L10 11.765L7.82086 12.9908C7.6385 13.0967 7.40888 13.0743 7.25045 12.9351C7.09202 12.796 7.04019 12.5712 7.12169 12.3767L8.02336 10.3058L6.39586 8.70417C6.25233 8.56523 6.20867 8.35251 6.28586 8.16826C6.36306 7.98402 6.54533 7.86596 6.74503 7.87084H8.51753L9.55836 5.82584C9.64263 5.65931 9.8134 5.55434 10 5.55434C10.1867 5.55434 10.3574 5.65931 10.4417 5.82584Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
			</svg>
			</div>	</span>

			</button>
         </div>
         <div class="icon shareButon">

			 <button class="btn btn--transparent btn--icon post-footer__button" data-open-modal="share-post-<?php echo $post_id;?>">
					<span class="btn__content">
					  <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M6.19043 17.5151L6.19043 9.64014" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
				<path d="M1.69043 13.5776L1.69043 17.5151" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M13.5029 2.89014L13.5029 1.26638C13.5034 1.15572 13.5686 1.05558 13.6696 1.01033C13.7706 0.965083 13.8888 0.983095 13.9717 1.05639L18.3427 4.94214C18.4007 4.99347 18.4348 5.0665 18.4371 5.14391C18.4394 5.22133 18.4096 5.29623 18.3547 5.35089L13.9837 9.72264C13.9031 9.80274 13.7822 9.82661 13.6772 9.78319C13.5722 9.73977 13.5035 9.63754 13.5029 9.52389L13.5029 7.39014L7.87793 7.39014C4.00568 7.39014 1.69043 8.46114 1.69043 13.5776L1.69043 6.67764C1.69043 4.02489 3.38768 2.88789 5.48018 2.88789L13.5029 2.89014Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
				</svg> 	</span>
			 </button>

         </div>

      </div>

	   <div class="modal micromodal-slide" id="share-post-<?php echo $post_id;?>" aria-hidden="true" style = "z-index: 1001">
		   <div class="modal__overlay" tabindex="-1" data-micromodal-close>
			   <div class="modal__container" style="overflow: hidden" role="dialog" aria-modal="true" aria-labelledby="publish-home-title">
				   <header class="modal__header">
					   <div class="flex flex--vertical">
						   <div class="flex flex--vertical-center">
							   <h2 class="resume__name card-form__title">SHARE POST</h2>
						   </div>
					   </div>
					   <?php get_template_part("components/btn", null,
						   array(
							   'label' => 'Close this modal window',
							   'href' => "",
							   'target' => "_self",
							   'skin'  => 'secondary',
							   'icon-only'  => true,
							   'disabled'  => false,
							   'icon-position' => 'right', // left or right
							   'icon' => 'close',
							   'additional-classes' => '',
							   'data-attribute' => 'data-close-modal',
							   'theme' => "",
						   )
					   ); ?>
				   </header>
				   <main class="modal__content contact__form contact__form--light">
					   <?php get_template_part("components/share-box", null, array(
							   'post_permalink' => get_the_permalink($post_id),
							   "post_id" => $post_id
						   )
					   ); ?>
				   </main>
			   </div>
		   </div>
	   </div>


   </a>
</div>

















