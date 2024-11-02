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





