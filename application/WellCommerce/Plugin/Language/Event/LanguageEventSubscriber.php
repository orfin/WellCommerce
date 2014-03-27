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
namespace WellCommerce\Plugin\Language\Event;

use Symfony\Component\EventDispatcher\Event,
    Symfony\Component\EventDispatcher\EventSubscriberInterface,
    Symfony\Component\HttpKernel\KernelEvents,
    Symfony\Component\HttpKernel\Event\GetResponseEvent;

use WellCommerce\Plugin\AdminMenu\Event\AdminMenuInitEvent;

/**
 * Class LanguageEventSubscriber
 *
 * @package WellCommerce\Plugin\Language\Event
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LanguageEventSubscriber implements EventSubscriberInterface
{
    /**
     * Resolves language id from Request using current locale
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {

    }

    /**
     * Appends items to admin menu
     *
     * @param Event $event
     */
    public function onAdminMenuInitAction(Event $event)
    {

    }

    /**
     * Return array containing all subscribed events
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST                     => 'onKernelRequest',
            AdminMenuInitEvent::ADMIN_MENU_INIT_EVENT => 'onAdminMenuInitAction'
        );
    }
}