<?php
/**
 * Plugin Name: MetForm Pro Addon for Elementor
 * Description: Transform your forms with the MetForm Country Selector Widget for Elementor! This intuitive addon seamlessly integrates into your MetForm-powered Elementor pages, allowing you to add a customizable country dropdown to your forms
 * Version: 1.0
 * Author: Arafat Rahman
 * sAuthor URI: https://rrrplus.co.uk/
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Define the plugin path
define('MFPRO_PATH', plugin_dir_path(__FILE__));

// Autoload classes
spl_autoload_register(function ($class_name) {
    if (strpos($class_name, 'MFPRO\\') === 0) {
        $file = MFPRO_PATH . 'includes/' . str_replace(['MFPRO\\', '\\'], ['', '/'], $class_name) . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
});

new \MFPRO\Controller\MFPRO_Addon_Controller();











