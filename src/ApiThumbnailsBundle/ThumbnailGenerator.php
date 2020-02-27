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
        foreach ($this->config as $configName => $config) {
            $thumbConfig = Image\Thumbnail\Config::getByName($configName);

            if (!$thumbConfig) {
                continue;
            }

            if (strpos($image->getFullPath(), $config['asset_dir']) === 0) {
                $this->createThumbnail($image, $thumbConfig, $config['generation_dir']);
            }
        }
    }

    protected function createThumbnail(Image $image, Image\Thumbnail\Config $config, string $path)
    {
        $thumbnail = $image->getThumbnail($config, false);
        $pimcorePath = $thumbnail->getFileSystemPath(false);

        $fileInfo = new \SplFileInfo($pimcorePath);
        $fileExtension = $fileInfo->getExtension();

        $originalFileInfo = new \SplFileInfo($image->getFileSystemPath());
        $originalFilenameWithoutExtension = pathinfo($originalFileInfo->getFilename(), PATHINFO_FILENAME);

        $thumbnailFolderPath = sprintf('%s/%s/%s', PIMCORE_PROJECT_ROOT, $path, $config->getName());
        $thumbnailFilePath = sprintf('%s/%s.%s', $thumbnailFolderPath, $originalFilenameWithoutExtension, $fileExtension);

        //No-Change detected
        if (file_exists($thumbnailFilePath) && file_exists($pimcorePath) && filemtime($pimcorePath) < filemtime($thumbnailFilePath)) {
            return;
        }

        $fs = new Filesystem();

        $fs->mkdir($thumbnailFolderPath);
        $fs->copy($pimcorePath, $thumbnailFilePath);
    }
}
