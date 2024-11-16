<nav id="mobileNavigation" class="site-navigation site-navigation--mobile" role="navigation" aria-labelledby="mobileNavigationButton" aria-hidden="true">
    <div class="container container--large">
        <?php if( have_rows('menu__mobile', 'options') ): ?>
            <ul class="site-navigation--mobile--list" role="menu">
                <?php while( have_rows('menu__mobile', 'options') ) : the_row();
                    $menu__links__mobile = get_sub_field('menu__mobile__links');
                    $menu__link_slug = get_sub_field('menu__mobile_slug');
                    if(is_array($menu__links__mobile)):
                        $menu__links__mobile__title = $menu__links__mobile['title'];
                        $menu__links__mobile__url = $menu__links__mobile['url']; ?>
                        <li class="site-navigation__item" role="presentation">
                            <a data-slug="<?php echo $menu__link_slug; ?>" class="site-navigation__link" role="menuitem" href="<?php echo $menu__links__mobile__url; ?>"><?php echo $menu__links__mobile__title; ?></a>
                        </li>
                    <?php endif; ?>
                <?php endwhile; ?>
                <!-- <li class="site-navigation--mobile--list site-navigation--mobile--list--addons">
                    <div class="site-navigation-languages site-navigation-languages--mobile" data-barba-prevent="all">
                        <?php // do_action('wpml_add_language_selector'); ?>
                    </div>
                </li> -->
            </ul>
        <?php else: ?>
            <p>No menu items</p><br>
            <p class="p-sm">Add "menus options page"</p>
    <?php endif; ?>
    </div>
</nav>