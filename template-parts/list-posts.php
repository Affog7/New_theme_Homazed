<?php

$arguments = array(  
	'post_type' => $args['post_type'],
	'post_status' => $args['post_status'],
	'posts_per_page' => $args['posts_per_page'], 
	'orderby' => $args['orderby'], 
	'order' => $args['order'],
);


$loop = new WP_Query( $arguments ); ?>
	<?php if ( have_posts() ) : ?>

		<ul class="projets__list grid-12" data-items="4">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<li class="projets__list__item showcase__item grid-col-4">
				<a href="<?php echo get_permalink(); ?>">
					<div class="image">
						<img src="https://via.placeholder.com/600x400" alt="placeholder">
					</div>
					<h3 class="h3">
						<?php echo get_the_title(); ?>
					</h3>
				</a>
			</li>

			
		<?php endwhile; ?>
	<?php endif; ?>
<?php wp_reset_postdata(); ?>