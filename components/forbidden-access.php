<div class="forbidden flex flex--vertical flex--vertical-center">
	<p>You do not have permission to view this page</p>

	<?php
	get_template_part("components/btn", null,
		array(
			'label' => 'Back to homepage',
			'href' => home_url(),
			'target' => "_self",
			'skin'  => 'ghost',
			'icon-only'  => false,
			'disabled'  => false,
			'icon-position' => '', // left or right
			'icon' => '', // nom du fichier svg
			'additional-classes' => '',
			'data-attribute' => null,
			'theme' => "",
		)
	);
	?>
</div>