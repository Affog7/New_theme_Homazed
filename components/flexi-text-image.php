<div class="flexi_content flexi_content--text-image">
    <div class="grid-12">
        <div class="text grid-col-1-6">
            <div class="title-text">
                <?php if( $args['title'] ): ?>
                    <h3 class="title"><?php echo $args['title']; ?></h3>
                <?php endif; ?>
                <?php if( $args['text'] ): ?>
                    <div class="p">
                        <p>
                            <?php echo $args['text']; ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="image grid-col-6-12">
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
    </div>
</div>