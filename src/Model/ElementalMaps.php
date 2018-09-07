<?php

namespace TheWebmen\ElementalMaps\Model;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\TextField;
use TheWebmen\Addressfield\Forms\GooglePlacesField;
use TheWebmen\ElementalMaps\Controller\ElementalMapsController;

class ElementalMaps extends BaseElement
{
    private static $maps_api_key = false;

    private static $icon = 'font-icon-block-globe-1';

    private static $table_name = 'ElementalMaps';

    private static $title = 'Map';

    private static $description = 'Google Maps Map';

    private static $singular_name = 'Map';

    private static $plural_name = 'Maps';

    private static $controller_class = ElementalMapsController::class;

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Map');
    }

    private static $db = [
        'MapLocation' => 'Varchar(255)',
        'Latitude' => 'Decimal(11,8)',
        'Longitude' => 'Decimal(11,8)',
        'MapZoom' => 'Int',
        'MapType' => 'Varchar'
    ];

    private static $has_many = [
        'Markers' => ElementalMapsMarker::class
    ];

    private static $defaults = [
        'MapZoom' => 12,
        'MapType' => 'roadmap'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.Main', new HeaderField('MapLocationHeader', 'Map location'));
        $fields->addFieldToTab('Root.Main', $googlePlacesField = new GooglePlacesField('MapLocation', 'Map location'));
        $fields->addFieldToTab('Root.Main', TextField::create('Latitude'));
        $fields->addFieldToTab('Root.Main', TextField::create('Longitude'));
        $googlePlacesField->setLatitudeField('Latitude');
        $googlePlacesField->setLongitudeField('Longitude');

        $fields->addFieldToTab('Root.Main', new HeaderField('MapSettingsHeader', 'Map settings'));
        $fields->addFieldToTab('Root.Main', new NumericField('MapZoom', 'Map zoom'));
        $fields->addFieldToTab('Root.Main', new DropdownField('MapType', 'Map type', [
            'roadmap' => 'Roadmap',
            'satellite' => 'Satellite',
            'hybrid' => 'Hybrid',
            'terrain' => 'Terrain'
        ]));

        $markersField = $fields->dataFieldByName('Markers');
        if($markersField){
            $markersField->setConfig(GridFieldConfig_RecordEditor::create());
        }

        return $fields;
    }

    public function getSummary()
    {
        return $this->MapLocation;
    }
}
