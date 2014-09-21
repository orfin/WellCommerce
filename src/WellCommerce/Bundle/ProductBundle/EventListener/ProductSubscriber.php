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
namespace WellCommerce\Bundle\ProductBundle\EventListener;

use Symfony\Component\Config\FileLocator;
use WellCommerce\Bundle\AdminBundle\Event\AdminMenuEvent;
use WellCommerce\Bundle\AdminBundle\MenuBuilder\XmlLoader;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;

/**
 * Class ProductSubscriber
 *
 * @package WellCommerce\Bundle\ProductBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductSubscriber extends AbstractEventSubscriber
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