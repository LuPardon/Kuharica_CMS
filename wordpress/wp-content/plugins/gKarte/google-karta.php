<?php
/*
Plugin Name: Google Map Pin
Plugin URI: https://example.com
Description: Prikazuje Google kartu s pinom na odabranoj lokaciji.
Version: 1.0
Author: Lucija Barišić
License: GPL2
*/

// Dodavanje menija u admin panel
add_action('admin_menu', 'gmp_add_admin_menu');
add_action('admin_init', 'gmp_register_settings');

function gmp_add_admin_menu()
{
    add_menu_page('Google Map Pin', 'Google Map Pin', 'manage_options', 'google-map-pin', 'gmp_settings_page');
}

function gmp_register_settings()
{
    register_setting('gmp_settings', 'gmp_api_key');
    register_setting('gmp_settings', 'gmp_latitude');
    register_setting('gmp_settings', 'gmp_longitude');
}

// Stranica s postavkama
function gmp_settings_page()
{ ?>
    <div class="wrap">
        <h1>Postavke Google Map Pin</h1>
        <form method="post" action="options.php">
            <?php settings_fields('gmp_settings'); ?>
            <?php do_settings_sections('gmp_settings'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Google Maps API ključ</th>
                    <td><input type="text" name="gmp_api_key" value="<?php echo esc_attr(get_option('gmp_api_key')); ?>" style="width: 400px;" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Geografska širina (Latitude)</th>
                    <td><input type="text" name="gmp_latitude" value="<?php echo esc_attr(get_option('gmp_latitude', '45.8150')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Geografska dužina (Longitude)</th>
                    <td><input type="text" name="gmp_longitude" value="<?php echo esc_attr(get_option('gmp_longitude', '15.9819')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
<?php }

// Uključivanje JavaScript datoteke
add_action('wp_enqueue_scripts', 'gmp_enqueue_scripts');

function gmp_enqueue_scripts()
{
    wp_enqueue_script('gmp_google_maps', 'https://maps.googleapis.com/maps/api/js?key=' . get_option('gmp_api_key'), array(), null, true);
    wp_enqueue_script('gmp_map_script', plugins_url('map.js', __FILE__), array('gmp_google_maps'), null, true);

    wp_localize_script('gmp_map_script', 'gmpData', array(
        'latitude' => get_option('gmp_latitude', '45.8150'),
        'longitude' => get_option('gmp_longitude', '15.9819'),
    ));
}

// Prikaz karte putem shortcodea
add_shortcode('google_map_pin', 'gmp_display_map');

function gmp_display_map()
{
    //https://www.google.com/maps/d/u/0/edit?mid=136oKtXs7DVaT8YjHl0dB-uEd_POAqEc&usp=sharing
    return '<iframe style="width: 100%;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d44532.94694486205!2d15.952078599999998!3d45.764993600000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4765d5dec326dfbd%3A0x26a5f559d57ebbbc!2sZagreb-Novi%20Zagreb%2C%20Zagreb!5e0!3m2!1shr!2shr!4v1738079414117!5m2!1shr!2shr" width="700" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
    return '<div id="gmp-map" style="width: 100%; height: 400px;"></div>';
}
