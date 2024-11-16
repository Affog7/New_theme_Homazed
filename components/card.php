<?php if ( !empty($args['href']) ) : ?>
    <a class="card grid--card <?php echo $args['additional-classes']; ?> card--<?php echo $args['theme']; ?>" href="<?php echo $args['href']; ?>">
<?php else: ?>
    <div class="card grid--card <?php echo $args['additional-classes']; ?> card--<?php echo $args['theme']; ?>">
<?php endif; ?>

<div class="card__img">
        <figure>
            <?php if( $args['img'] && is_array($args['img']) ): ?>
                <img
                    src="<?php echo $args['img'][0]['sizes'][$args['img_size']]; ?>"
                    srcset="<?php echo $args['img'][0]['sizes'][$args['img_size'].'@2x']; ?> 2x"
                    <?php if(!empty($args['img'][0]['alt'])): ?>
                        alt="<?php  echo esc_attr($args['img'][0]['alt']); ?>" />
                    <?php else: ?>
                        alt="<?php  echo __('Aperçu', 'custom-translation'). " - " . $args['title']; ?>" />
                    <?php endif; ?>
            <?php else: ?>
                <img src="https://source.unsplash.com/random" alt="">
            <?php endif; ?>
		</figure>
    </div>
    <div class="card__body">
        <?php  if(!empty($args['start_date'])): ?>
            <div class="dates">
                <div class="dates__start">
                    <div class="icon icon--play"></div><!--
            --><date><?php echo $args['start_date']; ?></date>
                </div>
                <?php  if(!empty($args['end_date'])): ?>
                <div class="dates--tiret">-</div><!--
            --><date><?php echo $args['end_date']; ?></date>
                <?php endif; ?>
            </div>    
        <?php endif; ?>
        <?php if($args['sub_title_left']): ?>
            <div class="flex flex--justify-between flex--align-start">
                <?php if($args['sub_title_left']): ?>
                    <div class="left">
                        <div class="icon icon--square"></div><!--
                        --><span><?php echo $args['sub_title_left']; ?></span>
                    </div>
                <?php endif; ?>
                <?php if($args['sub_title_right']): ?>
                    <div class="right">
                        <div class="icon icon--bullet"></div><!--
                        --><span><?php echo $args['sub_title_right']; ?></span>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <h4 class="card__body--title h5"><?php echo $args['title']; ?></h4>
        <p class="card__body--paragraph p-sm"><?php echo $args['content']; ?></p>
    </div>
<?php if ( !empty($args['href']) ) : ?>
    </a>
<?php else: ?>
    </div>
<?php endif; ?>