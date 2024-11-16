<?php if(isset($args["image"])): ?>
	<?php $avatar_ids_array = explode(',', $args["image"]); ?>
	<img class="owner__avatar" src="<?php echo wp_get_attachment_image_src($avatar_ids_array[0], 'large-img-medium')[0]; ?>" alt="<?php echo $args["first_name"]." ".$args["last_name"]." profile image"; ?>" />
<?php else: ?>
	<div class="owner__avatar owner__avatar--blank flex flex--horizontal-center flex--center">
		<span class="first-letters"><?php echo $args["first_name"][0].$args["last_name"][0]; ?></span>
	</div>
<?php endif; ?>