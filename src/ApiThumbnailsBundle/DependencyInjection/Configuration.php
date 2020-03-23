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
        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
                ->arrayNode('thumbnails')
                    ->useAttributeAsKey('thumbnail')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('asset_dir')->isRequired()->end()
                            ->scalarNode('generation_dir')->isRequired()->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
