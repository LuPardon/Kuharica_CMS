<?php get_header(); ?>

<main>
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1><?php the_title(); ?></h1>
                <p>Autor: <?php the_author(); ?> | Datum: <?php the_date(); ?></p>
                <div class="post-content">
                    <?php the_content(); ?>
                </div>
                <div class="post-categories">
                    <p>Kategorije: <?php the_category(', '); ?></p>
                </div>
                <div class="post-tags">
                    <p>Oznake: <?php the_tags('', ', ', ''); ?></p>
                </div>
            </article>

            <?php
            // Komentari (ako su omogućeni)
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
        endwhile;
    else :
        echo '<p>Nema pronađenih postova.</p>';
    endif;
    ?>
</main>

<?php get_footer(); ?>
