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

namespace WellCommerce\Bundle\OrderBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatusHistoryInterface;
use WellCommerce\Bundle\OrderBundle\Entity\OrderStatusInterface;
use WellCommerce\Component\Form\Elements\FormInterface;

/**
 * Class OrderController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderController extends AbstractAdminController
{
    public function indexAction(): Response
    {
        return $this->displayTemplate('index', [
            'datagrid' => $this->dataGrid->getInstance(),
            'statuses' => $this->get('order_status.dataset.admin')->getResult('select'),
        ]);
    }
    
    public function editAction(int $id): Response
    {
        $resource = $this->getManager()->getRepository()->find($id);
        if (!$resource instanceof OrderInterface) {
            return $this->redirectToAction('index');
        }
        
        $this->getOrderProvider()->setCurrentOrder($resource);
        
        $form = $this->getForm($resource, [
            'class' => 'editOrder',
        ]);
        
        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $this->getManager()->updateResource($resource);
            }
            
            return $this->createFormDefaultJsonResponse($form);
        }
        
        $orderStatusHistory     = $this->createOrderStatusHistoryResource($resource);
        $orderStatusHistoryForm = $this->createOrderStatusHistoryForm($orderStatusHistory);
        
        if ($orderStatusHistoryForm->handleRequest()->isSubmitted()) {
            if ($orderStatusHistoryForm->isValid()) {
                $this->get('order_status_history.manager')->createResource($orderStatusHistory);
            }
            
            return $this->jsonResponse([
                'valid'      => $orderStatusHistoryForm->isValid(),
                'next'       => false,
                'continue'   => false,
                'redirectTo' => $this->getRedirectToActionUrl('edit', ['id' => $resource->getId()]),
                'error'      => $orderStatusHistoryForm->getError(),
            ]);
        }
        
        return $this->displayTemplate('edit', [
            'form'                   => $form,
            'orderStatusHistoryForm' => $orderStatusHistoryForm,
            'resource'               => $resource,
        ]);
    }
    
    public function ajaxChangeOrderStatusAction(Request $request)
    {
        $id       = $request->get('id');
        $statusId = $request->get('status');
        $status   = $this->get('order_status.repository')->find($statusId);
        
        if (!$status instanceof OrderStatusInterface) {
            return $this->jsonResponse([
                'success' => false,
                'error'   => 'Wrong order status was given',
            ]);
        }
        
        $order = $this->getManager()->getRepository()->find($id);
        if ($order instanceof OrderInterface) {
            $order->setCurrentStatus($status);
            $history = $this->createOrderStatusHistoryResource($order);
            $history->setNotify(true);
            $this->get('order_status_history.manager')->createResource($history);
        }
        
        return $this->jsonResponse([
            'success' => true,
            'status'  => $status,
            'number'  => $order->getNumber(),
        ]);
    }
    
    public function ajaxChangeOrderStatusMultiAction(Request $request)
    {
        $ids      = $request->get('ids');
        $statusId = $request->get('status');
        $status   = $this->get('order_status.repository')->find($statusId);
        
        if (!$status instanceof OrderStatusInterface) {
            return $this->jsonResponse([
                'success' => false,
                'error'   => 'Wrong order status was given',
            ]);
        }
        
        foreach ($ids as $id) {
            $order = $this->getManager()->getRepository()->find($id);
            if ($order instanceof OrderInterface) {
                $order->setCurrentStatus($status);
                $history = $this->createOrderStatusHistoryResource($order);
                $history->setNotify(true);
                $this->get('order_status_history.manager')->createResource($history);
            }
        }
        
        return $this->jsonResponse([
            'success' => true,
            'status'  => $status,
            'ids'     => implode(',', $ids),
        ]);
    }
    
    protected function createOrderStatusHistoryForm(OrderStatusHistoryInterface $orderStatusHistory): FormInterface
    {
        return $this->get('order_status_history.form_builder.admin')->createForm([
            'name'  => 'orderStatusHistory',
            'class' => 'statusChange',
        ], $orderStatusHistory);
    }
    
    protected function createOrderStatusHistoryResource(OrderInterface $order): OrderStatusHistoryInterface
    {
        /** @var $orderStatusHistory OrderStatusHistoryInterface */
        $orderStatusHistory = $this->get('order_status_history.factory')->create();
        $orderStatusHistory->setNotify(false);
        $orderStatusHistory->setComment('');
        $orderStatusHistory->setOrder($order);
        $orderStatusHistory->setOrderStatus($order->getCurrentStatus());
        
        return $orderStatusHistory;
    }
}
