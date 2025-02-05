<?php get_header(); ?>

<main>
    <header class="archive-header">
        <h1>
            <?php
            if (is_category()) {
                single_cat_title('Kategorija: ');
            } elseif (is_tag()) {
                single_tag_title('Oznaka: ');
            } elseif (is_author()) {
                echo 'Autor: ' . get_the_author();
            } elseif (is_date()) {
                echo 'Arhiva za datum: ' . get_the_date();
            } else {
                echo 'Arhiva';
            }
            ?>
        </h1>
    </header>

    <?php if (have_posts()) : ?>
        <div class="post-list">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p>Autor: <?php the_author(); ?> | Datum: <?php the_date(); ?></p>
                    <div class="post-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                    <a href="<?php the_permalink(); ?>">Pročitaj više</a>
                </article>
            <?php endwhile; ?>
        </div>

        <div class="pagination">
            <?php
            // Prikaz navigacije između stranica
            the_posts_pagination([
                'prev_text' => '« Prethodna',
                'next_text' => 'Sljedeća »',
            ]);
            ?>
        </div>
    <?php else : ?>
        <p>Nema postova za prikaz.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>