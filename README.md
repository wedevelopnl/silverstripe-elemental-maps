# SilverStripe Elemental Maps
For compatibility with sheadawson/silverstripe-linkable please use v1.x

## Description
Google Maps element for Elemental

## Config
Add the Google Maps API key:

```yaml
TheWebmen\ElementalMaps\Model\ElementalMaps:
  maps_api_key: 'API_KEY'
```
or via an environment file
```env
ELEMENTAL_MAPS__MAPS_API_KEY=.....
```
or hint to the env key from the yml
```yml
TheWebmen\ElementalMaps\Model\ElementalMaps:
  maps_api_key: '`ENV_KEY_FOR_API_KEY`'
```

## Upgrading from v1.x to v2.x

In v2.x `sheadawson/silverstripe-linkable` is replaced by `gorriecoe/silverstripe-linkfield`.
When upgrading, you need to be aware of the fact that the links needs to get migrated.

You may can use https://github.com/dynamic/silverstripe-link-migrator (as refer) to do this migration .