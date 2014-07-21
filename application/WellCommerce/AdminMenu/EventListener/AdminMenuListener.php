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
namespace WellCommerce\AdminMenu\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use WellCommerce\Core\DataGrid\Column\ColumnInterface;
use WellCommerce\Core\DataGrid\Column\DataGridColumn;
use WellCommerce\AdminMenu\Builder\AdminMenuBuilder;
use WellCommerce\AdminMenu\Builder\AdminMenuItem;
use WellCommerce\AdminMenu\Event\AdminMenuInitEvent;
use WellCommerce\Core\DataGrid\Configuration\Appearance;
use WellCommerce\Core\Event\DataGridEvent;

/**
 * Class AdminMenuListener
 *
 * @package WellCommerce\AdminMenu\EventListener
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AdminMenuListener implements EventSubscriberInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        // admin menu will be rendered only when HttpKernelInterface::MASTER_REQUEST
        if ($event->getRequestType() == HttpKernelInterface::SUB_REQUEST) {
            return;
        }

        if (!$this->container->get('session')->has('admin/menu')) {

            $builder = new AdminMenuBuilder();

            $builder->add(new AdminMenuItem([
                'id'         => 'dashboard',
                'class'      => 'dashboard',
                'name'       => $this->container->get('translation')->trans('Dashboard'),
                'link'       => $this->container->get('router')->generate('admin.dashboard.index'),
                'path'       => '[menu][dashboard]',
                'sort_order' => 10,
            ]));

            $builder->add(new AdminMenuItem([
                'id'         => 'catalog',
                'class'      => 'catalog',
                'name'       => $this->container->get('translation')->trans('Catalog'),
                'link'       => $this->container->get('router')->generate('admin.product.index'),
                'path'       => '[menu][catalog]',
                'sort_order' => 20
            ]));

            $builder->add(new AdminMenuItem([
                'id'         => 'promotions',
                'class'      => 'promotions',
                'name'       => $this->container->get('translation')->trans('Promotions'),
                'link'       => $this->container->get('router')->generate('admin.product.index'),
                'path'       => '[menu][promotions]',
                'sort_order' => 30
            ]));

            $builder->add(new AdminMenuItem([
                'id'         => 'sales',
                'class'      => 'sales',
                'name'       => $this->container->get('translation')->trans('Sales'),
                'link'       => $this->container->get('router')->generate('admin.product.index'),
                'path'       => '[menu][sales]',
                'sort_order' => 40
            ]));

            $builder->add(new AdminMenuItem([
                'id'         => 'reports',
                'class'      => 'reports',
                'name'       => $this->container->get('translation')->trans('Reports'),
                'link'       => $this->container->get('router')->generate('admin.product.index'),
                'path'       => '[menu][reports]',
                'sort_order' => 50
            ]));

            $builder->add(new AdminMenuItem([
                'id'         => 'crm',
                'class'      => 'crm',
                'name'       => $this->container->get('translation')->trans('CRM'),
                'link'       => $this->container->get('router')->generate('admin.product.index'),
                'path'       => '[menu][crm]',
                'sort_order' => 60
            ]));

            $builder->add(new AdminMenuItem([
                'id'         => 'cms',
                'class'      => 'cms',
                'name'       => $this->container->get('translation')->trans('CMS'),
                'link'       => $this->container->get('router')->generate('admin.product.index'),
                'path'       => '[menu][cms]',
                'sort_order' => 70
            ]));

            $builder->add(new AdminMenuItem([
                'id'         => 'layout',
                'class'      => 'layout',
                'name'       => $this->container->get('translation')->trans('Layout settings'),
                'link'       => $this->container->get('router')->generate('admin.product.index'),
                'path'       => '[menu][layout]',
                'sort_order' => 80
            ]));

            $builder->add(new AdminMenuItem([
                'id'         => 'integration',
                'class'      => 'integration',
                'name'       => $this->container->get('translation')->trans('Integration'),
                'link'       => $this->container->get('router')->generate('admin.product.index'),
                'path'       => '[menu][integration]',
                'sort_order' => 90
            ]));

            $builder->add(new AdminMenuItem([
                'id'         => 'configuration',
                'class'      => 'configuration',
                'name'       => $this->container->get('translation')->trans('Configuration'),
                'link'       => $this->container->get('router')->generate('admin.product.index'),
                'path'       => '[menu][configuration]',
                'sort_order' => 100
            ]));

            $adminMenuEvent = new AdminMenuInitEvent($builder);

            $event->getDispatcher()->dispatch(AdminMenuInitEvent::ADMIN_MENU_INIT_EVENT, $adminMenuEvent);

            $menu = $adminMenuEvent->getBuilder()->getMenu();

            $this->container->get('session')->set('admin/menu', $menu);
        }
    }

    public function onAvailabilityFormInitAction($event)
    {
        $form    = $event->getForm();
        $data    = $event->getData();
        $builder = $this->container->get('form_builder');

        $form->getChild('required_data')->addChild($builder->addTextField([
            'name'  => 'Admin',
            'label' => 'Admin'
        ]));

        $additionalData = $form->addChild($builder->addFieldset([
            'name'  => 'Additional',
            'label' => 'Additional data'
        ]));

        $additionalData->addChild($builder->addTextField([
            'name'  => 'Admin',
            'label' => 'Admin'
        ]));

        $data['Additional']['Admin'] = 'adam';

        $event->setData($data);
    }

    public function onAvailabilityFormSubmitAction($event)
    {

    }

    public function onAvailabilityModelPreSaveAction(Event $event)
    {
    }

    public function onAvailabilityModelPostSaveAction(Event $event)
    {
    }

    public function onAvailabilityDataGridInitAction(DataGridEvent $event)
    {
//        $datagrid = $event->getDataGrid();
//        $options  = $datagrid->getOptions();
//
//        $options->setAppearance(new Appearance(['header' =>true]));
//
//        $datagrid->setOptions($options);

//        $options['foo'] = 1;
//
//        $datagrid->setOptions($options);
//
//        $collection = $datagrid->getColumnCollection();
//
//        $collection->add(new DataGridColumn([
//            'id'         => 'test',
//            'source'     => '1111',
//            'caption'    => 'UD',
//            'sorting'    => [
//                'default_order' => ColumnInterface::SORT_DIR_DESC
//            ],
//            'appearance' => [
//                'width' => 90,
//            ],
//            'filter'     => [
//                'type' => ColumnInterface::FILTER_BETWEEN
//            ]
//        ]));
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => array(
                'onKernelController',
                -256
            ),
            //            'availability.form.init'   => 'onAvailabilityFormInitAction',
            //            'availability.form.submit' => 'onAvailabilityFormSubmitAction'
            //            AvailabilityRepositoryInterface::PRE_SAVE_EVENT  => 'onAvailabilityModelPreSaveAction',
            //            AvailabilityRepositoryInterface::POST_SAVE_EVENT => 'onAvailabilityModelPostSaveAction'
                        'availability.datagrid.init' => 'onAvailabilityDataGridInitAction'
        );
    }
}