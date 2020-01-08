# Description

 - Create a Pimcore Image Thumbnail Config
 - Add following to a symfony config (eg. /app/config/config.yml)
 
```yaml
api_thumbnails:
    thumbnails:
        thumb_x: "PATH/TO/WHERE/IT/SHOULD/GET/STORED. eg:"
        thumb_y: "web/var/thumbnails"
```

Run Command `bin/console synoa:thumbnails:generate` to generate all images. If images gets added or updated, they will get created automatically.

# Installation

Install with composer

```
composer config repositories.synoa_apithumbnails git https://github.com/synoa/cerebro.pimcore.thumbnail.git
COMPOSER_MEMORY_LIMIT=-1 composer require synoa/apithumbnails
```

# Uninstall

```
COMPOSER_MEMORY_LIMIT=-1 composer remove synoa/apithumbnails
composer config unset repositories.synoa_apithumbnails
```

# Dependencies

| Software | Version |
| --- | --- |
| Pimcore | ^5.7.0||^6.0.0 |
| CoreShop/Pimcore | ^2.1.0 | 
