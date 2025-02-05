<?php
// Registracija glavnog menija
function kuharica_register_menus()
{
    register_nav_menus([
        'primary' => __('Glavni Meni', 'kuharica'),
    ]);
}
add_action('after_setup_theme', 'kuharica_register_menus');

// Uključivanje CSS-a i JS-a
function kuharica_enqueue_scripts()
{
    // Bootstrap CSS
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css');
    // Glavni stil
    wp_enqueue_style('kuharica-style', get_stylesheet_uri());
    // Bootstrap JS
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'kuharica_enqueue_scripts');

/**
 * Register Custom Navigation Walker
 */
function register_navwalker()
{
    require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}
add_action('after_setup_theme', 'register_navwalker');

// Registracija widget područja
function kuharica_widgets_init()
{
    register_sidebar(array(
        'name' => __('Sidebar', 'kuharica'),
        'id' => 'sidebar-1',
        'description' => __('Dodajte widgete ovdje.', 'kuharica'),
        'before_widget' => '<div class="widget mb-4">',
        'after_widget' => '</div>',
        'before_title' => '<h5 class="widget-title">',
        'after_title' => '</h5>',
    ));
}
add_action('widgets_init', 'kuharica_widgets_init');

// Registracija CPT-a: Recepti
function register_recipe_post_type()
{
    $labels = array(
        'name'                  => 'Recepti',
        'singular_name'         => 'Recept',
        'menu_name'             => 'Recepti',
        'name_admin_bar'        => 'Recept',
        'add_new'               => 'Dodaj novi',
        'add_new_item'          => 'Dodaj novi recept',
        'new_item'              => 'Novi recept',
        'edit_item'             => 'Uredi recept',
        'view_item'             => 'Pogledaj recept',
        'all_items'             => 'Svi recepti',
        'search_items'          => 'Pretraži recepte',
        'not_found'             => 'Nema pronađenih recepata',
        'not_found_in_trash'    => 'Nema recepata u smeću',
        'featured_image'        => 'Slika recepta',
        'set_featured_image'    => 'Postavi sliku recepta',
        'remove_featured_image' => 'Ukloni sliku recepta',
        'use_featured_image'    => 'Koristi kao sliku recepta',
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => true,
        'rewrite'               => array('slug' => 'recipe', 'with_front' => false),
        'supports'              => array('title', 'editor', 'thumbnail'),
        'show_in_rest'          => true,
        'taxonomies'            => array('category'), // Korištenje postojećih kategorija
    );

    register_post_type('recipe', $args);
}
add_action('init', 'register_recipe_post_type');

// Registracija CPT-a: Kategorije (kao vlastiti post type)
function register_category_post_type()
{
    $labels = array(
        'name'                  => 'Kategorije',
        'singular_name'         => 'Kategorija',
        'menu_name'             => 'Kategorije',
        'name_admin_bar'        => 'Kategorija',
        'add_new'               => 'Dodaj novu',
        'add_new_item'          => 'Dodaj novu kategoriju',
        'new_item'              => 'Nova kategorija',
        'edit_item'             => 'Uredi kategoriju',
        'view_item'             => 'Pogledaj kategoriju',
        'all_items'             => 'Sve kategorije',
        'search_items'          => 'Pretraži kategorije',
        'not_found'             => 'Nema pronađenih kategorija',
        'not_found_in_trash'    => 'Nema kategorija u smeću',
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => true,
        'rewrite'               => array('slug' => 'category', 'with_front' => false),
        'supports'              => array('title', 'editor'),
        'show_in_rest'          => true,
        'show_ui'               => true,  // Omogućuje prikaz u administraciji
        'show_in_menu'          => true,
        'hierarchical'          => true, // Omogućuje podkategorije
    );

    register_post_type('category', $args);
}
add_action('init', 'register_category_post_type');

// Povezivanje Kategorija s Receptima
function link_recipe_to_category()
{
    // Veza između Recepta i Kategorije
    register_taxonomy_for_object_type('category', 'recipe');
}
add_action('init', 'link_recipe_to_category');

function custom_flush_rewrite_rules()
{
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'custom_flush_rewrite_rules');

// Registracija CPT-a: Začini
function register_spice_post_type()
{
    $labels = array(
        'name'                  => 'Začini',
        'singular_name'         => 'Začin',
        'menu_name'             => 'Začini',
        'name_admin_bar'        => 'Začin',
        'add_new'               => 'Dodaj novi',
        'add_new_item'          => 'Dodaj novi začin',
        'new_item'              => 'Novi začin',
        'edit_item'             => 'Uredi začin',
        'view_item'             => 'Pogledaj začin',
        'all_items'             => 'Svi začini',
        'search_items'          => 'Pretraži začine',
        'not_found'             => 'Nema pronađenih začina',
        'not_found_in_trash'    => 'Nema začina u smeću',
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'has_archive'           => true,
        'rewrite'               => array('slug' => 'spice', 'with_front' => false),
        'supports'              => array('title', 'editor', 'thumbnail'),
        'show_in_rest'          => true,
    );

    register_post_type('spice', $args);
}
add_action('init', 'register_spice_post_type');
