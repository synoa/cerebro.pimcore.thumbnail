<?php

namespace ApiThumbnailsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('api_thumbnails');

        $treeBuilder->getRootNode()
        ->children()
            ->arrayNode('thumbnails')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()
        ->end();

        return $treeBuilder;
    }
}
