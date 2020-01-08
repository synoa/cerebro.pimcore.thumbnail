<?php

namespace ApiThumbnailsBundle\Command;

use ApiThumbnailsBundle\ThumbnailGeneratorInterface;
use CoreShop\Component\Pimcore\BatchProcessing\BatchListing;
use Pimcore\Console\AbstractCommand;
use Pimcore\Model\Asset;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateThumbnailsCommand extends AbstractCommand
{
    private $generator;

    public function __construct(ThumbnailGeneratorInterface $generator)
    {
        $this->generator = $generator;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('synoa:thumbnails:generate');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $list = new Asset\Listing();
        $list->setCondition('type = \'image\'');

        $batch = new BatchListing($list, 50);

        if (0 === $list->getTotalCount()) {
            $output->writeln('Not Images found, skipping...');
            return 0;
        }

        $progress = new ProgressBar($output, $list->getTotalCount());
        $progress->setFormat(
            '%current%/%max% [%bar%] %percent:3s%% (%elapsed:6s%/%estimated:-6s%) %memory:6s%: %message%'
        );
        $progress->start();

        foreach ($batch as $image)
        {
            if (!$image instanceof Asset\Image) {
                continue;
            }

            $progress->setMessage(sprintf('Generate Image %s (%s)', $image->getFullPath(), $image->getId()));
            $progress->advance();

            $this->generator->generateThumbnails($image);
        }

        return 0;
    }
}
