


<div id="map-popup" class="default-bckg map-slate">
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
                <h2 class="h4 title">Home</h2>
            </div>
            <div class="post-location card__header__item flex flex--justify-between">Address</div>
            <div class="post-details card__header__item flex flex--justify-between">
                <ul class="post-details__caracteristics flex flex--vertical-center">
                    <li class="post-details__bedroom">
                        <span class="post-details__prefix p-xs">BDR</span>
                        <span class="value">X</span>
                    </li>
                    <li class="post-details__bathroom">
                        <span class="post-details__prefix p-xs">BTH</span>
                        <span class="value">X</span>
                    </li>
                    <li class="post-details__house">
                        <span class="post-details__prefix p-xs">H</span>
                        <span class="value">X</span><span class="post-details__suffix p-xs">m2</span>
                    </li>
                    <li class="post-details__land">
                        <span class="post-details__prefix p-xs">L</span>
                        <span class="value">X</span><span class="post-details__suffix p-xs">m2</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="sidebar-icons">

            <div class="icon"  >
				<svg width="25" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="Edit / Add_Plus_Circle"> <path id="Vector" d="M8 12H12M12 12H16M12 12V16M12 12V8M12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g> </g></svg>
            </div>

            <div class="icon favoriteButon">
            <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M15.8825 20.2542L10.735 16.5108C10.2968 16.1923 9.70322 16.1923 9.265 16.5108L4.1175 20.2542C3.92757 20.3922 3.67629 20.4122 3.46694 20.3059C3.25759 20.1995 3.12551 19.9848 3.125 19.75V2.875C3.125 2.18464 3.68464 1.625 4.375 1.625H15.625C16.3154 1.625 16.875 2.18464 16.875 2.875V19.75C16.8745 19.9848 16.7424 20.1995 16.5331 20.3059C16.3237 20.4122 16.0724 20.3922 15.8825 20.2542V20.2542Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M10.4417 5.82584L11.4825 7.87417H13.255C13.4547 7.86929 13.637 7.98736 13.7142 8.1716C13.7914 8.35584 13.7477 8.56857 13.6042 8.7075L11.9767 10.3092L12.8784 12.38C12.9599 12.5745 12.908 12.7993 12.7496 12.9385C12.5912 13.0776 12.3616 13.1001 12.1792 12.9942L10 11.765L7.82086 12.9908C7.6385 13.0967 7.40888 13.0743 7.25045 12.9351C7.09202 12.796 7.04019 12.5712 7.12169 12.3767L8.02336 10.3058L6.39586 8.70417C6.25233 8.56523 6.20867 8.35251 6.28586 8.16826C6.36306 7.98402 6.54533 7.86596 6.74503 7.87084H8.51753L9.55836 5.82584C9.64263 5.65931 9.8134 5.55434 10 5.55434C10.1867 5.55434 10.3574 5.65931 10.4417 5.82584Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
			</svg>


            </div>
            
            
            <div class="icon shareButon">
                <div class="btn-group btn-group--related">
                        
                        <?php 
                                    get_template_part("components/btn", null,
                                        array(
                                            'label' => '',
                                            'href' => "",
                                            'target' => "_self",
                                            'skin'  => 'transparent',
                                            'icon-only'  => true,
                                            'disabled'  => false,
                                            'icon-position' => 'right', // left or right
                                            'icon' => 'diagram-arrow-bend-down', // nom du fichier svg
                                            'additional-classes' => 'post-footer__button',
                                            'data-attribute' => 'data-open-modal=\'share-slate-' .$post_id . '\'' ,
                                            'theme' => "",
                                        )
                                    );
                        ?>

                </div>
            </div>
        </div>


        <?php
                    
                    $i_favorite_posts_relationships = get_field("i_favorite_posts_relationships", "user_".$user_id);

                    $is_checked_favorite = (!empty($i_favorite_posts_relationships) && in_array($post_id, $i_favorite_posts_relationships)) ? true : false;
                
                        get_template_part(
                            "components/btn", null, array(
                            'label' => 'Favorite',
                            'href' => "",
                            'target' => "_self",
                            'skin'  => 'transparent',
                            'icon-only'  => true,
                            'disabled'  => false,
                            'icon-position' => '', // left or right
                            'icon' => 'rating-star-ribbon', // nom du fichier svg
                            'additional-classes' => $is_checked_favorite ? 'post-footer__button relation_btn--checked relation_btn relation_btn__posts relation_btn--favorite' : 'post-footer__button relation_btn relation_btn__posts relation_btn--favorite',
                            'data-attribute' => "data-relation-him=" . $post_id. " data-relation-type='favorite'",
                            'theme' => "",
                        ));
                ?> 
                


    </a>



</div>
