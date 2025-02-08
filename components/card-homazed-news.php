<?php

$user_link = get_permalink("602")."?user_id=".$args["user_id"];

$i_favorite_posts_relationships = get_field("i_favorite_posts_relationships", "user_".get_current_user_ID());
$i_like_posts_relationships = get_field("i_like_posts_relationships", "user_".get_current_user_ID());

$users_like_me_posts = get_field("users_like_me_posts", $args["id"]);
$users_favorite_me_posts = get_field("users_favorite_me_posts", $args["id"]);
$user_avatar_id = get_field("user_avatar_ids", "user_".$args["user_id"]);

// si un post est lié, on recupère le main du post
if($args["post_w_linked"]) {
	$main_picture_image_ids = get_field("post_home_main_picture_ids",intval($args["post_w_linked"]));
	$main_picture_image_ids_array = explode(',', $main_picture_image_ids);

	$gallery_image_ids = get_field("post_home_gallery_ids");
	$gallery_image_ids_array = explode(',', $gallery_image_ids);

	$post_avatar_picture_id = (!empty($main_picture_image_ids_array[0])) ? $main_picture_image_ids_array[0] : $gallery_image_ids_array[0];
}

$current_user_id = get_current_user_id();

$post_events_type = get_field("post_home_event_type", $args["id"]);
$post_events_text_1 = get_field("post_home_event_text_1", $args["id"]);
$post_events_text_2 = get_field("post_home_event_text_2", $args["id"]);
$post_events_privacy = get_field("post_home_event_privacy", $args["id"]);

$post_join_file_id = get_field("post_home_join_file", $args["id"]);
$post_join_file = wp_get_attachment_url($post_join_file_id);
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

				<?php
				get_template_part("components/user-and-post-avatar", null, array(
					'user_picture' => $user_avatar_id,
					'post_main_picture' => $post_avatar_picture_id,
					'first_name' => $args["first_name"],
					'last_name' => $args["last_name"],
					'user_link' => $user_link,
				) );
				?>
				<div class="card__wrapper__title flex">

					<?php if(!empty($args["post_creator_name"]) && $args["post_creator_name"] != " "): ?>
						<a href="<?php echo $user_link; ?>" class="card__title__owner">
							<?php
							echo $args["post_creator_name"].";";
							?></a>
					<?php endif; ?>
					<span class="card__title flex flex--vertical-center">
						<?php
							 if($args["post_w_linked"]){
								 echo "<a href=".get_permalink(intval($args["post_w_linked"]))."> ".get_the_title(intval($args["post_w_linked"]))." </a>";
							 }
						?>
					</span>

				</div>
			</div>

			<!-- Post type -->
			<?php if($args["post_type"] && $args["post_type_slug"]): ?>
				<div class="post-type flex flex--vertical-center">

					<span class="post-type__name post-type__name--<?php echo $args["post_type_slug"]; ?>">
							<?php switch ($args["post_type"]) {
								case "news": echo __('NEWS', 'homazed'); break;
								case "Services": echo __('Services', 'homazed'); break;
							} ?>
					</span>

					<?php echo file_get_contents(get_stylesheet_directory().'/src/images/icons/post-type-'.$args["post_type_slug"].'.svg'); ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="flex flex--justify-between card__header__item">
			<div class="flex flex--vertical-center owner_by">
				<span class="post-category post_type">
					<?php //get_first_element($args["post_w_linked"]); ?>
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
				<li class="post-footer__favorite post-footer__relation">
					<?php $is_checked_favorite = (!empty($i_favorite_posts_relationships) && in_array($args["id"], $i_favorite_posts_relationships)) ? true : false; ?>

					<?php get_template_part("components/btn", null, array(
						'label' => 'Favorite',
						'href' => "",
						'target' => "_self",
						'skin'  => 'transparent',
						'icon-only'  => true,
						'disabled'  => false,
						'icon-position' => '', // left or right
						'icon' => 'rating-star-ribbon', // nom du fichier svg
						'additional-classes' => $is_checked_favorite ? 'post-footer__button relation_btn--checked relation_btn relation_btn__posts relation_btn--favorite' : 'post-footer__button relation_btn relation_btn__posts relation_btn--favorite',
						'data-attribute' => "data-relation-him=" . $args["id"] . " data-relation-type='favorite'",
						'theme' => "",
					)); ?>
				</li>

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
				'post_permalink' => $post_permalink
			)
		); ?>
		<?php // end todo_augustin gestion component share et profile ?>

	</button>
</div>
