<h1>cerebro.pimcore.thumbnail</h1>

> Extension for Pimcore that converts uploaded images into thumbnails automactially and on the CLI using a custom command

- [Setup](#setup)
  - [Install](#install)
    - [Dependencies](#dependencies)
  - [Uninstall](#uninstall)
  - [Configuration](#configuration)
- [Usage](#usage)
  - [CLI](#cli)

---

# Setup

## Install

Install with composer

```
composer config repositories.synoa_apithumbnails git https://github.com/synoa/cerebro.pimcore.thumbnail.git
COMPOSER_MEMORY_LIMIT=-1 composer require synoa/apithumbnails
```

### Dependencies

| Software | Version |
| --- | --- |
| Pimcore | ^5.7.0||^6.0.0 |
| CoreShop/Pimcore | ^2.1.0 | 


## Uninstall

```
COMPOSER_MEMORY_LIMIT=-1 composer remove synoa/apithumbnails
composer config unset repositories.synoa_apithumbnails
```

## Configuration


 - Create Pimcore `Image Thumbnail`-profiles for each image-type (e.g. product or category) you want to generate: `Settings > Thumbnails > Image Thumbnails`
 - Add the following to a symfony config (eg. `app/config/config.yml`)
 
```yaml
api_thumbnails:
    thumbnails:
        product:
            # The path relative to the assets root-folder
            # This is where the original files are stored
            asset_dir: '/Bilder/Produktbilder'
            
            # The path relative to the Pimcore root-folder
            # This is where the generated / transformed files are stored
            # The images are placed into web/var/thumbnails/product as the name of the profile 
            # is also "product"
            generation_dir: 'web/var/thumbnails'
        category:
            asset_dir: '/Bilder/Kategoriebilder'
            # The images are placed into web/var/thumbnails/category as the name of the profile 
            # is also "category"
            generation_dir: 'web/var/thumbnails'
```

---

# Usage

The files are automatically generated if they are uploaded in Pimcore into the configured folders. 

## CLI

You can also generate all images by executing the command `bin/console synoa:thumbnails:generate`, but that is not needed. 