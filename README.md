# Kuzushiji data collection system for machine learning

## Objectives
Manually creating annotation data for machine learning by reading IIIF Manifests as possible as quickly and easily.

## Characteristics
- Simple and intuitive user experience.
- Task management with deadline function.
- Automatic generation of bounding boxes on each Kuzushiji characters. 
- Automatic annotation on each bounding box if you want. 
- Export annotation data in W3C annotation format.

## Required tools for this system
- Laravel 9 + Laravel Breeze for user management
- PHP 8.1
- database system (Mysql, Mariadb, PostgreSQL, etc.)
- IIIF manifests.
- For user management, you need to prepare a generic mail function (at least a sending function) on your system.

## Special thanks to:
- [OpenSeadragon](https://openseadragon.github.io/) 3.1.0 for IIIF image operation.
- [Annotorious](https://recogito.github.io/annotorious/) 2.7.6 customized to make labels visible directly on Safari + [OpenSeadragon plugin](https://recogito.github.io/annotorious/api-docs/osd-plugin/) as image annotation library + [Shape Labels](https://github.com/recogito/recogito-client-plugins/tree/main/plugins/annotorious-shape-labels).
- KuroNet, KogumaNet for automatic kuzushiji recognition assistance.

## Some Comments
- A journey of a thousand miles begins with a single step.
- Thank you for all developers related to this system.
- It's not only for Kuzushiji. Any IIIF images are applicable. 

## License
MIT License.

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
