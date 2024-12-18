<?php //todo_augustin modal profile ?>

<div class="modal micromodal-slide" id="user-card-popup-links-<?php echo $args["id"]; ?>"  aria-hidden="true">
	<div class="modal__overlay" tabindex="-1" data-micromodal-close>
		<div class="modal__container" style="overflow: hidden" role="dialog" aria-modal="true" aria-labelledby="publish-home-titlen">
		<header class="modal__header">
				<div class="flex flex--vertical">
					<h2 class="h1"> </h2>
				</div>
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
			</header>

<main class="modal__content contact__form contact__form--light">
	<?php if(get_current_user_id() != $args["user_id"]): ?>
		<a href="" class="quicklinks--item hide-post-button" data-post-id="<?php echo $args["id"]; ?>">
			Hide this Post from me
			<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
		</a>
		<a href="" class="quicklinks--item report-post-button" data-post-id="<?php echo $args["id"]; ?>">
			Signal this Post
			<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/alert-triangle.svg'; echo "</div>"; ?>
		</a>
	<?php else: ?>
		<a href="<?php echo esc_url($args["post_permalink"]) ;?>" class="quicklinks--item edit_post_main">
			Update  Post
			<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
		</a>
		<a href="/manageslate/?post=<?php echo $args["id"]; ?>" class="quicklinks--item">
			Promote Post
			<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
		</a>

	<?php endif; ?>
 
	</main>
</div>
	</div>
</div>