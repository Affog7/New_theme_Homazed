<?php 
$fmt = new NumberFormatter( 'fr_FR', NumberFormatter::CURRENCY );
$fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, 0);
?>

<div class="price">
    <span><?php echo $fmt->formatCurrency($args['price'], "EUR")."\n"; ?></span>
</div>
