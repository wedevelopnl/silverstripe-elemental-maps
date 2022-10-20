<?php

namespace TheWebmen\ElementalMaps\Controller;

use DNADesign\Elemental\Controllers\ElementController;
use SilverStripe\Core\Config\Config;
use SilverStripe\View\Requirements;
use TheWebmen\ElementalMaps\Model\ElementalMaps;
use SilverStripe\Core\Environment;

class ElementalMapsController extends ElementController
{
    public function init()
    {
        parent::init();

        $config = Config::forClass(ElementalMaps::class);
        $key = $config->get('maps_api_key');

        if (empty($key)) {
            throw new \InvalidArgumentException("maps_api_key is empty", 1);
        }

        /* Check for default SilverStripe behaviour (set env var ref in yml) */
        if ($key[0] === '`' && $key[strlen($key) - 1] === '`') {
            $envKey = trim($key, '`');
            $key = Environment::getEnv($envKey);

            if (is_null($key) || empty($key)) {
                throw new \InvalidArgumentException("maps_api_key starts with '`' indicating an environment file reference. But Environment variable '$envKey' empty or non existant.", 1);
            }
        }

        Requirements::javascript('https://maps.googleapis.com/maps/api/js?key=' . $config->get('maps_api_key'));
    }
}
