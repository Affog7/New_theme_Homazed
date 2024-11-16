<?php
	$i_favorite_users_relationships = get_field("i_favorite_users_relationships", "user_".get_current_user_ID());
	$i_like_users_relationships = get_field("i_like_users_relationships", "user_".get_current_user_ID());

	$users_like_me_relationships = get_field("users_like_me_relationships", "user_".$args["id"]);
	$users_like_me_relationships = get_field("users_like_me_relationships", "user_".$args["id"]);
?>

<div id="slate-<?php echo $args["id"]; ?>" class="card <?php if( is_array($args['img']) && count($args['img']) > 1 && $args['img_display'] !== "grid"){ echo "carrousel glide"; } ?>" data-h-id="<?php echo $args["id"]; ?>" data-post-type="<?php echo $args["post_type_slug"] ?>">
	<div class="card__header flex flex--vertical">
		<a href="<?php echo $args["post_creator_link"]; ?>" class="post-header card__header__item flex flex--justify-between flex--vertical-center">
			<!-- Post author -->
			<div class="card__title owner flex flex--vertical-center">

					<?php $avatar_ids = get_field("user_avatar_ids", "user_".$args["id"]); ?>
					<?php get_template_part("components/user-avatar-small", null, array(
						'image' => $avatar_ids,
						'first_name' => $args["first_name"],
						'last_name' => $args["last_name"]
					) ); ?>

					<span class="owner__name">
						<?php
						if(isset($args["first_name"]) && isset($args["last_name"])):
							echo $args["first_name"] . " " .$args["last_name"];
						endif;
						?>
					</span>
			</div>

			<!-- Post type -->
			<?php if($args["post_type"] && $args["post_type_slug"]): ?>
				<div class="post-type flex flex--vertical-center">
					<span class="post-type__name post-type__name--<?php echo $args["post_type_slug"]; ?>">
						<?php echo $args["post_type"]; ?>
					</span>
					<?php echo file_get_contents(get_stylesheet_directory().'/src/images/icons/post-type-'.$args["post_type_slug"].'.svg'); ?>
				</div>
			<?php endif; ?>
		</a>

		<!-- USER Post work position -->
		<?php if($args["work_position"]): ?>
			<div class="post-details post-details__work-position card__header__item flex flex--justify-between flex">
				<div class="post-details__item">
					<?php echo $args["work_position"]; ?>
				</div>
				<?php if($args["sector_of_activity"]): ?>
					<div class="post-details__item">
						<?php echo $args["sector_of_activity"]; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if($args["tags"]): ?>
			<div class="card__header__item">
				<div class="tag-list">
					<p>
						<?php foreach ($args["tags"] as $tags): ?>
							<a href="<?php echo get_permalink("604"); ?>?tag=<?php echo $tags->slug ?>" class="tag">#<?php echo $tags->name ; ?></a>
						<?php endforeach; ?>
					</p>
				</div>
			</div>
		<?php endif; ?>

	</div>



	<!-- Post image -->

	<?php if(isset($args['img']) && is_array($args['img'])): ?>
		<?php if($args['img_display'] === "grid" & count($args['img']) > 1): ?>
			<?php get_template_part("components/grid-images", null, array(
				'img' => $args['img'],
				'post_creator_name' => $args["post_creator_name"],
				'post_creator_link' => $args["post_creator_link"],
				'image_field_name' => 'user_gallery_image'
			)); ?>
		<?php else: ?>
			<div class="card__img">
				<?php if(count($args['img']) > 1): ?>
					<?php get_template_part("components/carrousel", null, array(
						'img' => $args['img'],
						'post_creator_name' => $args["post_creator_name"],
					)); ?>
				<?php else: ?>
					<?php get_template_part("components/carrousel-single-image", null, array(
						'img' => $args['img'],
						'post_creator_name' => $args["post_creator_name"],
					)); ?>
				<?php endif;  ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if($args["content"]): ?>
		<!-- Post content -->
		<div class="card__body h-p">
			<p class="post-body">
				<?php echo $args['content']; ?>
			</p>
		</div>
	<?php endif; ?>

	<?php if($users_like_me_relationships): ?>
		<div class="card__body h-p card__body__relations">
			<p class="post-body counter">
				<?php echo  count($users_like_me_relationships) . " people like this"; ?>
			</p>
		</div>
	<?php endif; ?>

	<!-- Post actions -->
	<div class="card__footer">
		<ul class="post-footer__left flex">
			<li class="post-footer__comment">
				<?php get_template_part("components/btn", null,
					array(
						'label' => 'Comments',
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
				); ?>
			</li>
		</ul>

		<p class="post-footer__publish-date p-xs">
			<?php
			if(isset($args["publish_date"])):
				echo $args["publish_date"];
			else:
				echo "N/A";
			endif;
			?>
		</p>

		<ul class="post-footer__right flex flex--justify-end">
			<li class="post-footer__options">
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
			</li>
			<li class="post-footer__favorite post-footer__relation">
				<?php $is_checked_favorite = (!empty($i_favorite_users_relationships) && in_array($args["id"], $i_favorite_users_relationships)) ? true : false; ?>

				<?php get_template_part("components/btn", null, array(
					'label' => 'Favorite',
					'href' => "",
					'target' => "_self",
					'skin'  => 'transparent',
					'icon-only'  => true,
					'disabled'  => false,
					'icon-position' => '', // left or right
					'icon' => 'rating-star-ribbon', // nom du fichier svg
					'additional-classes' => $is_checked_favorite ? 'post-footer__button relation_btn--checked relation_btn relation_btn--favorite' : 'post-footer__button relation_btn relation_btn--favorite',
					'data-attribute' => "data-relation-him=" . $args["id"] . " data-relation-type='favorite'",
					'theme' => "",
				)); ?>
			</li>
			<li  class="post-footer__like post-footer__relation">
				<?php $is_checked_like = (!empty($i_like_users_relationships) && in_array($args["id"], $i_like_users_relationships)) ? true : false; ?>

				<?php get_template_part("components/btn", null, array(
					'label' => 'Like',
					'href' => "",
					'target' => "_self",
					'skin'  => 'transparent',
					'icon-only'  => true,
					'disabled'  => false,
					'icon-position' => '', // left or right
					'icon' => 'love-it', // nom du fichier svg
					'additional-classes' => $is_checked_like ? 'post-footer__button relation_btn--checked relation_btn relation_btn--like' : 'post-footer__button relation_btn relation_btn--like',
					'data-attribute' => "data-relation-him=" . $args["id"] . " data-relation-type='like'",
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
	<div id="user-card-popup-links-<?php echo $args["id"]; ?>" class="card-popup card-popup--hidden">
		<div class="quicklinks">
			<div class="quicklinks--item">
				<h2 class="h4">More actions on <?php echo $args["first_name"] . " " .$args["last_name"]; ?></h2>
				<div>
					<?php get_template_part("components/btn", null,
						array(
							'label' => 'Close',
							'href' => "",
							'target' => "_self",
							'skin'  => 'transparent',
							'icon-only'  => false,
							'disabled'  => false,
							'icon-position' => 'right', // left or right
							'icon' => 'delete-1', // nom du fichier svg
							'additional-classes' => ' card-popup-close',
							'data-attribute' => null,
							'theme' => "",
						)
					); ?>
				</div>
			</div>
			<?php if(get_current_user_id() != $args["id"]): ?>
				<a href="" class="quicklinks--item">
					Hide this profile from me
					<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
				</a>
				<a href="" class="quicklinks--item">
					Signal this profile
					<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/alert-triangle.svg'; echo "</div>"; ?>
				</a>
			<?php else: ?>
				<a href="" class="quicklinks--item">
					Upgrade my profile
					<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
				</a>
				<a href="" class="quicklinks--item">
					Promote my profile
					<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
				</a>
				<a href="" class="quicklinks--item">
					Edit my profile
					<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
	<div class="modal micromodal-slide" id="share-slate-<?php echo $args["id"]; ?>" aria-hidden="true">
		<div class="modal__overlay" tabindex="-1" data-micromodal-close>
			<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="publish-home-title">
				<header class="modal__header">
					<div class="flex flex--vertical">
						<h2 class="h1">Share <?php echo $args["first_name"] . " " .$args["last_name"]; ?> profile</h2>
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
					<?php get_template_part( 'components/copy-paste', null,
						array(
							'label' => 'Copy user link',
							'copyValue' => $args["post_creator_link"],
							"iteration" => $args["id"]
						)
					); ?>
				</main>
			</div>
		</div>
	</div>
</div>
