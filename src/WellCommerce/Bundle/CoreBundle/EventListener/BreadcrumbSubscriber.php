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
namespace WellCommerce\Bundle\CoreBundle\EventListener;

use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Component\Breadcrumb\Model\Breadcrumb;

/**
 * Class BreadcrumbSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class BreadcrumbSubscriber extends AbstractEventSubscriber
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 0],
        ];
    }
    
    public function onKernelRequest()
    {
        $currentRoute = $this->getRouterHelper()->getCurrentRoute();

        if ($currentRoute->hasOption('breadcrumb')) {
            $options = $currentRoute->getOption('breadcrumb');

            $this->getBreadcrumbProvider()->add(new Breadcrumb([
                'label' => $this->trans($options['label']),
                'url'   => $currentRoute->getPath()
            ]));
        }
    }
}
