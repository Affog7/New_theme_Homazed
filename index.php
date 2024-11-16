<?php get_header(); ?>

<main class="main home" role="main" data-barba="container" data-barba-namespace="home" data-theme="theme-light">
	<div class="container--home">
		<div class="discover grid">
			<div class="discover__container grid-col-8">
				<div class="discover__wrap flex flex--vertical">
					<h2 class="h1 discover__title">Discover a place you’ll love to live</h2>
					<div class="discover--search flex flex--vertical">
						<p class="discover__text">
							Fill your criteria
							<br />
							and browse thousand of results
						</p>
						<div class="discover__research flex flex--justify-between flex--vertical-center">
							<p>Enter an adress, city or zip code...</p>
							<?php echo file_get_contents(get_stylesheet_directory()."/src/images/icons/real-estate-search-house.svg"); ?>
						</div>
					</div>
				</div>
			</div>

			<div class="discover__container grid-col-4">
				<div class="discover__wrap flex flex--vertical">
					<h2 class="h1 discover__title">A world of connections</h2>
					<div class="discover--connect flex flex--vertical" data-barba-prevent="all">
						<p class="discover__text">Link to Homes, Services and Homess Professionals around you</p>
						<?php
							get_template_part("components/btn", null,
								array( 
									'label' => 'Register for free in a few clicks',
									'href' => get_permalink("1793"),
									'target' => "_self",
									'skin'  => 'primary',
									'icon-only'  => false,
									'disabled'  => false,
									'icon-position' => '', // left or right
									'icon' => '',
									'additional-classes' => '',
									'data-attribute' => null,
									'theme' => "white",
								)
							);
						?>
						</div>
				</div>
			</div>
		</div>

		<div class="last-news flex">
			<?php echo file_get_contents(get_stylesheet_directory()."/src/images/icons/ellipse_6.svg"); ?>
			<dt>Last news</dt>
			<dd>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.</dd>
		</div>

		<div class="trending trending-homes">
			<div class="grid">
				<div class="grid-col-4">
					<div class="trending__left flex flex--vertical">
						<h3 class="trending__title h1">
							<?php echo file_get_contents(get_stylesheet_directory()."/src/images/icons/post-type-real-estate.svg"); ?>
							Trending homes in California, CA
						</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.</p>
						<div class="trending__action">
							<?php
							get_template_part( 'components/btn', null,
								array( 
									'label' => 'See more',
									'href' => get_permalink("604"),
									'target' => "_self",
									'skin'  => 'primary',
									'icon-only'  => false,
									'disabled'  => false,
									'icon-position' => '', // left or right
									'icon' => '',
									'additional-classes' => '',
									'data-attribute' => null,
									'theme' => "",
								)
							);
							?>
							<div>
								<?php
								get_template_part( 'components/btn', null,
									array( 
										'label' => '',
										'href' => "/",
										'target' => "_self",
										'skin'  => 'ghost',
										'icon-only'  => true,
										'disabled'  => false,
										'icon-position' => 'right', // left or right
										'icon' => 'arrow-left-1',
										'additional-classes' => '',
										'data-attribute' => null,
										'theme' => "",
									)
								);
								?>
								<?php
								get_template_part( 'components/btn', null,
									array( 
										'label' => '',
										'href' => "/",
										'target' => "_self",
										'skin'  => 'ghost',
										'icon-only'  => true,
										'disabled'  => false,
										'icon-position' => 'right', // left or right
										'icon' => 'arrow-right-1',
										'additional-classes' => '',
										'data-attribute' => null,
										'theme' => "",
									)
								);
								?>
							</div>
						</div>
					</div>
				</div>
			
			</div>
		</div>

		<div class="trending trending-services">
			<div class="grid flex--reverse">
				<div class="grid-col-4">
					<div class="trending__left flex flex--vertical">
						<h3 class="trending__title h1">
							<?php echo file_get_contents(get_stylesheet_directory()."/src/images/icons/post-type-services.svg"); ?>
							Trending services in California, CA
						</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.</p>
						<div class="trending__action">
							<?php
							get_template_part( 'components/btn', null,
								array( 
									'label' => 'See more',
									'href' => get_permalink("604"),
									'target' => "_self",
									'skin'  => 'primary',
									'icon-only'  => false,
									'disabled'  => false,
									'icon-position' => '', // left or right
									'icon' => '',
									'additional-classes' => '',
									'data-attribute' => null,
									'theme' => "",
								)
							);
							?>
							<div>
								<?php
								get_template_part( 'components/btn', null,
									array( 
										'label' => '',
										'href' => "/",
										'target' => "_self",
										'skin'  => 'ghost',
										'icon-only'  => true,
										'disabled'  => false,
										'icon-position' => 'right', // left or right
										'icon' => 'arrow-left-1',
										'additional-classes' => '',
										'data-attribute' => null,
										'theme' => "",										
									)
								);
								?>
								<?php
								get_template_part( 'components/btn', null,
									array( 
										'label' => '',
										'href' => "/",
										'target' => "_self",
										'skin'  => 'ghost',
										'icon-only'  => true,
										'disabled'  => false,
										'icon-position' => 'right', // left or right
										'icon' => 'arrow-right-1',
										'additional-classes' => '',
										'data-attribute' => null,
										'theme' => "",
									)
								);
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="needs grid">
			<div class="grid-col-6">
				<h4 class="h2">Access our map of homes and services</h4>
				<div class="needs__actions flex flex--vertical">
					<h5 class="h3">Browse over thusands of homes for sales or for rent near you</h5>
					<div class="btn-group">
						<?php
							get_template_part("components/btn", null,
								array( 
									'label' => 'Find homes on the map',
									'href' => "/",
									'target' => "_self",
									'skin'  => 'primary',
									'icon-only'  => false,
									'disabled'  => false,
									'icon-position' => '', // left or right
									'icon' => '',
									'additional-classes' => '',
									'data-attribute' => null,
									'theme' => "white",
								)
							);
						?>
						<?php
							get_template_part("components/btn", null,
								array( 
									'label' => 'Find services on the map',
									'href' => "/",
									'target' => "_self",
									'skin'  => 'primary',
									'icon-only'  => false,
									'disabled'  => false,
									'icon-position' => '', // left or right
									'icon' => '',
									'additional-classes' => '',
									'data-attribute' => null,
									'theme' => "white",
								)
							);
						?>
					</div>
				</div>
			</div>
			<div class="grid-col-6">
				<h4 class="h2">Need to do this or this ?</h4>
				<div class="needs__actions flex flex--vertical">
					<h5 class="h3">Need to do this or this ?</h5>
					<div class="btn-group">
						<?php
							get_template_part("components/btn", null,
								array( 
									'label' => 'View pricing',
									'href' => "/",
									'target' => "_self",
									'skin'  => 'primary',
									'icon-only'  => false,
									'disabled'  => false,
									'icon-position' => '', // left or right
									'icon' => '',
									'additional-classes' => '',
									'data-attribute' => null,
									'theme' => "white",
								)
							);
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<?php get_footer();
