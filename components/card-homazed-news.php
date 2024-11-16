<div id="slate-<?php echo $args["id"]; ?>" class="card" data-h-id="<?php echo $args["id"]; ?>">
	<div class="card__header flex flex--vertical">
		<div class="owner flex flex--vertical-center card__header__item">
				<?php echo $args["title"]; ?>
		</div>
		<a href="<?php echo $args["post_creator_link"]; ?>" class="post-header card__header__item flex flex--justify-between flex--vertical-center">
			<!-- Post author -->
			
			<div class="owner flex flex--vertical-center">
					<?php if($args['avatar']): ?>
						<img
							<?php if(is_array($args["avatar"])):
								$profile_picture = array_values($args["avatar"])[0];
							endif; ?>
							src="<?php echo esc_url(wp_get_attachment_url($profile_picture)); ?>"
							alt="<?php echo $args["post_creator_name"]." profile image"; ?>"
							class="owner__avatar"
						/>
					<?php else: ?>
						<div class="owner__avatar owner__avatar--blank flex flex--horizontal-center flex--center">
							<span class="first-letters"><?php echo $args["first_name"][0].$args["last_name"][0]; ?></span>
						</div>
					<?php endif; ?>

					<span class="owner__name">
						<?php
						if(isset($args["post_creator_name"])):
							echo $args["post_creator_name"];
						endif;
						?>
					</span>
			</div>
		</a>

	</div>

	

	<!-- Post image -->
	<?php if(isset($args['img']) && is_array($args['img'])): ?>
		<div class="card__img">
			<figure class="post-image">
				<img src="<?php echo $args['img'][0]["news_gallery_image"]["sizes"]['large-img-medium']; ?>" alt="<?php echo $args["post_creator_name"]." image"; ?>" />
			</figure>
		</div>
	<?php endif; ?>

	<?php if($args["content"]): ?>
		<!-- Post content -->
		<div class="card__body h-p">
			<p class="post-body">
				<?php echo $args['content']; ?>
			</p>
		</div>
	<?php endif; ?>


	<!-- Post actions -->
	<div class="card__footer flex flex--justify-around">
		<div class="post-footer__left"></div>
		<p class="post-footer__publish-date p-xs">
			<?php
			if(isset($args["publish_date"])):
				echo $args["publish_date"];
			else:
				echo "N/A";
			endif;
			?>
		</p>
		<div class="post-footer__right"></div>
	</div>
</div>