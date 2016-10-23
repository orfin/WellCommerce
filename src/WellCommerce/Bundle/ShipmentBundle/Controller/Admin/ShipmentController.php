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

namespace WellCommerce\Bundle\ShipmentBundle\Controller\Admin;

use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Admin\AbstractAdminController;
use WellCommerce\Bundle\ShipmentBundle\Adapter\ShipmentAdapterInterface;
use WellCommerce\Bundle\ShipmentBundle\Entity\ShipmentInterface;

/**
 * Class ShipmentController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShipmentController extends AbstractAdminController
{
    public function addAction(Request $request) : Response
    {
        $courier = $request->get('courier');
        $orderId = $request->get('orderId');
        $order   = $this->get('order.manager')->getRepository()->find($orderId);
        $this->getOrderProvider()->setCurrentOrder($order);
        
        /** @var ShipmentInterface $shipment */
        $shipment = $this->getManager()->initResource();
        $shipment->setOrder($order);
        $shipment->setCourier($courier);
        
        $form = $this->getForm($shipment, [
            'name'         => $courier,
            'ajax_enabled' => false,
        ]);
        
        $adapter = $this->getAdapter($courier);
        $adapter->addFormFields($form->getChildren()->get('required_data'), $this->getFormBuilder(), $shipment);
        
        if ($form->handleRequest()->isSubmitted()) {
            if ($form->isValid()) {
                $response = $adapter->addShipment($shipment, $form->getValue());
                $this->getManager()->createResource($shipment);
                
                return $response;
            }
        }
        
        return $this->displayTemplate('add', [
            'form'  => $form,
            'order' => $order,
        ]);
    }
    
    public function downloadLabelsAction(Request $request)
    {
        $courier = $request->get('courier');
        $date    = $request->get('date');
        $adapter = $this->getAdapter($courier);
        $labels  = $adapter->getLabels($date);
    }
    
    private function getAdapter(string $courier) : ShipmentAdapterInterface
    {
        if (false === $this->has($courier.'.shipment.adapter')) {
            throw new ServiceNotFoundException($courier.'.shipment.adapter');
        }
        
        return $this->get($courier.'.shipment.adapter');
    }
}
