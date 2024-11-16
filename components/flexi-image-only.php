<div class="flexi_content flexi_content--image-only">
    <?php if( $args['img-src'] ): ?>
        <div class="image">
            <figure>
                <img 
                src="<?php echo $args['img-src']["large-img-medium"]; ?>" 
				srcset="<?php echo $args['img-src']["large-img-medium"]; ?> 600w, <?php echo $args['img-src']["large-img-big"]; ?> 1000w"
                sizes="(max-width: 1240px) 600px, 1000px"
                alt="<?php echo $args['img-alt']; ?>">
                <?php if( $args['img-legend'] ): ?>
                    <figcaption><?php echo $args['img-legend']; ?></figcaption>
                <?php endif; ?>
            </figure>
        </div>
    <?php else: ?>
        <div class="image">
            <img src="https://via.placeholder.com/600x400" alt="placeholder">
            <figcaption>Ceci est une légende</figcaption>
        </div>
    <?php endif; ?>
</div>