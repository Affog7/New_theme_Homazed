<div class="avatar__list">
    <div class="avatar__list--wrapper">
        <div class="avatar">
            <img class="avatar__image post__avatar" src="<?php echo wp_get_attachment_image_src($args["post_main_picture"], 'large-img-medium')[0]; ?>" alt="<?php echo $args["first_name"]." ".$args["last_name"]." profile image"; ?>" />
        </div>
        <?php if(isset($args["user_picture"])): ?>
            <a href="<?php echo $args["user_link"]; ?>" class="avatar owner__avatar">
                <img class="avatar__image" src="<?php echo wp_get_attachment_image_src($args["user_picture"], 'large-img-medium')[0]; ?>" alt="<?php echo $args["first_name"]." ".$args["last_name"]." profile image"; ?>" />
            </a>
            <?php else: ?>
            <div class="avatar">
                <a href="<?php echo $args["user_link"]; ?>" class="avatar__image avatar--blank flex flex--horizontal-center flex--center">
                    <span class="first-letters"><?php echo $args["first_name"][0].$args["last_name"][0]; ?></span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>