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
namespace WellCommerce\Bundle\CompanyBundle\EventListener;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;
use WellCommerce\Bundle\AdminBundle\Event\AdminMenuEvent;
use WellCommerce\Bundle\AdminBundle\MenuBuilder\XmlLoader;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;

/**
 * Class CompanySubscriber
 *
 * @package WellCommerce\Bundle\CompanyBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanySubscriber extends AbstractEventSubscriber
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