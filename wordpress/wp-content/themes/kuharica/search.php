<?php get_header(); ?>

<main>
    <h1>Rezultati pretrage za: "<?php echo get_search_query(); ?>"</h1>
    <?php if (have_posts()) : ?>
        <ul>
            <?php while (have_posts()) : the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <p><?php the_excerpt(); ?></p>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else : ?>
        <p>Nema rezultata.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
