<?php

$user_link = get_permalink("602")."?user_id=".$args["user_id"];

$i_favorite_posts_relationships = get_field("i_favorite_posts_relationships", "user_".get_current_user_ID());

$account_category = get_field("account_category", "user_".$args["user_id"]);


$company_i_work = get_field("company_i_work",  $args["id"]);

$i_like_posts_relationships = get_field("i_like_posts_relationships", "user_".get_current_user_ID());

$users_like_me_posts = get_field("users_like_me_posts", $args["id"]);
$users_favorite_me_posts = get_field("users_favorite_me_posts", $args["id"]);
$user_avatar_id = get_field("user_avatar_ids", "user_".$args["user_id"]);


$main_picture_image_ids = get_field("post_home_main_picture_ids",  $args["id"]);

$main_picture_image_ids_array = explode(',', $main_picture_image_ids);

$current_user_id = get_current_user_id();

$post_events_type = get_field("post_home_event_type", $args["id"]);
$post_events_text_1 = get_field("post_home_event_text_1", $args["id"]);
$post_events_text_2 = get_field("post_home_event_text_2", $args["id"]);
$post_events_privacy = get_field("post_home_event_privacy", $args["id"]);

$post_join_file_id = get_field("post_home_join_file", $args["id"]);
$post_join_file = !wp_get_attachment_url($post_join_file_id)?$post_join_file_id:wp_get_attachment_url($post_join_file_id);
$post_permalink = get_the_permalink($args['id']);

$i_request_contactlist_users_relationships = get_field("i_request_contactlist_users_relationships", "user_".$current_user_id);
$i_accept_contactlist_users_relationships = get_field("i_accept_contactlist_users_relationships", "user_".$current_user_id);
$him_request_contactlist_users_relationships = get_field("i_request_contactlist_users_relationships", "user_".$args["user_id"]);
$him_accept_contactlist_users_relationships = get_field("i_accept_contactlist_users_relationships", "user_".$args["user_id"]);

$is_reniew_post_premium = get_field("post_Is_Automatic_Renewal", $args['id']);
$post_comment_available = get_field("post_comment_available", $args['id']);


?>

