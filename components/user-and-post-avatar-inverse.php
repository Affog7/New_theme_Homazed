<div class="avatar__list">
    <div class="avatar__list--wrapper">

		<?php if($args["post_main_picture"]) :  ?>
			<div class="avatar">
				<img class="avatar__image post__avatar" src="<?php echo wp_get_attachment_image_src($args["post_main_picture"], 'large-img-medium')[0]; ?>" alt="<?php echo $args["first_name"]." ".$args["last_name"]." profile image"; ?>" />
			</div>
		<?php  endif; ?>
        <?php
		if(isset($args["user_picture"])):
			$avatar_ids_array = explode(',', $args["user_picture"]);
			?>

			<?php if(  strlen($avatar_ids_array[0]) > 6) { ?>
				<a href="<?php echo $args["user_link"]; ?>" class="">
					<div>
						<img class="resume__image" src="<?php echo  $avatar_ids_array[0] ; ?>" alt="<?php echo $args["first_name"]." ".$args["last_name"]." profile image"; ?>" />

					</div>
				</a>
			<?php

			} else {

			if(!empty($args["user_picture"]) && !empty(wp_get_attachment_image_src($avatar_ids_array[0], 'large-img-medium'))): ?>
				<a href="<?php echo $args["user_link"]; ?>" class="">
					<img class="resume__image" src="<?php echo wp_get_attachment_image_src($avatar_ids_array[0], 'large-img-medium')[0]; ?>" alt="<?php echo $args["first_name"]." ".$args["last_name"]." profile image"; ?>" />
				</a>
					<?php else: ?>
				<div class="avatar">
					<a href="<?php echo $args["user_link"]; ?>" class="avatar__image avatar--blank flex flex--horizontal-center flex--center">
						<span class="first-letters"><?php echo $args["first_name"][0].$args["last_name"][0]; ?></span>
					</a>
				</div>
			<?php endif;} ?>
		<?php endif; ?>

    </div>
</div>
