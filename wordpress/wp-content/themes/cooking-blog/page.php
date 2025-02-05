<?php get_header(); ?>

<main class="container d-flex flex-row">
    <!-- <main> -->
    <div id="sidebar-primary" class="sidebar">
        <?php dynamic_sidebar('sidebar-1'); ?>
    </div>
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1><?php the_title(); ?></h1>
                <div class="page-content">
                    <?php the_content(); ?>
                </div>
            </article>
    <?php endwhile;
    else :
        echo '<div><p>Nema sadržaja za ovu stranicu.</p><div>';
    endif;
    ?>
</main>

<?php get_footer(); ?>