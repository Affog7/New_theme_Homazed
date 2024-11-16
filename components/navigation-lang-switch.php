<div class="dropdown">
    <div class="dropdown--wrapper">
        <?php
            $current_language = ICL_LANGUAGE_CODE;
            $languages = icl_get_languages();
        ?>
        <!-- <span class="dropdown-fake"></span> -->
        <a href="" id="test" class="dropdown-toggle" data-toggle="dropdown" data-label="<?php echo $current_language; ?>" role="button" aria-pressed="false" aria-haspopup="true" aria-expanded="false" aria-controls="language-list" data-cross="true">
            <?php echo $current_language; ?><span class="caret"></span>
        </a>
        <ul id="language-list" class="dropdown-menu t-center" aria-hidden="true">
            <?php foreach($languages as $lang): ?>
                    <?php
                    $translated_post_id = apply_filters('wpml_object_id', get_the_ID(), 'page', FALSE, $lang['language_code']);
                    $translated_post_url = apply_filters( 'wpml_permalink', get_the_permalink( $translated_post_id ), $lang['language_code'] );
                    $translatedSentence = __("Changer la langue en ", 'custom-translation');
                    ?>
                    <?php if($translated_post_id): ?>
                        <?php $active_class = ($lang['language_code'] == $current_language) ? 'active' : ''; ?>
                        <?php echo '<li class="dropdown-menu__item">'; ?>
                            <?php echo '<a href="' . esc_url($translated_post_url) . '" data-label="' . $lang['language_code'] . '" class="dropdown-menu__item__link ' . esc_attr($active_class) . '" title="Changer la langue du site">'; ?>
                                <?php echo '<span>' . $translatedSentence . " " . esc_html($lang['native_name']) . '</span>'; ?>
                            <?php echo '</a>'; ?>
                        <?php echo '</li>'; ?>
                    <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>