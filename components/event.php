<div class="event <?php echo $args['event_privacy']; ?>">
	<div class="event__frame">
		<?php if($args['event_type'] === "follow us" || $args['event_type'] === "follow-us" || $args['event_type'] === "Follow us"): ?>
			<a class="event__frame__link  <?php if ( $args['additional-classes'] ) { echo $args['additional-classes']; }?>" href="/" <?php if ( $args['data-attribute'] ) { echo $args['data-attribute']; }?>>
				<span class="btn__label">
					<?php echo $args['text_1']; ?>
				</span>
			</a>
		<?php endif; ?>
		<?php if($args['text_2']): ?>
			<p class="event__frame__description">
				<?php echo $args['text_2']; ?>
			</p>
		<?php endif; ?>
	</div>
</div>
