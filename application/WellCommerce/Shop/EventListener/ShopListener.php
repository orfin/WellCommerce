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
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
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

    /**
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    private $translator;

    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    public function __construct(ContainerInterface $container, TranslatorInterface $translator, RouterInterface $router)
    {
        $this->container  = $container;
        $this->translator = $translator;
        $this->router     = $router;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        if ($event->getRequestType() == HttpKernelInterface::SUB_REQUEST) {
            return;
        }

        $request = $event->getRequest();
        $session = $this->container->get('session');

        if (!$session->has('shop/settings')) {
            $shop = $this->container->get('shop.repository')->getShopByHost();
            $this->container->get('session')->set('shop/settings', $shop);
        }

        if (!$session->has('shop/shops')) {
            $shops = $this->container->get('shop.repository')->getAllShopToSelect();
            $this->container->get('session')->set('shop/shops', $shops);
        }

        $templateVars          = $request->attributes->get('_template_vars');
        $templateVars['shop']  = $this->container->get('session')->get('shop');
        $templateVars['shops'] = $this->container->get('shop.repository')->getAllShopToSelect();

        $request->attributes->set('_template_vars', $templateVars);

    }

    public function onAdminMenuInitEvent(AdminMenuEvent $event)
    {
        $builder = $event->getBuilder();

        $builder->add(new AdminMenuItem([
            'id'         => 'shop',
            'name'       => $this->translator->trans('Shops'),
            'link'       => $this->router->generate('admin.shop.index'),
            'path'       => '[menu][configuration][store_management][shop]',
            'sort_order' => 10
        ]));
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER                  => ['onKernelController', -256],
            AdminMenuInitEvent::ADMIN_MENU_INIT_EVENT => 'onAdminMenuInitEvent'
        ];
    }
}