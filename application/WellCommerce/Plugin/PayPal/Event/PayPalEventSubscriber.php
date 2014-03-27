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
namespace WellCommerce\Plugin\PayPal\Event;

use WellCommerce\Plugin\PaymentMethod\Event\PaymentMethodFormEvent;
use Symfony\Component\EventDispatcher\Event,
    Symfony\Component\EventDispatcher\EventSubscriberInterface;

use WellCommerce\Plugin\AdminMenu\Event\AdminMenuInitEvent;

/**
 * Class PayPalEventSubscriber
 *
 * @package WellCommerce\Plugin\PayPal\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PayPalEventSubscriber implements EventSubscriberInterface
{

    public function onPaymentMethodFormInitAction(Event $event)
    {

    }

    public static function getSubscribedEvents()
    {
        return array(
            PaymentMethodFormEvent::FORM_INIT_EVENT => 'onPaymentMethodFormInitAction'
        );
    }
}