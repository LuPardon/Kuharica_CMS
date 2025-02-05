<?php get_header(); ?>

<main class="container my-5">
    <h2>Dobrodošli na našu stranicu s neodoljivim receptima!</h2>
    <div class="row">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('medium'); ?>" class="card-img-top" alt="<?php the_title(); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php the_title(); ?></h5>
                            <p class="card-text"><?php the_excerpt(); ?></p>
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary">Pročitaj više</a>
                        </div>
                    </div>
                </div>
            <?php endwhile;
        else : ?>
            <p>Nema recepata za prikaz.</p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>