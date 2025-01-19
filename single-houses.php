<?php get_header(); ?>

 

<main id="main-content" class="site-main">

    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post(); // Boucle WordPress pour afficher le contenu de l'article
    ?>
    
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <h1 class="entry-title"><?php the_title(); ?></h1> <!-- Affiche le titre de l'article -->
            <div class="entry-meta">
                <span class="posted-on"><?php echo get_the_date(); ?></span> <!-- Affiche la date de publication -->
                <span class="byline">by <?php the_author(); ?></span> <!-- Affiche l'auteur -->
            </div>
        </header>

        <div class="entry-content">
            <?php the_content(); ?> <!-- Affiche le contenu de l'article -->
        </div>

        <footer class="entry-footer">
            <div class="post-categories"><?php the_category(', '); ?></div> <!-- Affiche les catégories -->
            <div class="post-tags"><?php the_tags(); ?></div> <!-- Affiche les tags -->
        </footer>
    </article>

    <?php
        endwhile;
    else :
    ?>

    <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>

    <?php
    endif;
    ?>
<?php comments_template(); ?>

</main>
 
 

<?php get_footer();
