<div class="avatar__list">
    <div class="avatar__list--wrapper">


        <?php  if(isset($args["user_picture"]) && $args["user_picture"] ): ?>

            <a href="<?php echo $args["user_link"]; ?>" class="avatar owner__avatar">
				<?php  if( !is_array($args["user_picture"]) && strlen($args["user_picture"]) > 6){ ?>
					<img class="avatar__image" src="<?php echo  $args["user_picture"] ; ?>" alt="<?php echo $args["first_name"]." ".$args["last_name"]." profile image"; ?>" />
				<?php } else { ?>
					<img class="avatar__image" src="<?php echo wp_get_attachment_image_src($args["user_picture"], 'large-img-medium')[0]; ?>" alt="<?php echo $args["first_name"]." ".$args["last_name"]." profile image"; ?>" />
				<?php } ?>
            </a>

            <?php else: ?>
            <div class="avatar">
                <a href="<?php echo $args["user_link"]; ?>" class="avatar__image avatar--blank flex flex--horizontal-center flex--center">
                    <span class="first-letters"><?php echo $args["first_name"][0].$args["last_name"][0]; ?></span>
                </a>
            </div>
        <?php endif; ?>

		<?php if($args["post_main_picture"]) :  ?>
			<div class="avatar">
				<img class="avatar__image post__avatar" src="<?php echo wp_get_attachment_image_src($args["post_main_picture"], 'large-img-medium')[0]; ?>" alt="<?php echo $args["first_name"]." ".$args["last_name"]." profile image"; ?>" />
			</div>
		<?php  endif; ?>
    </div>
</div>
