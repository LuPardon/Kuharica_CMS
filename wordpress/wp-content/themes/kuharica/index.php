<?php get_header(); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <div class="col-lg-8 mb-4">
                    <article class="card shadow border-0">
                        <!-- Header kartice sa slikom -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="card-header p-0">
                                <img src="<?php the_post_thumbnail_url('large'); ?>" class="img-fluid rounded-top" alt="<?php the_title(); ?>">
                            </div>
                        <?php endif; ?>

                        <div class="card-body">
                            <!-- Naslov posta -->
                            <h2 class="card-title text-center fw-bold"><?php the_title(); ?></h2>

                            <!-- Kratki uvod -->
                            <h4 class="text-center text-muted mb-3">Uživajte u receptu!</h4>

                            <!-- Cijeli sadržaj posta -->
                            <div class="recept-content mb-3">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <div class="col-lg-8">
                <p class="text-center text-danger">Stranica nije pronađena!</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Gumb za povratak -->
    <div class="row">
        <div class="col-lg-8 mx-auto text-center mt-4">
            <a href="<?php echo get_post_type_archive_link('recepti'); ?>" class="btn btn-outline-secondary">
                Povratak na sve recepte
            </a>
        </div>
    </div>
</div>

<?php get_footer(); ?>