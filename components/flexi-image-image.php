<div class="flexi_content flexi_content--image-image">
    <div class="grid-12">
        <div class="image grid-col-1-6">
            <?php if( $args['img-src'] ): ?>
                <figure>
                    <img src="<?php echo $args['img-src']; ?>" alt="<?php echo $args['img-alt']; ?>">
                    <?php if( $args['img-caption'] ): ?>
                        <figcaption><?php echo $args['img-caption']; ?></figcaption>
                    <?php endif; ?>
                </figure>
            <?php else: ?>
                <figure>
                    <img src="https://via.placeholder.com/600x400" alt="placeholder">
                    <figcaption>Ceci est une légende</figcaption>
                </figure>
            <?php endif; ?>
        </div>
        <div class="image grid-col-6-12">
            <?php if( $args['img-src-r'] ): ?>
                <figure>
                    <img src="<?php echo $args['img-src-r']; ?>" alt="<?php echo $args['img-alt-r']; ?>">
                    <?php if( $args['img-caption-r'] ): ?>
                        <figcaption><?php echo $args['img-caption-r']; ?></figcaption>
                    <?php endif; ?>
                </figure>
            <?php else: ?>
                <figure>
                    <img src="https://via.placeholder.com/600x400" alt="placeholder">
                    <figcaption>Ceci est une légende</figcaption>
                </figure>
            <?php endif; ?>
        </div>
    </div>
</div>