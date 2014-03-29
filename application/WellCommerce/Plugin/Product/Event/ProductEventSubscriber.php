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

use WellCommerce\Plugin\Layout\Event\LayoutBoxFormEvent;
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
            LayoutBoxFormEvent::FORM_GET_BOX_TYPES    => 'onLayoutBoxGetTypesAction',
            LayoutBoxFormEvent::FORM_INIT_EVENT       => 'onLayoutBoxFormInitAction'
        ];
    }

    public function onLayoutPageTreeInitAction(GenericEvent $event)
    {
        $event->setArgument('product', 'Product');
    }

    public function onProductDataGridInitAction(Event $event)
    {
    }

    public function onLayoutBoxGetTypesAction(Event $event)
    {
        $configurator = $event->getDispatcher()->getContainer()->get('product.layout.configurator');
        $event->setArgument($configurator->getAlias(), $configurator->getName());
    }

    public function onLayoutBoxFormInitAction(Event $event)
    {
        $configurator = $event->getDispatcher()->getContainer()->get('product.layout.configurator');
        $configurator->getConfigurationFields($event->getForm());
    }
}