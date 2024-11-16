    <span class="tooltip-icon" data-tooltip="tooltip-<?php echo $args['iteration'] ?>" data-tooltip-placement="<?php echo $args['placement'] ?>" data-tooltip-events="<?php echo $args['events'] ?>">
        <?php if($args['icon']):
            echo "<div class='o-svg-icon o-svg-icon-" . $args['icon'] . "'>";                              
                include get_stylesheet_directory() . '/src/images/icons/' . $args['icon'] . '.svg';
            echo "</div>";
        else:
            echo "[i]";
        endif; ?>
    </span>
    <div class="tooltip" id="tooltip-<?php echo $args['iteration'] ?>" role="tooltip">
        <?php echo $args['content'] ?>
        <div id="arrow"></div>
    </div>

