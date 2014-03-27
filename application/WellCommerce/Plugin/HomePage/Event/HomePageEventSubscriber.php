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
namespace WellCommerce\Plugin\HomePage\Event;

use WellCommerce\Plugin\Layout\Event\LayoutPageFormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Class HomePageEventSubscriber
 *
 * @package WellCommerce\Plugin\HomePage\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class HomePageEventSubscriber implements EventSubscriberInterface
{

    public function onLayoutPageTreeInitAction(GenericEvent $event)
    {
        $event->setArgument('home_page', 'Home Page');
    }

    public static function getSubscribedEvents()
    {
        return array(
            LayoutPageFormEvent::TREE_INIT_EVENT => 'onLayoutPageTreeInitAction'
        );
    }
}