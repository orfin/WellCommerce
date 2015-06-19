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
namespace WellCommerce\Bundle\MultiStoreBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Bundle\CoreBundle\EventListener\AbstractEventSubscriber;

/**
 * Class ShopSubscriber
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopSubscriber extends AbstractEventSubscriber
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', -256],
            'shop.post_update'       => 'onShopListModified',
            'shop.post_create'       => 'onShopListModified',
            'shop.post_remove'       => 'onShopListModified',
        ];
    }

    /**
     * Clears session data after shop list was changed
     */
    public function onShopListModified()
    {
        $this->container->get('session')->remove('admin/shops');
    }

    /**
     * Sets shop context related session variables
     *
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
            return;
        }

        $request = $event->getRequest();

        if ($request->hasSession()) {
            if (!$this->container->get('session')->has('admin/shops')) {
                $shops = $this->container->get('shop.collection')->getSelect();
                $this->container->get('session')->set('admin/shops', $shops);
            }

            $currentHost  = $this->container->get('request_helper')->getCurrentHost();
            $adminContext = $this->container->get('shop.context.admin');
            $frontContext = $this->container->get('shop.context.front');
            $themeManager = $this->container->get('theme.manager');

            if (!$adminContext->hasSessionPreviousData()) {
                $adminContext->determineCurrentScope($currentHost);
            }

            $frontContext->setCurrentScopeByHost($currentHost);
            if (null === $frontContext->getCurrentScope()) {
                $message = sprintf(
                    'Cannot load multi-store data for host "%s". Check url settings for shop.',
                    $currentHost
                );

                throw new \LogicException($message);
            }

            $themeManager->setCurrentTheme($frontContext->getCurrentScope()->getTheme());
        }
    }
}
