<?php

namespace TheWebmen\ElementalMaps\Controller;

use DNADesign\Elemental\Controllers\ElementController;
use SilverStripe\Core\Config\Config;
use SilverStripe\View\Requirements;
use TheWebmen\ElementalMaps\Model\ElementalMaps;
use SilverStripe\Core\Environment;

class ElementalMapsController extends ElementController
{
    const DEFAULT_ENV_KEY = 'ELEMENTAL_MAPS__MAPS_API_KEY';

    public function init()
    {
        parent::init();

        $config = Config::forClass(ElementalMaps::class);
        $key = $config->get('maps_api_key');

        if (empty($key) && !Environment::getEnv($envKey ?? self::DEFAULT_ENV_KEY)) {
            throw new \InvalidArgumentException("Maps API Key not defined in either yml or .env.", 1);
        }

        if ($key[0] === '`' && $key[strlen($key) - 1] === '`') {
            $envKey = trim($key, '`');
        }

        if(empty($key) && Environment::getEnv($envKey ?? self::DEFAULT_ENV_KEY)) {
            $key = Environment::getEnv($envKey ?? self::DEFAULT_ENV_KEY);

            if (is_null($key) || empty($key)) {
                throw new \InvalidArgumentException("maps_api_key starts with '`' indicating an environment file reference. But Environment variable '$envKey' empty or non existant.", 1);
            }
        }

        Requirements::javascript('https://maps.googleapis.com/maps/api/js?key=' . $key);
    }
}
