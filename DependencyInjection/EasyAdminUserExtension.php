<?php

namespace ItkDev\EasyAdminUserBundle\DependencyInjection;

use ItkDev\EasyAdminUserBundle\EventListener\PasswordResettingListener;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class EasyAdminUserExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $def = $container->getDefinition(PasswordResettingListener::class);
        $argumentIndex = 1;
        $def->replaceArgument($argumentIndex, array_replace_recursive($def->getArgument($argumentIndex), $config));
    }
}
