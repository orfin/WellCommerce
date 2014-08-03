<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace WellCommerce\Core\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestMatcher;

/**
 * Class AdminUserListener
 *
 * @package WellCommerce\Core\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminUserListener implements EventSubscriberInterface
{
    const LOGIN_ROUTE = 'admin.user.login';

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param FilterControllerEvent $event
     */

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request        = $event->getRequest();
        $requestMatcher = new RequestMatcher('^/admin');
        $currentRoute   = $request->attributes->get('_route');
        $user           = $this->container->get('session')->get('admin/user');
        if ($requestMatcher->matches($request) && !$user) {
            if ($currentRoute != self::LOGIN_ROUTE) {
                $event->setResponse(new RedirectResponse($this->container->get('router')->generate(self::LOGIN_ROUTE)));
            }
        }
    }

    /**
     * Returns subscribed events
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', -256]
        ];
    }
}