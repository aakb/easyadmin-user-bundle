<?php

namespace Itk\Bundle\EasyAdminUserBundle\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PasswordResettingListener implements EventSubscriberInterface
{
    private $router;
    private $config;

    public function __construct(UrlGeneratorInterface $router, array $config)
    {
        $this->router = $router;
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::RESETTING_RESET_SUCCESS => 'onPasswordResettingSuccess',
        ];
    }

    public function onPasswordResettingSuccess(FormEvent $event)
    {
        if ($event->getRequest()->request->get('create')) {
            if (isset($this->config['resetting']['create']['redirect_route'])) {
                $route = $this->config['resetting']['create']['redirect_route'];
                $url = $this->router->generate($route);

                $event->setResponse(new RedirectResponse($url));
            }
        }
    }
}
