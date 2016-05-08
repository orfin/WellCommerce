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

/**
 * Class ClientOrderBoxController
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientOrderBoxController extends AbstractBoxController
{
    public function indexAction(LayoutBoxSettingsCollection $boxSettings) : Response
    {
        $orders = $this->getAuthenticatedClient()->getOrders();

        return $this->displayTemplate('index', [
            'orders' => $orders
        ]);
    }

    public function viewAction() : Response
    {
        $id     = (int)$this->getRequestHelper()->getAttributesBagParam('id');
        $client = $this->getAuthenticatedClient();
        $order  = $this->get('order.repository')->findOneBy([
            'id'     => $id,
            'client' => $client
        ]);

        if (null === $order) {
            return $this->redirectToAction('index');
        }

        return $this->displayTemplate('view', [
            'order' => $order
        ]);
    }
}
