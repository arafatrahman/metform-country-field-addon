<?php
namespace MFpro\View;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use MFPRO\Model\Country_Model;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Country_Widget_View extends Widget_Base {

    public function get_name() {
        return 'country_widget';
    }

    public function get_title() {
        return __('Country Selector', 'metformpro');
    }

    public function get_icon() {
        return 'fa fa-globe';
    }

    public function get_categories() {
        return ['metform'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'metformpro'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Label Text Control
        $this->add_control(
            'label_text',
            [
                'label' => __('Label Text', 'metformpro'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Select Country', 'metformpro'),
            ]
        );

        // Show/Hide Label Control
        $this->add_control(
            'show_label',
            [
                'label' => __('Show Label', 'metformpro'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'metformpro'),
                'label_off' => __('Hide', 'metformpro'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Label Position Control
        $this->add_control(
            'label_position',
            [
                'label' => __('Label Position', 'metformpro'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'top' => __('Top', 'metformpro'),
                    'left' => __('Left', 'metformpro'),
                ],
                'default' => 'top',
                'condition' => [
                    'show_label' => 'yes',
                ],
            ]
        );

        // Field Name Control
        $this->add_control(
            'field_name',
            [
                'label' => __('Field Name', 'metformpro'),
                'type' => Controls_Manager::TEXT,
                'default' => 'mf-country',
            ]
        );

        // Default Country Dropdown
        $country_model = new Country_Model();
        $countries = $country_model->get_countries();
        
        $this->add_control(
            'country',
            [
                'label' => __('Default Country', 'metformpro'),
                'type' => Controls_Manager::SELECT,
                'options' => $countries,
                'default' => 'US',
            ]
        );

        $this->end_controls_section();

        // Style section for label
        $this->start_controls_section(
            'label_style_section',
            [
                'label' => __('Label', 'metformpro'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_label' => 'yes',
                ],
            ]
        );

        // Label Typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'label' => __('Typography', 'metformpro'),
                'selector' => '{{WRAPPER}} .country-selector-wrapper label',
            ]
        );

        // Label Color
        $this->add_control(
            'label_color',
            [
                'label' => __('Text Color', 'metformpro'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333', // Default label color
                'selectors' => [
                    '{{WRAPPER}} .country-selector-wrapper label' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Label Margin
        $this->add_responsive_control(
            'label_margin',
            [
                'label' => __('Margin', 'metformpro'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .country-selector-wrapper label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style section for dropdown
        $this->start_controls_section(
            'dropdown_style_section',
            [
                'label' => __('Dropdown', 'metformpro'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        // Dropdown Typography
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'dropdown_typography',
                'label' => __('Typography', 'metformpro'),
                'selector' => '{{WRAPPER}} .country-selector-wrapper select',
            ]
        );

        // Dropdown Text Color
        $this->add_control(
            'dropdown_text_color',
            [
                'label' => __('Text Color', 'metformpro'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333', // Default text color
                'selectors' => [
                    '{{WRAPPER}} .country-selector-wrapper select' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Dropdown Background Color
        $this->add_control(
            'dropdown_background_color',
            [
                'label' => __('Background Color', 'metformpro'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff', // Default background color
                'selectors' => [
                    '{{WRAPPER}} .country-selector-wrapper select' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Dropdown Border
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'dropdown_border',
                'label' => __('Border', 'metformpro'),
                'selector' => '{{WRAPPER}} .country-selector-wrapper select',
            ]
        );

        // Dropdown Border Radius
        $this->add_responsive_control(
            'dropdown_border_radius',
            [
                'label' => __('Border Radius', 'metformpro'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .country-selector-wrapper select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Dropdown Padding
        $this->add_responsive_control(
            'dropdown_padding',
            [
                'label' => __('Padding', 'metformpro'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .country-selector-wrapper select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $country_model = new Country_Model();
        $countries = $country_model->get_countries();

        $label_class = $settings['label_position'] === 'left' ? 'label-left' : 'label-top';

        echo "<div class='country-selector-wrapper {$label_class}'>";

        if ($settings['show_label'] === 'yes') {
            echo "<label for='{$settings['field_name']}'>{$settings['label_text']}</label>";
        }
        echo "<select name='mf-country' id='{$settings['field_name']}'>";

        foreach ($countries as $code => $name) {
            $selected = ($settings['country'] == $code) ? 'selected' : '';
            echo "<option value=\"{$name}\" {$selected}>{$name}</option>";
        }
        echo '</select>';

        echo "</div>";
    }

    protected function content_template() {}
    

}
