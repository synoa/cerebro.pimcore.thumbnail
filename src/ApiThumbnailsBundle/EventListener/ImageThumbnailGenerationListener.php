<?php

namespace ApiThumbnailsBundle\EventListener;

use ApiThumbnailsBundle\ThumbnailGeneratorInterface;
use Pimcore\Event\AssetEvents;
use Pimcore\Event\Model\AssetEvent;
use Pimcore\Model\Asset\Image;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Filesystem\Filesystem;

class ImageThumbnailGenerationListener implements EventSubscriberInterface
{
    /**
     * @var ThumbnailGeneratorInterface
     */
    private $generator;

    public function __construct(ThumbnailGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    public static function getSubscribedEvents()
    {
        return [
            AssetEvents::POST_ADD => 'assetPostAddUpdate',
            AssetEvents::POST_UPDATE => 'assetPostAddUpdate',
        ];
    }

    public function assetPostAddUpdate(AssetEvent $assetEvent)
    {
        $asset = $assetEvent->getAsset();

        if (!$asset instanceof Image) {
            return;
        }

        $this->updateImageThumbnails($asset);
    }

    protected function updateImageThumbnails(Image $image)
    {
        $this->generator->generateThumbnails($image);
    }
}
