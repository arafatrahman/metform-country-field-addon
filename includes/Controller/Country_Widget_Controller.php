<?php
namespace MFCA\Controller;

use \Elementor\Plugin;
use MFCA\View\Country_Widget_View;

class Country_Widget_Controller {
    public function register_widget() {
        require_once(MFCA_PATH . 'includes/View/Country_Widget_View.php');
        Plugin::instance()->widgets_manager->register_widget_type(new Country_Widget_View());
    }
}