<div id="slate-<?php echo $args["id"]; ?>" class="card <?php if( is_array($args['img']) && count($args['img']) > 1 && $args['img_display'] !== "grid"){ echo "carrousel glide"; } ?>" data-h-id="<?php echo $args["id"]; ?>" data-post-type="<?php echo $args["post_type_slug"]; ?>">
    <button onclick="location.href='<?php echo $post_permalink; ?>'" class="card__header flex flex--vertical">
        <div class="post-header card__header__item flex flex--justify-between">
            <!-- Post author -->
            <div class="post-header__main-title flex flex--vertical-center">

				<div class="avatar__list--wrapper">
					<?php   get_template_part("components/user-avatar", null, array(
						'title' => $args["post_creator_name"],
						'image' =>  $user_avatar_id !=null ? $user_avatar_id : $main_picture_image_ids_array[0],
						'first_name' => $args["first_name"],
						'last_name' => $args["last_name"],
					) ); ?>
				</div>

                <div class="card__wrapper__title flex">

					<?php if(!empty($args["post_creator_name"]) && $args["post_creator_name"] != " "): ?>
						<a href="<?php echo user_has_profile_post($args["user_id"]) ? get_permalink(user_has_profile_post($args["user_id"])) : $user_link; ?>" class="card__title__owner"  style="margin-right: unset">
							<?php echo $args["post_creator_name"]  ;?>
						</a><?php endif; ?>




                    <?php
                    //							if($args["user_id"] == $current_user_id) {
                    //								echo "<span style='background: #4b4235; padding: 5px 10px;font-size: x-small; border-radius: 100%;font-weight: 600;color: white;'> </span>";
                    //							}
                    ?>
                </div>
            </div>

            <!-- Post type -->
            <?php if($args["post_type"] && $args["post_type_slug"]): ?>
			<div class="post-type flex flex--vertical-center">
				<?php
				$is_reniew_post_premium = get_field("post_Is_Automatic_Renewal", $args["id"]);
				if ($is_reniew_post_premium)echo file_get_contents(get_stylesheet_directory().'/src/images/icons/badge-check-verified.svg'); ?>


					<span class="post-type__name post-type__name--<?php echo $args["post_type_slug"]; ?>">
							<?php  print_User_Category($account_category); ?>
					</span>
                    <?php echo file_get_contents(get_stylesheet_directory().'/src/images/icons/post-type-'.$args["post_type_slug"].'.svg'); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="flex flex--justify-between card__header__item">
            <div class="flex flex--vertical-center owner_by">
				<span class="post-category post_type">
					<?php
					if($account_category == "pro-user"){
						get_first_element(  $args["post_home_Jobs_title"]);
					} else {
						get_first_element(  $args["post_home_sector_activity"]);
					}

					?>
				</span>
            </div>
            <?php if($args["address_name"]): ?>
                <div class="flex flex--vertical-center">
					<span class="post-location__adress">
						<?php echo $args["address_name"]; ?>
					</span>
                </div>
            <?php endif; ?>
            </a>
        </div>

        <!-- Post price and bedrooms and bathrooms and house and land -->
        <?php if($args["price"] || $args["bedrooms"] || $args["bathrooms"] || $args["house"] || $args["land"]): ?>
            <div class="post-details card__header__item flex flex--justify-between">
                <?php if($args["price"]): ?>
                    <div class="post-details__price">
                        <?php get_template_part( 'components/price', null, array(
                                'price' =>  $args["price"], )
                        ); ?>
                    </div>
                <?php endif; ?>
                <?php if($args["bedrooms"] || $args["bathrooms"] || $args["house"] || $args["land"]): ?>
                    <ul class="post-details__caracteristics flex flex--vertical-center">
                        <?php if($args["bedrooms"]): ?>
                            <li class="post-details__bedroom">
                                <span class="post-details__prefix p-xs"><abbr title="<?php _e("Bedroom", "homazed"); ?>"><?php _e("BDR", "homazed"); ?></abbr></span>
                                <?php echo str_replace(' ', '', $args["bedrooms"]); ?>
                            </li>
                        <?php endif; ?>
                        <?php if($args["bathrooms"]): ?>
                            <li class="post-details__bathroom">
                                <span class="post-details__prefix p-xs"><abbr title="<?php _e("Bathroom", "homazed"); ?>"><?php _e("BTH", "homazed"); ?></abbr></span>
                                <?php echo str_replace(' ', '', $args["bathrooms"]); ?>
                            </li>
                        <?php endif; ?>
                        <?php if($args["house"]): ?>
                            <li class="post-details__house">
                                <span class="post-details__prefix p-xs"><abbr title="<?php _e("House", "homazed"); ?>"><?php _e("H", "homazed"); ?></abbr></span>
                                <?php echo str_replace(' ', '', $args["house"]); ?><span class="post-details__suffix p-xs"><abbr title="<?php _e("Square feet meters", "homazed"); ?>"><?php _e("m2", "homazed"); ?></abbr></span>
                            </li>
                        <?php endif; ?>
                        <?php if($args["land"]): ?>
                            <li class="post-details__land">
                                <span class="post-details__prefix p-xs">L</span>
                                <?php echo str_replace(' ', '', $args["land"]); ?><span class="post-details__suffix p-xs"><abbr title="<?php _e("Square feet meters", "homazed"); ?>"><?php _e("m2", "homazed"); ?></abbr></span>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </button>

    <!-- Post image -->

    <?php if(isset($args['img']) && is_array($args['img'])): ?>
        <div class="card__img">
            <div class="floating-bar flex">
                <?php if($post_join_file): ?>
                    <?php get_template_part( 'components/btn', null,
                        array(
                            'label' => 'File',
                            'href' => $post_join_file,
                            'target' => "_blank",
                            'skin'  => 'ghost',
                            'icon-only'  => false,
                            'disabled'  => false,
                            'icon-position' => 'left',
                            'icon' => 'hyperlink-2',
                            'additional-classes' => 'btn--small',
                            'data-attribute' => '',
                            'theme' => "",
                        )
                    ); ?>
                <?php endif; ?>

                <?php if(!empty($args['video_']) && $args['video_']): ?>
                    <?php get_template_part('components/btn', null,
                        array(
                            'label' => 'Video',
                            'href' => esc_url(stripslashes($args["video_"])),
                            'target' => "_blank",
                            'skin'  => 'ghost',
                            'icon-only'  => false,
                            'disabled'  => false,
                            'icon-position' => 'left',
                            'icon' => 'hyperlink-2',
                            'additional-classes' => ' btn--small ',
                            'data-attribute' => '',
                            'theme' => "",
                        )
                    ); ?>
                <?php endif; ?>
                <span class="gallery__size flex flex--vertical-center flex--horizontal-center">
					<b><?php echo count($args['img']); ?></b>
					<?php
                    echo "<div class='o-svg-icon o-svg-icon-paginate-filter-picture'>";
                    include get_stylesheet_directory() . '/src/images/icons/paginate-filter-picture.svg';
                    echo "</div>";
                    ?>
				</span>
            </div>
            <?php if($args['img_display'] === "grid" && count($args['img']) > 1): ?>
                <?php get_template_part("components/grid-images", null, array(
                    'post_id' => $args['id'],
                    'img' => $args['img'],
                    'post_creator_name' => $args["post_creator_name"],
                    'post_creator_link' => $args["post_creator_link"],
                    'image_field_name' => 'post_gallery_image'
                )); ?>
            <?php else: ?>
                <?php if(count($args['img']) > 1  ): ?>
                    <?php

                    //todo_augustin limiter 7 pour les non premium
                    $firstSevenValues = array_slice($args['img'], 0, 7);

                    get_template_part("components/carrousel-card", null, array(
                        'post_id' => $args['id'],
                        'img' =>  $args['img']  ,
                        'video_' =>  $args['video_'],
                        'post_creator_name' => $args["post_creator_name"],
                    )); ?>
                <?php else: ?>
                    <?php get_template_part("components/carrousel-single-image", null, array(
                        'post_id' => $args['id'],
                        'img' => $args['img'],
                        //'video_' => $args['video_'],

                        'post_creator_name' => $args["post_creator_name"],
                    )); ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <button onclick="location.href='<?php echo $post_permalink; ?>'" class="card__header card__header--lower flex flex--vertical">

        <?php $i_request_this_contact = (!empty($i_request_contactlist_users_relationships) && in_array($args["user_id"], $i_request_contactlist_users_relationships)) ? true : false; ?>
        <?php $i_accept_this_contact = (!empty($i_accept_contactlist_users_relationships) && in_array($args["user_id"], $i_accept_contactlist_users_relationships)) ? true : false; ?>
        <?php $him_request_me = (!empty($him_request_contactlist_users_relationships ) && in_array($current_user_id, $him_request_contactlist_users_relationships )) ? true : false; ?>
        <?php $him_accept_me = (!empty($him_accept_contactlist_users_relationships ) && in_array($current_user_id, $him_accept_contactlist_users_relationships )) ? true : false; ?>

        <?php if($post_events_text_1 && $post_events_type)  : ?>
            <?php
            $contact_classes = 'relation_btn relation_btn--contact-list';
            $contact_text = $post_events_text_1;
            $contact_text_default = 'Add contact';
            $contact_text_requested = 'Contact requested';
            $contact_icon = 'add-square';
            $relation_type = 'request-contact-list';

            if($i_request_this_contact && $i_accept_this_contact && $him_request_me && !$him_accept_me){
                // I request & him did not accept yet [GREEN1]";
                $contact_text = 'Contact requested';
                $contact_classes .= ' relation_btn--contact-requested';
                $contact_icon = 'single-neutral-actions-refresh';
                $relation_type = 'remove-request-contact-list';
            }elseif($i_request_this_contact && $i_accept_this_contact && $him_request_me && $him_accept_me){
                // relation done [RED]";
                $contact_text = 'Contact accepted';
                $contact_classes .= ' relation_btn--contact-relation-done';
                $contact_icon = 'check-circle-1';
                $relation_type = 'refuse-contact-list';
                // alert(are your sure ?)
            }elseif($i_request_this_contact  && !$i_accept_this_contact && $him_request_me && $him_accept_me){
                // He request, I did not accept yet [GREEN2]";
                $contact_text = 'Accept contact';
                $contact_classes .= ' relation_btn--contact-him-requested';
                $contact_icon = 'check-circle-1';
                $relation_type = 'accept-contact-list';
            }elseif(!$i_request_this_contact && !$i_accept_this_contact && !$him_request_me && !$him_accept_me){
                // No request for now [Default & BLACK]";
            }
            ?>
            <div class="card__body" style="max-height: unset">
                <?php get_template_part( 'components/event', null,
                    array(
                        'event_type' => $post_events_type,
                        'event_privacy' => $post_events_privacy,
                        'text_1' => $contact_text,
                        'text_2' => $post_events_text_2,
                        'additional-classes' => $contact_classes,
                        'data-attribute' => "data-relation-him=" . $args["user_id"] . " data-relation-type=" . $relation_type . " data-request-contact-default=" . rawurlencode($contact_text_default) . "  data-request-contact-requested=" . rawurlencode($contact_text_requested) . ""
                    )
                ); ?>
            </div>
        <?php endif; ?>

        <?php
        /**
         * todo_augustin : trier les tags
         */
        if($args["tags"]): ?>
            <div class="card__header__item card__header__item--tags">
                <div class="tag-list-container " style="display: inline-grid">
                    <span class="chevron left-chevron">&#9664;</span>
                    <div class="tag-list-wrapper">
                        <div class="tag-list">
                            <p>
                                <?php foreach ($args["tags"] as $tag): ?>
                                    <a href="<?php echo get_permalink("604"); ?>?tag=<?php echo $tag->slug ?>" class="tag">
                                        <span class="hash">#</span><?php echo $tag->name; ?>
                                    </a>
                                <?php endforeach; ?>
                            </p>
                        </div>
                    </div>
                    <span class="chevron right-chevron">&#9654;</span>
                </div>
            </div>



        <?php endif; ?>


        <?php // if($args["content"]): ?>
        <div class="card__header__item card__header__item--content h-p">
            <p class="post-body">
                <?php echo $args['content']; ?>
            </p>
        </div>
        <?php // endif; ?>


        <?php //todo_augustin : interchange like ?>
        <!-- Post actions -->
        <div class="card__footer">
            <ul class="post-footer__left flex">
                <li  class="post-footer__like post-footer__relation flex flex--justify-center flex--vertical-center">
                    <?php $is_checked_like = (!empty($i_like_posts_relationships) && in_array($args["id"], $i_like_posts_relationships)) ? true : false; ?>

                    <?php get_template_part("components/btn", null, array(
                        'label' => 'Like',
                        'href' => "",
                        'target' => "_self",
                        'skin'  => 'transparent',
                        'icon-only'  => true,
                        'disabled'  => false,
                        'icon-position' => '', // left or right
                        'icon' => 'love-it', // nom du fichier svg
                        'additional-classes' => $is_checked_like ? 'post-footer__button relation_btn--checked relation_btn relation_btn__posts relation_btn--like' : 'post-footer__button relation_btn relation_btn__posts relation_btn--like',
                        'data-attribute' => "data-relation-him=" . $args["id"] . " data-relation-type='like'",
                        'theme' => "",
                    )); ?>
                    <?php if($users_like_me_posts): //todo_augustin likes?>
                        <span class="count-like_">  <?php echo count($users_like_me_posts); ?> </span>
                    <?php endif; ?>

                    <?php if(!$users_like_me_posts): //todo_augustin likes?>
                        <span class="count-like_">  </span>
                    <?php endif; ?>
                </li>

                <?php
                if($post_comment_available) { ?>
                    <li class="post-footer__comment">
                        <?php

                        get_template_part("components/btn", null,
                            array(
                                'label' => 'Add a comment',
                                'href' => "",
                                'target' => "_self",
                                'skin'  => 'transparent',
                                'icon-only'  => true,
                                'disabled'  => false,
                                'icon-position' => 'right', // left or right
                                'icon' => 'messages-bubble',
                                'additional-classes' => 'post-footer__button',
                                'data-attribute' => null,
                                'theme' => "",
                            )
                        );

                        ?>
                    </li>
                <?php } ?>


            </ul>

            <div class="flex flex--justify-center flex--vertical-center">


                <?php get_template_part("components/btn", null,
                    array(
                        'label' => 'More...',
                        'href' => "",
                        'target' => "_self",
                        'skin'  => 'transparent',
                        'icon-only'  => true,
                        'disabled'  => false,
                        'icon-position' => 'right', // left or right
                        'icon' => 'navigation-menu-horizontal', // nom du fichier svg
                        'additional-classes' => 'post-footer__button card-popup-fire',
                        'data-attribute' => 'data-card-popup-id=\'user-card-popup-links-' . $args["id"] . '\'',
                        'theme' => "",
                    )
                ); ?>
                <p class="post-footer__publish-date p-xs">
                    <?php echo $args["publish_date"]; ?>
                </p>
            </div>

            <ul class="post-footer__right flex flex--justify-end">

				<?php //add recommendation ?>
                <li class="post-footer__favorite post-footer__relation">
                    <?php
						$account_category = get_field("account_category", "user_".$args["user_id"]);
						$is_for_recommandation = $account_category == "pro-user" || $account_category == "company-user";

					if ($is_for_recommandation) {
						$recommended_users = get_post_meta($args["id"], 'profile-recommend', true);
						if (!is_array($recommended_users)) {
							$recommended_users = [];
						}

						$is_recommended = in_array(get_current_user_id(), $recommended_users) ? 'active' : '';

						get_template_part("components/btn", null, array(
							'label' => '('.count($recommended_users).') Recommend',
							'href' => "#",
							'target' => "_self",
							'skin'  => 'transparent',
							'icon-only'  => true,
							'disabled'  => false,
							'icon-position' => '',
							'icon' => 'like-1',
							'additional-classes' => 'profile-recommend-btn ' . $is_recommended, // Ajout de la classe active
							'data-attribute' => "data-recommanduser='".$args["user_id"]."' data-postid='".$args["id"]."' data-userid='".get_current_user_id()."'",
							'theme' => "",
						));
					}

					?>
                </li>

				<!-- Add contact -->
				<li class="post-footer__favorite post-footer__relation">
                    <?php $is_checked_favorite = (!empty($i_favorite_posts_relationships) && in_array($args["id"], $i_favorite_posts_relationships)) ? true : false; ?>

                    <?php
					$i_request_contactlist_users_relationships = get_field("i_request_contactlist_users_relationships", "user_".$current_user_id);

					// Vérifier si l'utilisateur cible est déjà dans la liste de contacts
					$is_in_contact_list = is_array($i_request_contactlist_users_relationships) && in_array($args["user_id"], $i_request_contactlist_users_relationships);
					$active_class = $is_in_contact_list ? 'active' : '';

					get_template_part('components/btn', null, array(
						'label' => $is_in_contact_list ? 'Remove Contact' : 'Add Contact', // Modifier le label
						'href' => "#",
						'target' => "_self",
						'skin'  => 'transparent',
						'icon-only'  => true,
						'disabled'  => false,
						'icon-position' => '',
						'icon' => $is_in_contact_list ? 'user-added': 'user-plus',
						'additional-classes' => ' contact-toggle-btn  ' . $active_class,
						'data-attribute' => "data-userid='".$current_user_id."' data-contactid='".$args["user_id"]."'",
						'theme' => "",
					));

					?>
                </li>
				<!-- End Contact -->

                <li class="post-footer__share">
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
                            'data-attribute' => 'data-open-modal=\'share-slate-' . $args["id"] . '\'' ,
                            'theme' => "",
                        )
                    );
                    ?>
                </li>
            </ul>
        </div>

        <?php //todo_augustin gestion component share et profile ?>
        <?php ?>
        <?php get_template_part("components/more_profil_setting_modal", null, array(
                'first_name' => $args["first_name"],
                'last_name' => $args["last_name"],
                "id" => $args["id"],
                'post_permalink' => $post_permalink,
                "user_id" => $args["user_id"]
            )
        ); ?>

        <?php get_template_part("components/share-box-modal", null, array(
                'first_name' => $args["first_name"],
                'last_name' => $args["last_name"],
                "id" => $args["id"],
                'post_permalink' => get_field("user_profile_url", "user_".$args["user_id"]),
            )
        ); ?>
        <?php // end todo_augustin gestion component share et profile ?>

    </button>
</div>
