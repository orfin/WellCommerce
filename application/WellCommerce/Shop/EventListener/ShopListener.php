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
namespace WellCommerce\Shop\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use WellCommerce\Core\Event\AdminMenuEvent;
use WellCommerce\AdminMenu\Builder\AdminMenuItem;
use WellCommerce\AdminMenu\Event\AdminMenuInitEvent;

/**
 * Class ShopListener
 *
 * @package WellCommerce\Shop\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopListener implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelController(Event $event)
    {
        if ($event->getRequestType() == HttpKernelInterface::SUB_REQUEST) {
            return;
        }

        $container = $event->getDispatcher()->getContainer();
        $request   = $event->getRequest();
        $session   = $container->get('session');

        if (!$session->has('shop/settings')) {
            $shop = $container->get('shop.repository')->getShopByHost();
            $container->get('session')->set('shop/settings', $shop);
        }

        if (!$session->has('shop/shops')) {
            $shops = $container->get('shop.repository')->getAllShopToSelect();
            $container->get('session')->set('shop/shops', $shops);
        }

        $templateVars          = $request->attributes->get('_template_vars');
        $templateVars['shop']  = $container->get('session')->get('shop');
        $templateVars['shops'] = $container->get('shop.repository')->getAllShopToSelect();

        $request->attributes->set('_template_vars', $templateVars);

    }

    public function onAdminMenuInitEvent(AdminMenuEvent $event)
    {
        $builder = $event->getBuilder();

        $builder->add(new AdminMenuItem([
            'id'         => 'shop',
            'name'       => $this->container->get('translation')->trans('Shops'),
            'link'       => $this->container->get('router')->generate('admin.shop.index'),
            'path'       => '[menu][configuration][shop]',
            'sort_order' => 10
        ]));
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER                  => [
                'onKernelController',
                -256
            ],
            AdminMenuInitEvent::ADMIN_MENU_INIT_EVENT => 'onAdminMenuInitEvent'
        ];
    }
}