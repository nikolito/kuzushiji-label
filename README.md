# Kuzushiji data collection system for machine learning

## Objectives
Manually creating annotation data for machine learning by reading IIIF Manifests as possible as quickly and easily.

## Characteristics
- Automatic generation of bounding boxes on each Kuzushiji characters. 
- Automatic annotation on each bounding box if you want. 
- Export annotation data in W3C annotation format.
- Simple and instinctive user experience.

## Required tools for this system
- Laravel 9 + Laravel Breeze for user management
- Postgresql 14
- PHP 8.1
- [OpenSeadragon](https://openseadragon.github.io/) 3.1.0 for IIIF image operation.
- [Annotorious](https://recogito.github.io/annotorious/) 2.7.6 customized to make labels visible directly on Safari + [OpenSeadragon plugin](https://recogito.github.io/annotorious/api-docs/osd-plugin/) as image annotation library + [Shape Labels](https://github.com/recogito/recogito-client-plugins/tree/main/plugins/annotorious-shape-labels).

## License
MIT License.

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
