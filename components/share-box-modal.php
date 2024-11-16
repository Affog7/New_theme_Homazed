<?php //  todo_augustin share box modal ?>
<div class="modal micromodal-slide" id="share-slate-<?php echo $args["id"]; ?>" aria-hidden="true">
	<div class="modal__overlay" tabindex="-1" data-micromodal-close>
		<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="publish-home-title">
			<header class="modal__header">
				<div class="flex flex--vertical">
					<h2 class="h1">SHARE POST
						<?php
//						echo $args["first_name"] . " " .$args["last_name"]; ?><!-- -->
						 </h2>
				</div>
				<?php get_template_part("components/btn", null,
					array(
						'label' => 'Close this modal window',
						'href' => "",
						'target' => "_self",
						'skin'  => 'secondary',
						'icon-only'  => true,
						'disabled'  => false,
						'icon-position' => 'right', // left or right
						'icon' => 'close',
						'additional-classes' => '',
						'data-attribute' => 'data-close-modal',
						'theme' => "",
					)
				); ?>
			</header>
			<main class="modal__content contact__form contact__form--light">
				<?php get_template_part("components/share-box", null, array(
						'post_permalink' => $args["post_permalink"],
						"post_id" => $args["id"]
					)
				); ?>
			</main>
		</div>
	</div>
</div>
