<?php

namespace ItkDev\EasyAdminUserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('easy_admin_user');

        $rootNode
            ->children()
            ->arrayNode('resetting')
            ->children()
            ->arrayNode('create')
            ->children()
            ->scalarNode('redirect_route')->defaultValue('easyadmin')->end()
            ->end()
            ->end()
            ->end()
            ->end();

        return $treeBuilder;
    }

}
