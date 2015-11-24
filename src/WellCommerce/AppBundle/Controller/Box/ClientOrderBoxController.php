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

namespace WellCommerce\AppBundle\Controller\Box;

use WellCommerce\CoreBundle\Controller\Box\AbstractBoxController;

/**
 * Class ClientOrderBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientOrderBoxController extends AbstractBoxController
{
    public function indexAction()
    {
        $client = $this->manager->getClient();

        return $this->displayTemplate('index', [
            'orders' => $client->getOrders()
        ]);
    }

    public function viewAction()
    {
        $id     = (int)$this->getRequestHelper()->getAttributesBagParam('id');
        $client = $this->manager->getClient();
        $order  = $this->get('order.repository')->findOneBy(['id' => $id, 'client' => $client]);

        if (null === $order) {
            return $this->redirectToAction('index');
        }

        return $this->displayTemplate('view', [
            'order' => $order
        ]);
    }
}
