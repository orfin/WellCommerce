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
namespace WellCommerce\Bundle\LocaleBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\AdminBundle\Event\AdminMenuEvent;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;

/**
 * Class LocaleSubscriber
 *
 * @package WellCommerce\Bundle\LocaleBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleSubscriber extends AbstractEventSubscriber
{
    protected static $events = [
        KernelEvents::CONTROLLER   => ['onKernelController', -256],
        AdminMenuEvent::INIT_EVENT => 'onAdminMenuInitEvent'
    ];

    public function onKernelController(FilterControllerEvent $event)
    {
        // fetch locales only when HttpKernelInterface::MASTER_REQUEST
        if ($event->getRequestType() == HttpKernelInterface::SUB_REQUEST) {
            return;
        }

        if (!$this->container->get('session')->has('admin/locales')) {

            $locales = $this->container->get('locale.repository')->getAvailableLocales();

            $this->container->get('session')->set('admin/locales', $locales);
        }
    }
}