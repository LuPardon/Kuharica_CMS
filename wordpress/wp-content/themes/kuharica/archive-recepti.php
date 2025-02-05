<?php
/* Template Name: Recepti */
get_header(); ?>

<main class="container my-5">
    <h1 class="text-center mb-4">Svi Recepti</h1>

    <!-- Form za pretragu -->
    <form method="get" action="" class="mb-4 row g-3">
        <div class="col-md-3">
            <label for="kategorije_hrane" class="form-label">Kategorije hrane:</label>
            <select name="kategorije_hrane" id="kategorije_hrane" class="form-select">
                <option value="">Sve kategorije</option>
                <?php
                $kategorije = get_terms(['taxonomy' => 'kategorije_hrane', 'hide_empty' => true]);
                foreach ($kategorije as $kategorija) : ?>
                    <option value="<?php echo $kategorija->slug; ?>" <?php selected($_GET['kategorije_hrane'] ?? '', $kategorija->slug); ?>>
                        <?php echo $kategorija->name; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="vrsta_jela" class="form-label">Vrsta jela:</label>
            <select name="vrsta_jela" id="vrsta_jela" class="form-select">
                <option value="">Sve vrste</option>
                <?php
                $vrste = get_terms(['taxonomy' => 'vrsta_jela', 'hide_empty' => true]);
                foreach ($vrste as $vrsta) : ?>
                    <option value="<?php echo $vrsta->slug; ?>" <?php selected($_GET['vrsta_jela'] ?? '', $vrsta->slug); ?>>
                        <?php echo $vrsta->name; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="zacin" class="form-label">Začini (ključna riječ):</label>
            <input type="text" name="zacin" id="zacin" class="form-control" value="<?php echo esc_attr($_GET['zacin'] ?? ''); ?>">
        </div>
        <div class="col-md-3">
            <label for="vege" class="form-label">Vegetarijansko:</label>
            <select name="vege" id="vege" class="form-select">
                <option value="">Sve opcije</option>
                <option value="1" <?php selected($_GET['vege'] ?? '', '1'); ?>>Da</option>
                <option value="0" <?php selected($_GET['vege'] ?? '', '0'); ?>>Ne</option>
            </select>
        </div>
        <div class="col-md-12 text-end">
            <button type="submit" class="btn btn-primary">Filtriraj</button>
        </div>
    </form>

    <!-- Prikaz recepata -->
    <?php
    $args = [
        'post_type' => 'recepti',
        'posts_per_page' => -1,
        'tax_query' => [],
        'meta_query' => ['relation' => 'AND'],
    ];

    if (!empty($_GET['kategorije_hrane'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'kategorije_hrane',
            'field' => 'slug',
            'terms' => sanitize_text_field($_GET['kategorije_hrane']),
        ];
    }

    if (!empty($_GET['vrsta_jela'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'vrsta_jela',
            'field' => 'slug',
            'terms' => sanitize_text_field($_GET['vrsta_jela']),
        ];
    }

    if (!empty($_GET['zacin'])) {
        $args['s'] = sanitize_text_field($_GET['zacin']);
    }

    if (isset($_GET['vege']) && $_GET['vege'] !== '') {
        $args['meta_query'][] = [
            'key' => 'vegetarijansko',
            'value' => $_GET['vege'],
            'compare' => '=',
        ];
    }

    $recepti_query = new WP_Query($args);

    if ($recepti_query->have_posts()) : ?>
        <div class="row">
            <?php while ($recepti_query->have_posts()) : $recepti_query->the_post(); ?>
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
    <?php else : ?>
        <p class="text-center">Nema recepata koji odgovaraju traženim kriterijima.</p>
    <?php endif;
    wp_reset_postdata(); ?>
</main>

<?php get_footer(); ?>