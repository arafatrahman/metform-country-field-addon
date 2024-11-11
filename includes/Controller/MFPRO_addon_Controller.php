<?php
namespace MFPRO\Controller;

use MFPRO\View\Country_Widget_View;
use MFPRO\View\ColorPicker_Widget_View;
use Elementor\Plugin;

class MFPRO_Addon_Controller {

    public function __construct() {
        // Register widgets on Elementor initialization
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
        
        // Enqueue styles
        add_action('wp_enqueue_scripts', [$this, 'mfpro_enqueue_styles']);
        
        // Add custom fields to MetForm entries
        add_filter('metform_filter_before_store_form_data', [$this, 'add_custom_fields_to_form_data'], 10, 2);
        
        // Add custom fields to email notifications
        add_filter('wp_mail', [$this, 'append_custom_fields_to_email'], 10, 1);

        // Register meta box to display custom fields in entry edit screen
        add_action('add_meta_boxes', [$this, 'add_pro_fields_meta_box']);
    }

    public function register_widgets() {
        Plugin::instance()->widgets_manager->register_widget_type(new Country_Widget_View());
        Plugin::instance()->widgets_manager->register_widget_type(new ColorPicker_Widget_View());
    }

    public function mfpro_enqueue_styles() {
        wp_enqueue_style('metform-addon-style', plugin_dir_url(__DIR__) . '../assets/style.css');
        
        wp_enqueue_script('jquery');

        // Enqueue JavaScript file
         wp_enqueue_script('metform-addon-script', plugin_dir_url(__DIR__) . '../assets/script.js', array('jquery'), null, true);
    }

    public function add_custom_fields_to_form_data($data, $entry_id) {
        $mf_country = isset($_POST['mf-country']) ? sanitize_text_field($_POST['mf-country']) : null;
        $mf_color = isset($_POST['mf-color']) ? sanitize_hex_color($_POST['mf-color']) : null;
        
        if ($mf_country) {
            $data['mf-country'] = $mf_country;
        }
        if ($mf_color) {
            $data['mf-color'] = $mf_color;
        }
        
        return $data;
    }

    public function append_custom_fields_to_email($email) {

        
        $mf_country = isset($_POST['mf-country']) ? sanitize_text_field($_POST['mf-country']) : null;
        $mf_color = isset($_POST['mf-color']) ? sanitize_hex_color($_POST['mf-color']) : null;
        
        if ($mf_country) {
            $email['message'] .= "\nSelected Country: " . $mf_country;
        }
        if ($mf_color) {
            $email['message'] .= "\nSelected Color: " . $mf_color;
        }
        
        return $email;
    }

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

    // Add meta box for displaying Pro fields
    public function add_pro_fields_meta_box() {
        add_meta_box(
            'mfpro_pro_fields_meta_box',             // Unique ID for the meta box
            __('MetForm Pro Fields', 'metformpro'),  // Meta box title
            [$this, 'render_pro_fields_meta_box'],   // Callback to render the meta box
            'metform-entry',                         // Screen where it will appear
            'normal',                                // Context where the box will appear
            'default'                                // Priority
        );
    }

    // Render the meta box content
    public function render_pro_fields_meta_box($post) {

        $form_data = get_post_meta($post->ID, 'metform_entries__form_data', true);

        $mf_country = isset($form_data['mf-country']) ? sanitize_text_field($form_data['mf-country']) : null;
        $mf_color = isset($form_data['mf-color']) ? sanitize_text_field($form_data['mf-color']) : null;

        

        // Display the fields in the meta box
        echo '<table style="width:100%;">';
        if($mf_country){
        echo '<tr><th style="width:150px;">' . __('Selected Country:', 'metformpro') . '</th><td>' . esc_html($mf_country ?: __('N/A', 'metformpro')) . '</td></tr>';}
        if($mf_color){echo '<tr><th style="width:150px;">' . __('Selected Color:', 'metformpro') . '</th><td><input type="color" value="' . esc_attr($mf_color ?: '#ffffff') . '" disabled /></td></tr>';}
        echo '</table>';
    }
}
new MFPRO_Addon_Controller();
