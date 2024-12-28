<?php //todo_augustin modal profile ?>
<div id="user-card-popup-links-<?php echo $args["id"]; ?>" class="card-popup card-popup--hidden">
		<div class="quicklinks">
			<div class="quicklinks--item">
				<h2 class="h4"> </h2>
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

<?php if(get_current_user_id() != $args["user_id"]): ?>
	<a href="" class="quicklinks--item hide-post-button" data-post-id="<?php echo $args["id"]; ?>">
		Hide this profile from me
		<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
	</a>
	<a href="" class="quicklinks--item report-post-button" data-post-id="<?php echo $args["id"]; ?>">
		Signal this profile
		<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/alert-triangle.svg'; echo "</div>"; ?>
	</a>
<?php else: ?>
	<a href="<?php echo esc_url($args["post_permalink"])."/?post_id=".$args["id"] ;?>" class="quicklinks--item edit_post_main">
		Update  post
		<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
	</a>
	<a href="<?php echo esc_url($args["post_permalink"])."/?post_id=".$args["id"]."&premium=1" ;?>" class="quicklinks--item">
		Promote post
		<?php  echo "<div class='o-svg-icon o-svg-icon-arrow'>"; include get_stylesheet_directory() . '/src/images/icons/pencil-write.svg'; echo "</div>"; ?>
	</a>

<?php endif; ?>
</div>
</div>