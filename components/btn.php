<a href="<?php if ( $args['href'] ) { echo $args['href']; }else{ echo "/"; }?>" title="<?php echo $args['label']; ?>"
    <?php if ( $args['target'] ) { echo 'target="' . $args['target'] . '"'; } ?>
    class="btn btn--<?php if ( $args['skin'] ) { echo $args['skin']; }else{ echo "primary"; } if ( $args['icon-only'] ) { echo " btn--icon"; } ?> <?php if ( $args['additional-classes'] ) { echo $args['additional-classes']; }?>"
    <?php if ( $args['data-attribute'] ) { echo $args['data-attribute']; }?>
    <?php if ( $args['disabled'] ) { echo "disabled='disabled'"; } ?>>
	<span class="btn__content">
        <?php if($args['icon-position'] && $args['icon-position'] === "left"){
            echo "<div class='o-svg-icon o-svg-icon-" . $args['icon'] . "'>";                              
                include get_stylesheet_directory() . '/src/images/icons/' . $args['icon'] . '.svg';
            echo "</div>";
        } ?>
		<span class="<?php if ( $args['icon-only'] ) { echo "u-sr-accessible"; }else{ echo "btn__label"; } ?>"><?php echo $args['label']; ?></span>
        <?php if($args['icon-position'] && $args['icon-position'] === "right" || $args['icon-only']){
            echo "<div class='o-svg-icon o-svg-icon-" . $args['icon'] . "'>";                              
                include get_stylesheet_directory() . '/src/images/icons/' . $args['icon'] . '.svg';
            echo "</div>";
        } ?>
	</span>
</a>