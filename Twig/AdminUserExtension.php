<?php

namespace Itk\Bundle\EasyAdminUserBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class AdminUserExtension extends \Twig_Extension
{
    /** @var \Symfony\Component\DependencyInjection\ContainerInterface */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('get_app_parameter', [$this, 'getAppParameter']),
        ];
    }

    public function getAppParameter($name, $defaultValue = null)
    {
        list($parameterName, $propertyPath) = explode('.', $name, 2);

        if (!$this->container->hasParameter($parameterName)) {
            return $defaultValue;
        }

        $parameter = $this->container->getParameter($parameterName);
        $propertyPath = '['.str_replace('.', '][', $propertyPath).']';
        $accessor = $this->container->get('property_accessor');

        return $accessor->isReadable($parameter, $propertyPath) ? $accessor->getValue($parameter, $propertyPath) : $defaultValue;
    }
}
