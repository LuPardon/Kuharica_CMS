<?php get_header(); ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 mb-4">
            <article class="card shadow border-0">
                <!-- Header kartice sa slikom -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="card-header p-0">
                        <img src="<?php the_post_thumbnail_url('large'); ?>" class="card-img-top rounded-top" alt="<?php the_title(); ?>">
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


                <div class="card-footer bg-light text-center">
                    <?php
                    // Dohvati podatke o ocjenama
                    $total_ratings = get_post_meta(get_the_ID(), 'total_ratings', true) ?: 0;
                    $rating_count = get_post_meta(get_the_ID(), 'rating_count', true) ?: 0;

                    // Izračunaj prosječnu ocjenu
                    $average_rating = $rating_count > 0 ? round($total_ratings / $rating_count, 1) : 0;

                    if ($rating_count > 0) : ?>
                        <p><strong>Prosječna ocjena:</strong>
                            <span class="badge bg-success"><?php echo $average_rating; ?>/5</span>
                        </p>

                        <!-- Prikaz zvjezdica -->
                        <div class="rating-stars" style="font-size: 1.5rem; color: #FFD700;">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $average_rating) {
                                    echo '★'; // Popunjena zvjezdica
                                } else {
                                    echo '☆'; // Prazna zvjezdica
                                }
                            }
                            ?>
                        </div>
                        <p><small>(Broj ocjena: <?php echo $rating_count; ?>)</small></p>

                    <?php else : ?>
                        <p>Nema ocjena za ovaj recept. Budi prvi!</p>
                    <?php endif; ?>


                    <form method="post" class="rating-form">
                        <label for="user_rating">Ocijeni recept:</label>
                        <div class="flex">
                            <select name="user_rating" id="user_rating" class="form-select w-auto">
                                <option value="">Odaberi ocjenu</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Pošalji ocjenu</button>
                        </div>
                    </form>
                </div>
            </article>
        </div>
    </div>
</div>

<!-- Gumb za povratak -->
<div class="row">
    <div class="col-lg-8 mx-auto mb-5 text-center mt-4">
        <a href="<?php echo get_post_type_archive_link('recepti'); ?>" class="btn btn-outline-secondary">
            Povratak na sve recepte
        </a>
    </div>
</div>

<?php get_footer(); ?>