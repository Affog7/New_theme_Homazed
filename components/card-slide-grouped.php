
<?php if ($args["main_picture"][0] !=""):   ?>
<div class="post_prof">
	<div class="post_prof-thumbnail">
		<div class="floating-bar flex">
			<span class="gallery__size flex flex--vertical-center flex--horizontal-center">
					<b><?php echo count($args['all_img']); ?></b>
					<?php
					echo "<div class='o-svg-icon o-svg-icon-paginate-filter-picture'>";
					include get_stylesheet_directory() . '/src/images/icons/paginate-filter-picture.svg';
					echo "</div>";
					?>
				</span>
		</div>

		<img src="<?php echo wp_get_attachment_image_src($args["main_picture"][0],'large-img-medium')[0] ;?>" alt="Post 2">
	</div>
	<div class="post_prof-gallery">
		<?php
		foreach ($args["all_img"] as $post_gallery_id):
			if ($post_gallery_id) : ?>
				<img src="<?php echo wp_get_attachment_image_src($post_gallery_id, 'thumbnail-m')[0]; ?>" alt="Image 1">
			<?php endif;
		endforeach;
		?>

	</div>
</div>
<?php endif; ?>
