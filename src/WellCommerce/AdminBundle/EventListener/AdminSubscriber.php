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
namespace WellCommerce\AdminBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\AdminBundle\Entity\UserInterface;
use WellCommerce\AppBundle\EventListener\AbstractEventSubscriber;

/**
 * Class AdminSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminSubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', 0],
        ];
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $user = $this->getUser();
        if ($user instanceof UserInterface) {
            $route = $this->getRouterHelper()->getCurrentRoute();
            if ($route->hasOption('require_admin_permission')) {
                $name       = $route->getOption('require_admin_permission');
                $permission = $this->getSecurityHelper()->getPermission($name, $user);
                if (empty($permission)) {
                    $event->setController([$this->get('user.controller.admin'), 'accessDeniedAction']);
                }
            }
        }
    }
}
