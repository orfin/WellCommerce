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
namespace WellCommerce\Bundle\ApiBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;

/**
 * Class ApiSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ApiSubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequestEvent'],
        ];
    }
    
    public function onKernelRequestEvent(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if (false !== strpos($request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode($request->getContent(), true);
            if (is_array($data)) {
                $request->request->replace($data);
            }
        }
    }
}
