<nav id="desktopNavigation" class="site-navigation site-navigation--desktop flex flex--justify-between" role="navigation" aria-label="Navigation desktop" aria-hidden="false">
    <?php if( have_rows('menu__desktop', 'options') ): ?>
        <ul class="site-navigation__list flex" role="menu">
            <?php while( have_rows('menu__desktop', 'options') ) : the_row();
                $menu__links__desktop = get_sub_field('menu__desktop__links');
                $menu__link_slug = get_sub_field('menu__desktop_slug');
                if(is_array($menu__links__desktop)):
                    $menu__links__desktop__title = $menu__links__desktop['title'];
                    $menu__links__desktop__url = $menu__links__desktop['url']; ?>
                    <li class="site-navigation__item" role="presentation">
                        <a data-slug="<?php echo $menu__link_slug; ?>"
                        class="site-navigation__link <?php if( is_page( $menu__links__desktop['title'] ) ) : ?>active<?php endif; ?> <?php if( $menu__links__desktop['title'] === get_the_title( get_option('page_on_front') ) ) : ?>home<?php endif; ?>"
                        role="menuitem"
                        href="<?php echo $menu__links__desktop__url; ?>"
                        data-en="<?php echo apply_filters( 'wpml_permalink', $menu__links__desktop__url, 'en', true ); ?>"
                        data-fr="<?php echo apply_filters( 'wpml_permalink', $menu__links__desktop__url, 'fr', true ); ?>"><?php echo $menu__links__desktop__title ?></a>
                    </li>
                <?php endif; ?>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No menu items</p><br>
        <p class="p-sm">Add "menus options page"</p>
    <?php endif; ?>
     <!-- // LANG SWITCH -->
     <?php // get_template_part( 'components/navigation-lang-switch', null); ?>
     
 
</nav>