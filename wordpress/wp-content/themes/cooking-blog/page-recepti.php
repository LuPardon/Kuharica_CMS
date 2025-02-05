<?php
/* Template Name: Recepti */
get_header();
?>

<main class="container my-5">
    <h1 class="mb-4 text-center"><?php the_title(); ?></h1>
    <div class="row">
        <?php
        // Dohvati recepte iz prilagođenog tipa objava
        $args = array(
            'post_type' => 'recepti',
            'posts_per_page' => 9, // Prikaži 9 recepata po stranici
            'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
        );

        $recepti_query = new WP_Query($args);

        if ($recepti_query->have_posts()) :
            while ($recepti_query->have_posts()) : $recepti_query->the_post();
        ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('medium'); ?>" class="card-img-top" alt="<?php the_title(); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php the_title(); ?></h5>
                            <p class="card-text"><?php the_excerpt(); ?></p>
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary">Pročitaj recept</a>
                        </div>
                    </div>
                </div>
        <?php
            endwhile;
        else :
            echo '<p>Nema dostupnih recepata.</p>';
        endif;

        // Resetiraj upit
        wp_reset_postdata();
        ?>
    </div>

    <!-- Navigacija između stranica -->
    <div class="pagination">
        <?php
        echo paginate_links(array(
            'total' => $recepti_query->max_num_pages,
        ));
        ?>
    </div>
</main>

<?php get_footer(); ?>