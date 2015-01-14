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
namespace WellCommerce\Bundle\AdminBundle\EventListener;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\AdminBundle\Event\AdminMenuEvent;
use WellCommerce\Bundle\AdminBundle\MenuBuilder\XmlLoader;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;

/**
 * Class AdminSubscriber
 *
 * @package WellCommerce\Bundle\AdminBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminSubscriber extends AbstractEventSubscriber
{
    const ADMIN_MENU_SESSION_NAMESPACE = 'admin/menu';

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', -256]
        ];
    }

    public function onKernelController(FilterControllerEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        // admin menu will be rendered only when HttpKernelInterface::MASTER_REQUEST
        if ($event->getRequestType() == HttpKernelInterface::SUB_REQUEST) {
            return;
        }

        if (!$this->container->get('session')->has('admin/menu')) {
            $builder   = $this->initAdminMenuBuilder();
            $menuEvent = new AdminMenuEvent($builder);
            $dispatcher->dispatch(AdminMenuEvent::INIT_EVENT, $menuEvent);
            $menu = $menuEvent->getBuilder()->getMenu();
            $this->container->get('session')->set(self::ADMIN_MENU_SESSION_NAMESPACE, $menu);
        }
    }

    /**
     * Initializes admin menu builder and parses menu XML files
     *
     * @return \WellCommerce\Bundle\AdminBundle\MenuBuilder\AdminMenuBuilder
     */
    private function initAdminMenuBuilder()
    {
        $reflection = new \ReflectionClass($this);
        $directory  = dirname($reflection->getFileName());
        $builder    = $this->container->get('admin_menu.builder');
        $loader     = new XmlLoader($builder, new FileLocator($directory . '/../Resources/config'));
        $loader->load('admin_menu.xml');

        return $builder;
    }
}
