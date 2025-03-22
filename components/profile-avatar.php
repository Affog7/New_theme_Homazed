<div class="post-main-avatar" style="height: 15%">
	<?php if(!empty($args["image"]) && !empty(wp_get_attachment_image_src($avatar_ids_array[0], 'large-img-medium'))): ?>
		<?php $avatar_ids_array = explode(',', $args["image"]); ?>
		<img class="resume__image" src="<?php echo wp_get_attachment_image_src($avatar_ids_array[0], 'large-img-medium')[0]; ?>" alt="<?php echo $args["first_name"]." ".$args["last_name"]." profile image"; ?>" />
	<?php else: ?>
		<div  style="width: 75%;    height: 50%;    padding: 10px;    border-radius: 50%;" class="resume__image  resume__image--blank flex flex--horizontal-center flex--center">
			<span class="first-letters"><?php echo $args["first_name"][0].$args["last_name"][0]; ?></span>
		</div>
	<?php endif; ?>
</div>
