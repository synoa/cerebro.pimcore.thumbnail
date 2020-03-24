# Description

 - Create a Pimcore Image Thumbnail Config
 - Add following to a symfony config (eg. /app/config/config.yml)
 - Both paths are relative to the root of Pimcore
 
```yaml
api_thumbnails:
    thumbnails:
        synoa_hd:
            asset_dir: "path/to/the/source/directory"
            generation_dir: "path/to/the/generated/directory"
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
