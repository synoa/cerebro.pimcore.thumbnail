<?php

namespace ApiThumbnailsBundle;

use Pimcore\Model\Asset\Image;
use Symfony\Component\Filesystem\Filesystem;

class ThumbnailGenerator implements ThumbnailGeneratorInterface
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function generateThumbnails(Image $image)
    {
        foreach ($this->config as $configName => $path) {
            $config = Image\Thumbnail\Config::getByName($configName);

            if (!$config) {
                continue;
            }

            $this->createThumbnail($image, $config, $path);
        }
    }

    protected function createThumbnail(Image $image, Image\Thumbnail\Config $config, string $path)
    {
        $thumbnail = $image->getThumbnail($config, false);
        $pimcorePath = $thumbnail->getFileSystemPath(false);

        $fileInfo = new \SplFileInfo($pimcorePath);
        $fileExtension = $fileInfo->getExtension();

        $thumbnailFolderPath = sprintf('%s/%s/%s', PIMCORE_PROJECT_ROOT, $path, $config->getName());
        $thumbnailFilePath = sprintf('%s/%s.%s', $thumbnailFolderPath, $image->getId(), $fileExtension);

        //No-Change detected
        if (file_exists($thumbnailFilePath) && file_exists($pimcorePath) && filemtime($pimcorePath) < filemtime($thumbnailFilePath)) {
            return;
        }

        $fs = new Filesystem();

        $fs->mkdir($thumbnailFolderPath);
        $fs->copy($pimcorePath, $thumbnailFilePath);
    }
}