<?php

namespace TheWebmen\ElementalMaps\Controller;

use DNADesign\Elemental\Controllers\ElementController;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Environment;
use SilverStripe\View\Requirements;
use TheWebmen\ElementalMaps\Model\ElementalMaps;

class ElementalMapsController extends ElementController {

    public function init()
    {
        parent::init();

        $config = Config::forClass(ElementalMaps::class);

        if ($config->get('maps_api_key')) {
            $key = $config->get('maps_api_key');
        }

        if (empty($key) && Environment::getEnv('WDVLP_ELEMENTAL_MAPS_API_KEY')) {
            $key = Environment::getEnv('WDVLP_ELEMENTAL_MAPS_API_KEY');
        }

        if (empty($key)) {
            throw new \InvalidArgumentException("maps_api_key is empty", 1);
        }

        Requirements::javascript('https://maps.googleapis.com/maps/api/js?key=' . $key);
    }

}
