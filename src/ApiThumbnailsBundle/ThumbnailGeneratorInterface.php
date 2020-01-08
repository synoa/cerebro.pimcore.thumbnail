<?php

namespace ApiThumbnailsBundle;

use Pimcore\Model\Asset\Image;

interface ThumbnailGeneratorInterface
{
    public function generateThumbnails(Image $image);
}
