<?php

function my_theme_enqueue_styles()
{
    // Učitaj Bootstrap CSS
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '5.3.0');
    // Učitaj osnovni stil teme
    wp_enqueue_style('theme-style', get_stylesheet_uri());
}

function my_theme_enqueue_scripts()
{
    // Učitaj Bootstrap JS
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array('jquery'), '5.3.0', true);
}

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');

if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(150, 150, true); // default Post Thumbnail dimensions (cropped)
}

// Registriraj izbornik
function my_theme_register_menus()
{
    register_nav_menus(array(
        'primary' => __('topmenu', 'kuharica'),
    ));
}
add_action('init', 'my_theme_register_menus');

// Dodaj Bootstrap klase u izbornik
function my_theme_add_menu_classes($classes, $item, $args)
{
    if ($args->theme_location === 'primary') {
        $classes[] = 'nav-item';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'my_theme_add_menu_classes', 10, 3);

function my_theme_add_menu_link_attributes($atts, $item, $args)
{
    if ($args->theme_location === 'primary') {
        $atts['class'] = 'nav-link';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'my_theme_add_menu_link_attributes', 10, 3);

// Registracija CPT-a za recepte
function kuhaj_register_cpts()
{
    // CPT Recepti
    register_post_type('recepti', [
        'labels' => [
            'name' => 'Recepti',
            'singular_name' => 'Recept',
            'add_new' => 'Dodaj novi recept',
            'add_new_item' => 'Dodaj novi recept',
            'edit_item' => 'Uredi recept',
            'new_item' => 'Novi recept',
            'view_item' => 'Pogledaj recept',
            'search_items' => 'Pretraži recepte',
            'not_found' => 'Nema recepata',
            'not_found_in_trash' => 'Nema recepata u smeću',
        ],
        'public' => true,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'recepti'],
        'show_in_rest' => true,
    ]);

    // Taksonomije za Recepti
    register_taxonomy('kategorije_hrane', 'recepti', [
        'labels' => [
            'name' => 'Kategorije hrane',
            'singular_name' => 'Kategorija hrane',
            'search_items' => 'Pretraži kategorije',
            'all_items' => 'Sve kategorije',
            'edit_item' => 'Uredi kategoriju',
            'update_item' => 'Ažuriraj kategoriju',
            'add_new_item' => 'Dodaj novu kategoriju',
            'new_item_name' => 'Ime nove kategorije',
        ],
        'hierarchical' => true, // Kao kategorije
        'show_in_rest' => true,
    ]);

    register_taxonomy('vrsta_jela', 'recepti', [
        'labels' => [
            'name' => 'Vrsta jela',
            'singular_name' => 'Vrsta jela',
            'search_items' => 'Pretraži vrste',
            'all_items' => 'Sve vrste',
            'edit_item' => 'Uredi vrstu',
            'update_item' => 'Ažuriraj vrstu',
            'add_new_item' => 'Dodaj novu vrstu',
            'new_item_name' => 'Ime nove vrste',
        ],
        'hierarchical' => false, // Kao tagovi
        'show_in_rest' => true,
    ]);
}
add_action('init', 'kuhaj_register_cpts');


//metabox za oznaku vegetarijanskog jela
function kuhaj_add_meta_boxes()
{
    add_meta_box('vege_meta', 'Vegetarijansko jelo', 'kuhaj_render_vege_meta', 'recepti', 'side', 'default');
}
add_action('add_meta_boxes', 'kuhaj_add_meta_boxes');

function kuhaj_render_vege_meta($post)
{
    $value = get_post_meta($post->ID, 'vegetarijansko', true);
?>
    <label for="vegetarijansko">
        <input type="checkbox" name="vegetarijansko" id="vegetarijansko" value="1" <?php checked($value, '1'); ?>>
        Oznaka: Vegetarijansko jelo
    </label>
<?php
}

function kuhaj_save_meta_boxes($post_id)
{
    if (isset($_POST['vegetarijansko'])) {
        update_post_meta($post_id, 'vegetarijansko', '1');
    } else {
        delete_post_meta($post_id, 'vegetarijansko');
    }
}
add_action('save_post', 'kuhaj_save_meta_boxes');


//metabox za vrijeme pripreme
function vrijeme_pripreme_meta_box()
{
    add_meta_box('vrijeme_pripreme_meta', 'Vrijeme pripreme', 'vrijeme_pripreme_render__meta', 'recepti', 'side', 'default');
}
add_action('add_meta_boxes', 'vrijeme_pripreme_meta_box');

function vrijeme_pripreme_render__meta($post)
{
    $value = get_post_meta($post->ID, 'vrijeme_pripreme', true);
?>
    <label for="vrijeme_pripreme">
        Oznaka: Vrijeme pripreme (u minutama)
        <input type="number" name="vrijeme_pripreme" id="vrijeme_pripreme" value=<?php echo $value; ?>>
    </label>
<?php
}

function vrijeme_pripreme_save_meta_boxes($post_id)
{
    if (isset($_POST['vrijeme_pripreme'])) {
        update_post_meta($post_id, 'vrijeme_pripreme', $_POST['vrijeme_pripreme']);
    } else {
        delete_post_meta($post_id, 'vrijeme_pripreme');
    }
}
add_action('save_post', 'vrijeme_pripreme_save_meta_boxes');


// funkcionalnost za ocjenjivanje recepata
function save_user_rating()
{
    if (isset($_POST['user_rating']) && is_numeric($_POST['user_rating']) && is_singular('recepti')) {
        $rating = intval($_POST['user_rating']);

        // Validacija ocjene
        if ($rating >= 1 && $rating <= 5) {
            $post_id = get_the_ID();

            // Dohvati postojeće podatke
            $total_ratings = get_post_meta($post_id, 'total_ratings', true) ?: 0;
            $rating_count = get_post_meta($post_id, 'rating_count', true) ?: 0;

            // Ažuriraj podatke
            $total_ratings += $rating;
            $rating_count += 1;

            // Spremi ažurirane podatke
            update_post_meta($post_id, 'total_ratings', $total_ratings);
            update_post_meta($post_id, 'rating_count', $rating_count);
        }
    }
}
add_action('wp', 'save_user_rating');
