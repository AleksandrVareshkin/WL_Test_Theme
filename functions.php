<?php
add_theme_support('post-thumbnails');

add_action('wp_enqueue_scripts', 'add_scripts_and_styles');
function add_scripts_and_styles()
{
    wp_enqueue_style('style', get_stylesheet_directory_uri() . '/style.css');
}



add_theme_support('custom-logo', [
    'height' => 100,
    'width' => 150,
    'flex-width' => false,
    'flex-height' => false,
    'header-text' => '',
    'unlink-homepage-logo' => false,
]);

function customize_register_action($wp_customize)
{
    $a = $wp_customize;
    $wp_customize->add_setting(
        'title_tagline_phone',
        array(
            'default' => '+7 (777) 777-77-77',
        )
    );
    $wp_customize->add_control(
        'title_tagline_phone',
        array(
            'label' => 'Телефон',
            'section' => 'title_tagline',
            'type' => 'text',
        )
    );
}

add_action('customize_register', 'customize_register_action');



add_action('init', 'create_taxonomy');
function create_taxonomy()
{
    register_taxonomy('brand', ['car'], [
        'label' => '',
        'labels' => [
            'name' => 'Brand',
            'singular_name' => 'Brand',
            'search_items' => 'Search Brands',
            'all_items' => 'All Brands',
            'view_item ' => 'View Brand',
            'parent_item' => 'Parent Brand',
            'parent_item_colon' => 'Parent Brand:',
            'edit_item' => 'Edit Brand',
            'update_item' => 'Update Brand',
            'add_new_item' => 'Add New Brand',
            'new_item_name' => 'New Brand Name',
            'menu_name' => 'Brand',
            'back_to_items' => '← Back to Brand',
        ],
        'public' => true,
        'hierarchical' => false,

        'rewrite' => true,
        'capabilities' => array(),
        'meta_box_cb' => null,
        'show_admin_column' => false,
        'show_in_rest' => null,
        'rest_base' => null,
    ]);

    register_taxonomy('manufacturer', ['car'], [
        'label' => '',
        'labels' => [
            'name' => 'Manufacturer',
            'singular_name' => 'Manufacturer',
            'search_items' => 'Search Manufacturers',
            'all_items' => 'All Manufacturers',
            'view_item ' => 'View Manufacturer',
            'parent_item' => 'Parent Manufacturer',
            'parent_item_colon' => 'Parent Manufacturer:',
            'edit_item' => 'Edit Manufacturer',
            'update_item' => 'Update Manufacturer',
            'add_new_item' => 'Add New Manufacturer',
            'new_item_name' => 'New Manufacturer Name',
            'menu_name' => 'Genre',
            'back_to_items' => '← Back to Manufacturer',
        ],
        'public' => true,
        'hierarchical' => false,
        'rewrite' => true,
        'capabilities' => array(),
        'meta_box_cb' => null,
        'show_admin_column' => false,
        'show_in_rest' => null,
        'rest_base' => null,
    ]);
}

add_action('init', 'register_post_types');

function register_post_types()
{

    register_post_type('car', [
        'label' => null,
        'labels' => [
            'name' => 'Car',
            'singular_name' => 'Car',
            'add_new' => 'Add car',
            'add_new_item' => 'Add new car',
            'edit_item' => 'Edit car',
            'new_item' => 'New car',
            'view_item' => 'View cars',
            'search_items' => 'Search cars',
            'not_found' => 'Not found cars',
            'not_found_in_trash' => 'Not found in trash',
            'parent_item_colon' => '',
            'menu_name' => 'Car',
        ],
        'description' => '',
        'public' => true,
        'hierarchical' => true,
        'has_archive' => false,
        'supports' => array('title', 'editor', 'author', 'thumbnail')
    ]);

}



add_action('add_meta_boxes', 'my_theme_fields', 1);

function my_theme_fields()
{
    add_meta_box('theme_fields', 'Дополнительные поля', 'theme_fields_box_func', 'car', 'normal', 'high');
}



function theme_fields_box_func($post)
{
?>
<p><label><input type="number" name="theme[power]" value="<?php echo get_post_meta($post->ID, 'power', 1); ?>"
            style="width:20%" /> Power</label></p>
<p><label><input type="number" name="theme[price]" value="<?php echo get_post_meta($post->ID, 'price', 1); ?>"
            style="width:20%" /> Price</label></p>




<p><select name="theme[select]">
        <?php $sel_v = get_post_meta($post->ID, 'select', 1); ?>
        <option value="0">----</option>
        <option value="gas" <?php selected($sel_v, 'gas') ?>>gas</option>
        <option value="petrol" <?php selected($sel_v, 'petrol') ?>>petrol</option>
        <option value="diesel" <?php selected($sel_v, 'diesel') ?>>diesel</option>
    </select> Fuel</p>

<input type="hidden" name="theme_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
<?php
}


add_action('save_post', 'my_theme_fields_update', 0);

function my_theme_fields_update($post_id)
{

    if (
        empty($_POST['theme'])
        || !wp_verify_nonce($_POST['theme_fields_nonce'], __FILE__)
        || wp_is_post_autosave($post_id)
        || wp_is_post_revision($post_id)
    )
        return false;


    $_POST['theme'] = array_map('sanitize_text_field', $_POST['theme']);
    foreach ($_POST['theme'] as $key => $value) {
        if (empty($value)) {
            delete_post_meta($post_id, $key);
            continue;
        }

        update_post_meta($post_id, $key, $value);
    }

    return $post_id;
}



add_action('add_meta_boxes', 'mytheme_add_meta_box');

if (!function_exists('mytheme_add_meta_box')) {
    function mytheme_add_meta_box()
    {
        add_meta_box('header-car-metabox-options', esc_html__('Car Color', 'mytheme'), 'mytheme_car_meta_box', 'car', 'normal', 'low');
    }
}

add_action('admin_enqueue_scripts', 'mytheme_backend_scripts');

if (!function_exists('mytheme_backend_scripts')) {
    function mytheme_backend_scripts($hook)
    {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
    }
}



if (!function_exists('mytheme_car_meta_box')) {
    function mytheme_car_meta_box($post)
    {
        $custom = get_post_custom($post->ID);
        $car_color = (isset($custom['car_color'][0])) ? $custom['car_color'][0] : '';
        wp_nonce_field('mytheme_car_meta_box', 'mytheme_car_meta_box_nonce');
?>
<script>
    jQuery(document).ready(function ($) {
        $('.color_field').each(function () {
            $(this).wpColorPicker();
        });
    });
</script>
<div class="pagebox">
    <p><?php esc_attr_e('Choose a color for your car.', 'mytheme'); ?></p>
    <input class="color_field" type="hidden" name="car_color" value="<?php esc_attr_e($car_color); ?>" />
</div>
<?php
    }
}


if (!function_exists('mytheme_save_car_meta_box')) {
    function mytheme_save_car_meta_box($post_id)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        if (!current_user_can('edit_pages')) {
            return;
        }
        if (!isset($_POST['car_color']) || !wp_verify_nonce($_POST['mytheme_car_meta_box_nonce'], 'mytheme_car_meta_box')) {
            return;
        }
        $car_color = (isset($_POST['car_color']) && $_POST['car_color'] != '') ? $_POST['car_color'] : '';
        update_post_meta($post_id, 'car_color', $car_color);
    }
}

add_action('save_post', 'mytheme_save_car_meta_box');




add_shortcode('car_list', 'car_list_shortcode');

function car_list_shortcode()
{
    ob_start();
    get_template_part('templates/car-list');
    return ob_get_clean();
}