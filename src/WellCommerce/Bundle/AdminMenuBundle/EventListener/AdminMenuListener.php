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
namespace WellCommerce\Bundle\AdminMenuBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use WellCommerce\Bundle\AdminMenuBundle\Builder\AdminMenuBuilder;
use WellCommerce\Bundle\AdminMenuBundle\Builder\AdminMenuItem;
use WellCommerce\Bundle\AdminMenuBundle\Event\AdminMenuInitEvent;

/**
 * Class AdminMenuListener
 *
 * @package WellCommerce\Bundle\AdminMenuBundle\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminMenuListener implements EventSubscriberInterface
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
        // admin menu will be rendered only when HttpKernelInterface::MASTER_REQUEST
        if ($event->getRequestType() == HttpKernelInterface::SUB_REQUEST) {
            return;
        }

        if (!$this->container->get('session')->has('admin/menu')) {

            $builder = new AdminMenuBuilder();

//            $builder->add(new AdminMenuItem([
//                'id'         => 'dashboard',
//                'class'      => 'dashboard',
//                'name'       => $this->translator->trans('Dashboard'),
//                'link'       => $this->router->generate('admin.dashboard.index'),
//                'path'       => '[menu][dashboard]',
//                'sort_order' => 10,
//            ]));
//
//            $builder->add(new AdminMenuItem([
//                'id'         => 'catalog',
//                'class'      => 'catalog',
//                'name'       => $this->translator->trans('Catalog'),
//                'link'       => $this->router->generate('admin.product.index'),
//                'path'       => '[menu][catalog]',
//                'sort_order' => 20
//            ]));
//
//            $builder->add(new AdminMenuItem([
//                'id'         => 'promotions',
//                'class'      => 'promotions',
//                'name'       => $this->translator->trans('Promotions'),
//                'link'       => $this->router->generate('admin.product.index'),
//                'path'       => '[menu][promotions]',
//                'sort_order' => 30
//            ]));
//
//            $builder->add(new AdminMenuItem([
//                'id'         => 'sales',
//                'class'      => 'sales',
//                'name'       => $this->translator->trans('Sales'),
//                'link'       => $this->router->generate('admin.product.index'),
//                'path'       => '[menu][sales]',
//                'sort_order' => 40
//            ]));
//
//            $builder->add(new AdminMenuItem([
//                'id'         => 'reports',
//                'class'      => 'reports',
//                'name'       => $this->translator->trans('Reports'),
//                'link'       => $this->router->generate('admin.product.index'),
//                'path'       => '[menu][reports]',
//                'sort_order' => 50
//            ]));
//
            $builder->add(new AdminMenuItem([
                'id'         => 'crm',
                'class'      => 'crm',
                'name'       => $this->translator->trans('CRM'),
                'link'       => '',
                'path'       => '[menu][crm]',
                'sort_order' => 60
            ]));
//
//            $builder->add(new AdminMenuItem([
//                'id'         => 'cms',
//                'class'      => 'cms',
//                'name'       => $this->translator->trans('CMS'),
//                'link'       => $this->router->generate('admin.product.index'),
//                'path'       => '[menu][cms]',
//                'sort_order' => 70
//            ]));
//
//            $builder->add(new AdminMenuItem([
//                'id'         => 'layout',
//                'class'      => 'layout',
//                'name'       => $this->translator->trans('Layout settings'),
//                'link'       => $this->router->generate('admin.product.index'),
//                'path'       => '[menu][layout]',
//                'sort_order' => 80
//            ]));
//
//            $builder->add(new AdminMenuItem([
//                'id'         => 'integration',
//                'class'      => 'integration',
//                'name'       => $this->translator->trans('Integration'),
//                'link'       => $this->router->generate('admin.product.index'),
//                'path'       => '[menu][integration]',
//                'sort_order' => 90
//            ]));
//
            $builder->add(new AdminMenuItem([
                'id'         => 'configuration',
                'class'      => 'configuration',
                'name'       => $this->translator->trans('Configuration'),
                //                'link'       => $this->router->generate('admin.product.index'),
                'link'       => '',
                'path'       => '[menu][configuration]',
                'sort_order' => 100
            ]));
//
//            $builder->add(new AdminMenuItem([
//                'id'         => 'localization',
//                'class'      => 'localization',
//                'name'       => $this->translator->trans('Localization'),
//                'link'       => '',
//                'path'       => '[menu][configuration][localization]',
//                'sort_order' => 10
//            ]));
//
            $builder->add(new AdminMenuItem([
                'id'         => 'store_management',
                'class'      => 'store_management',
                'name'       => $this->translator->trans('Store management'),
                'link'       => '',
                'path'       => '[menu][configuration][store_management]',
                'sort_order' => 20
            ]));
//
//            $builder->add(new AdminMenuItem([
//                'id'         => 'user_management',
//                'name'       => $this->translator->trans('User management'),
//                'link'       => '',
//                'path'       => '[menu][configuration][user_management]',
//                'sort_order' => 30
//            ]));

            $adminMenuEvent = new AdminMenuInitEvent($builder);

            $event->getDispatcher()->dispatch(AdminMenuInitEvent::ADMIN_MENU_INIT_EVENT, $adminMenuEvent);

            $menu = $adminMenuEvent->getBuilder()->getMenu();

            $this->container->get('session')->set('admin/menu', $menu);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', -256],
        ];
    }
}