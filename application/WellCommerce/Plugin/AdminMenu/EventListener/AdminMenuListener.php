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
namespace WellCommerce\Plugin\AdminMenu\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use WellCommerce\Plugin\AdminMenu\Event\AdminMenuInitEvent;

/**
 * Class AdminMenuListener
 *
 * @package WellCommerce\Plugin\AdminMenu\EventListener
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

        if (!$this->container->get('session')->has('admin.menu')) {

            $menuData = Array(
                'menu' => Array(
                    'sales',
                    'crm'
                )
            );

            $eventData = new AdminMenuInitEvent($menuData);

            $event->getDispatcher()->dispatch(AdminMenuInitEvent::ADMIN_MENU_INIT_EVENT, $eventData);

            $adminMenuData = $eventData->getMenuData();

            $this->container->get('session')->set('admin.menu', $eventData->getMenuData());
        }
//
        $adminMenuData = [
            'admin_menu' => $this->container->get('admin_menu.repository')->getMenuData()
        ];

        $templateVars = $event->getRequest()->attributes->get('_template_vars');

        $event->getRequest()->attributes->set('_template_vars', array_merge($templateVars, $adminMenuData));
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

        echo "<pre>";
        echo "INIT:";
        print_r($data);
        echo "</pre>";
    }

    public function onAvailabilityFormSubmitAction($event)
    {
        echo "<pre>";
        echo "POST:";
        print_r($_POST);
        echo "SUBMIT:";
        print_r($event->getData());
        die();
    }

    public function onAvailabilityModelPreSaveAction(Event $event)
    {
        $data = $event->getData();

        $data['required_data']['foo'] = 1;

        $event->setData($data);

        print_r($data);
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER      => array(
                'onKernelController',
                -256
            ),
            //            'availability.form.init'   => 'onAvailabilityFormInitAction',
            //            'availability.form.submit' => 'onAvailabilityFormSubmitAction'
//            'availability.model.pre_save' => 'onAvailabilityModelPreSaveAction'
        );
    }
}