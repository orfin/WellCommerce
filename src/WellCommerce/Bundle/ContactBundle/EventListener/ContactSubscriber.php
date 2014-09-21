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
namespace WellCommerce\Bundle\ContactBundle\EventListener;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use WellCommerce\Bundle\AdminBundle\Event\AdminMenuEvent;
use WellCommerce\Bundle\AdminBundle\MenuBuilder\XmlLoader;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;

/**
 * Class ContactSubscriber
 *
 * @package WellCommerce\Bundle\ContactBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactSubscriber extends AbstractEventSubscriber
{
    /**
     * Adds new admin menu items to collection
     *
     * @param AdminMenuEvent $event
     */
    public function onAdminMenuInitEvent(AdminMenuEvent $event)
    {
        $loader = new XmlLoader($event->getBuilder(), new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('admin_menu.xml');
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            AdminMenuEvent::INIT_EVENT => 'onAdminMenuInitEvent'
        ];
    }
}