<?php

namespace Itk\Bundle\EasyAdminUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class EasyAdminUserBundle extends Bundle
{
    public function getParent()
    {
        // @see http://symfony.com/doc/current/bundles/inheritance.html
        return 'FOSUserBundle';
    }
}
