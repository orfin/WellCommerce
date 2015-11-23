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
namespace WellCommerce\AppBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\AppBundle\EventListener\AbstractEventSubscriber;

/**
 * Class LocaleSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LocaleSubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST    => ['onKernelRequest', 15],
            KernelEvents::CONTROLLER => ['onKernelController', -256],
        ];
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if ($event->getRequestType() == HttpKernelInterface::SUB_REQUEST) {
            return;
        }

        $request = $event->getRequest();
        $filter  = $this->getDoctrineHelper()->enableFilter('locale');

        if ($locale = $request->attributes->get('_locale')) {
            $request->getSession()->set('_locale', $locale);
            $filter->setParameter('locale', $locale);
        } else {
            if ($request->hasSession()) {
                $currentLocale = $request->getSession()->get('_locale', $request->getDefaultLocale());
                $request->setLocale($currentLocale);
                $filter->setParameter('locale', $currentLocale);
            }
        }
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        // skip fetching locales when handling sub-request
        if ($event->getRequestType() == HttpKernelInterface::SUB_REQUEST) {
            return;
        }

        if (!$this->container->get('session')->has('admin/locales')) {
            $locales = $this->container->get('locale.repository')->getAvailableLocales();
            $this->container->get('session')->set('admin/locales', $locales);
        }
    }
}
