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
namespace WellCommerce\Plugin\Contact\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use WellCommerce\Plugin\AdminMenu\Event\AdminMenuInitEvent;
use WellCommerce\Plugin\Layout\Event\LayoutBoxFormEvent;

/**
 * Class ContactEventSubscriber
 *
 * @package WellCommerce\Plugin\Contact\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactEventSubscriber implements EventSubscriberInterface
{
    public function onAdminMenuInitAction(Event $event)
    {

    }

    public function onLayoutBoxGetTypesAction(GenericEvent $event)
    {
        $configurator = $event->getDispatcher()->getContainer()->get('contact_box.layout.configurator');
        $event->setArgument($configurator->getAlias(), $configurator->getName());
    }

    public static function getSubscribedEvents()
    {
        return array(
            AdminMenuInitEvent::ADMIN_MENU_INIT_EVENT => 'onAdminMenuInitAction',
            LayoutBoxFormEvent::FORM_GET_BOX_TYPES    => 'onLayoutBoxGetTypesAction'
        );
    }
}