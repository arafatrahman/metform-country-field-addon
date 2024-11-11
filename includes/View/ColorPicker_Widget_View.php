<?php
namespace MFPRO\View;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class ColorPicker_Widget_View extends Widget_Base {
    public function get_name() {
        return 'color_picker_widget';
    }

    public function get_title() {
        return __('Color Picker', 'metformpro');
    }

    public function get_icon() {
        return 'fa fa-palette';
    }

    public function get_categories() {
        return ['metform'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Color Picker', 'metformpro'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Add a color picker control
        $this->add_control(
            'color_picker',
            [
                'label' => __('Choose Color', 'metformpro'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
    
        // Output an input field with the color picker as its default value
        echo '<div class="color-picker-input-wrapper">';
        echo '<label for="mf-color-picker">' . __('Selected Color:', 'metformpro') . '</label>';
        echo '<input type="color" id="mf-color" name="mf-color" value="' . esc_attr($settings['color_picker']) . '" />';
        echo '</div>';
        
    }


    
}
