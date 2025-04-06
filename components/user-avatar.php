<div class="resume__profile-picture">
	<?php
	$avatar_ids_array = explode(',', $args["image"]);
if(  strlen($avatar_ids_array[0]) > 6){
	?>
	<img class="resume__image" src="<?php echo  $avatar_ids_array[0] ; ?>" alt="<?php echo $args["first_name"]." ".$args["last_name"]." profile image"; ?>" />

	<?php
} else {
	if(!empty($args["image"]) && !empty(wp_get_attachment_image_src($avatar_ids_array[0], 'large-img-medium'))): ?>

		<img class="resume__image" src="<?php echo wp_get_attachment_image_src($avatar_ids_array[0], 'large-img-medium')[0]; ?>" alt="<?php echo $args["first_name"]." ".$args["last_name"]." profile image"; ?>" />
	<?php else: ?>
		<div class="resume__image resume__image--blank flex flex--horizontal-center flex--center" style="    height: 65px;
    width: 70px;">
			<span class="first-letters"><?php echo $args["first_name"][0].$args["last_name"][0]; ?></span>
		</div>
	<?php endif;} ?>
</div>
