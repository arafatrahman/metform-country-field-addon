<?php
/**
 * Plugin Name: MetForm Country Field Addon for Elementor
 * Description: Transform your forms with the MetForm Country Selector Widget for Elementor! This intuitive addon seamlessly integrates into your MetForm-powered Elementor pages, allowing you to add a customizable country dropdown to your forms
 * Version: 1.0
 * Author: Arafat Rahman
 * sAuthor URI: https://rrrplus.co.uk/
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Define the plugin path
define('MFCA_PATH', plugin_dir_path(__FILE__));

// Autoload classes
spl_autoload_register(function ($class_name) {
    if (strpos($class_name, 'MFCA\\') === 0) {
        $file = MFCA_PATH . 'includes/' . str_replace(['MFCA\\', '\\'], ['', '/'], $class_name) . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
});

// Main class to initialize the plugin
class MetForm_Country_Addon {
    public function __construct() {
        // Load the widget on Elementor initialization
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
    }

    public function register_widgets() {
        // Instantiate the controller to register the widget
        $controller = new \MFCA\Controller\Country_Widget_Controller();
        $controller->register_widget();
    }
}

// Initialize the plugin
new MetForm_Country_Addon();

add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('metform-country-addon-style', plugin_dir_url(__FILE__) . 'assets/style.css');
});



add_filter('metform_filter_before_store_form_data', 'mfca_add_country_to_form_data', 10, 2);

function mfca_add_country_to_form_data($data, $entry_id) {
    $mf_country = $_POST['mf']['mf-country'] ?? null;

    if ($mf_country) {
        $data['mf-country'] = htmlspecialchars($mf_country);  // Use the same naming convention as other MetForm fields
    }
    return $data;
}


add_action('add_meta_boxes', 'mfca_add_country_meta_box');


function mfca_add_country_meta_box() {
    // Add a custom meta box for the 'mf-country' field
    add_meta_box(
        'metform_entries__country', 
        esc_html__('Country', 'metform'), 
        'mfca_render_country_meta_box', 
        'metform-entry', 
        'normal', 
        'low' 
    );
}

// Callback function to render the content of the meta box
function mfca_render_country_meta_box($post) {
    // Retrieve the 'mf-country' data stored in the meta field
    $country = get_post_meta($post->ID, 'metform_entries__form_data', true);
    $mf_country = $country['mf-country'];
    echo '<p>' . esc_html($mf_country) . '</p>';
}

add_filter('wp_mail', 'mfca_append_country_to_email', 10, 1);

function mfca_append_country_to_email($email) {

    $mf_country = $_POST['mf']['mf-country'] ?? null;
    if ($mf_country) {


            $country_row = "<tr bgcolor='#EAF2FA'><td colspan='2'><strong>Country</strong></td></tr>
                        <tr bgcolor='#FFFFFF'><td width='20'>&nbsp;</td><td>" . esc_html($mf_country) . "</td></tr>";

        // Define the insertion point; find the table closing tag and insert the country row above it
        $pattern = '/<\/tbody>\s*<\/table>/';
        $replacement = $country_row . '</tbody></table>';

        // Insert the country row just before the closing tags of the table
        $email['message'] = preg_replace($pattern, $replacement, $email['message']);
    }
    return $email;


    

}










