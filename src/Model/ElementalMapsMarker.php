<?php

namespace TheWebmen\ElementalMaps\Model;

use gorriecoe\LinkField\LinkField;
use gorriecoe\Link\Models\Link;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use TheWebmen\Addressfield\Forms\GooglePlacesField;

class ElementalMapsMarker extends DataObject
{

    private static $singular_name = 'Marker';
    private static $plural_name = 'Markers';

    private static $table_name = 'ElementalMapsMarker';

    private static $db = [
        'Title' => 'Varchar(255)',
        'MapLocation' => 'Varchar(255)',
        'Latitude' => 'Decimal(11,8)',
        'Longitude' => 'Decimal(11,8)'
    ];

    private static $has_one = [
        'ElementalMaps' => ElementalMaps::class,
        'Link' => Link::class
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('ElementalMapsID');

        $fields->addFieldToTab('Root.Main', new TextField('Title', 'Title'));
        $fields->addFieldToTab('Root.Main', $googlePlacesField = new GooglePlacesField('MapLocation', 'Map location'));
        $fields->addFieldToTab('Root.Main', TextField::create('Latitude'));
        $fields->addFieldToTab('Root.Main', TextField::create('Longitude'));
        $googlePlacesField->setLatitudeField('Latitude');
        $googlePlacesField->setLongitudeField('Longitude');

        $fields->addFieldToTab('Root.Main', new LinkField('Link', 'Link', $this));

        return $fields;
    }

}
