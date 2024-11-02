<?php
namespace MFCA\Model;

class Country_Model {
    public function get_countries() {
        return include(MFCA_PATH . 'assets/countries.php');
    }
}
