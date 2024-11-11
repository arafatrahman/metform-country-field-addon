<?php
namespace MFPRO\Model;

class Country_Model {
    public function get_countries() {
        return include(MFPRO_PATH . 'assets/countries.php');
    }
}
