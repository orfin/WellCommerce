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

namespace WellCommerce\Bundle\ClientBundle\Controller\Box;

use Symfony\Component\HttpFoundation\Response;
use WellCommerce\Bundle\CoreBundle\Controller\Box\AbstractBoxController;
use WellCommerce\Bundle\LayoutBundle\Collection\LayoutBoxSettingsCollection;
use WellCommerce\Bundle\OrderBundle\Entity\OrderInterface;
use WellCommerce\Bundle\OrderBundle\Repository\OrderRepositoryInterface;

/**
 * Class ClientOrderBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientOrderBoxController extends AbstractBoxController
{
    public function indexAction(LayoutBoxSettingsCollection $boxSettings) : Response
    {
        $orders = $this->getOrderRepository()->getClientOrdersCollection($this->getAuthenticatedClient());
        
        return $this->displayTemplate('index', [
            'orders' => $orders
        ]);
    }
    
    public function viewAction() : Response
    {
        $order = $this->getOrderRepository()->findOneBy([
            'id'     => (int)$this->getRequestHelper()->getAttributesBagParam('id'),
            'client' => $this->getAuthenticatedClient()
        ]);
        
        if (!$order instanceof OrderInterface) {
            return $this->redirectToAction('index');
        }
        
        return $this->displayTemplate('view', [
            'order' => $order
        ]);
    }
    
    private function getOrderRepository() : OrderRepositoryInterface
    {
        return $this->get('order.repository');
    }
}
