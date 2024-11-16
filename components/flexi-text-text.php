<div class="flexi_content flexi_content--text-text">
    <?php if( $args['title'] ): ?>
        <h3 class="title"><?php echo $args['title']; ?></h3>
    <?php endif; ?>
    <div class="text-2-columns">
        <?php if( $args['text'] ): ?>
            <div class="p">
                <?php echo $args['text']; ?>
            </div>
        <?php endif; ?>
    </div>
</div>