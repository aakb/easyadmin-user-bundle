Easy Admin User Bundle
======================


Installation
------------

```sh
composer config repositories.easy-admin-user-bundle vcs https://github.com/aakb/easyadmin-user-bundle.git
composer require itk/easyadmin-user-bundle:^1.0
```

Add parameters to `app/config/parameters.yml':

```yaml
    site_name: Name of your site
    mailer_email: info@example.com
    mailer_name: Name of sender

    # Url to your site
    router.request_context.host: ~

    user_created:
        subject: '{{ site_name }} – brugeroprettelse'
        header: 'Bruger oprettet på {{ site_name }}'
        body: |
          <p style='margin: 0;'>Du er blevet oprettet som bruger på {{ site_name }} med e-mailadressen {{ user.email }}.</p>
          <p style='margin: 0;'>For at komme i gang skal du angive en adgangskode.
          <p style='margin: 0;'>Du kan efterfølgende logge ind med din e-mailadresse ({{ user.email }}) og den valgte adgangskode.</p>
        button:
            text: 'Angiv adgangskode'
        footer: '<p style="margin: 0;">Venlig hilsen<br/> {{ site_name }}</p>'
```

Add import to  `app/config/config.yml':

```yaml
imports:
    …
    - { resource: '@EasyAdminUserBundle/Resources/config/config.yml' }
    …
```

Expose `site_name` as global variable in Twig:

```yaml
twig:
    …
    globals:
        …
        site_name: '%site_name%'
        …
```


Add import to  `app/config/services.yml':

```yaml
imports:
    …
    - { resource: '@EasyAdminUserBundle/Resources/config/services.yml' }
    …
```

and enabled the `template_from_string` function:

```yaml
    twig.stringloader:
        class: Twig_Extension_StringLoader
```

Enable both the `FOSUserBundle`
(cf. https://symfony.com/doc/master/bundles/FOSUserBundle/index.html#step-2-enable-the-bundle)
and the `EasyAdminUserBundle`:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = [
        // …
        new FOS\UserBundle\FOSUserBundle(),
        new ItkDev\EasyAdminUserBundle\EasyAdminUserBundle(),
        // …
    ];
}
```


Run through the steps in [Integrating FOSUserBundle to Manage
Users](https://symfony.com/doc/current/bundles/EasyAdminBundle/integration/fosuserbundle.html#creating-new-users),
but use the
`ItkDev\EasyAdminUserBundle\Traits\EasyAdminControllerUserManager`
trait in your (user) admin controller
(cf. https://symfony.com/doc/current/bundles/EasyAdminBundle/integration/fosuserbundle.html#creating-new-users):

```php
<?php

namespace AppBundle\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use ItkDev\EasyAdminUserBundle\Traits\EasyAdminControllerUserManager;

class AdminController extends BaseAdminController
{
    use EasyAdminControllerUserManager;

    …
}

```
