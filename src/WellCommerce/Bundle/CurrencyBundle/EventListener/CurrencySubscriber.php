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
namespace WellCommerce\Bundle\CurrencyBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;
use WellCommerce\Bundle\CurrencyBundle\Entity\Currency;

/**
 * Class CurrencySubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencySubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', -100],
        ];
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();
        $session = $request->getSession();

        if (!$session->has('_currency')) {
            $currency = $this->getLocaleCurrency($request);
            if (null !== $currency) {
                $session->set('_currency', $currency);
            }
        }
    }

    /**
     * Returns the currency code for active locale
     *
     * @param Request $request
     *
     * @return string
     */
    protected function getLocaleCurrency(Request $request)
    {
        $currentLocale = $request->getLocale();
        $locale        = $this->container->get('locale.repository')->findOneBy(['code' => $currentLocale]);

        if (null !== $locale && $locale->getCurrency() instanceof Currency) {
            return $locale->getCurrency()->getCode();
        }

        return null;
    }
}
