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
namespace WellCommerce\Bundle\OrderBundle\EventListener;

use WellCommerce\Bundle\CoreBundle\Event\ResourceEvent;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\OrderBundle\Visitor\OrderVisitorTraverserInterface;

/**
 * Class OrderSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderSubscriber extends AbstractEventSubscriber
{
    /**
     * @var OrderVisitorTraverserInterface
     */
    protected $orderVisitorTraverser;

    /**
     * Constructor
     *
     * @param OrderVisitorTraverserInterface $orderVisitorTraverser
     */
    public function __construct(OrderVisitorTraverserInterface $orderVisitorTraverser)
    {
        $this->orderVisitorTraverser = $orderVisitorTraverser;
    }

    public static function getSubscribedEvents()
    {
        return [
            'order.post_prepared' => ['onOrderPostPreparedEvent', 0],
        ];
    }

    public function onOrderPostPreparedEvent(ResourceEvent $event)
    {
        $this->orderVisitorTraverser->traverse($event->getResource());
    }
}
