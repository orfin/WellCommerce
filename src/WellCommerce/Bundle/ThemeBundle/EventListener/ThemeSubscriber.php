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
namespace WellCommerce\Bundle\ThemeBundle\EventListener;

use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;

/**
 * Class ThemeSubscriber
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ThemeSubscriber extends AbstractEventSubscriber
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', -10],
        ];
    }
    
    /**
     * Sets shop context related session variables
     */
    public function onKernelController()
    {
        $themeContext = $this->container->get('theme.context.front');
        $themeContext->setCurrentTheme($this->getShopStorage()->getCurrentShop()->getTheme());
    }
}
