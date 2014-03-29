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
namespace WellCommerce\Plugin\Product\Event;

use WellCommerce\Plugin\Layout\Event\LayoutPageFormEvent;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ProductEventSubscriber
 *
 * @package WellCommerce\Plugin\Product\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductEventSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            ProductDataGridEvent::DATAGRID_INIT_EVENT => 'onProductDataGridInitAction',
            LayoutPageFormEvent::TREE_INIT_EVENT      => 'onLayoutPageTreeInitAction',
        ];
    }

    public function onLayoutPageTreeInitAction(GenericEvent $event)
    {
        $event->setArgument('product', 'Product');
    }

    public function onProductDataGridInitAction(Event $event)
    {
    }
}