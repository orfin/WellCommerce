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
namespace WellCommerce\Plugin\Producer\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ProducerEventSubscriber
 *
 * @package WellCommerce\Plugin\Producer\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [];
    }
}