<?php
namespace MFPRO\Controller;

use \Elementor\Plugin;
use MFPRO\View\Country_Widget_View;

class MFPRO_Addon_Controller {


    public function __construct() {
        // Load the widget on Elementor initialization
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
        add_filter('metform_filter_before_store_form_data', [$this, 'add_country_to_form_data'], 10, 2);
        add_action('add_meta_boxes', [$this, 'add_country_meta_box']);
        add_filter('wp_mail', [$this, 'append_country_to_email'], 10, 1);

    }



    public function register_widgets() {
        // Instantiate the controller to register the widget
        $controller = new \MFPRO\Controller\MFPRO_Addon_Controller();
        $controller->register_widget();
    }

    public function register_widget() {
        require_once(MFPRO_PATH . 'includes/View/Country_Widget_View.php');
        Plugin::instance()->widgets_manager->register_widget_type(new Country_Widget_View());
    }

    // Enqueue styles for the widget
    public function enqueue_styles() {
        wp_enqueue_style('metform-country-addon-style', plugin_dir_url(__DIR__) . '../assets/style.css');
    }

    // Filter to add the country data to MetForm entries
    public function add_country_to_form_data($data, $entry_id) {
        $mf_country = isset($_POST['mf']['mf-country']) ? sanitize_text_field($_POST['mf']['mf-country']) : null;

        if ($mf_country) {
            $data['mf-country'] = htmlspecialchars($mf_country);
        }

        return $data;
    }

    // Add a meta box to the MetForm entry post type
    public function add_country_meta_box() {
        add_meta_box(
            'metform_entries__country', 
            esc_html__('Country', 'metformpro'), 
            [$this, 'render_country_meta_box'], 
            'metform-entry', 
            'normal', 
            'low'
        );
    }

    // Render the country meta box content
    public function render_country_meta_box($post) {
        $country_data = get_post_meta($post->ID, 'metform_entries__form_data', true);
        $mf_country = isset($country_data['mf-country']) ? esc_html($country_data['mf-country']) : 'N/A';
        echo '<p>' . $mf_country . '</p>';
    }

    // Filter to append the country data to the email content
    public function append_country_to_email($email) {
        $mf_country = isset($_POST['mf']['mf-country']) ? sanitize_text_field($_POST['mf']['mf-country']) : null;

        if ($mf_country) {
            $country_row = "<tr bgcolor='#EAF2FA'><td colspan='2'><strong>Country</strong></td></tr>
                            <tr bgcolor='#FFFFFF'><td width='20'>&nbsp;</td><td>" . esc_html($mf_country) . "</td></tr>";

            $pattern = '/<\/tbody>\s*<\/table>/';
            $replacement = $country_row . '</tbody></table>';
            $email['message'] = preg_replace($pattern, $replacement, $email['message']);
        }

        return $email;
    }
}
