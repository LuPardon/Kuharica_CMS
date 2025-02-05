<?php get_header(); ?>

<?php
$term = get_queried_object();
$taxonomy = $term->taxonomy;


$args = array(
    'post_type' => 'recepti',
    'tax_query' => array(
        array(
            'taxonomy' => $taxonomy,
            'field'    => 'slug',
            'terms'    => $term->slug,
        ),
    ),
);
$query = new WP_Query($args);
?>
<div class="container">
    <header class="taxonomy-header">
        <h1 class="taxonomy-title"><?php echo single_term_title(); ?></h1>
        <p class="taxonomy-description"><?php echo term_description(); ?></p>
    </header>
    <?php if ($query->have_posts()) : ?>
        <div class="row">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('medium'); ?>" class="card-img-top" alt="<?php the_title(); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php the_title(); ?></h5>
                            <p class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                            <?php
                            $preparation_time = get_post_meta(get_the_ID(), 'vrijeme_pripreme', true);
                            ?>
                            <p><strong>Vrijeme:</strong> <?php echo $preparation_time ? esc_html($preparation_time) . ' minuta' : '?'; ?></p>
                            <p><strong>Vrste:</strong> <?php echo get_the_term_list(get_the_ID(), 'vrsta_jela', '', ', ', ''); ?></p>
                            <p><strong>Kategorije:</strong> <?php echo get_the_term_list(get_the_ID(), 'kategorije_hrane', '', ', ', ''); ?></p>
                            <?php
                            // Dohvati podatke o ocjenama
                            $total_ratings = get_post_meta(get_the_ID(), 'total_ratings', true) ?: 0;
                            $rating_count = get_post_meta(get_the_ID(), 'rating_count', true) ?: 0;

                            // Izračunaj prosječnu ocjenu
                            $average_rating = $rating_count > 0 ? round($total_ratings / $rating_count, 1) : 0;

                            if ($rating_count > 0) : ?>
                                <div>
                                    <p><strong>Prosječna ocjena:</strong>
                                        <span class="badge bg-success"><?php echo $average_rating; ?>/5</span>
                                    </p>
                                </div>

                            <?php else : ?>
                                <p>Nema ocjena za ovaj recept. Budi prvi!</p>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer">
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary w-100">Pogledaj recept</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <p>No posts found.</p>
    <?php endif; ?>

    <!-- Gumb za povratak -->
    <div class="row">
        <div class="col-lg-8 mx-auto text-center my-4">
            <a href="<?php echo get_post_type_archive_link('recepti'); ?>" class="btn btn-outline-secondary">
                Povratak na sve recepte
            </a>
        </div>
    </div>
</div>
<?php get_footer(); ?>