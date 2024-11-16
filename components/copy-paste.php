
<?php $iteration_ref = $args['iteration']; ?>
<div class="copy-past-btn">
    <p class="copy-past-btn__ref" id="ref-<?php echo $iteration_ref ?>"><?php echo $args['copyValue'] ?></p>
    <?php get_template_part( 'components/btn', null,
        array( 
            'label' => $args['label'],
            'href' => "/",
            'target' => "_self",
            'skin'  => 'primary',
            'icon-only'  => true,
            'disabled'  => false,
            'icon-position' => '', // left or right
            'icon' => 'hyperlink',
            'additional-classes' => '',
            'data-attribute' => 'data-action=\'copy\' data-action-trad=\'copied\' data-copy-content=\'#ref-' . $iteration_ref . '\' data-tooltip=\'tooltip-' . $iteration_ref . '\' data-tooltip-placement=\'left\'',
            'theme' => "",
        )
    ); ?>
    <div class="c-tooltip hide" id="tooltip-<?php echo $iteration_ref ?>" role="tooltip" data-popper-placement="right">
        <span></span>
        <div class="c-tooltip__arrow" data-popper-arrow="data-popper-arrow" style="position: absolute; top: 0px; transform: translate(0px, 4px);"></div>
    </div>
</div>